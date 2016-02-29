Contributing to Pico
====================

Pico aims to be a high quality Content Management System (CMS) but at the same time wants to give contributors freedom when submitting fixes or improvements.

As such we want to *encourage* but not obligate you, the contributor, to follow these guidelines. The only exception to this are the guidelines elucidated in the *Prevent `merge-hell`* section.

Having said that: we really appreciate it when you apply the guidelines in part or wholly as that will save us time which, in turn, we can spend on bugfixes and new features.

Issues
------

If you want to report an *issue* with Pico's core, please create a new [Issue](https://github.com/picocms/Pico/issues) on GitHub. Concerning problems with plugins or themes, please refer to the website of the developer of this plugin or theme.

Before creating a [new Issue on GitHub](https://github.com/picocms/Pico/issues/new), please make sure the problem wasn't reported yet using [GitHubs search engine](https://github.com/picocms/Pico/search?type=Issues).

Please describe your issue as clear as possible and always include the *Pico version* you're using. Provided that you're using *plugins*, include a list of them too. We need information about the *actual and expected behavior*, the *steps to reproduce* the problem, and what steps you have taken to resolve the problem by yourself (i.e. *your own troubleshooting*).

Contributing code
-----------------

Once you decide you want to contribute to *Pico's core* (which we really appreciate!) you can fork the project from https://github.com/picocms/Pico. If you're interested in developing a *plugin* or *theme* for Pico, please refer to the [development section](http://picocms.org/development/) of our website.

### Prevent `merge-hell`

Please do *not* develop your contribution on the `master` branch of your fork, but create a separate feature branch, that is based off the `master` branch, for each feature that you want to contribute.

> Not doing so means that if you decide to work on two separate features and place a pull request for one of them, that the changes of the other issue that you are working on is also submitted. Even if it is not completely finished.

To get more information about the usage of Git, please refer to the [Pro Git book](https://git-scm.com/book) written by Scott Chacon and/or [this help page of GitHub](https://help.github.com/articles/using-pull-requests).

### Pull Requests

Please keep in mind that pull requests should be small (i.e. one feature per request), stick to existing coding conventions and documentation should be updated if required. It's encouraged to make commits of logical units and check for unnecessary whitespace before committing (try `git diff --check`). Please reference issue numbers in your commit messages where appropriate.

### Coding Standards

Pico uses the [PSR-2 Coding Standard](http://www.php-fig.org/psr/psr-2/) as defined by the [PHP Framework Interoperability Group (PHP-FIG)](http://www.php-fig.org/).

For historical reasons we don't use formal namespaces. Markdown files in the `content-sample` folder (the inline documentation) must follow a hard limit of 80 characters line length.

It is recommended to check your code using [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) using Pico's `.phpcs.xml` standard. Use the following command:

    $ ./vendor/bin/phpcs --standard=.phpcs.xml [file]...

With this command you can specify a file or folder to limit which files it will check or omit that argument altogether, in which case the current working directory is checked.

### Keep documentation in sync

Pico accepts the problems of having redundant documentation on different places (concretely Pico's inline user docs, the `README.md` and the website) for the sake of a better user experience. When updating the docs, please make sure to keep them in sync.

If you update the [`README.md`](https://github.com/picocms/Pico/blob/master/README.md) or [`content-sample/index.md`](https://github.com/picocms/Pico/blob/master/content-sample/index.md), please make sure to update the corresponding files in the [`_docs`](https://github.com/picocms/Pico/tree/gh-pages/_docs/) folder of the `gh-pages` branch (i.e. [Pico's website](http://picocms.org/docs/)) and vice versa. Unfortunately this involves three (!) different markdown parsers. If you're experiencing problems, use Pico's [`erusev/parsedown-extra`](https://github.com/erusev/parsedown-extra) as a reference. You can try to make the contents compatible to [Kramdown](http://kramdown.gettalong.org/) (Pico's website) and [Redcarpet](https://github.com/vmg/redcarpet) (`README.md`) by yourself, otherwise please address the issues in your pull request message and we'll take care of it.

Versioning
----------

Pico follows [Semantic Versioning 2.0](http://semver.org) and uses version numbers like `MAJOR`.`MINOR`.`PATCH`. We will increment the:

- `MAJOR` version when we make incompatible API changes,
- `MINOR` version when we add functionality in a backwards-compatible manner, and
- `PATCH` version when we make backwards-compatible bug fixes.

For more information please refer to the http://semver.org website.

Branching
---------

The `master` branch contains the current development version of Pico. It is likely *unstable* and *not ready for production use*.

However, the `master` branch always consists of a deployable (but not necessarily deployed) version of Pico. As soon as development of a new `MAJOR` or `MINOR` release starts, a separate branch (e.g. `pico-1.1`) is created and a [pull request](https://github.com/picocms/Pico/pulls) is opened to receive the desired feedback.

Pico's actual development happens in separate development branches. Development branches are prefixed by:

- `feature/` for bigger features,
- `enhancement/` for smaller improvements, and
- `bugfix/` for non-trivial bug fixes.

As soon as development reaches a point where feedback is appreciated, a pull request is opened. After some time (very soon for bug fixes, and other improvements should have a reasonable feedback phase) the pull request is merged and the development branch will be deleted. Trivial bug fixes which will be part of the next `PATCH` version will be merged directly into `master`.

Build & Release process
-----------------------

We're using [Travis CI](https://travis-ci.com) to automate the build & release process of Pico. It generates and deploys [phpDoc](http://phpdoc.org) class docs for new releases and on every commit to the `master` branch. Travis also prepares new releases by generating Pico's pre-built packages, a version badge and pushing both to our website (the [`gh-pages` branch](https://github.com/picocms/Pico/tree/gh-pages)). Please refer to our [`.travis.yml`](https://github.com/picocms/Pico/blob/master/.travis.yml) and the [`_build` directory](https://github.com/picocms/Pico/tree/master/_build) for details.

As insinuated above, it is important that each commit to `master` is deployable. Once development of a new Pico release is finished, trigger Pico's build & release process by pushing a new Git tag. This tag should reference a (usually empty) commit on `master`, which message should adhere to the following template:

```
Version 1.0.0

* [Security] ...
* [New] ...
* [Changed] ...
* [Fixed] ...
* [Removed] ...
```

Travis CI will draft the new [release on GitHub](https://github.com/picocms/Pico/releases) automatically, but will require you to manually amend the descriptions formatting. The latest Pico version is always available at https://github.com/picocms/Pico/releases/latest, so please make sure to publish this URL rather than version-specific URLs. [Packagist](http://packagist.org/packages/picocms/pico) will be updated automatically.
