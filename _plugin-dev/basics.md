---
toc:
    basics:
        _title: Basics
        versioning: Versioning
        build--release: Build & Release
nav: 1
---

# Basics
Creating your own content for Pico is *easy*.

Inside the root Pico folder, all *themes* reside in the `themes` directory, and all *plugins* in the `plugins` directory. (As a developer, you may have changed these paths and/or directory names when you initialized Pico.)

Note that if you are submitting pull requests they should be small (i.e. one feature per request), stick to existing coding conventions and documentation should be updated if required.

# Versioning
Pico uses Semantic Versioning. Given a version number MAJOR.MINOR.PATCH, increment the:

- MAJOR version when you make incompatible API changes,
- MINOR version when you add functionality in a backwards-compatible manner, and
- PATCH version when you make backwards-compatible bug fixes.

For more information see the [http://semver.org](http://semver.org) website.

# Build & Release
Defined below is a specification to which the Build and Release process of Pico should follow. We use `travis-ci` to automate the process, and each commit to `master` should be releasable.

### Commit phase
- Commit changes
- Create & Push Git tag
- Trigger automatic build process...

Example commit message:

    Pico 1.0.1
    * [New] ...
    * [Changed] ...

*Please submit pull-requests with a properly
formatted commit message/SemVer increase to avoid the need for manual amendments.*

### Analysis phase
- Run through `scrutinizer-ci`?

### Packaging phase
- Run composer locally
- Create a ZIP archive (so vendor/ is included)
- Build documentation, output goes to a new folder in the `gh-pages` branch

### Release phase
- Create new Git release at tag
- Upload ZIP archive
- Upload documentation to the `gh-pages` branch
- Set Symlink for latest documentation (http://picocms.org/docs/latest)
- Update release information on GitHub with:
    - Release title (taken from changelog)
    - Changelog

### Announcements
- Where to announce new Pico release?
