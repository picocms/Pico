#!/usr/bin/env bash
#
# https://gist.github.com/domenic/ec8b0fc8ab45f39403dd
#

# Exit with nonzero exit code if anything fails
set -e

# Clone Pico, then create & checkout gh-pages branch
git clone -b gh-pages "https://github.com/theshka/Pico.git"

# Inside this git repo we'll pretend to be a new user
git config user.name "theshka"
git config user.email "tyler@heshka.com"

#move old files
mv $TRAVIS_BUILD_DIR/Pico/phpDoc/master $TRAVIS_BUILD_DIR/Pico/phpDoc/old-stable
#move new files
cp $TRAVIS_BUILD_DIR/build/docs/$TRAVIS_TAG $TRAVIS_BUILD_DIR/Pico/phpDoc/master

# Add the files to our commit
git add $TRAVIS_BUILD_DIR/Pico/phpDoc/*

# Commit the files with our commit message
git commit -m "update documentation"

# Force push from the current repo's master branch to the remote
# repo's gh-pages branch.We redirect any output to
# /dev/null to hide any sensitive credential data that might otherwise be exposed.
#git push --force --quiet "https://${GH_TOKEN}@${GH_REF}" master:gh-pages > /dev/null 2>&1
git push --force --quiet "https://${GH_TOKEN}@${GH_REF}" master:gh-pages > /dev/null 2>&1
