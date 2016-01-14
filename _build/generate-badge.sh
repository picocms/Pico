#!/usr/bin/env bash

##
# Downloads a custom badge from shields.io
#
# All credit goes to the awesome guys at shields.io!
#
# @see     http://shields.io/
#
# @author  Daniel Rudolf
# @link    http://picocms.org
# @license http://opensource.org/licenses/MIT
#

set -e

# parameters
BADGE_FILE_PATH="$1"
BADGE_SUBJECT="$2"
BADGE_STATUS="$3"
BADGE_COLOR="$4"

# print parameters
echo "Generating badge..."
printf 'BADGE_FILE_PATH="%s"\n' "$BADGE_FILE_PATH"
printf 'BADGE_SUBJECT="%s"\n' "$BADGE_SUBJECT"
printf 'BADGE_STATUS="%s"\n' "$BADGE_STATUS"
printf 'BADGE_COLOR="%s"\n' "$BADGE_COLOR"
echo

# download badge from shields.io
printf 'Downloading badge...\n'
TMP_BADGE="$(mktemp -u)"

wget -O "$TMP_BADGE" \
    "https://img.shields.io/badge/$BADGE_SUBJECT-$BADGE_STATUS-$BADGE_COLOR.svg"

# validate badge
if [ ! -f "$TMP_BADGE" ]; then
    echo "Unable to generate badge; aborting...\n" >&2
    exit 1
fi

# MIME type image/svg+xml isn't supported at the moment
#
#TMP_BADGE_MIME="$(file --mime-type "$TMP_BADGE" | cut -d ' ' -f 2)"
#if [ "$TMP_BADGE_MIME" != "image/svg+xml" ]; then
#    echo "Generated badge should be of type 'image/svg+xml', '$TMP_BADGE_MIME' given; aborting...\n" >&2
#    exit 1
#fi

# deploy badge
mv "$TMP_BADGE" "$BADGE_FILE_PATH"

echo
