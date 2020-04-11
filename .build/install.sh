#!/usr/bin/env bash
set -e

[ -n "$PICO_BUILD_ENV" ] || { echo "No Pico build environment specified" >&2; exit 1; }

# setup build system
BUILD_REQUIREMENTS=( --phpcs )
[ "$1" != "--deploy" ] || BUILD_REQUIREMENTS+=( --cloc --phpdoc )
"$PICO_TOOLS_DIR/setup/$PICO_BUILD_ENV.sh" "${BUILD_REQUIREMENTS[@]}"

# set COMPOSER_ROOT_VERSION when necessary
if [ -z "$COMPOSER_ROOT_VERSION" ] && [ -n "$PROJECT_REPO_BRANCH" ]; then
    echo "Setting up Composer..."

    PICO_VERSION_PATTERN="$(php -r "
        \$json = json_decode(file_get_contents('$PICO_PROJECT_DIR/composer.json'), true);
        if (\$json !== null) {
            if (isset(\$json['extra']['branch-alias']['dev-$PROJECT_REPO_BRANCH'])) {
                echo 'dev-$PROJECT_REPO_BRANCH';
            }
        }
    ")"

    if [ -z "$PICO_VERSION_PATTERN" ]; then
        PICO_VERSION_PATTERN="$(php -r "
            require_once('$PICO_PROJECT_DIR/lib/Pico.php');
            echo preg_replace('/\.[0-9]+-dev$/', '.x-dev', picocms\Pico\Pico::VERSION);
        ")"
    fi

    if [ -n "$PICO_VERSION_PATTERN" ]; then
        export COMPOSER_ROOT_VERSION="$PICO_VERSION_PATTERN"
    fi

    echo
fi

# install dependencies
echo "Running \`composer install\`$([ -n "$COMPOSER_ROOT_VERSION" ] && echo -n " ($COMPOSER_ROOT_VERSION)")..."
composer install --no-suggest
