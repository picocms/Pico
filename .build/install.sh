#!/usr/bin/env bash
set -e

# setup build system
echo "Installing build dependencies..."

case "$1" in
    "--deploy")
        sudo apt-get install -y cloc
        ;;
esac

echo

# setup composer
echo "Setup Composer..."

# let composer use our GITHUB_OAUTH_TOKEN
if [ -n "$GITHUB_OAUTH_TOKEN" ]; then
    composer config --global github-oauth.github.com "$GITHUB_OAUTH_TOKEN"
fi

# set COMPOSER_ROOT_VERSION when necessary
if [ -z "$COMPOSER_ROOT_VERSION" ] && [ -n "$PROJECT_REPO_BRANCH" ]; then
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
            echo preg_replace('/\.[0-9]+-dev$/', '.x-dev', Pico::VERSION);
        ")"
    fi

    if [ -n "$PICO_VERSION_PATTERN" ]; then
        export COMPOSER_ROOT_VERSION="$PICO_VERSION_PATTERN"
    fi
fi

echo

# install dependencies
echo "Running \`composer install\`$([ -n "$COMPOSER_ROOT_VERSION" ] && echo -n " ($COMPOSER_ROOT_VERSION)")..."
composer install --no-suggest
