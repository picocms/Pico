Pico
====

Pico is a stupidly simple, blazing fast, flat file CMS. See http://picocms.org/ for more info.

<!--flippa verify-->
[![I Love Open Source](http://www.iloveopensource.io/images/logo-lightbg.png)][iloveopensource]

Install
-------

You can install Pico either using a pre-bundled release or with composer. Pico requires PHP 5.3+

#### Using a pre-bundled release

Just [download the latest Pico release][LatestRelease] and upload all files to the `httpdocs` directory (e.g. `/var/www/html`) of your server.

#### Composer

**Step 1**
[Download the *source code* of Picos latest release][LatestRelease] and upload all files to the `httpdocs` directory (e.g. `/var/www/html`) of your server.

**Step 2**
Navigate to the upload directory using a shell.

**Step 3**
Download [composer][] and run it with the `install` option:
```bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```

Run
---

You have nothing to consider specially, simply navigate to your Pico install using your favourite web browser. Picos default contents will explain how to use your brand new, stupidly simple, blazing fast, flat file CMS.

**You don't have a web server?**

The easiest way to Pico is using [the built-in web server of PHP][PHPServer]. Please note that PHPs built-in web server is for development and testing purposes only!

**Step 1**
Navigate to Picos installation directory using a shell.

**Step 2**
Start PHPs built-in web server:
```bash
$ php -S 0.0.0.0:8080
```

**Step 3**
Access Pico from <http://localhost:8080>.

Wiki
----

Visit the [Pico Wiki](https://github.com/picocms/Pico/wiki) for plugins, themes, etc.

[iloveopensource]: http://www.iloveopensource.io/projects/524c55dcca7964c617000756
[LatestRelease]: https://github.com/picocms/Pico/releases/latest
[composer]: https://getcomposer.org/
[PHPServer]: <http://php.net/manual/en/features.commandline.webserver.php>
