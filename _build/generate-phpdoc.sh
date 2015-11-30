#!/usr/bin/env bash
set -e

# parameters
PHPDOC_CONFIG="$1"          # phpDoc config file
PHPDOC_CACHE_DIR="$2"       # phpDoc cache dir
PHPDOC_TARGET_DIR="$3"      # phpDoc output dir
PHPDOC_TITLE="$4"           # API docs title

# print parameters
echo "Generating phpDocs..."
printf 'PHPDOC_CONFIG="%s"\n' "$PHPDOC_CONFIG"
printf 'PHPDOC_CACHE_DIR="%s"\n' "$PHPDOC_CACHE_DIR"
printf 'PHPDOC_TARGET_DIR="%s"\n' "$PHPDOC_TARGET_DIR"
printf 'PHPDOC_TITLE="%s"\n' "$PHPDOC_TITLE"
echo

# update a separate phpDoc cache
if [ "$PHPDOC_CACHE_DIR" != "-" ]; then
    # parse phpDoc files (i.e. update cache)
    printf "\nUpdate phpDoc cache...\n"
    phpdoc project:parse --config "$PHPDOC_CONFIG" \
        --target "$PHPDOC_CACHE_DIR"

    # check for changes
    printf '\nCheck for phpDoc cache changes...\n'
    if [ -z "$(git status --porcelain "$PHPDOC_CACHE_DIR")" ]; then
        printf 'No changes detected; skipping phpDocs renewal...\n\n'
        exit 0
    fi

    # NOTE: actually the following command should be `phpdoc project:transform`
    #       instead of `phpdoc project:run`, but the command seems to be broken...
else
    # create temporary cache files in PHPDOC_TARGET_DIR
    PHPDOC_CACHE_DIR="$PHPDOC_TARGET_DIR"
fi

# transform phpDoc files (i.e. rewrite API docs)
printf '\nRewrite phpDocs...\n'
rm -rf "$PHPDOC_TARGET_DIR"
phpdoc project:run --config "$PHPDOC_CONFIG" \
    --cache-folder "$PHPDOC_CACHE_DIR" \
    --target "$PHPDOC_TARGET_DIR" \
    --title "$PHPDOC_TITLE"

echo
