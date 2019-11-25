if [ -z "$PICO_BUILD_ENV" ]; then
    echo "No Pico build environment specified" >&2
    exit 1
fi

# add project build dir to $PATH
export PATH="$PICO_PROJECT_DIR/.build:$PATH"

# set environment variables
__picocms_cmd export RELEASE_REPO_SLUG="${RELEASE_REPO_SLUG:-picocms/pico-composer}"
__picocms_cmd export RELEASE_REPO_BRANCH="${RELEASE_REPO_BRANCH:-master}"

if [ "$PROJECT_REPO_SLUG" != "picocms/Pico" ]; then
    __picocms_cmd export DEPLOY_REPO_SLUG="${DEPLOY_REPO_SLUG:-$PROJECT_REPO_SLUG}"
    __picocms_cmd export DEPLOY_REPO_BRANCH="${DEPLOY_REPO_BRANCH:-gh-pages}"
else
    __picocms_cmd export DEPLOY_REPO_SLUG="${DEPLOY_REPO_SLUG:-picocms.github.io}"
    __picocms_cmd export DEPLOY_REPO_BRANCH="${DEPLOY_REPO_BRANCH:-master}"
fi
