#!/usr/bin/env bash

if [ "$DEPLOY_PHPDOC_RELEASES" != "true" ]; then
    echo "Skipping phpDoc release deployment because it has been disabled"
fi
if [ "$DEPLOY_VERSION_BADGE" != "true" ]; then
    echo "Skipping version badge deployment because it has been disabled"
fi
if [ "$DEPLOY_PHPDOC_RELEASES" != "true" ] || [ "$DEPLOY_VERSION_BADGE" != "true" ]; then
    [ "$DEPLOY_PHPDOC_RELEASES" != "true" ] && [ "$DEPLOY_VERSION_BADGE" != "true" ] && exit || echo
fi

PHPDOC_ID="${TRAVIS_BRANCH//\//_}"
GIT_DIR="$TRAVIS_BUILD_DIR/_build/phpdoc-$PHPDOC_ID.git"

# clone repo
echo "Cloning repo..."
git clone --branch="gh-pages" "https://github.com/$TRAVIS_REPO_SLUG.git" "$GIT_DIR"
[ $? -eq 0 ] || exit 1

cd "$GIT_DIR"
echo

# setup repo
github-setup.sh

# generate phpDocs
if [ "$DEPLOY_PHPDOC_RELEASES" == "true" ]; then
    generate-phpdoc.sh \
        "$TRAVIS_BUILD_DIR/.phpdoc.xml" \
        "-" "$GIT_DIR/phpDoc/$PHPDOC_ID" \
        "Pico 1.0 API Documentation ($TRAVIS_TAG)"
    [ $? -eq 0 ] || exit 1

    # commit phpDocs
    if [ -n "$(git status --porcelain "$GIT_DIR/phpDoc/$PHPDOC_ID")" ]; then
        echo "Committing phpDoc changes..."
        git add "$GIT_DIR/phpDoc/$PHPDOC_ID"
        git commit \
            --message="Update phpDocumentor class docs for $TRAVIS_TAG" \
            "$GIT_DIR/phpDoc/$PHPDOC_ID"
        [ $? -eq 0 ] || exit 1
        echo
    fi
fi

# update version badge
if [ "$DEPLOY_VERSION_BADGE" == "true" ]; then
    generate-badge.sh \
        "$GIT_DIR/badges/pico-version.svg" \
        "release" "$TRAVIS_TAG" "blue"

    # commit version badge
    echo "Committing changes..."
    git add "$GIT_DIR/badges/pico-version.svg"
    git commit \
        --message="Update version badge for $TRAVIS_TAG" \
        "$GIT_DIR/badges/pico-version.svg"
    [ $? -eq 0 ] || exit 1
    echo
fi

# deploy
github-deploy.sh "$TRAVIS_REPO_SLUG" "tags/$TRAVIS_TAG" "$TRAVIS_COMMIT"
[ $? -eq 0 ] || exit 1
