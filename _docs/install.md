---
toc:
    install:
        _title: Install
        using-a-pre-bundled-release: Using a pre-bundled released
        composer: Composer
    run: Run
nav: 1
---

## Install

You can install Pico either using a pre-bundled release or with composer. Pico requires PHP 5.3+

### Using a pre-bundled release

Just [download the latest Pico release][LatestRelease] and upload all files to the `httpdocs` directory (e.g. `/var/www/html`) of your server.

### Composer

#### Step 1 - for users
[Download the *source code* of Picos latest release][LatestRelease], upload all files to the `httpdocs` directory (e.g. `/var/www/html`) of your server and navigate to the upload directory using a shell.

#### Step 1 - for developers
Open a shell and navigate to the desired install directory of Pico within the `httpdocs` directory (e.g. `/var/www/html`) of your server. You can now clone Picos Git repository as follows:
<pre><code>$ git clone https://github.com/picocms/Pico.git .</code></pre>
Please note that this gives you the current development version of Pico, what is likely *unstable* and *not ready for production use*!

#### Step 2
Download [composer][composer] and run it with the `install` option:
<pre><code>$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install</code></pre>

Pico is available on [Packagist.org](http://packagist.org/packages/picocms/pico) and may be included in other projects via `composer require picocms/pico`

---

## Run

You have nothing to consider specially, simply navigate to your Pico install using your favorite web browser. Picos default contents will explain how to use your brand new, stupidly simple, blazing fast, flat file CMS.

### You don't have a web server?

Starting with PHP 5.4 the easiest way to try Pico is using [the built-in web server of PHP][PHPServer]. Please note that PHPs built-in web server is for development and testing purposes only!

#### Step 1
Navigate to Picos installation directory using a shell.

#### Step 2
Start PHPs built-in web server:
<pre><code>$ php -S 127.0.0.1:8080</code></pre>

#### Step 3
Access Pico from <http://localhost:8080>.

[LatestRelease]: https://github.com/picocms/Pico/releases/latest
[composer]: https://getcomposer.org/
[PHPServer]: http://php.net/manual/en/features.commandline.webserver.php
