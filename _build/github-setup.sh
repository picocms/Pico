#!/usr/bin/env bash

##
# Prepares a GitHub repo for deployment
#
# @author  Daniel Rudolf
# @link    http://picocms.org
# @license http://opensource.org/licenses/MIT
#

set -e

# environment variables
# GITHUB_OAUTH_TOKEN    GitHub authentication token, see https://github.com/settings/tokens

# print "parameters" (we don't have any)
echo "Setup repo..."
echo

# check for git repo
if ! git rev-parse --git-dir > /dev/null 2>&1; then
    echo "Not a git repo; aborting..." >&2
    exit 1
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

echo
