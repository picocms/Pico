#!/usr/bin/env bash
set -e

# setup build system
echo "Installing build dependencies..."

case "$1" in
    "--deploy")
        echo "Synchronizing package index files..."
        sudo apt-get update

        echo "Installing cloc..."
        sudo apt-get install -y cloc

        echo "Installing phpDocumentor..."
        curl --location --output "$PICO_TOOLS_DIR/phpdoc" \
            "https://github.com/phpDocumentor/phpDocumentor2/releases/latest/download/phpDocumentor.phar"
        chmod +x "$PICO_TOOLS_DIR/phpdoc"
        ;;
esac

echo "Installing PHP_CodeSniffer..."
if [ "$(php -r 'echo PHP_VERSION_ID;')" -ge 50400 ]; then
    PHPCS_DOWNLOAD="https://github.com/squizlabs/PHP_CodeSniffer/releases/latest/download/"
else
    PHPCS_DOWNLOAD="https://github.com/squizlabs/PHP_CodeSniffer/releases/download/2.9.2/"
fi

curl --location --output "$PICO_TOOLS_DIR/phpcs" \
    "$PHPCS_DOWNLOAD/phpcs.phar"
chmod +x "$PICO_TOOLS_DIR/phpcs"

curl --location --output "$PICO_TOOLS_DIR/phpcbf" \
    "$PHPCS_DOWNLOAD/phpcbf.phar"
chmod +x "$PICO_TOOLS_DIR/phpcbf"

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
