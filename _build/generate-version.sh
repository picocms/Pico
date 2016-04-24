#!/usr/bin/env bash

##
# Updates the version file
#
# @author  Daniel Rudolf
# @link    http://picocms.org
# @license http://opensource.org/licenses/MIT
#

set -e

# parameters
VERSION_FILE_PATH="$1"  # target file path
VERSION_FULL="$2"       # full version string (e.g. 1.0.0-beta.1+7b4ad7f)

# print parameters
echo "Generating version file..."
printf 'VERSION_FILE_PATH="%s"\n' "$VERSION_FILE_PATH"
printf 'VERSION_FULL="%s"\n' "$VERSION_FULL"
echo

# evaluate version constraint (see http://semver.org/)
printf 'Evaluating version constraint...\n'
if [[ "$VERSION_FULL" =~ ^([0-9]+)\.([0-9]{1,2})\.([0-9]{1,2})(-([0-9A-Za-z\.\-]+))?(\+([0-9A-Za-z\.\-]+))?$ ]]; then
    VERSION_MAJOR="${BASH_REMATCH[1]}"
    VERSION_MINOR="${BASH_REMATCH[2]}"
    VERSION_PATCH="${BASH_REMATCH[3]}"
    VERSION_SUFFIX="${BASH_REMATCH[5]}"
    VERSION_BUILD="${BASH_REMATCH[7]}"

    VERSION_MILESTONE="$VERSION_MAJOR.$VERSION_MINOR"
    VERSION_NAME="$VERSION_MAJOR.$VERSION_MINOR.$VERSION_PATCH"
    VERSION_ID="$VERSION_MAJOR$(printf '%02d' "$VERSION_MINOR")$(printf '%02d' "$VERSION_PATCH")"
else
    echo "Invalid version constraint; skipping..." >&2
    exit 1
fi

# generate version file
printf 'Updating version file...\n'
echo -n "" > "$VERSION_FILE_PATH"
exec 3> "$VERSION_FILE_PATH"

printf 'full: %s\n' "$VERSION_FULL" >&3
printf 'name: %s\n' "$VERSION_NAME" >&3
printf 'milestone: %s\n' "$VERSION_MILESTONE" >&3
printf 'id: %d\n' "$VERSION_ID" >&3
printf 'major: %d\n' "$VERSION_MAJOR" >&3
printf 'minor: %d\n' "$VERSION_MINOR" >&3
printf 'patch: %d\n' "$VERSION_PATCH" >&3
printf 'suffix: %s\n' "$VERSION_SUFFIX" >&3
printf 'build: %s\n' "$VERSION_BUILD" >&3

exec 3>&-

echo
