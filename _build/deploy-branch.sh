#!/usr/bin/env bash
set -e

export PATH="$(dirname "$0")/tools:$PATH"

DEPLOYMENT_ID="${TRAVIS_BRANCH//\//_}"
DEPLOYMENT_DIR="$TRAVIS_BUILD_DIR/_build/deploy-$DEPLOYMENT_ID.git"

[ -n "$DEPLOY_REPO_SLUG" ] || export DEPLOY_REPO_SLUG="$TRAVIS_REPO_SLUG"
[ -n "$DEPLOY_REPO_BRANCH" ] || export DEPLOY_REPO_BRANCH="gh-pages"

# get current Pico milestone
VERSION="$(php -r 'require_once(__DIR__ . "/lib/Pico.php"); echo Pico::VERSION;')"
MILESTONE="Pico$([[ "$VERSION" =~ ^([0-9]+\.[0-9]+)\. ]] && echo " ${BASH_REMATCH[1]}")"

echo "Deploying $TRAVIS_BRANCH branch ($MILESTONE)..."
echo

# clone repo
github-clone.sh "$DEPLOYMENT_DIR" "https://github.com/$DEPLOY_REPO_SLUG.git" "$DEPLOY_REPO_BRANCH"

cd "$DEPLOYMENT_DIR"

# setup repo
github-setup.sh

# generate phpDocs
generate-phpdoc.sh \
    "$TRAVIS_BUILD_DIR/.phpdoc.xml" \
    "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID.cache" "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID" \
    "$MILESTONE API Documentation ($TRAVIS_BRANCH branch)"

if [ -z "$(git status --porcelain "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID.cache")" ]; then
    # nothing to do
    exit 0
fi

# update phpDoc list
update-phpdoc-list.sh \
    "$DEPLOYMENT_DIR/_data/phpDoc.yml" \
    "$TRAVIS_BRANCH" "branch" "<code>$TRAVIS_BRANCH</code> branch" "$(date +%s)"

# commit phpDocs
github-commit.sh \
    "Update phpDocumentor class docs for $TRAVIS_BRANCH branch @ $TRAVIS_COMMIT" \
    "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID.cache" "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID" \
    "$DEPLOYMENT_DIR/_data/phpDoc.yml"

# deploy phpDocs
github-deploy.sh "$TRAVIS_REPO_SLUG" "heads/$TRAVIS_BRANCH" "$TRAVIS_COMMIT"
