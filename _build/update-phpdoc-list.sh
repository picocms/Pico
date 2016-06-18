#!/usr/bin/env bash

##
# Updates the phpDoc list
#
# @author  Daniel Rudolf
# @link    http://picocms.org
# @license http://opensource.org/licenses/MIT
#

set -e

# parameters
LIST_FILE_PATH="$1"      # target file path
LIST_ID="$2"             # phpDoc ID
LIST_TYPE="$3"           # phpDoc type
LIST_TITLE="$4"          # phpDoc title
LIST_LAST_UPDATE="$5"    # phpDoc last update

# print parameters
echo "Updating phpDoc list..."
printf 'LIST_FILE_PATH="%s"\n' "$LIST_FILE_PATH"
printf 'LIST_ID="%s"\n' "$LIST_ID"
printf 'LIST_TYPE="%s"\n' "$LIST_TYPE"
printf 'LIST_TITLE="%s"\n' "$LIST_TITLE"
printf 'LIST_LAST_UPDATE="%s"\n' "$LIST_LAST_UPDATE"
echo

# create temporary file
printf 'Creating temporary file...\n'
LIST_TMP_FILE="$(mktemp)"
[ -n "$LIST_TMP_FILE" ] || exit 1

exec 3> "$LIST_TMP_FILE"

# walk through phpDoc list
printf 'Walking through phpDoc list...\n'

DO_REPLACE="no"
DID_REPLACE="no"
while IFS='' read -r LINE || [[ -n "$LINE" ]]; do
    if [ "$DO_REPLACE" == "yes" ]; then
        # skip lines until next entry is reached
        [ "${LINE:0:2}" == "  " ] && continue
        DO_REPLACE="no"

    elif [ "$LINE" == "- id: $LIST_ID" ]; then
        # update existing entry
        printf 'Updating existing entry...\n'
        printf -- '- id: %s\n' "$LIST_ID" >&3
        printf -- '  type: %s\n' "$LIST_TYPE" >&3
        printf -- '  title: %s\n' "$LIST_TITLE" >&3
        printf -- '  last_update: %s\n' "$LIST_LAST_UPDATE" >&3

        DO_REPLACE="yes"
        DID_REPLACE="yes"
        continue
    fi

    echo "$LINE" >&3
done < "$LIST_FILE_PATH"

# add new entry
if [ "$DID_REPLACE" == "no" ]; then
    printf 'Adding new entry...\n'
    printf -- '- id: %s\n' "$LIST_ID" >&3
    printf -- '  type: %s\n' "$LIST_TYPE" >&3
    printf -- '  title: %s\n' "$LIST_TITLE" >&3
    printf -- '  last_update: %s\n' "$LIST_LAST_UPDATE" >&3
fi

exec 3>&-

# move temporary file
printf 'Replacing phpDoc list...\n'
mv "$LIST_TMP_FILE" "$LIST_FILE_PATH"

echo
