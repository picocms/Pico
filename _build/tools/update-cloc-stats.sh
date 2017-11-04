#!/usr/bin/env bash

##
# Updates the cloc statistics files
#
# @author  Daniel Rudolf
# @link    http://picocms.org
# @license http://opensource.org/licenses/MIT
#

set -e

# parameters
TARGET_FILE="$1"     # statistics target file path

# print parameters
echo "Updating cloc statistics..."
printf 'TARGET_FILE="%s"\n' "$TARGET_FILE"
echo

# create cloc statistics
create_cloc_stats() {
    local CLOC_FILE="$1"
    shift

    cloc --yaml --report-file "$CLOC_FILE" \
        --progress-rate 0 \
        --read-lang-def <(
            echo "JSON"
            echo "    filter remove_matches ^\s*$"
            echo "    extension json"
            echo "    3rd_gen_scale 2.50"
            echo "Twig"
            echo "    filter remove_between_general {# #}"
            echo "    extension twig"
            echo "    3rd_gen_scale 2.00"
            echo "Markdown"
            echo "    filter remove_html_comments"
            echo "    extension md"
            echo "    3rd_gen_scale 1.00"
            echo "Apache config"
            echo "    filter remove_matches ^\s*#"
            echo "    filter remove_inline #.*$"
            echo "    extension htaccess"
            echo "    3rd_gen_scale 1.90"
        ) \
        --force-lang PHP,php.dist \
        --force-lang YAML,yml.template \
        "$@"
}

# remove header from cloc statistics
clean_cloc_stats() {
    local LINE=""
    local IS_HEADER="no"
    while IFS='' read -r LINE || [[ -n "$LINE" ]]; do
        if [ "$IS_HEADER" == "yes" ]; then
            # skip lines until next entry is reached
            [ "${LINE:0:2}" != "  " ] || continue
            IS_HEADER="no"
        elif [ "$LINE" == "header :" ]; then
            # header detected
            IS_HEADER="yes"
            continue
        fi

        echo "$LINE"
    done < <(tail -n +3 "$1")
}

# create temporary file
printf 'Creating temporary file...\n'
TMP_FILE="$(mktemp)"
[ -n "$TMP_FILE" ] || exit 1
echo

# create statistics
printf 'Creating statistics...\n'
create_cloc_stats "$TMP_FILE" \
    lib index.php
echo

# remove headers from cloc statistics
printf 'Writing statistics file without header...\n'
clean_cloc_stats "$TMP_FILE" > "$TARGET_FILE"
echo

# remove temporary file
printf 'Removing temporary file...\n'
rm "$TMP_FILE"
echo
