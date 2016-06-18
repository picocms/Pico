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

# clone repo
echo "Cloning repo..."
git clone --branch="gh-pages" "https://github.com/$TRAVIS_REPO_SLUG.git" "$DEPLOYMENT_DIR"
[ $? -eq 0 ] || exit 1

cd "$DEPLOYMENT_DIR"
echo

# setup repo
github-setup.sh

# generate phpDocs
if [ "$DEPLOY_PHPDOC_RELEASES" == "true" ]; then
    # get current Pico milestone
    MILESTONE="Pico$([[ "$TRAVIS_TAG" =~ ^v([0-9]+\.[0-9]+)\. ]] && echo " ${BASH_REMATCH[1]}")"

    # generate phpDocs
    generate-phpdoc.sh \
        "$TRAVIS_BUILD_DIR/.phpdoc.xml" \
        "-" "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID" \
        "$MILESTONE API Documentation ($TRAVIS_TAG)"
    [ $? -eq 0 ] || exit 1

    if [ -n "$(git status --porcelain "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID")" ]; then
        # update phpDoc list
        update-phpdoc-list.sh \
            "$DEPLOYMENT_DIR/_data/phpDoc.yml" \
            "$TRAVIS_TAG" "version" "Pico ${TRAVIS_TAG#v}" "$(date +%s)"

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
