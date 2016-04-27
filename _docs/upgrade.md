---
toc:
    upgrade: Upgrade
nav: 2
---

## Upgrade [Learn more…][HelpUpgrade]{:.learn-more}
{:#upgrade}

Upgrading Pico is very easy: You just have to replace all of Pico's files - that's it! Nevertheless you should *always* create a backup of your Pico installation before upgrading.

Pico follows [Semantic Versioning 2.0][SemVer] and uses version numbers like `MAJOR`.`MINOR`.`PATCH`. When we update...

- the `PATCH` version (e.g. `1.0.0` to `1.0.1`), we made backwards-compatible bug fixes. It's then sufficient to extract [Pico's latest release][LatestRelease] to your existing installation directory and overwriting all files. Alternatively you can either use the [*source code* of Pico's latest release][LatestRelease] or pull from Pico's Git repository, but are then required to update Pico's [composer][] dependencies manually by running `php composer.phar update`.

- the `MINOR` version (e.g. `1.0` to `1.1`), we added functionality in a backwards-compatible manner, but anyway recommend you to "install" Pico newly. Backup all of your files, empty your installation directory and install Pico as elucidated above. You can then copy your `config/config.php` and `content` directory without any change. If applicable, you can also copy the folder of your custom theme within the `themes` directory. Provided that you're using plugins, also copy all of your plugins from the `plugins` directory.

- the `MAJOR` version (e.g. `1.0` to `2.0`), we made incompatible API changes. We will then provide a appropriate upgrade tutorial.

Upgrading Pico 0.8 or 0.9 to Pico 1.0 is a special case. The new `PicoDeprecated` plugin ensures backwards compatibility, so you basically can follow the above upgrade instructions as if we updated the `MINOR` version. However, we recommend you to take some further steps to confine the necessity of `PicoDeprecated` as far as possible. For more information about what has changed with Pico 1.0 and a step-by-step upgrade tutorial, please refer to the [upgrade page of our website][HelpUpgrade].

[SemVer]: http://semver.org
[LatestRelease]: {{ site.gh_project_url }}/releases/latest
[composer]: https://getcomposer.org/
[HelpUpgrade]: {{ site.github.url }}/in-depth/upgrade/
