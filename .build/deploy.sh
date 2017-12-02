#!/usr/bin/env bash
if [ -n "$PROJECT_REPO_TAG" ]; then
    exec "$(dirname "$0")/deploy-release.sh"
else
    exec "$(dirname "$0")/deploy-branch.sh"
fi
