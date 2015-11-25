#!/usr/bin/env bash
set -e

# parameters
PHPDOC_SOURCE_DIR="$1"
PHPDOC_TARGET_DIR="$2"
PHPDOC_TITLE="$3"

# generate phpdoc
phpdoc -d "$PHPDOC_SOURCE_DIR" \
    -i 'build/*' -i 'vendor/*' -i 'plugins/*' \
    -f 'plugins/DummyPlugin.php' \
    -t "$PHPDOC_TARGET_DIR" \
    --title "$PHPDOC_TITLE"
