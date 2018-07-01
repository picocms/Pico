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

export PATH="$PICO_TOOLS_DIR:$PATH"
. "$PICO_TOOLS_DIR/functions/parse-version.sh.inc"

# parse version
if ! parse_version "$PROJECT_REPO_TAG"; then
    echo "Invalid version '$PROJECT_REPO_TAG'; aborting..." >&2
    exit 1
fi

echo "Deploying Pico $VERSION_MILESTONE ($VERSION_STABILITY)..."
printf 'VERSION_FULL="%s"\n' "$VERSION_FULL"
printf 'VERSION_NAME="%s"\n' "$VERSION_NAME"
printf 'VERSION_ID="%s"\n' "$VERSION_ID"
echo

# clone repo
github-clone.sh "$PICO_DEPLOY_DIR" "https://github.com/$DEPLOY_REPO_SLUG.git" "$DEPLOY_REPO_BRANCH"

cd "$PICO_DEPLOY_DIR"

# setup repo
github-setup.sh

# generate phpDocs
if [ "$DEPLOY_PHPDOC_RELEASES" == "true" ]; then
    # generate phpDocs
    generate-phpdoc.sh \
        "$PICO_PROJECT_DIR/.phpdoc.xml" \
        "-" "$PICO_DEPLOY_DIR/phpDoc/$PICO_DEPLOYMENT" \
        "Pico $VERSION_MILESTONE API Documentation (v$VERSION_FULL)"

    if [ -n "$(git status --porcelain "$PICO_DEPLOY_DIR/phpDoc/$PICO_DEPLOYMENT")" ]; then
        # update phpDoc list
        update-phpdoc-list.sh \
            "$PICO_DEPLOY_DIR/_data/phpDoc.yml" \
            "$PICO_DEPLOYMENT" "version" "Pico $VERSION_FULL" "$(date +%s)"

        # commit phpDocs
        github-commit.sh \
            "Update phpDocumentor class docs for v$VERSION_FULL" \
            "$PICO_DEPLOY_DIR/phpDoc/$PICO_DEPLOYMENT" "$PICO_DEPLOY_DIR/_data/phpDoc.yml"
    fi
fi

# don't update version badge, version file and cloc statistics for pre-releases
if [ "$VERSION_STABILITY" == "stable" ]; then
    # update version badge
    if [ "$DEPLOY_VERSION_BADGE" == "true" ]; then
        generate-badge.sh \
            "$PICO_DEPLOY_DIR/badges/pico-version.svg" \
            "release" "$VERSION_FULL" "blue"

        # commit version badge
        github-commit.sh \
            "Update version badge for v$VERSION_FULL" \
            "$PICO_DEPLOY_DIR/badges/pico-version.svg"
    fi

    # update version file
    if [ "$DEPLOY_VERSION_FILE" == "true" ]; then
        update-version-file.sh \
            "$PICO_DEPLOY_DIR/_data/version.yml" \
            "$VERSION_FULL"

        # commit version file
        github-commit.sh \
            "Update version file for v$VERSION_FULL" \
            "$PICO_DEPLOY_DIR/_data/version.yml"
    fi

    # update cloc statistics
    if [ "$DEPLOY_CLOC_STATS" == "true" ]; then
        update-cloc-stats.sh \
            "$PICO_PROJECT_DIR" \
            "$PICO_DEPLOY_DIR/_data/cloc.yml"

        # commit cloc statistics
        github-commit.sh \
            "Update cloc statistics for v$VERSION_FULL" \
            "$PICO_DEPLOY_DIR/_data/cloc.yml"
    fi
fi

# deploy
github-deploy.sh "$PROJECT_REPO_SLUG" "tags/$PROJECT_REPO_TAG" "$PROJECT_REPO_COMMIT"
