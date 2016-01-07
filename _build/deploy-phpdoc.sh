#!/usr/bin/env bash

##
# Deploys phpDoc class documentation
#
# @author  Daniel Rudolf
# @link    http://picocms.org
# @license http://opensource.org/licenses/MIT
#

set -e

# environment variables
# GITHUB_OAUTH_TOKEN    GitHub authentication token, see https://github.com/settings/tokens

# parameters
COMMIT_MESSAGE="$1"         # commit message
CHECK_REPO_SLUG="$2"        # optional GitHub repo (e.g. picocms/Pico) to check
                            # its latest commit as basic race condition protection
CHECK_REMOTE_REF="$3"       # optional remote Git reference (e.g. heads/master)
CHECK_LOCAL_COMMIT="$4"     # optional local commit SHA1

# print parameters
echo "Deploying phpDocs..."
printf 'COMMIT_MESSAGE="%s"\n' "$COMMIT_MESSAGE"
printf 'CHECK_REPO_SLUG="%s"\n' "$CHECK_REPO_SLUG"
printf 'CHECK_REMOTE_REF="%s"\n' "$CHECK_REMOTE_REF"
printf 'CHECK_LOCAL_COMMIT="%s"\n' "$CHECK_LOCAL_COMMIT"
echo

# check for changes
if [ -z "$(git status --porcelain)" ]; then
    printf 'Nothing to deploy; skipping...\n\n'
    exit 0
fi

# setup git
printf 'Preparing repo...\n'
git config push.default simple
git config user.name "Travis CI"
git config user.email "travis-ci@picocms.org"

if [ -n "$GITHUB_OAUTH_TOKEN" ]; then
    git config credential.helper 'store --file=.git/credentials'
    (umask 077 && echo "https://GitHub:$GITHUB_OAUTH_TOKEN@github.com" > .git/credentials)
fi

# commit changes
printf '\nCommiting changes...\n'
git add --all
git commit --message="$COMMIT_MESSAGE"

# race condition protection for concurrent Travis builds
# this is no definite protection (race conditions are still possible during `git push`),
# but it should give a basic protection without disabling concurrent builds completely
if [ -n "$CHECK_REPO_SLUG" ] && [ -n "$CHECK_REMOTE_REF" ] && [ -n "$CHECK_LOCAL_COMMIT" ]; then
    # retrieve information using GitHub APIv3
    printf '\nChecking latest commit...\n'
    CHECK_API_URL="https://api.github.com/repos/$CHECK_REPO_SLUG/git/refs/$CHECK_REMOTE_REF"
    if [ -n "$GITHUB_OAUTH_TOKEN" ]; then
        CHECK_API_RESPONSE="$(wget -O- --header="Authorization: token $GITHUB_OAUTH_TOKEN" "$CHECK_API_URL" 2> /dev/null)"
    else
        CHECK_API_RESPONSE="$(wget -O- "$CHECK_API_URL" 2> /dev/null)"
    fi

    # evaluate JSON response
    CHECK_REMOTE_COMMIT="$(echo "$CHECK_API_RESPONSE" | php -r "
        \$json = json_decode(stream_get_contents(STDIN), true);
        if (\$json !== null) {
            if (isset(\$json['ref']) && (\$json['ref'] === 'refs/$CHECK_REMOTE_REF')) {
                if (isset(\$json['object']) && isset(\$json['object']['sha'])) {
                    echo \$json['object']['sha'];
                }
            }
        }
    ")"

    # compare source reference against the latest commit
    if [ "$CHECK_REMOTE_COMMIT" != "$CHECK_LOCAL_COMMIT" ]; then
        echo "WARNING: latest local commit '$CHECK_LOCAL_COMMIT' doesn't match latest remote commit '$CHECK_REMOTE_COMMIT'" >&2
        exit 0
    fi
fi

# push changes
printf '\nPushing changes...\n'
git push origin

echo
