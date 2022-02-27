#!/bin/bash
# Pico -- build.sh
# Builds a new Pico release and creates release archives.
#
# This file is part of Pico, a stupidly simple, blazing fast, flat file CMS.
# Visit us at https://picocms.org/ for more info.
#
# Copyright (c) 2017  Daniel Rudolf <https://www.daniel-rudolf.de>
#
# This work is licensed under the terms of the MIT license.
# For a copy, see LICENSE file or <https://opensource.org/licenses/MIT>.
#
# SPDX-License-Identifier: MIT
# License-Filename: LICENSE

set -eu -o pipefail
export LC_ALL=C

# env variables
PHP="${PHP:-php}"
export -n PHP

COMPOSER="${COMPOSER:-composer}"
export -n COMPOSER

if ! which "$PHP" > /dev/null; then
    echo "Missing script dependency: php" >&2
    exit 1
elif ! which "$COMPOSER" > /dev/null; then
    echo "Missing script dependency: composer" >&2
    exit 1
elif ! which "git" > /dev/null; then
    echo "Missing script dependency: git" >&2
    exit 1
elif ! which "rsync" > /dev/null; then
    echo "Missing script dependency: rsync" >&2
    exit 1
elif ! which "jq" > /dev/null; then
    echo "Missing script dependency: jq" >&2
    exit 1
fi

# parameters
BUILD_NAME="pico"
BUILD_PROJECT="picocms/pico"
BUILD_VERSION=

PICO_COMPOSER_NAME="pico-composer"
PICO_COMPOSER_PROJECT="picocms/pico-composer"
PICO_COMPOSER_DIR=

PICO_THEME_NAME="pico-theme"
PICO_THEME_PROJECT="picocms/pico-theme"
PICO_THEME_DIR=

PICO_DEPRECATED_NAME="pico-deprecated"
PICO_DEPRECATED_PROJECT="picocms/pico-deprecated"
PICO_DEPRECATED_DIR=

# options
VERSION=
NOCHECK=
NOCLEAN=

while [ $# -gt 0 ]; do
    if [ "$1" == "--help" ]; then
        echo "Usage:"
        echo "  build.sh [OPTIONS]... [VERSION]"
        echo
        echo "Builds a new Pico release and creates release archives."
        echo
        echo "Help options:"
        echo "  --help                  display this help and exit"
        echo
        echo "Application options:"
        echo "  --pico-composer PATH    path to a local copy of '$PICO_COMPOSER_PROJECT'"
        echo "  --pico-theme PATH       path to a local copy of '$PICO_THEME_PROJECT'"
        echo "  --pico-deprecated PATH  path to a local copy of '$PICO_DEPRECATED_PROJECT'"
        echo "  --no-check              skip version checks for dev builds"
        echo "  --no-clean              don't remove build dir on exit"
        echo
        echo "You must run this script from within Pico's source directory. Please note"
        echo "that this script will perform a large number of strict sanity checks before"
        echo "building a new non-development version of Pico. VERSION must start with 'v'."
        exit 0
    elif [ "$1" == "--no-check" ]; then
        NOCHECK="y"
        shift
    elif [ "$1" == "--no-clean" ]; then
        NOCLEAN="y"
        shift
    elif [ "$1" == "--pico-composer" ] && [ $# -ge 2 ]; then
        PICO_COMPOSER_DIR="$2"
        shift 2
    elif [ "$1" == "--pico-theme" ] && [ $# -ge 2 ]; then
        PICO_THEME_DIR="$2"
        shift 2
    elif [ "$1" == "--pico-deprecated" ] && [ $# -ge 2 ]; then
        PICO_DEPRECATED_DIR="$2"
        shift 2
    elif [ -z "$VERSION" ] && [ "${1:0:1}" == "v" ]; then
        VERSION="$1"
        shift
    else
        echo "Unknown option: $1" >&2
        exit 1
    fi
done

# check options and current working dir
if [ ! -f "./composer.json" ] || [ ! -f "./lib/Pico.php" ]; then
    echo "You must run this from within Pico's source directory" >&2
    exit 1
elif [ "$(git rev-parse --is-inside-work-tree 2> /dev/null)" != "true" ]; then
    echo "You must run this from within a non-bare Git repository" >&2
    exit 1
fi

if [ -n "$PICO_COMPOSER_DIR" ]; then
    if [ ! -f "$PICO_COMPOSER_DIR/composer.json" ] || [ ! -f "$PICO_COMPOSER_DIR/index.php" ]; then
        echo "You must pass a source directory of '$PICO_COMPOSER_PROJECT' as '--pico-composer': $PICO_COMPOSER_DIR" >&2
        exit 1
    elif [ "$(git -C "$PICO_COMPOSER_DIR" rev-parse --is-inside-work-tree 2> /dev/null)" != "true" ]; then
        echo "You must pass a non-bare Git repository as '--pico-composer': $PICO_COMPOSER_DIR" >&2
        exit 1
    fi
fi

if [ -n "$PICO_THEME_DIR" ]; then
    if [ ! -f "$PICO_THEME_DIR/composer.json" ] || [ ! -f "$PICO_THEME_DIR/pico-theme.yml" ]; then
        echo "You must pass a source directory of '$PICO_THEME_PROJECT' as '--pico-theme': $PICO_THEME_DIR" >&2
        exit 1
    elif [ "$(git -C "$PICO_THEME_DIR" rev-parse --is-inside-work-tree 2> /dev/null)" != "true" ]; then
        echo "You must pass a non-bare Git repository as '--pico-theme': $PICO_THEME_DIR" >&2
        exit 1
    fi
fi

if [ -n "$PICO_DEPRECATED_DIR" ]; then
    if [ ! -f "$PICO_DEPRECATED_DIR/composer.json" ] || [ ! -f "$PICO_DEPRECATED_DIR/PicoDeprecated.php" ]; then
        echo "You must pass a source directory of '$PICO_DEPRECATED_PROJECT' as '--pico-deprecated': $PICO_DEPRECATED_DIR" >&2
        exit 1
    elif [ "$(git -C "$PICO_DEPRECATED_DIR" rev-parse --is-inside-work-tree 2> /dev/null)" != "true" ]; then
        echo "You must pass a non-bare Git repository as '--pico-deprecated': $PICO_DEPRECATED_DIR" >&2
        exit 1
    fi
fi

# parse version
function parse_version {
    VERSION_FULL="${1#v}"

    if ! [[ "$VERSION_FULL" =~ ^([0-9]+)\.([0-9]+)\.([0-9]+)(-([0-9A-Za-z\.\-]+))?(\+([0-9A-Za-z\.\-]+))?$ ]]; then
        return 1
    fi

    VERSION_MAJOR="${BASH_REMATCH[1]}"
    VERSION_MINOR="${BASH_REMATCH[2]}"
    VERSION_PATCH="${BASH_REMATCH[3]}"
    VERSION_SUFFIX="${BASH_REMATCH[5]}"

    VERSION_STABILITY="stable"
    if [[ "$VERSION_SUFFIX" =~ ^(dev|a|alpha|b|beta|rc)?([.-]?[0-9]+)?([.-](dev))?$ ]]; then
        if [ "${BASH_REMATCH[1]}" == "dev" ] || [ "${BASH_REMATCH[4]}" == "dev" ]; then
            VERSION_STABILITY="dev"
        elif [ "${BASH_REMATCH[1]}" == "a" ] || [ "${BASH_REMATCH[1]}" == "alpha" ]; then
            VERSION_STABILITY="alpha"
        elif [ "${BASH_REMATCH[1]}" == "b" ] || [ "${BASH_REMATCH[1]}" == "beta" ]; then
            VERSION_STABILITY="beta"
        elif [ "${BASH_REMATCH[1]}" == "rc" ]; then
            VERSION_STABILITY="rc"
        fi
    fi
}

BUILD_VERSION="v$("$PHP" -r 'require("./lib/Pico.php"); echo Pico::VERSION;')"

if ! parse_version "$BUILD_VERSION"; then
     echo "Unable to build Pico: Invalid Pico version '$BUILD_VERSION'" >&2
     exit 1
fi

if [ -z "$VERSION" ]; then
    GIT_LOCAL_HEAD="$(git rev-parse HEAD)"
    GIT_LOCAL_BRANCH="$(git rev-parse --abbrev-ref HEAD)"
    DATETIME="$(date -u +'%Y%m%dT%H%M%SZ')"

    VERSION="v$VERSION_MAJOR.$VERSION_MINOR.$VERSION_PATCH"
    [ -z "$VERSION_SUFFIX" ] || VERSION+="-$VERSION_SUFFIX"
    [ "$VERSION_STABILITY" == "dev" ] || VERSION+="-dev"
    VERSION+="+git.$GIT_LOCAL_HEAD.$DATETIME"

    if ! parse_version "$VERSION"; then
         echo "Unable to build Pico: Invalid build version '$VERSION'" >&2
         exit 1
    fi

    DEPENDENCY_VERSION="dev-$GIT_LOCAL_BRANCH"
else
    if ! parse_version "$VERSION"; then
         echo "Unable to build Pico: Invalid build version '$VERSION'" >&2
         exit 1
    fi

    DEPENDENCY_VERSION=
    if [ "$VERSION_STABILITY" == "dev" ]; then
         DEPENDENCY_VERSION="$(jq -r --arg ALIAS "$VERSION_MAJOR.$VERSION_MINOR.x-dev" \
            '.extra."branch-alias"|to_entries|map(select(.value==$ALIAS).key)[0]//empty' \
            "composer.json")"
    fi

    if [ -z "$DEPENDENCY_VERSION" ]; then
        DEPENDENCY_VERSION="$VERSION_MAJOR.$VERSION_MINOR.$VERSION_PATCH"
        [ -z "$VERSION_SUFFIX" ] || DEPENDENCY_VERSION+="-$VERSION_SUFFIX"
        [ "$VERSION_STABILITY" == "stable" ] || DEPENDENCY_VERSION+="@$VERSION_STABILITY"
    fi
fi

# build checks
if [ "$VERSION_STABILITY" != "dev" ]; then
    GIT_LOCAL_CLEAN="$(git status --porcelain)"
    GIT_LOCAL_HEAD="$(git rev-parse HEAD)"
    GIT_LOCAL_TAG="$(git rev-parse --verify "refs/tags/$VERSION" 2> /dev/null || true)"
    GIT_REMOTE="$(git 'for-each-ref' --format='%(upstream:remotename)' "$(git symbolic-ref -q HEAD)")"
    GIT_REMOTE_TAG="$(git ls-remote "${GIT_REMOTE:-origin}" "refs/tags/$VERSION" 2> /dev/null | cut -f 1 || true)"

    if [ "$VERSION" != "$BUILD_VERSION" ]; then
        echo "Unable to build Pico: Building $VERSION, but Pico indicates $BUILD_VERSION" >&2
        exit 1
    elif [ -n "$GIT_LOCAL_CLEAN" ]; then
        echo "Unable to build Pico: Building $VERSION, but the working tree is not clean" >&2
        exit 1
    elif [ -z "$GIT_LOCAL_TAG" ]; then
        echo "Unable to build Pico: Building $VERSION, but no matching local Git tag was found" >&2
        exit 1
    elif [ "$GIT_LOCAL_HEAD" != "$GIT_LOCAL_TAG" ]; then
        echo "Unable to build Pico: Building $VERSION, but the matching Git tag is not checked out" >&2
        exit 1
    elif [ -z "$GIT_REMOTE_TAG" ]; then
        echo "Unable to build Pico: Building $VERSION, but no matching remote Git tag was found" >&2
        exit 1
    elif [ "$GIT_LOCAL_TAG" != "$GIT_REMOTE_TAG" ]; then
        echo "Unable to build Pico: Building $VERSION, but the matching local and remote Git tags differ" >&2
        exit 1
    elif [ -n "$PICO_COMPOSER_DIR" ] || [ -n "$PICO_THEME_DIR" ] || [ -n "$PICO_DEPRECATED_DIR" ]; then
        echo "Unable to build Pico: Refusing to build a non-dev version with local dependencies" >&2
        exit 1
    fi
elif [ -z "$NOCHECK" ]; then
    if [[ "$VERSION" != "$BUILD_VERSION"* ]]; then
        echo "Unable to build Pico: Building $VERSION, but Pico indicates $BUILD_VERSION" >&2
        exit 1
    fi
fi

# build in progress...
APP_DIR="$PWD"

BUILD_DIR="$(mktemp -d)"
[ -n "$NOCLEAN" ] || trap "rm -rf ${BUILD_DIR@Q}" ERR EXIT

echo "Building Pico $BUILD_VERSION ($VERSION)..."
[ -z "$NOCLEAN" ] || echo "Build directory: $BUILD_DIR"
echo

if [ "$VERSION_STABILITY" == "dev" ]; then
    # copy dev version of Pico
    echo "Creating clean working tree copy of '$BUILD_PROJECT'..."
    rsync -a \
        --exclude="/.build" \
        --exclude="/.git" \
        --exclude="/.github" \
        --exclude="/assets/.gitignore" \
        --exclude="/config/.gitignore" \
        --exclude="/content/.gitignore" \
        --exclude="/plugins/.gitignore" \
        --exclude="/themes/.gitignore" \
        --exclude="/.gitattributes" \
        --exclude="/.gitignore" \
        --exclude="/.phpcs.xml" \
        --exclude="/.phpdoc.xml" \
        --exclude-from=<(git ls-files --exclude-standard -oi --directory) \
        ./ "$BUILD_DIR/$BUILD_NAME/"

    # copy dev version of Composer starter project
    if [ -n "$PICO_COMPOSER_DIR" ]; then
        echo "Creating clean working tree copy of '$PICO_COMPOSER_PROJECT'..."
        rsync -a \
            --exclude="/.git" \
            --exclude="/assets/.gitignore" \
            --exclude="/config/.gitignore" \
            --exclude="/content/.gitignore" \
            --exclude="/plugins/.gitignore" \
            --exclude="/themes/.gitignore" \
            --exclude="/.gitattributes" \
            --exclude="/.gitignore" \
            --exclude-from=<(git -C "$PICO_COMPOSER_DIR" ls-files --exclude-standard -oi --directory) \
            "$PICO_COMPOSER_DIR/" "$BUILD_DIR/$PICO_COMPOSER_NAME/"
    fi

    # copy dev version of default theme
    if [ -n "$PICO_THEME_DIR" ]; then
        echo "Creating clean working tree copy of '$PICO_THEME_PROJECT'..."
        rsync -a \
            --exclude="/.git" \
            --exclude="/.github" \
            --exclude="/.gitattributes" \
            --exclude="/.gitignore" \
            --exclude-from=<(git -C "$PICO_THEME_DIR" ls-files --exclude-standard -oi --directory) \
            "$PICO_THEME_DIR/" "$BUILD_DIR/$PICO_THEME_NAME/"
    fi

    # copy dev version of PicoDeprecated
    if [ -n "$PICO_DEPRECATED_DIR" ]; then
        echo "Creating clean working tree copy of '$PICO_DEPRECATED_PROJECT'..."
        rsync -a \
            --exclude="/.build" \
            --exclude="/.git" \
            --exclude="/.github" \
            --exclude="/.gitattributes" \
            --exclude="/.gitignore" \
            --exclude="/.phpcs.xml" \
            --exclude-from=<(git -C "$PICO_DEPRECATED_DIR" ls-files --exclude-standard -oi --directory) \
            "$PICO_DEPRECATED_DIR/" "$BUILD_DIR/$PICO_DEPRECATED_NAME/"
    fi

    echo
fi

if [ "$VERSION_STABILITY" != "dev" ] || [ -z "$PICO_COMPOSER_DIR" ]; then
    PICO_COMPOSER_VERSION="$DEPENDENCY_VERSION"
    [[ "$PICO_COMPOSER_VERSION" == "dev-"* ]] || PICO_COMPOSER_VERSION="$VERSION_MAJOR.$VERSION_MINOR"

    # download Composer starter project
    echo "Setting up Pico's Composer starter project (version '$PICO_COMPOSER_VERSION')..."
    "$COMPOSER" create-project --no-install "$PICO_COMPOSER_PROJECT" \
        "$BUILD_DIR/$PICO_COMPOSER_NAME" \
        "$PICO_COMPOSER_VERSION"
    echo
fi

# switch to build dir...
cd "$BUILD_DIR/$PICO_COMPOSER_NAME"

# inject local copy of Pico
if [ "$VERSION_STABILITY" == "dev" ]; then
    function composer_repo_config {
        jq -nc --arg PACKAGE "$1" --arg VERSION "$2" --arg URL "$3" \
            '{"type": "path", "url": $URL, options: {"symlink": false, "versions": {($PACKAGE): $VERSION}}}'
    }

    echo "Adding Composer repository for '$BUILD_PROJECT'..."
    "$COMPOSER" config repositories."$BUILD_NAME" \
        "$(composer_repo_config "$BUILD_PROJECT" "$DEPENDENCY_VERSION" "$BUILD_DIR/$BUILD_NAME")"

    if [ -n "$PICO_THEME_DIR" ]; then
        echo "Adding Composer repository for '$PICO_THEME_PROJECT'..."
        "$COMPOSER" config repositories."$PICO_THEME_NAME" \
            "$(composer_repo_config "$PICO_THEME_PROJECT" "$DEPENDENCY_VERSION" "$BUILD_DIR/$PICO_THEME_NAME")"
    fi

    if [ -n "$PICO_DEPRECATED_DIR" ]; then
        echo "Adding Composer repository for '$PICO_DEPRECATED_PROJECT'..."
        "$COMPOSER" config repositories."$PICO_DEPRECATED_NAME" \
            "$(composer_repo_config "$PICO_DEPRECATED_PROJECT" "$DEPENDENCY_VERSION" "$BUILD_DIR/$PICO_DEPRECATED_NAME")"
    fi

    echo
fi

# update build version constraints
echo "Updating Composer dependency version constraints..."
"$COMPOSER" require --no-update \
    "$BUILD_PROJECT $DEPENDENCY_VERSION" \
    "$PICO_THEME_PROJECT $DEPENDENCY_VERSION" \
    "$PICO_DEPRECATED_PROJECT $DEPENDENCY_VERSION"
echo

# set minimum stability
if [ "$VERSION_STABILITY" != "stable" ]; then
    echo "Setting minimum stability to '$VERSION_STABILITY'..."
    "$COMPOSER" config "minimum-stability" "$VERSION_STABILITY"
    "$COMPOSER" config "prefer-stable" "true"
    echo
fi

# install dependencies
echo "Installing Composer dependencies..."
"$COMPOSER" install --no-dev --optimize-autoloader
echo

# prepare release
echo "Replacing 'index.php'..."
cp "vendor/$BUILD_PROJECT/index.php.dist" index.php

echo "Adding 'README.md', 'CONTRIBUTING.md', 'CHANGELOG.md', 'SECURITY.md'..."
cp "vendor/$BUILD_PROJECT/README.md" README.md
cp "vendor/$BUILD_PROJECT/CONTRIBUTING.md" CONTRIBUTING.md
cp "vendor/$BUILD_PROJECT/CHANGELOG.md" CHANGELOG.md
cp "vendor/$BUILD_PROJECT/SECURITY.md" SECURITY.md

echo "Removing '.git' directory..."
rm -rf .git

echo "Removing '.git' directories of dependencies..."
find vendor/ -type d -path 'vendor/*/*/.git' -print0 | xargs -0 rm -rf

echo "Removing '.git' directories of plugins and themes..."
find themes/ -type d -path 'themes/*/.git' -print0 | xargs -0 rm -rf
find plugins/ -type d -path 'plugins/*/.git' -print0 | xargs -0 rm -rf

echo "Removing 'index.php' and 'index.php.dist' from 'vendor/$BUILD_PROJECT'"
rm -f "vendor/$BUILD_PROJECT/index.php"
rm -f "vendor/$BUILD_PROJECT/index.php.dist"
echo

# restore composer.json
echo "Restoring Composer dependency version constraints..."
"$COMPOSER" require --no-update \
    "$BUILD_PROJECT ^$VERSION_MAJOR.$VERSION_MINOR" \
    "$PICO_THEME_PROJECT ^$VERSION_MAJOR.$VERSION_MINOR" \
    "$PICO_DEPRECATED_PROJECT ^$VERSION_MAJOR.$VERSION_MINOR"

if [ "$VERSION_STABILITY" == "dev" ]; then
    echo "Removing Composer repositories..."
    "$COMPOSER" config --unset repositories."$BUILD_NAME"

    if [ -n "$PICO_THEME_DIR" ]; then
        "$COMPOSER" config --unset repositories."$PICO_THEME_NAME"
    fi
    if [ -n "$PICO_DEPRECATED_DIR" ]; then
        "$COMPOSER" config --unset repositories."$PICO_DEPRECATED_NAME"
    fi
fi

echo

# create release archives
ARCHIVE_FILENAME="$BUILD_NAME-release-$VERSION"

echo "Creating release archive '$ARCHIVE_FILENAME.tar.gz'..."
find . -mindepth 1 -maxdepth 1 -printf '%f\0' \
    | xargs -0 -- tar -czf "$APP_DIR/$ARCHIVE_FILENAME.tar.gz" --

echo "Creating release archive '$ARCHIVE_FILENAME.zip'..."
zip -q -r "$APP_DIR/$ARCHIVE_FILENAME.zip" .
