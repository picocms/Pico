---
toc:
    installing-pico:
        _title: Installing Pico
        using-a-pre-bundled-release--recommended-: Using a Pre-Bundled Release
        composer: Composer
nav: 1
---

## Installing Pico

You can install Pico using either a pre-bundled release (which we'd recommend for new users) or by using composer. Pico is also available on [Packagist.org][] and may be included in other projects via `composer require picocms/pico`. Pico requires PHP 5.3 or above.

* Changed `+` to "or above" because the lack of a period bugged me.

### Using a Pre-Bundled Release (Recommended)

Just [download the latest Pico release][LatestRelease] from GitHub and upload all the extracted files to the `httpdocs` directory (e.g. `/var/www/html`) of your server.  If you are using Apache, make sure you upload our `.htaccess` file for worry-free configuration.  **Please Note** that depending on your OS, after you've extracted the files, the `.htaccess` file may appear hidden by your file manager.

* investigate how "Recommended" id works.

### Composer

#### Step 1 - for users
[Download the *source code* of Pico's latest release][LatestRelease], upload all files to the `httpdocs` directory (e.g. `/var/www/html`) of your server and navigate to the upload directory using a shell.

* This Users/Developers split is *really* confusing.  If they have to open a shell anyway, then they might as well use the "developers" instructions.  Yes, I realize that this isn't quite so black and white, since most webhosts probably don't have `git` installed, but the split is still a bit weird.  I feel like any "non-developers" should just be using a bundled release.  Ah, I also see that the other difference is stable vs unstable.

#### Step 1 - for developers
Open a shell and navigate to the desired install directory of Pico within the `httpdocs` directory (e.g. `/var/www/html`) of your server. You can now clone Pico's Git repository as follows:
<pre><code>$ git clone {{ site.gh_project_url }}.git .</code></pre>
Please note that this gives you the current development version of Pico, that is likely *unstable* and *not ready for production use*!

#### Step 2
Download [composer][] and run it with the `install` option:
<pre><code>$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install</code></pre>

[Packagist.org]: http://packagist.org/packages/picocms/pico
[LatestRelease]: {{ site.gh_project_url }}/releases/latest
[composer]: https://getcomposer.org/
