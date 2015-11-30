#!/usr/bin/env bash
set -e

# parameters
PHPDOC_CONFIG="$1"
PHPDOC_CACHE_DIR="$3"
PHPDOC_TARGET_DIR="$4"
PHPDOC_TITLE="$5"

# print parameters
echo "Generating phpDocs..."
printf 'PHPDOC_SOURCE_DIR="%s"\n' "$PHPDOC_SOURCE_DIR"
printf 'PHPDOC_TARGET_DIR="%s"\n' "$PHPDOC_TARGET_DIR"
printf 'PHPDOC_TITLE="%s"\n' "$PHPDOC_TITLE"
echo

# generate phpdoc
phpdoc --config "$PHPDOC_CONFIG" \
    --cache-folder "$PHPDOC_CACHE_DIR" \
    --target "$PHPDOC_TARGET_DIR" \
    --title "$PHPDOC_TITLE"

echo
