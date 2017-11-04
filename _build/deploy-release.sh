#!/usr/bin/env bash
set -e

DEPLOY_FULL="true"
if [ "$DEPLOY_PHPDOC_RELEASES" != "true" ]; then
    echo "Skipping phpDoc release deployment because it has been disabled"
    DEPLOY_FULL="false"
fi
if [ "$DEPLOY_VERSION_BADGE" != "true" ]; then
    echo "Skipping version badge deployment because it has been disabled"
    DEPLOY_FULL="false"
fi
if [ "$DEPLOY_VERSION_FILE" != "true" ]; then
    echo "Skipping version file deployment because it has been disabled"
    DEPLOY_FULL="false"
fi
if [ "$DEPLOY_CLOC_STATS" != "true" ]; then
    echo "Skipping cloc statistics deployment because it has been disabled"
    DEPLOY_FULL="false"
fi

if [ "$DEPLOY_FULL" != "true" ]; then
    if [ "$DEPLOY_PHPDOC_RELEASES" != "true" ] \
        && [ "$DEPLOY_VERSION_BADGE" != "true" ] \
        && [ "$DEPLOY_VERSION_FILE" != "true" ] \
        && [ "$DEPLOY_CLOC_STATS" != "true" ]
    then
        # nothing to do
        exit 0
    fi
    echo
fi

. "$(dirname "$0")/functions/parse-version.sh.inc"
export PATH="$(dirname "$0")/tools:$PATH"

DEPLOYMENT_ID="${TRAVIS_TAG//\//_}"
DEPLOYMENT_DIR="$TRAVIS_BUILD_DIR/_build/deploy-$DEPLOYMENT_ID.git"

[ -n "$DEPLOY_REPO_SLUG" ] || export DEPLOY_REPO_SLUG="$TRAVIS_REPO_SLUG"
[ -n "$DEPLOY_REPO_BRANCH" ] || export DEPLOY_REPO_BRANCH="gh-pages"

# parse version
if ! parse_version "$TRAVIS_TAG"; then
    echo "Invalid version '$TRAVIS_TAG'; aborting..." >&2
    exit 1
fi

# clone repo
github-clone.sh "$DEPLOYMENT_DIR" "https://github.com/$DEPLOY_REPO_SLUG.git" "$DEPLOY_REPO_BRANCH"

cd "$DEPLOYMENT_DIR"

# setup repo
github-setup.sh

# generate phpDocs
if [ "$DEPLOY_PHPDOC_RELEASES" == "true" ]; then
    # get current Pico milestone
    MILESTONE="Pico $VERSION_MILESTONE"

    # generate phpDocs
    generate-phpdoc.sh \
        "$TRAVIS_BUILD_DIR/.phpdoc.xml" \
        "-" "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID" \
        "$MILESTONE API Documentation ($TRAVIS_TAG)"

    if [ -n "$(git status --porcelain "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID")" ]; then
        # update phpDoc list
        update-phpdoc-list.sh \
            "$DEPLOYMENT_DIR/_data/phpDoc.yml" \
            "$TRAVIS_TAG" "version" "Pico ${TRAVIS_TAG#v}" "$(date +%s)"

        # commit phpDocs
        github-commit.sh \
            "Update phpDocumentor class docs for $TRAVIS_TAG" \
            "$DEPLOYMENT_DIR/phpDoc/$DEPLOYMENT_ID" "$DEPLOYMENT_DIR/_data/phpDoc.yml"
    fi
fi

# don't update version badge, version file and cloc statistics for pre-releases
if [ "$VERSION_STABILITY" != "stable" ]; then
    # update version badge
    if [ "$DEPLOY_VERSION_BADGE" == "true" ]; then
        generate-badge.sh \
            "$DEPLOYMENT_DIR/badges/pico-version.svg" \
            "release" "$TRAVIS_TAG" "blue"

        # commit version badge
        github-commit.sh \
            "Update version badge for $TRAVIS_TAG" \
            "$DEPLOYMENT_DIR/badges/pico-version.svg"
    fi

    # update version file
    if [ "$DEPLOY_VERSION_FILE" == "true" ]; then
        update-version-file.sh \
            "$DEPLOYMENT_DIR/_data/version.yml" \
            "$VERSION_FULL"

        # commit version file
        github-commit.sh \
            "Update version file for $TRAVIS_TAG" \
            "$DEPLOYMENT_DIR/_data/version.yml"
    fi

    # update cloc statistics
    if [ "$DEPLOY_CLOC_STATS" == "true" ]; then
        update-cloc-stats.sh \
            "$DEPLOYMENT_DIR/_data/clocCore.yml" \
            "$DEPLOYMENT_DIR/_data/clocRelease.yml"

        # commit cloc statistics
        github-commit.sh \
            "Update cloc statistics for $TRAVIS_TAG" \
            "$DEPLOYMENT_DIR/_data/clocCore.yml" "$DEPLOYMENT_DIR/_data/clocRelease.yml"
    fi
fi

# deploy
github-deploy.sh "$TRAVIS_REPO_SLUG" "tags/$TRAVIS_TAG" "$TRAVIS_COMMIT"
