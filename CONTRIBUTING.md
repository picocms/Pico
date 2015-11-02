Contributing to Pico
====================

Pico aims to be a high quality Content Management System (CMS) but at the same time wants to give contributors freedom when submitting fixes or improvements.

As such we want to *encourage* but not obligate you, the contributor, to follow these guidelines. The only exception to this are the guidelines elucidated in the *Prevent `merge-hell`* section.

Having said that: we really appreciate it when you apply the guidelines in part or wholly as that will save us time which, in turn, we can spend on bugfixes and new features.

Issues
------

If you want to report an *issue* with Picos core, please create a new [Issue](https://github.com/picocms/Pico/issues) on GitHub. Concerning problems with plugins or themes, please refer to the website of the developer of this plugin or theme.

Before creating a [new Issue on GitHub](https://github.com/picocms/Pico/issues/new), please make sure the problem wasn't reported yet using [GitHubs search engine](https://github.com/picocms/Pico/search?type=Issues). Please describe your issue as clear as possible and always include steps to reproduce the problem.

Contributing code
-----------------

Once you decide you want to contribute to *Picos core* (which we really appreciate!) you can fork the project from https://github.com/picocms/Pico. If you're interested in developing a *plugin* or *theme* for Pico, please refer to the [development section](http://picocms.org/plugin-dev.html) of our website.

### Prevent `merge-hell`

Please do *not* develop your contribution on the `master` branch of your fork, but create a separate feature branch, that is based off the `master` branch, for each feature that you want to contribute.

> Not doing so means that if you decide to work on two separate features and place a pull request for one of them, that the changes of the other issue that you are working on is also submitted. Even if it is not completely finished.

To get more information about the usage of Git, please refer to the [Pro Git book](https://git-scm.com/book) written by Scott Chacon and/or [this help page of GitHub](https://help.github.com/articles/using-pull-requests).

### Pull Requests

Please keep in mind that pull requests should be small (i.e. one feature per request), stick to existing coding conventions and documentation should be updated if required. It's encouraged to make commits of logical units and check for unnecessary whitespaces before commiting (try `git diff --check`). Please reference issue numbers in your commit messages where appropriate.

### Coding Standards

Pico uses the [PSR-2 Coding Standard](http://www.php-fig.org/psr/psr-2/) as defined by the [PHP Framework Interoperability Group (PHP-FIG)](http://www.php-fig.org/).

For historical reasons we don't use formal namespaces. Markdown files in the `content-sample` folder (the inline documentation) must follow a hard limit of 80 characters line length.

It is recommended to check your code using [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) using the `PSR2` standard using the following command:

    $ ./bin/phpcs --standard=PSR2 [file(s)]

With this command you can specify a file or folder to limit which files it will check or omit that argument altogether, in which case the current directory is checked.

Versioning
----------

Pico follows [Semantic Versioning 2.0](http://semver.org) and uses version numbers like `MAJOR`.`MINOR`.`PATCH`. We will increment the:

- `MAJOR` version when we make incompatible API changes,
- `MINOR` version when we add functionality in a backwards-compatible manner, and
- `PATCH` version when we make backwards-compatible bug fixes.

For more information please refer to the http://semver.org website.

Branching
---------

The `master` branch contains the current development version of Pico. It is likely *unstable* and *not ready for production use*. However, the `master` branch always consists of a deployable version of Pico.

Picos actual development happens in separate development branches. Development branches are prefixed by:

- `feature/` for bigger features,
- `enhancement/` for smaller improvements, and
- `bugfix/` for bug fixes.

As soon as development reaches a point where feedback is appreciated, a [pull request](https://github.com/picocms/Pico/pulls) is opened. After some time (very soon for bug fixes, and other improvements should have a reasonable feedback phase) the pull request is merged into `master` and the development branch will be deleted.

Build & Release process
-----------------------

This is work in progress. Please refer to [#268](https://github.com/picocms/Pico/issues/268) for details.

<!--

Defined below is a specification to which the Build and Release process of Pico should follow. We use `travis-ci` to automate the process, and each commit to `master` should be releasable.

#### Commit phase
- Commit changes
- Create & Push Git tag
- Trigger automatic build process...

Example commit message:

    Pico 1.0.1
    * [New] ...
    * [Changed] ...

*Please submit pull-requests with a properly
formatted commit message/SemVer increase to avoid the need for manual amendments.*

#### Analysis phase
- Run through `scrutinizer-ci`?

#### Packaging phase
- Run composer locally
- Create a ZIP archive (so vendor/ is included)
- Build documentation, output goes to a new folder in the `gh-pages` branch

#### Release phase
- Create new Git release at tag
- Upload ZIP archive
- Upload documentation to the `gh-pages` branch
- Set Symlink for latest documentation (http://picocms.org/docs/latest)
- Update release information on GitHub with:
    - Release title (taken from changelog)
    - Changelog

#### Announcements
- Where to announce new Pico release?

-->
