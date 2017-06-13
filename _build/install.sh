#!/usr/bin/env bash

set -e

# set COMPOSER_ROOT_VERSION when necessary
if [ -z "$TRAVIS_TAG" ] && [ "$TRAVIS_PULL_REQUEST" == "false" ]; then
    PICO_VERSION_PATTERN="$(php -r "
        \$json = json_decode(file_get_contents('$TRAVIS_BUILD_DIR/composer.json'), true);
        if (\$json !== null) {
            if (isset(\$json['extra']['branch-alias']['dev-$TRAVIS_BRANCH'])) {
                echo 'dev-$TRAVIS_BRANCH';
            }
        }
    ")"

    if [ -z "$PICO_VERSION_PATTERN" ]; then
        PICO_VERSION_PATTERN="$(php -r "
            require_once('$TRAVIS_BUILD_DIR/lib/Pico.php');
            echo preg_replace('/\.[0-9]+-dev$/', '.x-dev', Pico::VERSION);
        ")"
    fi

    if [ -z "$COMPOSER_ROOT_VERSION" ] && [ -n "$PICO_VERSION_PATTERN" ]; then
        export COMPOSER_ROOT_VERSION="$PICO_VERSION_PATTERN"
    fi
fi

# install dependencies
echo "Running \`composer install\`$([ -n "$COMPOSER_ROOT_VERSION" ] && echo -n " ($COMPOSER_ROOT_VERSION)")..."
composer install
