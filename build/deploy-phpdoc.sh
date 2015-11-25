#!/usr/bin/env bash
APP_NAME="$(basename "$0")"
BASE_PWD="$PWD"
set -e

# environment variables
# GITHUB_OAUTH_TOKEN    GitHub authentication token, see https://github.com/settings/tokens

# parameters
SOURCE_DIR="$1"             # absolute local source path
TARGET_REPO_SLUG="$2"       # target repo (e.g. picocms/Pico)
TARGET_BRANCH="$3"          # target branch (e.g. gh-pages)
TARGET_REF="$4"             # target reference (either [branch]@[commit], [branch] or [tag])

# evaluate target reference
if git check-ref-format "tags/$TARGET_REF"; then
    TARGET_REF_TYPE="tag"
    TARGET_REF_TAG="$TARGET_REF"
    TARGET_DIR="$TARGET_REF_TAG"
elif [[ "$TARGET_REF" == *@* ]]; then
    TARGET_REF_TYPE="commit"
    TARGET_REF_BRANCH="${TARGET_REF%@*}"
    TARGET_REF_COMMIT="${TARGET_REF##*@}"
    TARGET_DIR="$TARGET_REF_BRANCH"

    if ! git check-ref-format "heads/$TARGET_REF_BRANCH"; then
        echo "FATAL: $APP_NAME target reference '$TARGET_REF' is invalid" >&2
        exit 1
    fi
elif git check-ref-format "heads/$TARGET_REF"; then
    TARGET_REF_TYPE="branch"
    TARGET_REF_BRANCH="$TARGET_REF"
    TARGET_DIR="$TARGET_REF_BRANCH"
else
    echo "FATAL: $APP_NAME target reference '$TARGET_REF' is invalid" >&2
    exit 1
fi

# clone repo
GIT_DIR="$SOURCE_DIR.git"
git clone -b "$TARGET_BRANCH" "https://github.com/$TARGET_REPO_SLUG.git" "$GIT_DIR"

# setup git
cd "$GIT_DIR"
git config user.name "Travis CI"
git config user.email "travis-ci@picocms.org"
[ -n "$GITHUB_OAUTH_TOKEN" ] && git config credential.https://github.com.username "$GITHUB_OAUTH_TOKEN"

# copy phpdoc
[ -e "$TARGET_DIR" ] && echo "FATAL: $(basename "$0") target directory '$TARGET_DIR' exists" >&2 && exit 1
[ "${SOURCE_DIR:0:1}" == "/" ] || SOURCE_DIR="$BASE_PWD/$SOURCE_DIR"
cp -R "$SOURCE_DIR" "phpDoc/$TARGET_DIR"

# commit changes
git add "$TARGET_DIR"
git commit -m "Add phpDocumentor class docs for $TARGET_REF"

# very simple race condition protection for concurrent Travis builds
# this is no definite protection (race conditions are still possible during `git push`),
# but it should give a basic protection without disabling concurrent builds completely
if [ "$TARGET_REF_TYPE" == "commit" ]; then
    # get latest commit
    LATEST_COMMIT="$(wget -O- "https://api.github.com/repos/$TARGET_REPO_SLUG/git/refs/heads/$TARGET_REF_BRANCH" 2> /dev/null | php -r "
        \$json = json_decode(stream_get_contents(STDIN), true);
        if (\$json !== null) {
            if (isset(\$json['ref']) && (\$json['ref'] === 'refs/heads/$TARGET_REF_BRANCH')) {
                if (isset(\$json['object']) && isset(\$json['object']['sha'])) {
                    echo \$json['object']['sha'];
                }
            }
        }
    ")"

    # compare target reference against the latest commit
    if [ "$LATEST_COMMIT" != "$TARGET_REF_COMMIT" ]; then
        echo "WARNING: $APP_NAME target reference '$TARGET_REF' doesn't match the latest commit '$LATEST_COMMIT'" >&2
        exit 0
    fi
fi

# push changes
git push "https://github.com/$TARGET_REPO_SLUG.git" "$TARGET_BRANCH:$TARGET_BRANCH"
