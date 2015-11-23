#!/usr/bin/env bash
# Modified from: https://gist.github.com/domenic/ec8b0fc8ab45f39403dd

# Exit with nonzero exit code if anything fails
set -e

# Clone Pico, then create & checkout gh-pages branch
git clone -b gh-pages "https://github.com/picocms/Pico.git $TRAVIS_BUILD_DIR/build/Pico"

# Inside this git repo we'll pretend to be a new user
git config user.name "Travis CI"
git config user.email "travis-ci@picocms.org"

#copy new files to release number
cp -a $TRAVIS_BUILD_DIR/build/docs/pico-$TRAVIS_TAG $TRAVIS_BUILD_DIR/build/Pico/phpDoc/pico-$TRAVIS_TAG
#move old files
mv -f $TRAVIS_BUILD_DIR/build/Pico/phpDoc/master $TRAVIS_BUILD_DIR/build/Pico/phpDoc/old-stable
#copy new files to master
cp -a $TRAVIS_BUILD_DIR/build/docs/pico-$TRAVIS_TAG $TRAVIS_BUILD_DIR/build/Pico/phpDoc/master

# Add the files to our commit
git add $TRAVIS_BUILD_DIR/build/Pico/phpDoc/*

# Commit the files with our commit message
git commit -m "Update Documentation for Pico $TRAVIS_TAG"

# Force push from the current repo's master branch to the remote
# repo's gh-pages branch.We redirect any output to
# /dev/null to hide any sensitive credential data that might otherwise be exposed.
git push --force --quiet "https://${GITHUB_OAUTH_TOKEN}@${GH_REF}" master:gh-pages > /dev/null 2>&1
