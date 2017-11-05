#!/usr/bin/env bash
set -e

. "$(dirname "$0")/tools/functions/parse-version.sh.inc"
export PATH="$(dirname "$0")/tools:$PATH"

DEPLOYMENT_ID="${TRAVIS_TAG//\//_}"
DEPLOYMENT_DIR="$TRAVIS_BUILD_DIR/_build/release-$DEPLOYMENT_ID.git"

[ -n "$RELEASE_REPO_SLUG" ] || export RELEASE_REPO_SLUG="$TRAVIS_REPO_SLUG"
[ -n "$RELEASE_REPO_BRANCH" ] || export RELEASE_REPO_BRANCH="master"

# parameters
ARCHIVE="$1"    # release archive file name

if [ -z "$ARCHIVE" ]; then
    echo "Unable to create release archive: No file name specified" >&2
    exit 1
fi

# parse version
if ! parse_version "$TRAVIS_TAG"; then
    echo "Unable to create release archive: Invalid version '$TRAVIS_TAG'" >&2
    exit 1
fi

# clone repo
github-clone.sh "$DEPLOYMENT_DIR" "https://github.com/$RELEASE_REPO_SLUG.git" "$RELEASE_REPO_BRANCH"

cd "$DEPLOYMENT_DIR"

# force Pico version
echo "Updating composer dependencies..."
composer require --no-update \
    "picocms/pico $VERSION_FULL@$VERSION_STABILITY" \
    "picocms/pico-theme $VERSION_FULL@$VERSION_STABILITY" \
    "picocms/pico-deprecated $VERSION_FULL@$VERSION_STABILITY"
echo

# install dependencies
echo "Running \`composer install\`..."
composer install --no-suggest --prefer-dist --no-dev --optimize-autoloader
echo

# prepare release
echo "Replacing 'index.php'..."
cp vendor/picocms/pico/index.php.dist index.php

echo "Adding 'config/config.yml.template'..."
cp vendor/picocms/pico/config/config.yml.template config/config.yml.template

echo "Preparing 'composer.json' for release..."
composer require --no-update \
    "picocms/pico ^$VERSION_MILESTONE" \
    "picocms/pico-theme ^$VERSION_MILESTONE" \
    "picocms/pico-deprecated ^$VERSION_MILESTONE"

echo "Removing '.git' directory and '.gitignore' file..."
rm -f .gitignore
rm -rf .git

echo "Removing '.git' directories of dependencies..."
find vendor/ -type d -path 'vendor/*/*/.git' -print0 | xargs -0 rm -rf
find themes/ -type d -path 'themes/*/.git' -print0 | xargs -0 rm -rf
find plugins/ -type d -path 'plugins/*/.git' -print0 | xargs -0 rm -rf

echo

# create release archive
echo "Creating release archive '$ARCHIVE'..."

if [ -e "$ARCHIVE" ]; then
    echo "Unable to create release archive: File exists" >&2
    exit 1
fi

find . -mindepth 1 -maxdepth 1 -printf '%f\0' \
    | xargs -0 -- tar -czf "$ARCHIVE" --
echo
