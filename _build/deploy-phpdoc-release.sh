#!/usr/bin/env bash

[ "$DEPLOY_PHPDOC_RELEASES" == "true" ] || exit

PHPDOC_ID="${TRAVIS_BRANCH//\//_}"

generate-phpdoc.sh \
    "$TRAVIS_BUILD_DIR/.phpdoc.xml" \
    "$TRAVIS_BUILD_DIR/_build/phpdoc.cache" \
    "$TRAVIS_BUILD_DIR/_build/phpdoc-$PHPDOC_ID" \
    "Pico 1.0 API Documentation ($TRAVIS_TAG)"
[ $? -eq 0 ] || exit 1

deploy-phpdoc.sh \
    "$TRAVIS_REPO_SLUG" "tags/$TRAVIS_TAG" "$TRAVIS_BUILD_DIR/_build/phpdoc-$PHPDOC_ID" \
    "$TRAVIS_REPO_SLUG" "gh-pages" "phpDoc/$PHPDOC_ID"
[ $? -eq 0 ] || exit 1
