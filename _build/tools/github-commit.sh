#!/usr/bin/env bash

##
# Commits changes to a Git repo
#
# @author  Daniel Rudolf
# @link    http://picocms.org
# @license http://opensource.org/licenses/MIT
#

set -e

# parameters
COMMIT_MESSAGE="$1"     # commit message
shift 1

# print parameters
echo "Commiting changes..."
printf 'COMMIT_MESSAGE="%s"\n' "$COMMIT_MESSAGE"
echo

# stage changes
COMMIT_FILES=()
while [ $# -gt 0 ]; do
    if [ -n "$(git status --porcelain "$1")" ]; then
        if [ -d "$1" ]; then
            git add --all "$1"
        elif [ -f "$1" ] || [ -h "$1" ]; then
            git add "$1"
        else
            echo "Unable to commit '$1': No such file, symbolic link or directory" >&2
            exit 1
        fi

        COMMIT_FILES+=( "$1" )
        shift
    fi
done

# commit changes
if [ ${#COMMIT_FILES[@]} -gt 0 ]; then
    git commit --message="$COMMIT_MESSAGE" "${COMMIT_FILES[@]}"
fi

echo
