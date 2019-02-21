#!/usr/bin/env bash
set -e

export PATH="$PICO_TOOLS_DIR:$PATH"
. "$PICO_TOOLS_DIR/functions/parse-version.sh.inc"

# parameters
ARCHIVE="$1"    # release archive file name

if [ -z "$ARCHIVE" ]; then
    echo "Unable to create release archive: No file name specified" >&2
    exit 1
fi

# parse version
if ! parse_version "$PROJECT_REPO_TAG"; then
    echo "Unable to create release archive: Invalid version '$PROJECT_REPO_TAG'" >&2
    exit 1
fi

# clone repo
github-clone.sh "$PICO_BUILD_DIR" "https://github.com/$RELEASE_REPO_SLUG.git" "$RELEASE_REPO_BRANCH"

cd "$PICO_BUILD_DIR"

# force Pico version
echo "Updating composer dependencies..."
composer require --no-update \
    "picocms/pico $VERSION_FULL@$VERSION_STABILITY" \
    "picocms/pico-theme $VERSION_FULL@$VERSION_STABILITY" \
    "picocms/pico-deprecated $VERSION_FULL@$VERSION_STABILITY"
echo

# set minimum stability
if [ "$VERSION_STABILITY" != "stable" ]; then
    echo "Setting minimum stability to '$VERSION_STABILITY'..."
    composer config "minimum-stability" "$VERSION_STABILITY"
    composer config "prefer-stable" "true"
    echo
fi

# install dependencies
echo "Running \`composer install\`..."
composer install --no-suggest --prefer-dist --no-dev --optimize-autoloader
echo

# prepare release
echo "Replacing 'index.php'..."
cp vendor/picocms/pico/index.php.dist index.php

echo "Adding 'README.md', 'CONTRIBUTING.md', 'CHANGELOG.md'..."
cp vendor/picocms/pico/README.md README.md
cp vendor/picocms/pico/CONTRIBUTING.md CONTRIBUTING.md
cp vendor/picocms/pico/CHANGELOG.md CHANGELOG.md

echo "Preparing 'composer.json' for release..."
composer require --no-update \
    "picocms/pico ^$VERSION_MILESTONE" \
    "picocms/pico-theme ^$VERSION_MILESTONE" \
    "picocms/pico-deprecated ^$VERSION_MILESTONE"

echo "Removing '.git' directory..."
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
