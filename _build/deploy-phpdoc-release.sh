#!/usr/bin/env bash

if [ "$DEPLOY_PHPDOC_RELEASES" != "true" ]; then
    echo "Skipping phpDoc release deployment because it has been disabled"
fi
if [ "$DEPLOY_VERSION_BADGE" != "true" ]; then
    echo "Skipping version badge deployment because it has been disabled"
fi
if [ "$DEPLOY_VERSION_FILE" != "true" ]; then
    echo "Skipping version file deployment because it has been disabled"
fi
if [ "$DEPLOY_PHPDOC_RELEASES" != "true" ] || [ "$DEPLOY_VERSION_BADGE" != "true" ] || [ "$DEPLOY_VERSION_FILE" != "true" ]; then
    [ "$DEPLOY_PHPDOC_RELEASES" != "true" ] && [ "$DEPLOY_VERSION_BADGE" != "true" ] && [ "$DEPLOY_VERSION_FILE" != "true" ] && exit 0 || echo
fi

DEPLOYMENT_ID="${TRAVIS_BRANCH//\//_}"
DEPLOYMENT_DIR="$TRAVIS_BUILD_DIR/_build/deploy-$DEPLOYMENT_ID.git"

[ -n "$DEPLOY_REPO_SLUG" ] || export DEPLOY_REPO_SLUG="$TRAVIS_REPO_SLUG"
[ -n "$DEPLOY_REPO_BRANCH" ] || export DEPLOY_REPO_BRANCH="gh-pages"

# clone repo
github-clone.sh "$DEPLOYMENT_DIR" "https://github.com/$DEPLOY_REPO_SLUG.git" "$DEPLOY_REPO_BRANCH"
[ $? -eq 0 ] || exit 1

cd "$DEPLOYMENT_DIR"

# setup repo
github-setup.sh
[ $? -eq 0 ] || exit 1

# generate phpDocs
if [ "$DEPLOY_PHPDOC_RELEASES" == "true" ]; then
    generate-phpdoc.sh \
        "$TRAVIS_BUILD_DIR/.phpdoc.xml" \
        "-" "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID" \
        "Pico 1.0 API Documentation ($TRAVIS_TAG)"
    [ $? -eq 0 ] || exit 1

    if [ -n "$(git status --porcelain "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID")" ]; then
        # update phpDoc list
        update-phpdoc-list.sh \
            "$DEPLOYMENT_DIR/_data/phpDoc.yml" \
            "$TRAVIS_TAG" "version" "Pico ${TRAVIS_TAG#v}" "$(date +%s)"
        [ $? -eq 0 ] || exit 1

        # commit phpDocs
        echo "Committing phpDoc changes..."
        git add "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID" "$DEPLOYMENT_DIR/_data/phpDoc.yml"
        git commit \
            --message="Update phpDocumentor class docs for $TRAVIS_TAG" \
            "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID" "$DEPLOYMENT_DIR/_data/phpDoc.yml"
        [ $? -eq 0 ] || exit 1
        echo
    fi
fi

# update version badge
if [ "$DEPLOY_VERSION_BADGE" == "true" ]; then
    generate-badge.sh \
        "$DEPLOYMENT_DIR/badges/pico-version.svg" \
        "release" "$TRAVIS_TAG" "blue"
    [ $? -eq 0 ] || exit 1

    # commit version badge
    echo "Committing version badge..."
    git add "$DEPLOYMENT_DIR/badges/pico-version.svg"
    git commit \
        --message="Update version badge for $TRAVIS_TAG" \
        "$DEPLOYMENT_DIR/badges/pico-version.svg"
    [ $? -eq 0 ] || exit 1
    echo
fi

# update version file
if [ "$DEPLOY_VERSION_FILE" == "true" ]; then
    update-version-file.sh \
        "$DEPLOYMENT_DIR/_data/version.yml" \
        "${TRAVIS_TAG#v}"
    [ $? -eq 0 ] || exit 1

    # commit version file
    echo "Committing version file..."
    git add "$DEPLOYMENT_DIR/_data/version.yml"
    git commit \
        --message="Update version file for $TRAVIS_TAG" \
        "$DEPLOYMENT_DIR/_data/version.yml"
    [ $? -eq 0 ] || exit 1
    echo
fi

# deploy
github-deploy.sh "$TRAVIS_REPO_SLUG" "tags/$TRAVIS_TAG" "$TRAVIS_COMMIT"
[ $? -eq 0 ] || exit 1
