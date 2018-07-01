#!/usr/bin/env bash
set -e

export PATH="$PICO_TOOLS_DIR:$PATH"

# get current Pico milestone
VERSION="$(php -r "require_once('$PICO_PROJECT_DIR/lib/Pico.php'); echo Pico::VERSION;")"
MILESTONE="Pico$([[ "$VERSION" =~ ^([0-9]+\.[0-9]+)\. ]] && echo " ${BASH_REMATCH[1]}")"

echo "Deploying $PROJECT_REPO_BRANCH branch ($MILESTONE)..."
echo

# clone repo
github-clone.sh "$PICO_DEPLOY_DIR" "https://github.com/$DEPLOY_REPO_SLUG.git" "$DEPLOY_REPO_BRANCH"

cd "$PICO_DEPLOY_DIR"

# setup repo
github-setup.sh

# generate phpDocs
generate-phpdoc.sh \
    "$PICO_PROJECT_DIR/.phpdoc.xml" \
    "$PICO_DEPLOY_DIR/phpDoc/$PICO_DEPLOYMENT.cache" "$PICO_DEPLOY_DIR/phpDoc/$PICO_DEPLOYMENT" \
    "$MILESTONE API Documentation ($PROJECT_REPO_BRANCH branch)"

if [ -z "$(git status --porcelain "$PICO_DEPLOY_DIR/phpDoc/$PICO_DEPLOYMENT.cache")" ]; then
    # nothing to do
    exit 0
fi

# update phpDoc list
update-phpdoc-list.sh \
    "$PICO_DEPLOY_DIR/_data/phpDoc.yml" \
    "$PICO_DEPLOYMENT" "branch" "<code>$PROJECT_REPO_BRANCH</code> branch" "$(date +%s)"

# commit phpDocs
github-commit.sh \
    "Update phpDocumentor class docs for $PROJECT_REPO_BRANCH branch @ $PROJECT_REPO_COMMIT" \
    "$PICO_DEPLOY_DIR/phpDoc/$PICO_DEPLOYMENT.cache" "$PICO_DEPLOY_DIR/phpDoc/$PICO_DEPLOYMENT" \
    "$PICO_DEPLOY_DIR/_data/phpDoc.yml"

# deploy phpDocs
github-deploy.sh "$PROJECT_REPO_SLUG" "heads/$PROJECT_REPO_BRANCH" "$PROJECT_REPO_COMMIT"
