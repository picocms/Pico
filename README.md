Pico
====

[![License](https://img.shields.io/packagist/l/doctrine/orm.svg)](https://scrutinizer-ci.com/g/theshka/Pico/build-status/LICENSE)
[![Version](https://img.shields.io/badge/version-0.9-lightgrey.svg)]()
[![Build Status](https://scrutinizer-ci.com/g/theshka/Pico/badges/build.png?b=master)](https://scrutinizer-ci.com/g/theshka/Pico/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/theshka/Pico/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/theshka/Pico/?branch=master)

Pico is a stupidly simple, blazing fast, flat file CMS. See http://picocms.org/ for more info.

<!--flippa verify-->
[![I Love Open Source](http://www.iloveopensource.io/images/logo-lightbg.png)](http://www.iloveopensource.io/projects/524c55dcca7964c617000756)

Install
-------

You can install Pico either using a pre-bundled release or with composer. Pico requires PHP 5.3+

#### Using a pre-bundled release

Just [download the latest Pico release][LatestRelease] and upload all files to the `httpdocs` directory (e.g. `/var/www/html`) of your server.

#### Composer

###### Step 1 - for users
[Download the *source code* of Picos latest release][LatestRelease], upload all files to the `httpdocs` directory (e.g. `/var/www/html`) of your server and navigate to the upload directory using a shell.

###### Step 1 - for developers
Open a shell and navigate to the desired install directory of Pico within the `httpdocs` directory (e.g. `/var/www/html`) of your server. You can now clone Picos Git repository as follows:
```shell
$ git clone https://github.com/picocms/Pico.git .
```
Please note that this gives you the current development version of Pico, what is likely *unstable* and *not ready for production use*!

###### Step 2
Download [composer][] and run it with the `install` option:
```shell
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```

Run
---

You have nothing to consider specially, simply navigate to your Pico install using your favourite web browser. Picos default contents will explain how to use your brand new, stupidly simple, blazing fast, flat file CMS.

#### You don't have a web server?

The easiest way to Pico is using [the built-in web server of PHP][PHPServer]. Please note that PHPs built-in web server is for development and testing purposes only!

###### Step 1
Navigate to Picos installation directory using a shell.

###### Step 2
Start PHPs built-in web server:
```shell
$ php -S 127.0.0.1:8080
```

###### Step 3
Access Pico from <http://localhost:8080>.

Getting Help
------------

You can read the wiki if you are looking for examples and read the inline-docs for more development information.

If you find a bug please report it on the issues page, but remember to include as much detail as possible, and what someone can do to re-create the issue.

Issues with plugins should be reported on the offending plugins homepage, same goes for themes.

Contributing
------------

Help make PicoCMS better by checking out the GitHub repository and submitting pull requests.

If you create a plugin please add it to the Wiki.

Plugins + Wiki
--------------

Pico can be extended with a wide variety of plugins in order to add extra functionality, speed, or features.

Visit the [Pico Wiki][Wiki] for docs, plugins, themes, etc...

[LatestRelease]: https://github.com/picocms/Pico/releases/latest
[composer]: https://getcomposer.org/
[PHPServer]: http://php.net/manual/en/features.commandline.webserver.php
[Wiki]: https://github.com/picocms/Pico/wiki
