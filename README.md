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

Możesz przygotować sobie również również [projekt Pico w aplikacji Composer][PicoComposerGit] i dołączyć do niego brakujące elementy, używając lokalnych pakietów. 

Ważną rzeczą jest to, że to repozytorium **jest aktualizowane na bieżąco**. Oznacza to, że "poprawki" składające się na kolejne aktualizacje są tutaj bieżąco wrzucane, a całe repozytorium jest traktowane jako swego rodzaju platforma do testów oraz baza dla programistów chcących współtworzyć projekt. Repozytorium nie jest przeznaczone do użytku jako instalacja CMS'a na serwerze dla użytkowników końcowych.

1. Otwórz terminal i przejdź do katalogu, w którym docelowo będzie się znajdowało deweloperskie wydanie Pico. Powinieneś/Powinnaś ustawić go jako katalog serwowania strony internetowej przez Twój server (np. w Apache zmień adres w opcji *DocumentRoot* albo dodaj swój folder do innego portu). Przykładowa lokalizacja: `/var/www/picocms-dev`.

2. Pobierz i rozpakuj gotową paczkę z projektem startowym w Composerze do docelowego katalogu. W tym przykładzie dodatkowo zmieniamy nazwę podkatalogu, do którego projekt został rozpakowany na *workspace*, więc docelowym katalogiem Twojej pracy zostanie `/var/www/picocms-dev/workspace`:

    ```shell
    $ curl -sSL https://github.com/picocms/pico-composer/archive/master.tar.gz | tar xz
    $ mv pico-composer-master workspace
    ```

3. Będąc w katalogu wyżej od `workspace` (w przykładzie `/var/www/picocms-dev`), utwórz w nim dodatkowy podkatalog `components` i sklonuj do niego (w sensie `components`) repozytoria trzech podstawowych składników Pico:

    ```shell
    $ mkdir components
    $ git clone https://github.com/picocms/Pico.git components/pico
    $ git clone https://github.com/picocms/pico-theme.git components/pico-theme
    $ git clone https://github.com/picocms/pico-deprecated.git components/pico-deprecated
    ```

4. W Twoim katalogu pracy znajduje się plik `composer.json`. Zaktualizuj go tak, żeby użył uprzednio sklonowanych przez Ciebie repozytoriów zamiast pobierać stabilne wersje z serwerów. Tutaj masz przykład gotowej zmiany:

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

Pamiętaj, że repozytoria oznaczają odpowiednio: `pico` - główne repozytorium Pico, `pico-theme` - domyślny szablon i `pico-deprecated` - wtyczka PicoDeprecated.

4. Zainstaluj aplikację Composer i za jej pomocą skończ przygotowywanie katalogu komendą `install`:

    ```shell
    $ curl -sSL https://getcomposer.org/installer | php
    $ php composer.phar --working-dir=workspace install
    ```

Możesz teraz otworzyć swoją przeglądarkę (pamiętając o tym, jak skonfigurowałeś swój serwer). Powinienieś teraz zobaczyć stronę domyślną Pico. Wszystkie zmiany, które przeprowadzisz w częściach tego systemu, będziesz mógł natychmiast zaobserwować na ekranie.

Wszystkie komponenty Pico możesz znaleźć również w serwisie [Packagist.org][Packagist]: [główne jądro][PicoPackagist], [domyślny szablon][PicoThemePackagist], [wtyczka `PicoDeprecated`][PicoDeprecatedPackagist] i [startowy projekt w Composerze][PicoComposerPackagist].

Aktualizacja systemu
--------------------

Pamiętasz moment, gdy instalowałeś Pico? Łatwo było, co nie? Aktualizację się robi bardzo podobnie. Proces aktualizacji różni się przebiegiem w zależności od metody pierwszej installacji. Niezależnie od tego czynnika, *zawsze* warto przygotować sobie kopię zapasową treści Twojej strony.

Pico korzysta z [semantycznego wersjonowania][SemVer] (standard w wersji 2.0.0), a co za tym idzie, numeracja kolejnych wersji CMS'a odbywa się w schemacie `MAJOR`.`MINOR`.`PATCH`. Gdy aktualizacja zmienia numerek `PATCH` (np. `2.0.0` -> `2.0.1`), oznacza to, że zawiera ona głównie poprawki błędów. Natomiast gdy zmienionym numerkiem jest `MINOR` (np. `2.0.5` -> `2.1.0`), dodaje ona ważniejsze zmiany, które jednak nie powinny zaburzać wstecznej kompatybilności ze starszymi wydaniami.

Ostatnią możliwą sytuacją jest zmiana numerka `MINOR` (np. `2.0` -> `3.0`), co oznacza wprowadzenie bardzo ważnych nowości, które mogą (zwykle są) niekompatybilne z poprzednimi odsłonami API. W takiej sytuacji udostępnimy Wam dodatkowe informacje o aktualizacji oraz poradniki co i jak, więc spokojnie ;) Udaj się wtedy do [sekcji "Upgrade" na stronie Pico][HelpUpgrade]

### Używałem/am Composera

Pamiętasz, gdy było napisane, że zalecamy używać Composera do zainstalowania Pico? Dzięki temu możesz zaktualizować CMS'a jedną komendą w terminalu, wykonaną w katalogu, w którym znajduje się Twoja strona internetowa:

```shell
$ php composer.phar update
```

Composer dokona automatycznej aktualizacji wszystkich tematów, wtyczek oraz oczywiście jądra Pico. **Ważna rzecz**: wszystkie tematy i wtyczki ręcznie wgrywane do systemu nie zostaną zaktualizowane, musisz tego dokonać samemu (w razie potrzeby).

### Używałem/am gotowego wydania (paczki do wgrania na serwer)

Nie martw się, nie będziesz miał/miała trudniejszej drogi do zaktualizowania Pico!

Na początku usuń subfolder `vendor` z katalogu, w którym zainstalowany jest Pico (przykładowo, gdy Pico znajduje się w `/var/www/html`, usuń `/var/www/html/vendor`). Następnie [pobierz najnowszą gotową paczkę] i skopiuj wszystkie pliki z niej do katalogu z zainstalowaną starszą wersją. Zgódź się na nadpisanie plików (np. `index.php`, `.htaccess` itd.). Automatycznie skopiuje to także cały folder `vendor` i zaktualizuje biblioteki używane przez system.

To już wszystko - wejdź na swoją stronę i sprawdź, czy otwiera się poprawnie.

### Jestem programistą / webdesignerem

Jako programista powinieneś/powinnaś wiedzieć, jak być ze wszystkim na bieżąco... ;)
Jeśli utworzyłeś sobie miejsce pracy z repozytoriów i projektu startowego na Composerze, dokonaj w katalogach ze sklonowanymi repozytoriami Gita aktualizacji do najnowszej wersji. Następnie zaktualizuj projekt za pomocą Composera. Już, to wszystko.

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

Udział w projekcie
------------------

Chciałbyś/Chciałabyś włożyć swoją cegiełkę w rozwój Pico? Jesteś dokładnie tą osobą, której potrzebujemy! Możesz nam pomóc przez [zmiany kodu źródłowego][PullRequests] i [zgłaszanie problemów][Issues]. Prosimy jednak o zapoznanie się z [zasadami udziału w projekcie][ContributionGuidelines]. Możesz działać w tych sektorach:

1. Wtyczki i tematy: Potrafisz napisać wtyczkę i/lub przeportować szablon do Pico, a może nawet stworzyć coś samemu? Czeka na Ciebie potężne wsparcie na specjalnej wiki dla deweloperów: http://picocms.org/development (po angielsku). Jeśli już coś stworzyłeś, możesz to dodać do [wiki dla użytkowników]. Stworzone są tam dwie sekcje: [dla wtyczek][WikiPlugins] i [dla szablonów stron][WikiThemes]. Możesz nawet [zaproponować ją do dodania strony projektu][]. Jeśli społeczność projektu zaakceptuje Twoją propozycję, będziesz mógł zobaczyć ją na oficjalnej stronie, odpowiednio [dla wtyczek][OfficialPlugins] bądź [szablonów stron][OfficialThemes]!

2. Dokumentacja: Jeśli masz już doświadczenie w używaniu Pico, możesz przekuć je w dokumentację dla innych. Zarówno [domyślna strona dla świeżo zainstalowanego CMS'a][EditInlineDocs], jak i [wiki użytkownika][EditUserDocs], a także [wiki dewelopera][EditDevDocs] są hostowane na GitHubie, więc możesz śmiało skopiować repozytorium naszej strony: https://github.com/picocms/picocms.github.io, dokonać swoich zmian i otworzyć [nowy pull request][PullRequestsWebsite].

3. Jądro systemu: Tutaj sprawa zaczyna być poważna. Ważne jest to, że Twoja zmiana powinna pomagać *każdemu* użytkownikowi Pico w użyciu tego systemu. Jeśli ten warunek się u Ciebie sprawdza, po prostu sklonuj [repozytorium Pico](https://github.com/picocms/Pico) i otwórz [pull request][PullRequests].

Każda pomoc w projekcie jest mile widziana! :) Pamiętaj o zapoznaniu się z zasadami uczestnictwa w projekcie, zwłaszcza z sekcją [*Developer Certificate of Origin*][ContributionGuidelinesDCO].

Nie masz czasu, żeby wspierać nas w pisaniu kodu źródłowego, jednak chciałbyś nam jakkolwiek pomóc? Możesz dokonać tego pieniężnie, używając crowdfundingowej strony [Bountysource][]. Po więcej informacji zerknij poniżej.

Wsparcie pieniężne i zlecenia
-----------------------------

Pico używa strony [Bountysource], dzięki której możecie wpłacać środki na działanie projektu i wysyłać nam Wasze prośby w formie "zleceń". Użytkownicy mogą w specjalnej sekcji dotyczącej naszego systemu otworzyć prośbę o naprawienie jakiegoś problemu czy napisanie pluginu bądź szablonu. Programiści mogą wybierać sobie zadania, będąc w stałym kontakcie z osobą, która je otworzyła, i je wykonać, przy okazji zarabiając troszkę pieniędzy. Oczywiście taka zapłata nie zastąpi im pełnowymiarowej pracy. Można to raczej ująć jako coś w stylu "postawienia kawy", przy okazji zbliżając do siebie osób używających danych funkcji oraz osób programujących te funkcje. Programiści dodatkowo mogą bliżej poznać potrzeby użytkowników i użyteczność Pico z ich perspektywy. Istnieje także możliwość wpłacenia pieniędzy na sam projekt, co także nas miło wesprze.

Jeśli chciałbyś zaangażować kogoś do [naprawienia usterki w systemie][Issues] bądź dodania nowej funkcji, możesz [dodać nowe zlecenie][Bountysource] w Bountysource lub odwołać się do już istniejącego. Jako programista nie musisz być oficjalnym deweloperem Pico. Jak już widzisz, nasz projekt jest otwarty dla wszystkich - każdy może wybrać sobie zlecenie ;)

Osoby oficjalnie biorące udział w projekcie nigdy nie wezmą pieniędzy zebranych na rzecz Pico dla siebie. Deklarujemy, że wszystkie pieniądze zebrane w ramach Bountysource są wykorzystywane do wspierania projektów, na których Pico polega oraz na tworzenie nowych zleceń.

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
