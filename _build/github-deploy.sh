#!/usr/bin/env bash

##
# Pushes commits to a GitHub repo
#
# @author  Daniel Rudolf
# @link    http://picocms.org
# @license http://opensource.org/licenses/MIT
#

set -e

# parameters
CHECK_REPO_SLUG="$1"        # optional GitHub repo (e.g. picocms/Pico) to check
                            # its latest commit as basic race condition protection
CHECK_REMOTE_REF="$2"       # optional remote Git reference (e.g. heads/master)
CHECK_LOCAL_COMMIT="$3"     # optional local commit SHA1

# print parameters
echo "Deploying repo..."
printf 'CHECK_REPO_SLUG="%s"\n' "$CHECK_REPO_SLUG"
printf 'CHECK_REMOTE_REF="%s"\n' "$CHECK_REMOTE_REF"
printf 'CHECK_LOCAL_COMMIT="%s"\n' "$CHECK_LOCAL_COMMIT"
echo

# check for changes
if [ -z "$(git log --oneline '@{upstream}..')" ]; then
    printf 'Nothing to deploy; skipping...\n\n'
    exit 0
fi

# race condition protection for concurrent Travis builds
# this is no definite protection (race conditions are still possible during `git push`),
# but it should give a basic protection without disabling concurrent builds completely
if [ -n "$CHECK_REPO_SLUG" ] && [ -n "$CHECK_REMOTE_REF" ] && [ -n "$CHECK_LOCAL_COMMIT" ]; then
    # retrieve information using GitHub APIv3
    printf 'Checking latest commit...\n'
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
        echo "Latest local commit '$CHECK_LOCAL_COMMIT' doesn't match latest remote commit '$CHECK_REMOTE_COMMIT'; aborting..." >&2
        exit 1
    fi

    echo
fi

# push changes
printf 'Pushing changes...\n'
git push

echo
