#!/usr/bin/env bash
set -e

export PATH="$PICO_TOOLS_DIR:$PATH"
. "$PICO_TOOLS_DIR/functions/parse-version.sh.inc"

# parameters
ARCHIVE_DIR="$1"        # directory to create release archives in
ARCHIVE_FILENAME="$2"   # release archive file name (without file extension)

if [ -z "$ARCHIVE_DIR" ] || [ "$(realpath "$ARCHIVE_DIR")" == "$(realpath "$PICO_BUILD_DIR")" ]; then
    echo "Unable to create release archives: Invalid release archive target dir '$ARCHIVE_DIR'" >&2
    exit 1
fi
if [ -z "$ARCHIVE_FILENAME" ]; then
    echo "Unable to create release archives: No release archive file name given" >&2
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

# create release archives
echo "Creating release archive '$ARCHIVE.tar.gz'..."

if [ -e "$ARCHIVE_DIR/$ARCHIVE.tar.gz" ]; then
    echo "Unable to create release archive: File '$ARCHIVE.tar.gz' exists" >&2
    exit 1
fi

find . -mindepth 1 -maxdepth 1 -printf '%f\0' \
    | xargs -0 -- tar -czf "$ARCHIVE_DIR/$ARCHIVE.tar.gz" --
echo

echo "Creating release archive '$ARCHIVE.zip'..."

if [ -e "$ARCHIVE_DIR/$ARCHIVE.zip" ]; then
    echo "Unable to create release archive: File '$ARCHIVE.zip' exists" >&2
    exit 1
fi

zip -q -r "$ARCHIVE_DIR/$ARCHIVE.zip" .
echo
