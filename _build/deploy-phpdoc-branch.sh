#!/usr/bin/env bash

if [ "$TRAVIS_PHP_VERSION" != "5.3" ]; then
    echo "Skipping phpDoc deployment because this is not on the required runtime"
    exit
fi

if [[ ",$DEPLOY_PHPDOC_BRANCHES," != *,"$TRAVIS_BRANCH",* ]]; then
    echo "Skipping phpDoc deployment because this branch ($TRAVIS_BRANCH) is not permitted to deploy"
    exit
fi

if [ "$TRAVIS_PULL_REQUEST" != "false" ]; then
    echo "Skipping phpDoc deployment because this pull request (#$TRAVIS_PULL_REQUEST) is not permitted to deploy"
    exit
fi

PHPDOC_ID="${TRAVIS_BRANCH//\//_}"
PHPDOC_GIT_DIR="$TRAVIS_BUILD_DIR/_build/phpdoc-$PHPDOC_ID.git"

# clone repo
echo "Cloning repo..."
git clone --branch="gh-pages" "https://github.com/$TRAVIS_REPO_SLUG.git" "$PHPDOC_GIT_DIR"
[ $? -eq 0 ] || exit 1

cd "$PHPDOC_GIT_DIR"
echo

# generate phpDocs
generate-phpdoc.sh \
    "$TRAVIS_BUILD_DIR/.phpdoc.xml" \
    "$PHPDOC_GIT_DIR/phpDoc/$PHPDOC_ID.cache" "$PHPDOC_GIT_DIR/phpDoc/$PHPDOC_ID" \
    "Pico 1.0 API Documentation ($TRAVIS_BRANCH branch)"
[ $? -eq 0 ] || exit 1

# deploy phpDocs
deploy-phpdoc.sh \
    "Update phpDocumentor class docs for $TRAVIS_BRANCH branch @ $TRAVIS_COMMIT" \
    "$TRAVIS_REPO_SLUG" "heads/$TRAVIS_BRANCH" "$TRAVIS_COMMIT"
[ $? -eq 0 ] || exit 1
