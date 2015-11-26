#!/usr/bin/env bash

if [ "$TRAVIS_PHP_VERSION" != "5.3" ]; then
    echo "Skipping phpDoc deployment because this is not on the required runtime"
    exit
fi

if [[ ",$DEPLOY_PHPDOC_BRANCHES," != *,"$TRAVIS_BRANCH",* ]]; then
    echo "Skipping phpDoc deployment because this branch is not permitted to deploy"
    exit
fi

if [ "$TRAVIS_SECURE_ENV_VARS" != "true" ]; then
    echo "Skipping phpDoc deployment because this is no environment with write access to the repository"
    exit
fi

if [ "$TRAVIS_PULL_REQUEST" != "false" ]; then
    echo "Skipping phpDoc deployment because this pull request (#$TRAVIS_PULL_REQUEST) is not permitted to deploy"
    exit
fi

PHPDOC_ID="${TRAVIS_BRANCH//\//_}"

generate-phpdoc.sh \
    "$TRAVIS_BUILD_DIR" "$TRAVIS_BUILD_DIR/build/phpdoc-$PHPDOC_ID" \
    "Pico 1.0 API Documentation ($TRAVIS_BRANCH branch)"
[ $? -eq 0 ] || exit 1

deploy-phpdoc.sh \
    "$TRAVIS_REPO_SLUG" "$TRAVIS_BRANCH @ $TRAVIS_COMMIT" "$TRAVIS_BUILD_DIR/build/phpdoc-$PHPDOC_ID" \
    "$TRAVIS_REPO_SLUG" "gh-pages" "phpDoc/$PHPDOC_ID"
[ $? -eq 0 ] || exit 1
