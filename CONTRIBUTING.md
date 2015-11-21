Contributing to Pico
====================

Pico aims to be a high quality Content Management System (CMS) but at the same time wants to give contributors freedom when submitting fixes or improvements.

As such we want to *encourage* but not obligate you, the contributor, to follow these guidelines. The only exception to this are the guidelines elucidated in the *Prevent `merge-hell`* section.

Having said that: we really appreciate it when you apply the guidelines in part or wholly as that will save us time which, in turn, we can spend on bugfixes and new features.

Issues
------

If you want to report an *issue* with Pico's core, please create a new [Issue](https://github.com/picocms/Pico/issues) on GitHub. Concerning problems with plugins or themes, please refer to the website of the developer of this plugin or theme.

Before creating a [new Issue on GitHub](https://github.com/picocms/Pico/issues/new), please make sure the problem wasn't reported yet using [GitHubs search engine](https://github.com/picocms/Pico/search?type=Issues). Please describe your issue as clear as possible and always include steps to reproduce the problem.

This is an example of what information to include with your issue.

    Version
    - Operating System and version
    - Pico Version
    - other installed software, plugins, if applicable
    - hardware information, if applicable

    Bug Description
    - A concise description of what the problem is.  Pure description, no narrative or conversational language.

    Severity
    - Trivial, Minor, Major, or Catastrophic

    Steps to Reproduce
    - Step by step instructions on how to reproduce this bug.
    - Do not assume anything, the more detailed your list of instructions, the easier it is for the developer to track down the problem!

    Actual Behavior
    - Type what happens when you follow the instructions.  This is the manifestation of the bug.

    Expected Behavior
    - Type what you expected to happen when you followed the instructions.  
    - This is important, because you may have misunderstood something or missed a step,
      and knowing what you expected to see will help the developer recognize that.

    Troubleshooting/Testing Steps Attempted
    - Describe anything you did to try to fix it on your own.

    Workaround
    - If you found a way to make the program work in spite of the bug, describe how you did it here.


Contributing code
-----------------

Once you decide you want to contribute to *Pico's core* (which we really appreciate!) you can fork the project from https://github.com/picocms/Pico. If you're interested in developing a *plugin* or *theme* for Pico, please refer to the [development section](http://picocms.org/plugin-dev.html) of our website.

### Prevent `merge-hell`

Please do *not* develop your contribution on the `master` branch of your fork, but create a separate feature branch, that is based off the `master` branch, for each feature that you want to contribute.

> Not doing so means that if you decide to work on two separate features and place a pull request for one of them, that the changes of the other issue that you are working on is also submitted. Even if it is not completely finished.

To get more information about the usage of Git, please refer to the [Pro Git book](https://git-scm.com/book) written by Scott Chacon and/or [this help page of GitHub](https://help.github.com/articles/using-pull-requests).

### Pull Requests

Please keep in mind that pull requests should be small (i.e. one feature per request), stick to existing coding conventions and documentation should be updated if required. It's encouraged to make commits of logical units and check for unnecessary whitespace before committing (try `git diff --check`). Please reference issue numbers in your commit messages where appropriate.

### Coding Standards

Pico uses the [PSR-2 Coding Standard](http://www.php-fig.org/psr/psr-2/) as defined by the [PHP Framework Interoperability Group (PHP-FIG)](http://www.php-fig.org/).

For historical reasons we don't use formal namespaces. Markdown files in the `content-sample` folder (the inline documentation) must follow a hard limit of 80 characters line length.

It is recommended to check your code using [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) using the `PSR2` standard using the following command:

    $ ./bin/phpcs --standard=PSR2 [file(s)]

With this command you can specify a file or folder to limit which files it will check or omit that argument altogether, in which case the current directory is checked.

### Keep documentation in sync

Pico accepts the problems of having redundant documentation on different places (concretely Pico's inline user docs, the `README.md` and the website) for the sake of a better user experience. When updating the docs, please make sure to keep them in sync.

If you update the [`README.md`](https://github.com/picocms/Pico/blob/master/README.md) or [`content-sample/index.md`](https://github.com/picocms/Pico/blob/master/content-sample/index.md), please make sure to update the corresponding files in the [`_docs`](https://github.com/picocms/Pico/tree/gh-pages/_docs/) folder of the `gh-pages` branch (i.e. [Pico's website](http://picocms.org/docs.html)) and vice versa. Unfortunately this involves three (!) different markdown parsers. If you're experiencing problems, use Pico's [`erusev/parsedown-extra`](https://github.com/erusev/parsedown-extra) as a reference. You can try to make the contents compatible to [Redcarpet](https://github.com/vmg/redcarpet) by yourself, otherwise please address the issues in your pull request message and we'll take care of it.

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

> This is work in progress. Please refer to [#268](https://github.com/picocms/Pico/issues/268) for details.

Defined below is a specification to which the Build and Release process of Pico should follow. We use [travis-ci](https://travis-ci.com) to automate the process, and each commit to `master` should be deployable. Once a `feature/branch` or the `master` branch have reached a point where the need for a version increase is necessary, move through these phases to generate a Pico release.

### Commit phase

- Make/Commit/Merge changes
- Use a formatted commit message with contents of `CHANGELOG.md` since last release.

    Example:
    ```
    Pico Version 1.0.1
    * [New] ...
    * [Changed] ...
    * [Removed] ...
    * [Security] ...
    ```

- Tagging a commit on the `master` branch will trigger an automatic build..

- __Please submit pull-requests with a properly formatted commit message and
[SemVer](http://semver.org) increase to avoid the need for manual amendments.__


### Analysis phase

Does the commit pass all `travis-ci` checks?

- We test PHP 5.3, 5.4, 5.5, 5.6, 7, the nighlty build, and HHVM

- should we `allow_failures:` in `.tavis.yml?`
    - php: hhvm
    - php: 7

If not, all errors will need to be corrected before the build can complete.

### Packaging phase

###### travis-ci
- will run [composer](http://getcomposer.org) locally.
- will create a ZIP archive (so vendor/ is included)

###### manually

- build current documentation using [PhpDocumentor](http://phpdoc.org)

    `phpdoc -d path/to/Pico/ -t path/to/Pico/build/docs/master`

    When running `phpDocumentor` there are three command-line options that are essential:
    - `-d`, specifies the directory, or directories, of your project that you want to document.
    - `-f`, specifies a specific file, or files, in your project that you want to document.
    - `-t`, specifies the location where your documentation will be written (also called ‘target folder’).

TO-DO: in the future, this should be automatic.
- can `phpDocumentor` be included in Pico's `composer.json`?
- can `travis-ci` run `phpDocumentor`? `php vendor/bin/phpdoc ...`
- can `travis-ci` run a shell script to:
    - `git clone`, `git add`, `git commit`, `git push` to `gh-pages`?
      e.g. `git clone -b gh-pages "https://github.com/picocms/Pico.git"`
    - (below) rename `docs/master` ...
    - `git push`
- organize in `build` folder?

### Release phase

###### travis-ci
- will create new Git release at tag
- will include the properly formatted commit message  including the changelog of items since the last release.
- will include ZIP archive in release

###### manually
TO-DO: in the future, this should be automatic. (See above)
- rename `docs/master` folder in `gh-pages` branch to the name of the previous Pico release. (e.g. `docs/pico-1.0.0`)
- upload current documentation to the `gh-pages` branch `/docs/master`
- update release information on GitHub with:
    - release title (taken from changelog)
    - changelog

###### automatically
- Pico will be automatically updated on [Packagist](http://packagist.org/packages/picocms/pico)

### Announcements
- Releases will be available at https://github.com/picocms/Pico/releases
