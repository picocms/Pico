#!/usr/bin/env bash
set -e

# parameters
PHPDOC_CONFIG="$1"
PHPDOC_CACHE_DIR="$2"
PHPDOC_TARGET_DIR="$3"
PHPDOC_TITLE="$4"

# print parameters
echo "Generating phpDocs..."
printf 'PHPDOC_CONFIG="%s"\n' "$PHPDOC_CONFIG"
printf 'PHPDOC_CACHE_DIR="%s"\n' "$PHPDOC_CACHE_DIR"
printf 'PHPDOC_TARGET_DIR="%s"\n' "$PHPDOC_TARGET_DIR"
printf 'PHPDOC_TITLE="%s"\n' "$PHPDOC_TITLE"
echo

# generate phpdoc
phpdoc --config "$PHPDOC_CONFIG" \
    --cache-folder "$PHPDOC_CACHE_DIR" \
    --target "$PHPDOC_TARGET_DIR" \
    --title "$PHPDOC_TITLE"

echo
