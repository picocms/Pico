#!/usr/bin/env bash

##
# Clones a Git repo
#
# @author  Daniel Rudolf
# @link    http://picocms.org
# @license http://opensource.org/licenses/MIT
#

set -e

# parameters
CLONE_TARGET_DIR="$1"   # target directory
CLONE_REPO_URL="$2"     # URL of the git repo to clone
CLONE_REPO_BRANCH="$3"  # optional branch to checkout

# print parameters
echo "Cloning repo..."
printf 'CLONE_TARGET_DIR="%s"\n' "$CLONE_TARGET_DIR"
printf 'CLONE_REPO_URL="%s"\n' "$CLONE_REPO_URL"
printf 'CLONE_REPO_BRANCH="%s"\n' "$CLONE_REPO_BRANCH"
echo

# clone repo
[ -n "$CLONE_REPO_BRANCH" ] || CLONE_REPO_BRANCH="master"
git clone --branch="$CLONE_REPO_BRANCH" "$CLONE_REPO_URL" "$CLONE_TARGET_DIR"

echo
