#!/usr/bin/env bash

[ "$DEPLOY_PHPDOC_RELEASES" == "true" ] || exit

PHPDOC_ID="${TRAVIS_BRANCH//\//_}"
PHPDOC_GIT_DIR="$TRAVIS_BUILD_DIR/_build/phpdoc-$PHPDOC_ID.git"
PHPDOC_CACHE_DIR="$TRAVIS_BUILD_DIR/_build/phpdoc-$PHPDOC_ID.cache"
PHPDOC_TARGET_DIR="$PHPDOC_GIT_DIR/phpDoc/$PHPDOC_ID"

# clone repo
echo "Cloning repo..."
git clone --branch="gh-pages" "https://github.com/$TRAVIS_REPO_SLUG.git" "$PHPDOC_GIT_DIR"
[ $? -eq 0 ] || exit 1

cd "$PHPDOC_GIT_DIR"
echo

# generate phpDocs
generate-phpdoc.sh \
    "$TRAVIS_BUILD_DIR/.phpdoc.xml" \
    "$PHPDOC_CACHE_DIR" "$PHPDOC_TARGET_DIR" \
    "Pico 1.0 API Documentation ($TRAVIS_TAG)"
[ $? -eq 0 ] || exit 1

# deploy phpDocs
deploy-phpdoc.sh \
    "Update phpDocumentor class docs for $TRAVIS_TAG" \
    "$TRAVIS_REPO_SLUG" "tags/$TRAVIS_TAG" "$TRAVIS_COMMIT"
[ $? -eq 0 ] || exit 1
