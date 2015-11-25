#!/usr/bin/env bash
APP_NAME="$(basename "$0")"
BASE_PWD="$PWD"
set -e

# environment variables
# GITHUB_OAUTH_TOKEN    GitHub authentication token, see https://github.com/settings/tokens

# parameters
GITHUB_SLUG="$1"            # GitHub repo (e.g. picocms/Pico)
SOURCE_DIR="$2"             # absolute source path
SOURCE_REF="$3"             # source reference (either [branch]@[commit], [branch] or [tag])
TARGET_DIR="$4"             # relative target path
TARGET_BRANCH="$5"          # target branch (e.g. gh-pages)

# print parameters
echo "Deploying phpDocs..."
printf 'GITHUB_SLUG="%s"\n' "$GITHUB_SLUG"
printf 'SOURCE_DIR="%s"\n' "$SOURCE_DIR"
printf 'SOURCE_REF="%s"\n' "$SOURCE_REF"
printf 'TARGET_DIR="%s"\n' "$TARGET_DIR"
printf 'TARGET_BRANCH="%s"\n' "$TARGET_BRANCH"
echo

# evaluate target reference
if git check-ref-format "tags/$SOURCE_REF"; then
    SOURCE_REF_TYPE="tag"
    SOURCE_REF_TAG="$SOURCE_REF"
elif [[ "$SOURCE_REF" == *" @ "* ]]; then
    SOURCE_REF_TYPE="commit"
    SOURCE_REF_BRANCH="${SOURCE_REF% @ *}"
    SOURCE_REF_COMMIT="${SOURCE_REF##* @ }"

    if ! git check-ref-format "heads/$SOURCE_REF_BRANCH" || ! git rev-parse --verify "$SOURCE_REF_COMMIT"; then
        echo "FATAL: $APP_NAME target reference '$SOURCE_REF' is invalid" >&2
        exit 1
    fi
elif git check-ref-format "heads/$SOURCE_REF"; then
    SOURCE_REF_TYPE="branch"
    SOURCE_REF_BRANCH="$SOURCE_REF"
else
    echo "FATAL: $APP_NAME target reference '$SOURCE_REF' is invalid" >&2
    exit 1
fi

# clone repo
printf 'Cloning repo...\n'
GIT_DIR="$SOURCE_DIR.git"
git clone --branch="$TARGET_BRANCH" "https://github.com/$GITHUB_SLUG.git" "$GIT_DIR"

# setup git
cd "$GIT_DIR"
git config user.name "Travis CI"
git config user.email "travis-ci@picocms.org"

if [ -n "$GITHUB_OAUTH_TOKEN" ]; then
    git config credential.helper 'store --file=.git/credentials'
    (umask 077 && echo "https://GitHub:$GITHUB_OAUTH_TOKEN@github.com" > .git/credentials)
fi

# copy phpdoc
printf '\nCopying phpDocs...\n'
[ ! -d "$TARGET_DIR" ] || rm -rf "$TARGET_DIR"
[ "${SOURCE_DIR:0:1}" == "/" ] || SOURCE_DIR="$BASE_PWD/$SOURCE_DIR"
cp -R "$SOURCE_DIR" "$TARGET_DIR"

# commit changes
printf '\nCommiting changes...\n'
git add --all "$TARGET_DIR"
git commit -m "Update phpDocumentor class docs for $SOURCE_REF"

# very simple race condition protection for concurrent Travis builds
# this is no definite protection (race conditions are still possible during `git push`),
# but it should give a basic protection without disabling concurrent builds completely
if [ "$SOURCE_REF_TYPE" == "commit" ]; then
    # get latest commit
    printf '\nRetrieving latest commit of %s:%s' "$GITHUB_SLUG" "$SOURCE_REF_BRANCH"
    LATEST_COMMIT="$(wget -O- "https://api.github.com/repos/$GITHUB_SLUG/git/refs/heads/$SOURCE_REF_BRANCH" 2> /dev/null | php -r "
        \$json = json_decode(stream_get_contents(STDIN), true);
        if (\$json !== null) {
            if (isset(\$json['ref']) && (\$json['ref'] === 'refs/heads/$SOURCE_REF_BRANCH')) {
                if (isset(\$json['object']) && isset(\$json['object']['sha'])) {
                    echo \$json['object']['sha'];
                }
            }
        }
    ")"

    # compare target reference against the latest commit
    if [ "$LATEST_COMMIT" != "$SOURCE_REF_COMMIT" ]; then
        echo "WARNING: $APP_NAME target reference '$SOURCE_REF' doesn't match the latest commit '$LATEST_COMMIT'" >&2
        exit 0
    fi
fi

# push changes
printf '\nPushing changes...\n'
git push "https://github.com/$GITHUB_SLUG.git" "$TARGET_BRANCH:$TARGET_BRANCH"

echo
