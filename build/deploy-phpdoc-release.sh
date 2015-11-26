#!/usr/bin/env bash

[ "$DEPLOY_PHPDOC_RELEASES" == "true" ] || exit

PHPDOC_ID="${TRAVIS_BRANCH//\//_}"
PHPDOC_REF="tags/$TRAVIS_TAG"
PHPDOC_REF_TEXT="$TRAVIS_TAG"

generate-phpdoc.sh \
    "$TRAVIS_BUILD_DIR" "$TRAVIS_BUILD_DIR/build/phpdoc-$PHPDOC_ID" \
    "Pico 1.0 API Documentation ($PHPDOC_REF_TEXT)"
[ $? -eq 0 ] || exit 1

deploy-phpdoc.sh \
    "$TRAVIS_REPO_SLUG" "$PHPDOC_REF" "$TRAVIS_BUILD_DIR/build/phpdoc-$PHPDOC_ID" \
    "$TRAVIS_REPO_SLUG" "gh-pages" "phpDoc/$PHPDOC_ID"
[ $? -eq 0 ] || exit 1
