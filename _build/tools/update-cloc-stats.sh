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
CORE_TARGET_FILE="$1"     # target file path for core statistics
RELEASE_TARGET_FILE="$2"  # target file path for release package statistics

# print parameters
echo "Updating cloc statistics..."
printf 'CORE_TARGET_FILE="%s"\n' "$CORE_TARGET_FILE"
printf 'RELEASE_TARGET_FILE="%s"\n' "$RELEASE_TARGET_FILE"
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

# create temporary files
printf 'Creating temporary files...\n'
CORE_TMP_FILE="$(mktemp)"
RELEASE_TMP_FILE="$(mktemp)"
[ -n "$CORE_TMP_FILE" ] && [ -n "$RELEASE_TMP_FILE" ] || exit 1
echo

# create core statistics
printf 'Creating core statistics...\n'
create_cloc_stats "$CORE_TMP_FILE" \
    lib index.php
echo

printf 'Creating release package statistics...\n'
create_cloc_stats "$RELEASE_TMP_FILE" \
    README.md LICENSE.md CONTRIBUTING.md CHANGELOG.md \
    assets config content content-sample lib plugins themes \
    .htaccess index.php.dist composer.json
echo

# remove headers from cloc statistics
printf 'Writing core statistics file without header...\n'
clean_cloc_stats "$CORE_TMP_FILE" > "$CORE_TARGET_FILE"

printf 'Writing release package statistics file without header...\n'
clean_cloc_stats "$RELEASE_TMP_FILE" > "$RELEASE_TARGET_FILE"
echo

# remove temporary files
printf 'Removing temporary files...\n'
rm "$CORE_TMP_FILE" "$RELEASE_TMP_FILE"
echo
