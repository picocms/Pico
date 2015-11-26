#!/usr/bin/env bash

if [ "$TRAVIS_PHP_VERSION" != "5.3" ]; then
    echo "Skipping phpDoc deployment because this is not on the required runtime"
    exit
fi

if [[ ",$DEPLOY_PHPDOC_BRANCHES," != *,"$TRAVIS_BRANCH",* ]]; then
    echo "Skipping phpDoc deployment because this branch ($TRAVIS_BRANCH) is not permitted to deploy"
    exit
fi

if [ "$TRAVIS_SECURE_ENV_VARS" != "true" ]; then
    echo "Skipping phpDoc deployment because this is no environment with write access to the repository"
    exit
fi

PHPDOC_ID="${TRAVIS_BRANCH//\//_}"
PHPDOC_REF="heads/$TRAVIS_BRANCH @ $TRAVIS_COMMIT"
PHPDOC_REF_TEXT="$TRAVIS_BRANCH branch"

if [ "$TRAVIS_PULL_REQUEST" != "false" ]; then
    PHPDOC_ID="pull_$TRAVIS_PULL_REQUEST"
    PHPDOC_REF="pull/$TRAVIS_PULL_REQUEST/head"
    PHPDOC_REF_TEXT="pull request #$TRAVIS_PULL_REQUEST"

    if [[ ",$DEPLOY_PHPDOC_BRANCHES," != *,"#$TRAVIS_PULL_REQUEST",* ]]; then
        echo "Skipping phpDoc deployment because this pull request (#$TRAVIS_PULL_REQUEST) is not permitted to deploy"
        exit
    fi
fi

generate-phpdoc.sh \
    "$TRAVIS_BUILD_DIR" "$TRAVIS_BUILD_DIR/build/phpdoc-$PHPDOC_ID" \
    "Pico 1.0 API Documentation ($PHPDOC_REF_TEXT)"
[ $? -eq 0 ] || exit 1

deploy-phpdoc.sh \
    "$TRAVIS_REPO_SLUG" "$PHPDOC_REF" "$TRAVIS_BUILD_DIR/build/phpdoc-$PHPDOC_ID" \
    "$TRAVIS_REPO_SLUG" "gh-pages" "phpDoc/$PHPDOC_ID"
[ $? -eq 0 ] || exit 1
