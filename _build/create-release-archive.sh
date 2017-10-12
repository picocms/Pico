#!/usr/bin/env bash

ARCHIVE="$1"

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
    assets config content content-sample lib plugins themes vendor \
    .htaccess index.php
EXIT=$?

mv index.php index.php.dist
mv "$INDEX_BACKUP" index.php

echo

[ $EXIT -eq 0 ] || exit 1
