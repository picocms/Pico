#!/usr/bin/env bash

[ "$DEPLOY_PHPDOC_RELEASES" == "true" ] || exit

PHPDOC_ID="${TRAVIS_BRANCH//\//_}"
GIT_DIR="$TRAVIS_BUILD_DIR/_build/phpdoc-$PHPDOC_ID.git"

# clone repo
echo "Cloning repo..."
git clone --branch="gh-pages" "https://github.com/$TRAVIS_REPO_SLUG.git" "$GIT_DIR"
[ $? -eq 0 ] || exit 1

cd "$GIT_DIR"
echo

# generate phpDocs
generate-phpdoc.sh \
    "$TRAVIS_BUILD_DIR/.phpdoc.xml" \
    "-" "$GIT_DIR/phpDoc/$PHPDOC_ID" \
    "Pico 1.0 API Documentation ($TRAVIS_TAG)"
[ $? -eq 0 ] || exit 1

# commit phpDocs
git add "$GIT_DIR/phpDoc/$PHPDOC_ID"
git commit \
    --message="Update phpDocumentor class docs for $TRAVIS_TAG" \
    "$GIT_DIR/phpDoc/$PHPDOC_ID"
[ $? -eq 0 ] || exit 1

# update version badge
gnerate-badge.sh \
    "$GIT_DIR/badges/pico-version.svg" \
    "release" "v$TRAVIS_TAG" "blue"

# commit version badge
git add "$GIT_DIR/badges/pico-version.svg"
git commit \
    --message="Update version badge for $TRAVIS_TAG" \
    "$GIT_DIR/badges/pico-version.svg"

# deploy
github-deploy.sh "$TRAVIS_REPO_SLUG" "tags/$TRAVIS_TAG" "$TRAVIS_COMMIT"
[ $? -eq 0 ] || exit 1
