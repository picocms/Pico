---
toc:
    install:
        _title: Install
        using-a-pre-bundled-release: Using a pre-bundled released
        composer: Composer
nav: 1
---

Install
-------

You can install Pico either using a pre-bundled release or with composer. Pico is also available on [Packagist.org][] and may be included in other projects via `composer require picocms/pico`. Pico requires PHP 5.3+

### Using a pre-bundled release - for users

1. [Download the latest Pico release][LatestRelease]

2. Upload all files to the `httpdocs` directory (e.g. `/var/www/html`) of your server.

### Using Composer - for developers

1. Open a shell and navigate to the desired install directory of Pico within the `httpdocs` directory (e.g. `/var/www/html`) of your server. You can now clone Pico's Git repository as follows:

    ```
    $ git clone https://github.com/picocms/Pico.git .
    ```

    > Please note that this gives you the current development version of Pico, what is likely *unstable* and *not ready for production use*!

2. Download [composer][] and run it with the `install` option:

    ```
    $ curl -sS https://getcomposer.org/installer | php
    $ php composer.phar install
    ```

[Packagist.org]: http://packagist.org/packages/picocms/pico
[LatestRelease]: {{ site.gh_project_url }}/releases/latest
[composer]: https://getcomposer.org/
