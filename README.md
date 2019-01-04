Pico
====

[![License](https://picocms.github.io/badges/pico-license.svg)](https://github.com/picocms/Pico/blob/master/LICENSE.md)
[![Version](https://picocms.github.io/badges/pico-version.svg)](https://github.com/picocms/Pico/releases/latest)
[![Build Status](https://api.travis-ci.org/picocms/Pico.svg?branch=master)](https://travis-ci.org/picocms/Pico)
[![Freenode IRC Webchat](https://picocms.github.io/badges/pico-chat.svg)](https://webchat.freenode.net/?channels=%23picocms)
[![Open Bounties on Bountysource](https://www.bountysource.com/badge/team?team_id=198139&style=bounties_received)](https://www.bountysource.com/teams/picocms)

Pico jest prostym do bólu, niewymagającym żadnej bazy danych, doświadczenia w stronach internetowych ani znajomości HTML'a CMS'em (systemem zarządzania treścią) o otwartym kodzie źródłowym.

Pełna wersja dokumentacji, zarówno dla użytkowników, jak i programistów, dostępna jest aktualnie tylko w języku angielskim na oficjalnej stronie projektu: http://picocms.org (bezpośredni link do wiki dla użytkownika: http://picocms.org/docs)

Screenshot
----------

![Pico Screenshot](http://nepose.rf.gd/pico-po-polsku.png)

Instalacja na serwerze (hostingu)
----------------------

Instalacja Pico na serwerze jest naprawdę łatwa, szybka i przyjemna. Jeśli masz dostęp do terminala na serwerze (np. przez protokół SSH), zalecamy użycie aplikacji Composer. Jeśli nie wiesz, co to jest SSH bądź nie masz takiego dostępu, skorzystaj z uprzednio przygotowanej wersji. 😇

Jedyne, czego Pico wymaga do działania, to dostęp do PHP w wersji 5.6.3 lub wyższej.

### Chcę skorzystać z aplikacji Composer

Zalecamy używanie Composera wszędzie tam, gdzie jest to tylko możliwe, ponieważ przy użyciu tej metody łatwiej Ci będzie później zaktualizować CMS'a do nowszej wersji. Oczywiście nic nie tracisz, używając gotowego pakietu.

###### Krok 1.

Otwórz terminal, podłącz się do serwera przez SSH i przejdź do katalogu, w którym musisz postawić stronę (na przykład `/var/www/html`, najczęściej ma on nazwę `htdocs`, `public_html` albo `html`) na Twoim serwerze. Zainstaluj na swoim serwerze Composera i pobierz najnowszą wersję Pico:

```shell
$ curl -sSL https://getcomposer.org/installer | php
$ php composer.phar create-project picocms/pico-composer pico
```

###### Krok 2

Jaki drugi krok? To koniec instalacji! Drugim krokiem jest wejście na Twoją stronę i sprawdzenie, czy poprawnie wyświetla się domyślna strona główna. Zapoznaj się z tą stroną, żeby się dowiedzieć, jak wygląda tworzenie kontentu na Pico CMS. 😊

### Chcę pobrać najnowszą wersję jako archiwum

Znasz to uczucie? Chcesz stworzyć fajną i ciekawą wizytówkę w Internecie, więc sięgasz po jakiegoś renomowanego CMS'a, jak na przykład WordPressa albo Joomlę. Ściągasz wszystkie pliki i wrzucasz je na serwer, potem się dowiadując, że musisz utworzyć bazę danych MySQL. Następnie wyskoczy Ci komunikat o konieczności zmiany uprawnień wybranych plików...
Zapomnij o tym. Pico działa zupełnie inaczej!

###### Krok 1.

[Pobierz najnowszą wersję Pico][LatestRelease] i wrzuć ją do katalogu z plikami strony (`htdocs` itp.) na serwer. Rozpakuj tam ją.

###### Krok 2.

Co to jest *krok drugi*? To jest wszystko! Zostało Ci tylko wejść na stronę i sprawdzić, czy wyświetla się domyślna strona początkowa. Zapoznaj się z nią uważnie, żeby się dowiedzieć, jak tworzyć kontent w Pico.

### Jestem programistą

Aaa! Więc jesteś jedną z tych osób, która wie, jak technicznie działa CMS i mogłaby wspomóc nasz projekt? Kochamy Was! Pico jest systemem o otwartym kodzie źródłowym, więc każdy może dołożyć przysłowiową cegiełkę do systemu. Żeby zapoznać się z kodem źródłowym oraz możliwościami Pico, możesz skopiować na swój komputer trzy repozytoria składające się na ten system:

* [główne repozytorium][PicoGit], 
* [domyślny szablon tego CMS'a][PicoThemeGit],
* [wtyczkę `PicoDeprecated`][PicoDeprecatedGit], umożliwiającą zgodność najnowszej wersji CMS'a z wtyczkami i szablonami pisanymi pod starsze wersje.

Możesz przygotować również [Pico's Composer starter project][PicoComposerGit] and include all of Pico's components using local packages.

Using Pico's Git repositories is different from using one of the installation methods elucidated above. It gives you the current development version of Pico, what is likely *unstable* and *not ready for production use*!

1. Open a shell and navigate to the desired directory of Pico's development workspace within the `httpdocs` directory (e.g. `/var/www/html/pico`) of your server. Download and extract Pico's Composer starter project into the `workspace` directory:

    ```shell
    $ curl -sSL https://github.com/picocms/pico-composer/archive/master.tar.gz | tar xz
    $ mv pico-composer-master workspace
    ```

2. Clone the Git repositories of all Pico components (Pico's core, Pico's default theme and the `PicoDeprecated` plugin) into the `components` directory:

    ```shell
    $ mkdir components
    $ git clone https://github.com/picocms/Pico.git components/pico
    $ git clone https://github.com/picocms/pico-theme.git components/pico-theme
    $ git clone https://github.com/picocms/pico-deprecated.git components/pico-deprecated
    ```

3. Instruct Composer to use the local Git repositories as replacement for the `picocms/pico` (Pico's core), `picocms/pico-theme` (Pico's default theme) and `picocms/pico-deprecated` (the `PicoDeprecated` plugin) packages. Update the `composer.json` of your development workspace (i.e. `workspace/composer.json`) accordingly:

    ```json
    {
        "repositories": [
            {
                "type": "path",
                "url": "../components/pico",
                "options": { "symlink": true }
            },
            {
                "type": "path",
                "url": "../components/pico-theme",
                "options": { "symlink": true }
            },
            {
                "type": "path",
                "url": "../components/pico-deprecated",
                "options": { "symlink": true }
            }
        ],
        "require": {
            "picocms/pico": "dev-master",
            "picocms/pico-theme": "dev-master",
            "picocms/pico-deprecated": "dev-master",
            "picocms/composer-installer": "^1.0"
        }
    }
    ```

4. Download Composer and run it with the `install` option:

    ```shell
    $ curl -sSL https://getcomposer.org/installer | php
    $ php composer.phar --working-dir=workspace install
    ```

You can now open your web browser and navigate to Pico's development workspace. All changes you make to Pico's components will automatically be reflected in the development workspace.

By the way, you can also find all of Pico's components on [Packagist.org][Packagist]: [Pico's core][PicoPackagist], [Pico's default theme][PicoThemePackagist], the [`PicoDeprecated` plugin][PicoDeprecatedPackagist] and [Pico's Composer starter project][PicoComposerPackagist].

Upgrade
-------

Do you remember when you installed Pico? It was ingeniously simple, wasn't it? Upgrading Pico is no difference! The upgrade process differs depending on whether you used [Composer][] or a pre-bundled release to install Pico. Please note that you should *always* create a backup of your Pico installation before upgrading!

Pico follows [Semantic Versioning 2.0][SemVer] and uses version numbers like `MAJOR`.`MINOR`.`PATCH`. When we update the `PATCH` version (e.g. `2.0.0` to `2.0.1`), we made backwards-compatible bug fixes. If we change the `MINOR` version (e.g. `2.0` to `2.1`), we added functionality in a backwards-compatible manner. Upgrading Pico is dead simple in both cases. Simply head over to the appropiate Upgrade sections below.

But wait, we forgot to mention what happens when we update the `MAJOR` version (e.g. `2.0` to `3.0`). In this case we made incompatible API changes. We will then provide a appropriate upgrade tutorial, so please head over to the ["Upgrade" page on our website][HelpUpgrade].

### I've used Composer to install Pico

Upgrading Pico is dead simple if you've used Composer to install Pico. Simply open a shell and navigate to Pico's install directory within the `httpdocs` directory (e.g. `/var/www/html/pico`) of your server. You can now upgrade Pico using just a single command:

```shell
$ php composer.phar update
```

That's it! Composer will automatically update Pico and all plugins and themes you've installed using Composer. Please make sure to manually update all plugins and themes you've installed manually.

### I've used a pre-bundled release to install Pico

Okay, installing Pico was easy, but upgrading Pico is going to be hard, isn't it? I'm affraid I have to disappoint you... It's just as simple as installing Pico!

First you'll have to delete the `vendor` directory of your Pico installation (e.g. if you've installed Pico to `/var/www/html/pico`, delete `/var/www/html/pico/vendor`). Then [download the latest Pico release][LatestRelease] and upload all files to your existing Pico installation directory. You will be prompted whether you want to overwrite files like `index.php`, `.htaccess`, ... - simply hit "Yes".

That's it! Now that Pico is up-to-date, you need to update all plugins and themes you've installed.

### I'm a developer

As a developer you should know how to stay up-to-date... 😉 For the sake of completeness, if you want to upgrade Pico, simply open a shell and navigate to Pico's development workspace (e.g. `/var/www/html/pico`). Then pull the latest commits from the Git repositories of [Pico's core][PicoGit], [Pico's default theme][PicoThemeGit] and the [`PicoDeprecated` plugin][PicoDeprecatedGit]. Let Composer update your dependencies and you're ready to go.

```shell
$ git -C components/pico pull
$ git -C components/pico-theme pull
$ git -C components/pico-deprecated pull
$ php composer.phar --working-dir=workspace update
```

Pomoc
-----

#### Dla użytkownika

Jeśli po zainstalowaniu Pico coś nie jest jeszcze dla Ciebie jasne, możesz się zapoznać ze specjalnie przygotowaną [dokumentacją dla początkujących][HelpUserDocs] (jej część jest w języku angielskim). Zapoznaj się z [tym poradnikiem][HelpUpgrade], jeśli potrzebujesz zaktualizować Pico do wersji 2.0. Na oficjalnej stronie CMS'a możesz znaleźć oficjalne i wyróżnione [wtyczki][OfficialPlugins] oraz [szablony][OfficialThemes]. Dużo większy wybór możesz znaleźć na liście [wtyczek][WikiPlugins] i [szablonów][WikiThemes] przygotowanych przez społeczność projektu. Ty też możesz coś zrobić - zerknij na [wiki projektu na GitHubie][Wiki] oraz na akapit poniżej.

#### Dla programisty i designera

Jeśli jesteś programistą, webdesignerem, osobą mogącą wesprzeć projekt, jesteś kimś, kogo bardzo potrzebujemy! Zapoznaj się z [zasadami udziału w projekcie][ContributionGuidelines] oraz z [dokumentacją dla programistów][HelpDevDocs] (po angielsku, ale chyba Ci to nie straszne ;) ). Pico używa [Twiga](https://twig.symfony.com) do renderowania strony z szablonów. Jest to bardzo prosty w użyciu silnik używający PHP, więc łatwo Ci będzie przeportować praktycznie dowolny szablon - wystarczy zastąpić te części, które mogą się zmieniać na stronie odpowiednimi zmiennymi Twiga.

#### Masz jeszcze jakieś pytanie, problem, pomysł?

Jeśli nie znalazłeś/aś szukanej przez Ciebie odpowiedzi w dokumentacji, nie wahaj się spytać o nią na [oficjalnym kanale IRC #picocms][Freenode] ([logi][FreenodeLogs]). Możesz także rozpocząć [dyskusję na GitHubie][Issues] lub przyłączyć się do już istniejącej. W razie problemów z wtyczkami bądź szablonami odwołaj się do jego/jej twórcy.

**Przed rozpoczęciem dyskusji na GitHubie** upewnij się, że już ktoś o to nie zapytał, używając [wyszukiwarki][IssuesSearch]. Zawsze opisuj swój problem tak dokładnie, jak tylko potrafisz, podając jak najwięcej szczegółów. Oczywistą koniecznością będzie podanie używanej wersji Pico, powiedz także, jakich wtyczek i jakiego szablonu używasz. Musimy wiedzieć, *w jakim stanie obecnie jest problem*, w jaki sposób *my możemy go odtworzyć u siebie* oraz co próbowałeś robić samemu, żeby go naprawić.

Contributing
------------

You want to contribute to Pico? We really appreciate that! You can help make Pico better by [contributing code][PullRequests] or [reporting issues][Issues], but please take note of our [contribution guidelines][ContributionGuidelines]. In general you can contribute in three different areas:

1. Plugins & Themes: You're a plugin developer or theme designer? We love you guys! You can find tons of information about how to develop plugins and themes at http://picocms.org/development/. If you have created a plugin or theme, please add it to our [Wiki][], either on the [plugins][WikiPlugins] or [themes][WikiThemes] page. You may also [Submit][] it to our website, where it'll be displayed on the official [plugin][OfficialPlugins] or [theme][OfficialThemes] pages!

2. Documentation: We always appreciate people improving our documentation. You can either improve the [inline user docs][EditInlineDocs] or the more extensive [user docs on our website][EditUserDocs]. You can also improve the [docs for plugin and theme developers][EditDevDocs]. Simply fork our website's Git repository from https://github.com/picocms/picocms.github.io, change the Markdown files and open a [pull request][PullRequestsWebsite].

3. Pico's Core: The supreme discipline is to work on Pico's Core. Your contribution should help *every* Pico user to have a better experience with Pico. If this is the case, fork Pico from https://github.com/picocms/Pico and open a [pull request][PullRequests]. We look forward to your contribution!

By contributing to Pico, you accept and agree to the *Developer Certificate of Origin* for your present and future contributions submitted to Pico. Please refer to the ["Developer Certificate of Origin" section in our `CONTRIBUTING.md`][ContributionGuidelinesDCO].

You don't have time to contribute code to Pico, but still want to "stand a coffee" for the ones who do? You can contribute monetary to Pico using [Bountysource][], a crowd funding website that focuses on individual issues and feature requests. Just refer to the "Bounties and Fundraisers" section below for more info.

Bounties and Fundraisers
------------------------

Pico uses [Bountysource][] to allow monetary contributions to the project. Bountysource is a crowd funding website that focuses on individual issues and feature requests in Open Source projects using micropayment. Users, or "Backers", can pledge money for fixing a specific issue, implementing new features, or developing a new plugin or theme. Open source software developers, or "Bounty Hunters", can then pick up and solve these tasks to earn the money.

Obviously this won't allow a developer to replace a full time job, it's rather aiming to "stand a coffee". However, it helps bringing users and developers closer together, and shows developers what users want and how much they care about certain things. Nevertheless you can still donate money to the project itself, as an easy way to say "Thank You" and to support Pico.

If you want to encourage developers to [fix a specific issue][Issues] or implement a feature, simply [pledge a new bounty][Bountysource] or back an existing one.

As a developer you can pick up a bounty by simply contributing to Pico (please refer to the "Contributing" section above). You don't have to be a official Pico Contributor! Pico is a Open Source project, anyone can open [pull requests][PullRequests] and claim bounties.

Official Pico Contributors won't claim bounties on their own behalf, Pico will never take any money out of Bountysource. All money collected by Pico is used to pledge new bounties or to support projects Pico depends on.

[Composer]: https://getcomposer.org/
[LatestRelease]: https://github.com/picocms/Pico/releases/latest
[PicoGit]: https://github.com/picocms/Pico
[PicoThemeGit]: https://github.com/picocms/pico-theme
[PicoDeprecatedGit]: https://github.com/picocms/pico-deprecated
[PicoComposerGit]: https://github.com/picocms/pico-composer
[Packagist]: https://packagist.org/
[PicoPackagist]: https://packagist.org/packages/picocms/pico
[PicoThemePackagist]: https://packagist.org/packages/picocms/pico-theme
[PicoDeprecatedPackagist]: https://packagist.org/packages/picocms/pico-deprecated
[PicoComposerPackagist]: https://packagist.org/packages/picocms/pico-composer
[SemVer]: http://semver.org
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
[Freenode]: https://webchat.freenode.net/?channels=%23picocms
[FreenodeLogs]: http://picocms.org/irc-logs
[PullRequests]: https://github.com/picocms/Pico/pulls
[PullRequestsWebsite]: https://github.com/picocms/picocms.github.io/pulls
[ContributionGuidelines]: https://github.com/picocms/Pico/blob/master/CONTRIBUTING.md
[ContributionGuidelinesDCO]: https://github.com/picocms/Pico/blob/master/CONTRIBUTING.md#developer-certificate-of-origin
[EditInlineDocs]: https://github.com/picocms/Pico/edit/master/content-sample/index.md
[EditUserDocs]: https://github.com/picocms/picocms.github.io/tree/master/_docs
[EditDevDocs]: https://github.com/picocms/picocms.github.io/tree/master/_development
[Bountysource]: https://www.bountysource.com/teams/picocms
