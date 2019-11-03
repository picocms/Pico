#!/usr/bin/env bash
set -e

[ -n "$PICO_BUILD_ENV" ] || { echo "No Pico build environment specified" >&2; exit 1; }

# parameters
VERSION="${1:-$PROJECT_REPO_TAG}"       # version to create a release for
ARCHIVE_DIR="${2:-$PICO_PROJECT_DIR}"   # directory to create release archives in

# print parameters
echo "Creating new release..."
printf 'VERSION="%s"\n' "$VERSION"
echo

# guess version string
if [ -z "$VERSION" ]; then
    PICO_VERSION="$(php -r "
        require_once('$PICO_PROJECT_DIR/lib/Pico.php');
        echo preg_replace('/-(?:dev|n|nightly)(?:[.-]?[0-9]+)?(?:[.-]dev)?$/', '', Pico::VERSION);
    ")"

    VERSION="v$PICO_VERSION-dev+${PROJECT_REPO_BRANCH:-master}"
    echo "Creating development release of Pico v$PICO_VERSION ($VERSION)..."
    echo
fi

# parse version
. "$PICO_TOOLS_DIR/functions/parse-version.sh.inc"

if ! parse_version "$VERSION"; then
    echo "Unable to create release archive: Invalid version '$VERSION'" >&2
    exit 1
fi

DEPENDENCY_VERSION="$VERSION_FULL@$VERSION_STABILITY"
if [ "$VERSION_STABILITY" == "dev" ] && [ -n "$VERSION_BUILD" ]; then
    DEPENDENCY_VERSION="dev-$VERSION_BUILD"
fi

# clone repo
github-clone.sh "$PICO_BUILD_DIR" "https://github.com/$RELEASE_REPO_SLUG.git" "$RELEASE_REPO_BRANCH"

cd "$PICO_BUILD_DIR"

# force Pico version
echo "Updating composer dependencies..."
composer require --no-update \
    "picocms/pico $DEPENDENCY_VERSION" \
    "picocms/pico-theme $DEPENDENCY_VERSION" \
    "picocms/pico-deprecated $DEPENDENCY_VERSION"
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

echo "Removing '.git' directories of plugins and themes..."
find themes/ -type d -path 'themes/*/.git' -print0 | xargs -0 rm -rf
find plugins/ -type d -path 'plugins/*/.git' -print0 | xargs -0 rm -rf

echo "Preparing 'composer.json' for release..."
composer require --no-update \
    "picocms/pico ^$VERSION_MILESTONE" \
    "picocms/pico-theme ^$VERSION_MILESTONE" \
    "picocms/pico-deprecated ^$VERSION_MILESTONE"

# create release archives
create-release.sh "$PICO_BUILD_DIR" "$ARCHIVE_DIR" "pico-release-v$VERSION_FULL"
