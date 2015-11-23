#!/usr/bin/env bash
set -e

# parameters
GITHUB_PROJECT="$1"         # GitHub repo (e.g. picocms/Pico)
GITHUB_BRANCH="$2"          # branch to use (e.g. gh-pages)
GITHUB_OAUTH_TOKEN="$3"     # see https://github.com/settings/tokens
SOURCE_DIR="$4"             # absolute path to phpDocs target directory
TARGET_DIR="$5"             # relative path within the specified GitHub repo

# clone repo
GIT_DIR="$(dirname "$0")/$(basename "$SOURCE_DIR").git"
git clone -b "$GITHUB_BRANCH" "https://github.com/$GITHUB_PROJECT.git" "$GIT_DIR"

# setup git
cd "$GIT_DIR"
git config user.name "Travis CI"
git config user.email "travis-ci@picocms.org"

# copy phpdoc
[ -e "$TARGET_DIR" ] && echo "FATAL: $(basename "$0") target directory exists" && exit 1
cp -R "$SOURCE_DIR" "$TARGET_DIR"

# commit changes
git add "$TARGET_DIR"
git commit -m "Add phpDocumentor class docs for Pico $TRAVIS_TAG"

# push changes
git push --force --quiet "https://${GITHUB_OAUTH_TOKEN}@github.com/$GITHUB_PROJECT.git" "$GITHUB_BRANCH:$GITHUB_BRANCH" > /dev/null 2>&1
