Pico
====

[![License](https://picocms.github.io/badges/pico-license.svg)](https://github.com/picocms/Pico/blob/master/LICENSE.md)
[![Version](https://picocms.github.io/badges/pico-version.svg)](https://github.com/picocms/Pico/releases/latest)
[![Build Status](https://api.travis-ci.org/picocms/Pico.svg)](https://travis-ci.org/picocms/Pico)
[![Freenode IRC Webchat](https://picocms.github.io/badges/pico-chat.svg)](https://webchat.freenode.net/?channels=%23picocms)
[![Tweet Button](https://cloud.githubusercontent.com/assets/640217/11483728/b0842918-976f-11e5-9185-d53261b3125b.png)](https://twitter.com/intent/tweet?text=Pico+is+a+stupidly+simple%2C+blazing+fast%2C+flat+file+CMS.+Visit+http%3A%2F%2Fpicocms.org+and+downlaod+%23picocms+today%21+via+%40gitpicocms&amp;related=gitpicocms)

Pico is a stupidly simple, blazing fast, flat file CMS.

Visit us at http://picocms.org/ and see http://picocms.org/about/ for more info.

Screenshot
-------
![Pico Screenshot](https://cloud.githubusercontent.com/assets/640217/11488596/70b39396-978d-11e5-885e-01341ad9dd75.gif)

Install
-------

You can install Pico either using a pre-bundled release or with composer. Pico is also available on [Packagist.org][] and may be included in other projects via `composer require picocms/pico`. Pico requires PHP 5.3.6+

#### Using a pre-bundled release

Just [download the latest Pico release][LatestRelease] and upload all files to the `httpdocs` directory (e.g. `/var/www/html`) of your server.

#### Composer

###### Step 1 - for users
[Download the *source code* of Pico's latest release][LatestRelease], upload all files to the `httpdocs` directory (e.g. `/var/www/html`) of your server and navigate to the upload directory using a shell.

###### Step 1 - for developers
Open a shell and navigate to the desired install directory of Pico within the `httpdocs` directory (e.g. `/var/www/html`) of your server. You can now clone Pico's Git repository as follows:
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

Upgrade
-------

Upgrading Pico is very easy: You just have to replace all of Pico's files - that's it! Nevertheless you should *always* create a backup of your Pico installation before upgrading.

Pico follows [Semantic Versioning 2.0][SemVer] and uses version numbers like `MAJOR`.`MINOR`.`PATCH`. When we update...

- the `PATCH` version (e.g. `1.0.0` to `1.0.1`), we made backwards-compatible bug fixes. It's then sufficient to extract [Pico's latest release][LatestRelease] to your existing installation directory and overwriting all files. Alternatively you can either use the [*source code* of Pico's latest release][LatestRelease] or pull from Pico's Git repository, but are then required to update Pico's [composer][] dependencies manually by running `php composer.phar update`.

- the `MINOR` version (e.g. `1.0` to `1.1`), we added functionality in a backwards-compatible manner, but anyway recommend you to "install" Pico newly. Backup all of your files, empty your installation directory and install Pico as elucidated above. You can then copy your `config/config.php` and `content` directory without any change. If applicable, you can also copy the folder of your custom theme within the `themes` directory. Provided that you're using plugins, also copy all of your plugins from the `plugins` directory.

- the `MAJOR` version (e.g. `1.0` to `2.0`), we made incompatible API changes. We will then provide a appropriate upgrade tutorial.

Upgrading Pico 0.8 or 0.9 to Pico 1.0 is a special case. The new `PicoDeprecated` plugin ensures backwards compatibility, so you basically can follow the above upgrade instructions as if we updated the `MINOR` version. However, we recommend you to take some further steps to confine the necessity of `PicoDeprecated` as far as possible. For more information about what has changed with Pico 1.0 and a step-by-step upgrade tutorial, please refer to the [upgrade page of our website][HelpUpgrade].

Run
---

You have nothing to consider specially, simply navigate to your Pico install using your favorite web browser. Pico's default contents will explain how to use your brand new, stupidly simple, blazing fast, flat file CMS.

#### You don't have a web server?
Starting with PHP 5.4 the easiest way to try Pico is using [the built-in web server of PHP][PHPServer]. Please note that PHPs built-in web server is for development and testing purposes only!

###### Step 1
Navigate to Pico's installation directory using a shell.

###### Step 2
Start PHPs built-in web server:
```shell
$ php -S 127.0.0.1:8080
```

###### Step 3
Access Pico from http://localhost:8080.

Getting Help
------------

#### Getting Help as a user
If you want to get started using Pico, please refer to our [user docs][HelpUserDocs]. Please read the [upgrade notes][HelpUpgrade] if you want to upgrade from Pico 0.8 or 0.9 to Pico 1.0. You can find officially supported [plugins][OfficialPlugins] and [themes][OfficialThemes] on our website. A greater choice of third-party plugins and themes can be found in our [Wiki][] on the [plugins][WikiPlugins] or [themes][WikiThemes] pages respectively. If you want to create your own plugin or theme, please refer to the "Getting Help as a developer" section below.

#### Getting Help as a developer
If you're a developer, please refer to the "Contributing" section below and our [contribution guidelines][ContributionGuidelines]. To get you started with creating a plugin or theme, please read the [dev docs on our website][HelpDevDocs].

#### You still need help or experience a problem with Pico?
When the docs can't answer your question, you can get help by joining us on [#picocms on Freenode IRC](https://webchat.freenode.net/?channels=%23picocms). When you're experiencing problems with Pico, please don't hesitate to create a new [Issue][Issues] on GitHub. Concerning problems with plugins or themes, please refer to the website of the developer of this plugin or theme.

**Before creating a new Issue,** please make sure the problem wasn't reported yet using [GitHubs search engine][IssuesSearch]. Please describe your issue as clear as possible and always include the *Pico version* you're using. Provided that you're using *plugins*, include a list of them too. We need information about the *actual and expected behavior*, the *steps to reproduce* the problem, and what steps you have taken to resolve the problem by yourself (i.e. *your own troubleshooting*).

Contributing
------------

You want to contribute to Pico? We really appreciate that! You can help make Pico better by [contributing code][PullRequests] or [reporting issues][Issues], but please take note of our [contribution guidelines][ContributionGuidelines]. In general you can contribute in three different areas:

1. Plugins & Themes: You're a plugin developer or theme designer? We love you guys! You can find tons of information about how to develop plugins and themes at http://picocms.org/development/. If you have created a plugin or theme, please add it to our [Wiki][], either on the [plugins][WikiPlugins] or [themes][WikiThemes] page. You may also [Submit][] it to our website, where it'll be displayed on the official [plugin][OfficialPlugins] or [theme][OfficialThemes] pages!

2. Documentation: We always appreciate people improving our documentation. You can either improve the [inline user docs][EditInlineDocs] or the more extensive [user docs on our website][EditUserDocs]. You can also improve the [docs for plugin and theme developers][EditDevDocs]. Simply fork Pico from https://github.com/picocms/Pico, change the Markdown files and open a [pull request][PullRequests].

3. Pico's Core: The supreme discipline is to work on Pico's Core. Your contribution should help *every* Pico user to have a better experience with Pico. If this is the case, fork Pico from https://github.com/picocms/Pico and open a [pull request][PullRequests]. We look forward to your contribution!

[Packagist.org]: http://packagist.org/packages/picocms/pico
[LatestRelease]: https://github.com/picocms/Pico/releases/latest
[composer]: https://getcomposer.org/
[SemVer]: http://semver.org
[PHPServer]: http://php.net/manual/en/features.commandline.webserver.php
[HelpUpgrade]: http://picocms.org/in-depth/upgrade/
[HelpUserDocs]: http://picocms.org/docs/
[HelpDevDocs]: http://picocms.org/development/
[Submit]: http://picocms.org/in-depth/submission_guidelines
[OfficialPlugins]: http://picocms.org/plugins/
[OfficialThemes]: http://picocms.org/themes/
[Wiki]: https://github.com/picocms/Pico/wiki
[WikiPlugins]: https://github.com/picocms/Pico/wiki/Pico-Plugins
[WikiThemes]: https://github.com/picocms/Pico/wiki/Pico-Themes
[Issues]: https://github.com/picocms/Pico/issues
[IssuesSearch]: https://github.com/picocms/Pico/search?type=Issues
[PullRequests]: https://github.com/picocms/Pico/pulls
[ContributionGuidelines]: https://github.com/picocms/Pico/blob/master/CONTRIBUTING.md
[EditInlineDocs]: https://github.com/picocms/Pico/edit/master/content-sample/index.md
[EditUserDocs]: https://github.com/picocms/picocms.github.io/tree/master/_docs
[EditDevDocs]: https://github.com/picocms/picocms.github.io/tree/master/_development
