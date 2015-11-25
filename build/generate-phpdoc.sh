#!/usr/bin/env bash
set -e

# parameters
PHPDOC_SOURCE_DIR="$1"
PHPDOC_TARGET_DIR="$2"
PHPDOC_TITLE="$3"

# print parameters
echo "Generating phpDocs..."
printf 'PHPDOC_SOURCE_DIR="%s"\n' "$PHPDOC_SOURCE_DIR"
printf 'PHPDOC_TARGET_DIR="%s"\n' "$PHPDOC_TARGET_DIR"
printf 'PHPDOC_TITLE="%s"\n' "$PHPDOC_TITLE"
echo

# generate phpdoc
phpdoc -d "$PHPDOC_SOURCE_DIR" \
    -i "$PHPDOC_SOURCE_DIR/build/" \
    -i "$PHPDOC_SOURCE_DIR/vendor/" \
    -i "$PHPDOC_SOURCE_DIR/plugins/" -f "$PHPDOC_SOURCE_DIR/plugins/DummyPlugin.php" \
    -t "$PHPDOC_TARGET_DIR" \
    --title "$PHPDOC_TITLE"

echo
