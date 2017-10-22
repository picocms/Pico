#!/usr/bin/env bash

##
# Updates the version file
#
# @author  Daniel Rudolf
# @link    http://picocms.org
# @license http://opensource.org/licenses/MIT
#

set -e

. "$(dirname "$0")/functions/parse-version.sh.inc"

# parameters
VERSION_FILE_PATH="$1"  # target file path
VERSION_STRING="$2"     # version string (e.g. 1.0.0-beta.1+7b4ad7f)

# print parameters
echo "Generating version file..."
printf 'VERSION_FILE_PATH="%s"\n' "$VERSION_FILE_PATH"
printf 'VERSION_STRING="%s"\n' "$VERSION_STRING"
echo

# evaluate version string (see http://semver.org/)
printf 'Evaluating version string...\n'
if ! parse_version "$VERSION_STRING"; then
    echo "Invalid version string; skipping..." >&2
    exit 1
fi

# generate version file
printf 'Updating version file...\n'
echo -n "" > "$VERSION_FILE_PATH"
exec 3> "$VERSION_FILE_PATH"

printf 'full: %s\n' "$VERSION_FULL" >&3
printf 'name: %s\n' "$VERSION_NAME" >&3
printf 'milestone: %s\n' "$VERSION_MILESTONE" >&3
printf 'stability: %s\n' "$VERSION_STABILITY" >&3
printf 'id: %d\n' "$VERSION_ID" >&3
printf 'major: %d\n' "$VERSION_MAJOR" >&3
printf 'minor: %d\n' "$VERSION_MINOR" >&3
printf 'patch: %d\n' "$VERSION_PATCH" >&3
printf 'suffix: %s\n' "$VERSION_SUFFIX" >&3
printf 'build: %s\n' "$VERSION_BUILD" >&3

exec 3>&-

echo
