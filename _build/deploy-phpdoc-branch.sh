#!/usr/bin/env bash

if [ "$TRAVIS_PHP_VERSION" != "5.3" ]; then
    echo "Skipping branch deployment because this is not on the required runtime"
    exit 0
fi

if [ "$TRAVIS_PULL_REQUEST" != "false" ]; then
    echo "Skipping branch deployment because this pull request (#$TRAVIS_PULL_REQUEST) is not permitted to deploy"
    exit 0
fi

if [[ ",$DEPLOY_PHPDOC_BRANCHES," != *,"$TRAVIS_BRANCH",* ]]; then
    echo "Skipping phpDoc branch deployment because this branch ($TRAVIS_BRANCH) is not permitted to deploy"
    exit 0
fi

DEPLOYMENT_ID="${TRAVIS_BRANCH//\//_}"
DEPLOYMENT_DIR="$TRAVIS_BUILD_DIR/_build/deploy-$DEPLOYMENT_ID.git"

# clone repo
echo "Cloning repo..."
git clone --branch="gh-pages" "https://github.com/$TRAVIS_REPO_SLUG.git" "$DEPLOYMENT_DIR"
[ $? -eq 0 ] || exit 1

cd "$DEPLOYMENT_DIR"
echo

# setup repo
github-setup.sh

# generate phpDocs
generate-phpdoc.sh \
    "$TRAVIS_BUILD_DIR/.phpdoc.xml" \
    "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID.cache" "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID" \
    "Pico 1.0 API Documentation ($TRAVIS_BRANCH branch)"
[ $? -eq 0 ] || exit 1
[ -n "$(git status --porcelain "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID.cache")" ] || exit 0

# update phpDoc list
update-phpdoc-list.sh \
    "$DEPLOYMENT_DIR/_data/phpDoc.yml" \
    "$TRAVIS_BRANCH" "branch" "<code>$TRAVIS_BRANCH</code> branch" "$(date +%s)"

# commit phpDocs
echo "Committing changes..."
git add \
    "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID.cache" "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID" \
    "$DEPLOYMENT_DIR/_data/phpDoc.yml"
git commit \
    --message="Update phpDocumentor class docs for $TRAVIS_BRANCH branch @ $TRAVIS_COMMIT" \
    "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID.cache" "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID" \
    "$DEPLOYMENT_DIR/_data/phpDoc.yml"
[ $? -eq 0 ] || exit 1
echo

# deploy phpDocs
github-deploy.sh "$TRAVIS_REPO_SLUG" "heads/$TRAVIS_BRANCH" "$TRAVIS_COMMIT"
[ $? -eq 0 ] || exit 1
