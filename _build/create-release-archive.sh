#!/usr/bin/env bash

RELEASE="$1"
ARCHIVE="pico-release.tar.gz"
[ -n "$RELEASE" ] && ARCHIVE="pico-release-$RELEASE.tar.gz"

# install dependencies
echo "Running \`composer install\`..."
composer install --no-dev --optimize-autoloader
[ $? -eq 0 ] || exit 1
echo

# remove .git dirs
echo "Removing '.git' directories of dependencies..."
find vendor/ -type d -path 'vendor/*/*/.git' -print0 | xargs -0 rm -rf
echo

# create release archive
echo "Creating release archive '$ARCHIVE'..."

if [ -e "$ARCHIVE" ]; then
    echo "Unable to create archive: File exists" >&2
    exit 1
fi

INDEX_BACKUP="$(mktemp -u)"
mv index.php "$INDEX_BACKUP"
mv index.php.dist index.php

tar -czf "$ARCHIVE" \
    README.md LICENSE.md CONTRIBUTING.md CHANGELOG.md \
    composer.json composer.lock \
    config content-sample lib plugins themes vendor \
    .htaccess index.php
EXIT=$?

mv index.php index.php.dist
mv "$INDEX_BACKUP" index.php

echo

[ $EXIT -eq 0 ] || exit 1
