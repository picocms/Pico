---
Title: Witaj w Pico
Description: Pico jest prostym do bólu, niewymagającym żadnej bazy danych, doświadczenia w stronach internetowych ani znajomości HTML'a CMS'em (systemem zarządzania treścią).
---

## Witaj w Pico

Gratulujemy, właśnie zainstalowałeś [Pico][] %version%.
%meta.description%

## Tworzenie kontentu

Pico jest CMS'em typu *flat file*. Oznacza to, że nie potrzebuje on do działania
żadnej bazy danych ani panelu administratora. Tworzenie nowych stron polega na
dodawaniu plików `.md` (Markdown) do folderu `content`, które będą wypełnione
metadanymi oraz treścią docelową. Przykładowo, plik odpowiadający za wyświetlanie
strony domyślnej nazywa się `index.md`, dlatego jest wyświetlany jako strona główna.

Pico tuż po instalacji posiada kilka zapisanych stron, które wyświetlają się
zamiast Twojego kontentu. Gdy tylko dodasz jakiś plik `.md` do folderu `content`,
treść ta zniknie, a zamiast niej witryna zacznie być generowana z plików znajdujących
się w `content`. Jeśli będziesz potrzebował pomocy w tworzeniu strony z Pico, możesz
się wzorować na [treści plików `.md` domyślnych stron][SampleContents].

Gdy utworzysz folder w katalogu z kontentem (np. `content/sub`) i dodasz do niego
plik `index.md`, będziesz mógł otworzyć wygenerowaną przez niego stronę pod adresem
`%base_url%?sub`. Jeśli chcesz zmienić adres URL na jakiś inny, np. `%base_url%?sub/page`,
wystarczy, że w katalogu `sub` utworzysz plik `page.md` i wypełnisz go treścią.
Tak samo robi się dla każdej innej strony - wystarczy, że utworzysz plik (w razie
potrzeby także katalogi) z odpowiadającymi adresowi nazwami. Zobacz kilka przykładów
poniżej:

<table style="width: 100%; max-width: 40em;">
    <thead>
        <tr>
            <th style="width: 50%;">Lokalizacja na serwerze</th>
            <th style="width: 50%;">Adres URL</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>content/index.md</td>
            <td><a href="%base_url%">/</a></td>
        </tr>
        <tr>
            <td>content/sub.md</td>
            <td><del>?sub</del> (not accessible, see below)</td>
        </tr>
        <tr>
            <td>content/sub/index.md</td>
            <td><a href="%base_url%?sub">?sub</a> (same as above)</td>
        </tr>
        <tr>
            <td>content/jakisurl/alamakota.md</td>
            <td><a href="%base_url%?jakisurl/alamakota">?jakisurl/alamakota</a> (nie istnieje, to tylko taki przykład)</td>
        </tr>
        <tr>
            <td>content/a/stasiek/ma/psa.md</td>
            <td>
              <a href="%base_url%?a/stasiek/ma/psa">?a/stasiek/ma/psa</a>
              (również nie istnieje)
            </td>
        </tr>
    </tbody>
</table>

Jeśli jakiś plik nie będzie mógł zostać odnaleziony, zamiast niego zostanie pokazana
strona 404, którą możesz zdefiniować w pliku `content/404.md`. Możesz dodatkowo dodać
różne pliki `404.md` do zmiany treści tej strony dla poszczególnych podkatalogów.
Przykładowo, gdybyś chciał(a), żeby blog wyświetlał inną stronę 404, a blog ma adres
`%base_url%/?blog`, utwórz dla niej plik `content/blog/404.md`.

Pico osobno renderuje kontent Twojej strony (pliki `.md` w katalogu `content`)
oraz **szablony**, czyli pliki określające, jak Twoja strona ma wyglądać (pliki
w katalogu `themes`). Nie każdy plik w katalogu `content` pełni jednak funkcję
definiującą daną stronę w Twojej witrynie. Przykładowo niektóre szablony (jak
ten domyślny) pozwalają tworzyć tzw. **ukryte strony**. Są to fragmenty kodu w Markdownie,
które mogą być metadanymi albo na przykład definiować strony w pasku nawigacji. Domyślna
strona Pico posiada plik `_meta.md` określający wygląd dolnej stopki strony w domyślnym temacie.
Ważny tutaj jest znak `_` przed "właściwą nazwą", ponieważ to on blokuje renderowanie strony,
gdy przeglądarka zostanie o to zapytana. Przykładowo, gdybyś do swojej strony dodał(a)
plik `content/_alajednakmapsa.md`, a następnie spróbował(a) otworzyć stronę
`%base_url%?alajednakmapsa`, zamiast niej pojawi się błąd 404.

Dobą praktyką jest oddzielenie kontentu na stronie i wszelkich dodatków, jak na przykład
zdjęć i filmów do osadzenia na stronie czy plików do pobrania. Domyślnie Pico zabrania
dostępu do folderu `content` przez przeglądarkę. Jeśli chciałbyś/chciałabyś dodać jakiś
plik tego typu na swój serwer, zalecamy Ci, żebyś użył(a) w tym celu folderu `assets`.
Jest on niesprawdzany przez Pico, więc tam możesz spokojnie trzymać, co chcesz. Jeśli
katalog nie istnieje, utwórz go samemu. Możesz dodać wszystko z `assets` do Markdowna, 
jak w tym przykładzie:
<code>&#37;base_url&#37;/assets/</code> for example:
<code>!\[Image Title\](&#37;base_url&#37;/assets/image.png)</code>


### Pisanie treści na stronie

Pliki tworzące treść strony używają składni [Markdown][] i [Markdown Extra][MarkdownExtra].
Możesz do nich dodawać także zwykły kod HTML albo w razie potrzeby używać jednego i drugiego 
łącznie.
Na początku tych plików możesz dodać blok komentarza, w którym określisz metadane strony
(np. tytuł, opis, słowa kluczowe). Później będzie on nazwany "YAML header'em". Przykładowy
header (nazwy danych muszą być po angielsku):

    ---
    Title: Tytuł Twojej strony internetowej
    Description: To, co tu wpiszesz, zostanie wyświetlone w <meta name="description" ... />
    Author: Joe Bloggs
    Date: 2001-04-25
    Robots: noindex,nofollow
    Template: index
    ---

Te wartości będą później dostępne do użytku w szablonach przez zmienną `{{ meta }}`
(zobacz więcej poniżej). Czasami metadane mogą mieć znaczenie dodatkowe, przykładem
może być tutaj dana `Date` - Pico używa jej nie tylko do dodania do sekcji `<head>`
gotowej strony, lecz także sprawdza za jej pomocą, kiedy strona została utworzona.
Może Ci się to przydać, gdy będziesz chciał(a) posortować strony według daty utworzenia
(np. przy tworzeniu bloga). Kolejnym przykładem jest metadana `Template`, której
zadaniem jest sprawdzanie, którego szablonu z templatki Pico ma użyć do renderowania
strony (przykładowo, wpisując `Template: blog`, Pico będzie szukał szablonu `blog.twig`
w używanym templacie).

Następną zalecaną przez nas dobrą praktyką jest niewstawianie CSS'a bezpośrednio do
plików Markdowna. Zamiast tego dodaj potrzebne style do szablonów w templacie. Przykładowo,
przypuśćmy, że potrzebujesz ustawić następującą regułę CSS: `img.small { width: 80%; }`.
Możesz ją dodać do szablonu, a następnie wywołać ją w pliku `.md`, jak tutaj:
<code>!\[Image Title\](&#37;base_url&#37;/assets/image.png) {.small}</code>

Pico oferuje Ci także kilka zmiennych, których możesz używać w plikach Markdowna w celu
uniknięcia zbędnego powtarzania rzeczy takich jak:

* <code>&#37;site_title&#37;</code> - Tytuł Twojej strony;
* <code>&#37;base_url&#37;</code> - Adres Twojej strony; linki do poszczególnych
stron mogą być wywołane za pomocą <code>&#37;base_url&#37;?przykladowy/link</code>;
* <code>&#37;theme_url&#37;</code> - Adres do plików używanej przez Twoją stronę templatki;
* <code>&#37;version&#37;</code> - Obecna wersja systemu (np. `2.0.5-beta.1`);
* <code>&#37;meta.&#42;&#37;</code> - Wywołuje wartości z YAML header'a, np. 
<code>&#37;meta.author&#37;</code> spowoduje wypisane `Joe Bloggs`.

### Blogowanie

Pico nie jest pisany z myślą o blogowaniu, lecz bardzo łatwo jest wprowadzić
taką funkcjonalność, jeśli tylko tego potrzebujesz. Możesz znaleźć potrzebne
Ci wtyczki, jeśli czegoś Ci będzie brakowało, jak na przykład tagowania,
uwierzytelniania czy paginacji. Więcej informacji znajdziesz w sekcji Wtyczki
poniżej.

Chcąc używać Pico jako systemu także (bądź głównie) do prowadzenia bloga,
najłatwiej Ci będzie podążać za tym poradnikiem:

1. Umieść wszystkie Twoje artykuły w oddzielnym folderze `blog` w katalogu
`content`. Wszystkie artykuły powinny mieć metadaną `Date`.
2. Utwórz stronę dla bloga, która stanie się swego rodzaju placeholderem
do czytania postów. Najlepiej oczywiście będzie, gdy będzie miała ona adres
`%base_url%?blog/`, więc utwórz plik o nazwie `blog.md` albo `blog/index.md`
(oba będą się odwoływały do tego adresu, lecz nie mogą istnieć jednocześnie). 
Dodaj do tej strony metadaną `Template: blog-index`.
3. Utwórz nowy szablon Twiga o nazwie `blog-index.twig` (jak już pewnie widzisz,
nazwa musi się zgadzać z metadaną `Template` z pliku) tam, gdzie znajduje
się Twoja templatka. Nie będzie on zbytnio się różnił od głównego szablonu
`index.twig` (możesz przykładowo skopiować index, nadać kopii nazwę `blog-index.twig`
i wprowadzić w kopii Twoje zmiany). Przed zmienną `{{ content }}` dodaj
w pliku `blog-index.twig` ten kawałek kodu Twiga:

   ```
    {% for page in pages|sort_by("time")|reverse %}
        {% if page.id starts with "blog/" and not page.hidden %}
            <div class="post">
                <h3><a href="{{ page.url }}">{{ page.title }}</a></h3>
                <p class="date">{{ page.date_formatted }}</p>
                <p class="excerpt">{{ page.description }}</p>
            </div>
        {% endif %}
    {% endfor %}
   ```

## Modyfikowanie

Pico może być łatwo modyfikowany dwoma sposobami: z jednej strony możesz
zmienić wygląd swojej strony przez tematy, z drugiej możesz dodać
nowe funkcje do samego CMS'a przez wtyczki. To pierwsze wiąże się
z używaniem języków webowych, jak HTML, CSS czy JS, a to drugie opiera
się głównie na PHP.

Nie rozumiesz o co chodzi? Nie martw się, czeka na Ciebie katalog uprzednio
przygotowanych templatek i wtyczek. Więcej informacji znajduje się
w kolejnym rozdziale.

### Szablony i motywy

Możesz dodawać i tworzyć motywy dla systemu Pico w folderze `themes`. Jako
przykład możesz wykorzystać kod domyślnego motywu. Pico używa [Twiga][Twig] do
renderowania gotowej witryny. W celu wskazania motywu, którego chcesz używać na
swojej stronie, użyj opcji `theme` w pliku `config/config.yml`, ustawiając
jej wartość na nazwę Twojego szablonu.

Wszystkie tematy muszą zawierać co najmniej jeden *szablon* - plik definiujący
strukturę strony i jej kod HTML. Obowiązkowym szablonem jest `index.twig`,
używany jako podstawowy. Oczywiście motywy mogą także zawierać więcej niż
jeden szablon, np. wspomniany w powyższej sekcji `blog-index.twig`. Ważną
uwagą jest to, że wszystkie ścieżki i URLe w Pico (np. `{{ base_dir }}`)
nie zawierają końcowego slasha `/`. Tworząc szablon do użycia z motywem w Pico,
możesz korzystać z następujących zmiennych Twiga:

* `{{ site_title }}` - Nazwa Twojej strony (wartość z `config/config.yml`.
* `{{ config }}` - Tablica zawierająca wszystkie wartości z pliku `config/config.yml`,
	           np. `{{ config.theme }}` przyjmie wartość `default`.
* `{{ base_dir }}` - Ścieżka do Twojej instalacji Pico
* `{{ base_url }}` - Adres URL, pod którym jest dostępna Twoja instalacja Pico;
	             możesz użyć filtra `link` do zdefiniowania linków do innych
	             stron, np. `{{ "sub/page"|link }}`. Filtr `link` będzie działał
		     niezależnie od stanu modułu rewrite.
* `{{ theme_dir }}` - Ścieżka do aktualnie używanego tematu.
* `{{ theme_url }}` - Adres URL do aktualnie używanego tematu.
* `{{ version }}` - Obecna wersja Pico (np. `2.0.0`)
* `{{ meta }}` - Tablica zawierająca wartości z nagłówka YAML aktualnie renderowanej strony:
    * `{{ meta.title }}` zawiera wartość `Title` z YAML header'a
    * `{{ meta.description }}` zawiera wartość `Description`
    * `{{ meta.author }}`
    * `{{ meta.date }}`
    * `{{ meta.date_formatted }}`
    * `{{ meta.time }}`
    * `{{ meta.robots }}`
    * i tak dalej...
* `{{ content }}` - Zmienna zawierająca kontent strony uprzednio przeparsowanej przez filtr Markdowna.
* `{{ pages }}` - Tablica zawierająca informacje o wszystkich stronach wykrytych przez Pico:
    * `{{ page.id }}` - Identyfikator strony (URL bez adresu hosta i początkowego slasha)
    * `{{ page.url }}` - Adres URL strony
    * `{{ page.title }}` - Tytuł strony z nagłówka YAML
    * `{{ page.description }}` - Opis strony
    * `{{ page.author }}` - Autor strony
    * `{{ page.time }}` - [Czas uniksowy][UnixTimestamp] wyliczony na podstawie zmiennej `Date` z nagłówka YAML
    * `{{ page.date }}` - Data utworzenia strony, tak jak powyżej wykryta ze zmiennej `Date`
    * `{{ page.date_formatted }}` - Data strony przeparsowana w sposób określony przez opcję `date_format` w pliku konfiguracyjnym
    * `{{ page.raw_content }}` - Kontent danego pliku, jeszcze nie przeparsowany przez filtr Markdowna;
                                 możesz użyć filtru `content` do włączenia parsera Markdowna dla podanej strony
                                 (np. `{{ "sub/page"|content }}`)
    * `{{ page.meta }}`- Podtablica zawierająca metadane stron (zobacz tablicę `{{ meta }}` dla porównania
    * `{{ page.previous_page }}` - Informacje o poprzedniej stronie według numeracji Pico
    * `{{ page.next_page }}` - Informacje o następnej stronie według numeracji Pico
    * `{{ page.tree_node }}` - Tablica zawierająca wszystkie strony wykryte przez Pico ułożone hierarchicznie, niczym drzewo
* `{{ current_page }}` - Tablica zawierająca wszystkie informacje o obecnej stronie (dostępne wartości z `{{ pages }}`, zapoznaj się z tym po więcej informacji)
* `{{ prev_page }}` - Tablica zawierająca informacje o poprzedniej stronie (podobnie, jak `{{ current_page }}`)
* `{{ next_page }}` - Tablica z informacjami o następnej stronie (tak samo, jak `{{ prev_page }}`)

Zmienne Twiga i dostęp do układu stron według numeracji Pico mogą zostać wykorzystane na przykład do ich wylistowania:

    <ul class="nav">
        {% for page in pages if not page.hidden %}
            <li><a href="{{ page.url }}">{{ page.title }}</a></li>
        {% endfor %}
    </ul>

Oprócz używania tablicy `{{ pages }}`, możesz również skorzystać z *drzewa
stron* Pico. Jest to tablica zawierająca wszystkie strony ułożone hierarchicznie,
niczym drzewo, co pozwoli Ci przykładowo na wylistowanie stron będących *dziećmi*
strony `sub` czy budowanie rekursywnych menu, jak np. list drop-down. Po więcej
informacji o tej funkcji sięgnij do [dokumentacji funkcji page tree][FeaturesPageTree].

W celu dodania do Twojej strony dodatków zawartych w Twoim temacie, możesz
użyć zmiennej Twiga `{{ theme_url }}`. Przypuszczając, że chcesz dodać arkusz
CSS `themes/moj_temat/przykladowy_arkusz.css`, dodaj
`<link rel="stylesheet" href="{{ theme_url }}/przykladowy_arkusz.css" type="text/css" />`
do Twojego szablonu, np. `index.twig`. Funkcja ta będzie działała dla wszystkich plików
zawartych w katalogu z aktualnie używanym tematem.

Kolejną funkcjonalnością w szablonach oprócz dostępnych filtrów Twiga są filtry
oferowane przez Pico:

* Filtr `link` wywołuje adres URL żądanej przez Ciebie strony (np. `{{ "sub/page"|link }}`
  doda do Twojej strony `%base_url%?sub/page`).
* Filtr `content` przepuszcza żądaną przez Ciebie stronę przez filtr Markdowna
  (np. `{{ "sub/page"|content }}` wywoła kontent z pliku `content/sub/page.md`).
* Filtr `markdown` zamienia dowolny ciąg znaków Markdowna na kod HTML. Przykładowo,
  możesz sformatować nagłówek `Description` danej strony i dodać go do Twojego szablonu
  za pomocą zmiennej `{{ meta.description|markdown }}`. Możesz także dodać ogół
  metadanych jako parametr zamiast wyrażenia <code>&#37;meta.&#42;&#37;</code> (tutaj
  też przykład, `{{ "Utworzone *przez %meta.author%*"|markdown(meta) }}` wypluje
  "Utworzone przez *John Doe*".
* Filtr `sort_by` sortuje zmienne w tablicach według jednego albo więcej z ich kluczy
  (np. `{% for page in pages|sort_by([ 'meta', 'nav' ]) %}...{% endfor %}` posortuje
  wszystkie strony według informacji `nav` z nagłówka YAML; zwróć uwagę na użytą składnię
  parametru, w przykładzie jest to `[ 'meta', 'nav' ]`, co wskazuje na `page.meta.nav`).
  Pozycje niemożliwe do posortowania, np. z powodu braku zmiennej `nav`, zostaną umieszczone
  na dole listy. Możesz to jednak zmienić za pomocą drugiego parametru filtra; oprócz
  `bottom` (dół, domyślne) możesz także użyć `top` (góra, tutaj na początku listy), `keep`
  (zachowaj oryginalną kolejność) albo `remove` (usuń strony niemożliwe do posortowania).
* Filtr `map` zwróci wszystkie wartości danej zmiennej ze wszystkich stron (np. 
  `{{ pages|map("title") }}` zwróci wszystkie tytuły stron znajdujących się w tablicy `pages`.
* Oprócz tych filtrów Twig udostępnia również funkcje `url_param` i `form_param`. Pozwalają one
  na użycie odpowiednio metod GET (tutaj np. query string jak `?jakas-zmienna=wartosc`)
  i POST (np. wysłanie informacji z formularza). Za pomocą tej funkcji możesz wprowadzić do
  swojej strony dynamiczne elementy, jak np. kategorie, paginację czy tagi. Po więcej informacji
  na ten temat [sięgnij do odpowiedniego działu ze strony Pico][FeaturesHttpParams].

Budując lub edytując daną stronę w Twojej witrynie, możesz dodać do odpowiadającego jej pliku
kontentu zmienną `Template` w nagłówku YAML. Odpowiada ona za przypisanie danej stronie szablonu
oferowanego przez dany motyw. Przykładowo, dodając do pliku `content/blog.md` zmienną
`Template: blog`, gdy użytkownik wejdzie na adres `%base_url%/?blog`, ujrzy stronę wygenerowaną
za pomocą szablonu `blog.twig`. Nazwa zmiennej `Template` musi odpowiadać nazwie któregoś
z szablonów, w przeciwnym wypadku spowoduje to błąd 500.

Domyślny motyw oferowany przez Pico nie jest przeznaczony do budowania docelowych witryn,
lecz ma na celu bycie swego rodzaju bazą do modyfikacji, co Ci pozwoli na budowę prawdziwej
strony. Jeśli ani on, ani potrzeba wcześniej wspomnianej modyfikacji nie odpowiada Twoim
możliwościom bądź chęciom, możesz skorzystać z biblioteki motywów przygotowanych przez
chętnych programistów i webdesignerów. Wystarczy, że wejdziesz na [wiki Pico][WikiThemes]
albo na [listę najlepszych dodatków][OfficialThemes].


### Wtyczki

#### Dla użytkowników

Officially tested plugins can be found at http://picocms.org/plugins/, but
there are many awesome third-party plugins out there! A good start point for
discovery is [our Wiki][WikiPlugins].

Pico makes it very easy for you to add new features to your website using
plugins. Just like Pico, you can install plugins either using [Composer][]
(e.g. `composer require phrozenbyte/pico-file-prefixes`), or manually by
uploading the plugin's file (just for small plugins consisting of a single file,
e.g. `PicoFilePrefixes.php`) or directory (e.g. `PicoFilePrefixes`) to your
`plugins` directory. We always recommend you to use Composer whenever possible,
because it makes updating both Pico and your plugins way easier. Anyway,
depending on the plugin you want to install, you may have to go through some
more steps (e.g. specifying config variables) to make the plugin work. Thus you
should always check out the plugin's docs or `README.md` file to learn the
necessary steps.

Plugins which were written to work with Pico 1.0 and later can be enabled and
disabled through your `config/config.yml`. If you want to e.g. disable the
`PicoDeprecated` plugin, add the following line to your `config/config.yml`:
`PicoDeprecated.enabled: false`. To force the plugin to be enabled, replace
`false` by `true`.

#### Plugins for developers

You're a plugin developer? We love you guys! You can find tons of information
about how to develop plugins at http://picocms.org/development/. If you've
developed a plugin before and want to upgrade it to Pico 2.0, refer to the
[upgrade section of the docs][PluginUpgrade].

## Config

Configuring Pico really is stupidly simple: Just create a `config/config.yml`
to override the default Pico settings (and add your own custom settings). Take
a look at the `config/config.yml.template` for a brief overview of the
available settings and their defaults. To override a setting, simply copy the
line from `config/config.yml.template` to `config/config.yml` and set your
custom value.

But we didn't stop there. Rather than having just a single config file, you can
use a arbitrary number of config files. Simply create a `.yml` file in Pico's
`config` dir and you're good to go. This allows you to add some structure to
your config, like a separate config file for your theme (`config/my_theme.yml`).

Please note that Pico loads config files in a special way you should be aware
of. First of all it loads the main config file `config/config.yml`, and then
any other `*.yml` file in Pico's `config` dir in alphabetical order. The file
order is crucial: Config values which have been set already, cannot be
overwritten by a succeeding file. For example, if you set `site_title: Pico` in
`config/a.yml` and `site_title: My awesome site!` in `config/b.yml`, your site
title will be "Pico".

Since YAML files are plain text files, users might read your Pico config by
navigating to `%base_url%/config/config.yml`. This is no problem in the first
place, but might get a problem if you use plugins that require you to store
security-relevant data in the config (like credentials). Thus you should
*always* make sure to configure your webserver to deny access to Pico's
`config` dir. Just refer to the "URL Rewriting" section below. By following the
instructions, you will not just enable URL rewriting, but also deny access to
Pico's `config` dir.

### URL Rewriting

Pico's default URLs (e.g. %base_url%/?sub/page) already are very user-friendly.
Additionally, Pico offers you a URL rewrite feature to make URLs even more
user-friendly (e.g. %base_url%/sub/page). Below you'll find some basic info
about how to configure your webserver proberly to enable URL rewriting.

#### Apache

If you're using the Apache web server, URL rewriting probably already is
enabled - try it yourself, click on the [second URL](%base_url%/sub/page). If
URL rewriting doesn't work (you're getting `404 Not Found` error messages from
Apache), please make sure to enable the [`mod_rewrite` module][ModRewrite] and
to enable `.htaccess` overrides. You might have to set the
[`AllowOverride` directive][AllowOverride] to `AllowOverride All` in your
virtual host config file or global `httpd.conf`/`apache.conf`. Assuming
rewritten URLs work, but Pico still shows no rewritten URLs, force URL
rewriting by setting `rewrite_url: true` in your `config/config.yml`. If you
rather get a `500 Internal Server Error` no matter what you do, try removing
the `Options` directive from Pico's `.htaccess` file (it's the last line).

#### Nginx

If you're using Nginx, you can use the following config to enable URL rewriting
(lines `5` to `8`) and denying access to Pico's internal files (lines `1` to
`3`). You'll need to adjust the path (`/pico` on lines `1`, `2`, `5` and `7`)
to match your installation directory. Additionally, you'll need to enable URL
rewriting by setting `rewrite_url: true` in your `config/config.yml`. The Nginx
config should provide the *bare minimum* you need for Pico. Nginx is a very
extensive subject. If you have any trouble, please read through our
[Nginx config docs][NginxConfig].

```
location ~ ^/pico/((config|content|vendor|composer\.(json|lock|phar))(/|$)|(.+/)?\.(?!well-known(/|$))) {
    try_files /pico/index.php$is_args$args =404;
}

location /pico/ {
    index index.php;
    try_files $uri $uri/ /pico/index.php$is_args$args;
}
```

#### Lighttpd

Pico runs smoothly on Lighttpd. You can use the following config to enable URL
rewriting (lines `6` to `9`) and denying access to Pico's internal files (lines
`1` to `4`). Make sure to adjust the path (`/pico` on lines `2`, `3` and `7`)
to match your installation directory, and let Pico know about available URL
rewriting by setting `rewrite_url: true` in your `config/config.yml`. The
config below should provide the *bare minimum* you need for Pico.

```
url.rewrite-once = (
    "^/pico/(config|content|vendor|composer\.(json|lock|phar))(/|$)" => "/pico/index.php",
    "^/pico/(.+/)?\.(?!well-known(/|$))" => "/pico/index.php"
)

url.rewrite-if-not-file = (
    "^/pico(/|$)" => "/pico/index.php"
)
```

## Documentation

For more help have a look at the Pico documentation at http://picocms.org/docs.

[Pico]: http://picocms.org/
[SampleContents]: https://github.com/picocms/Pico/tree/master/content-sample
[Markdown]: http://daringfireball.net/projects/markdown/syntax
[MarkdownExtra]: https://michelf.ca/projects/php-markdown/extra/
[YAML]: https://en.wikipedia.org/wiki/YAML
[Twig]: http://twig.sensiolabs.org/documentation
[UnixTimestamp]: https://en.wikipedia.org/wiki/Unix_timestamp
[Composer]: https://getcomposer.org/
[FeaturesHttpParams]: http://picocms.org/in-depth/features/http-params/
[FeaturesPageTree]: http://picocms.org/in-depth/features/page-tree/
[WikiThemes]: https://github.com/picocms/Pico/wiki/Pico-Themes
[WikiPlugins]: https://github.com/picocms/Pico/wiki/Pico-Plugins
[OfficialThemes]: http://picocms.org/themes/
[PluginUpgrade]: http://picocms.org/development/#upgrade
[ModRewrite]: https://httpd.apache.org/docs/current/mod/mod_rewrite.html
[AllowOverride]: https://httpd.apache.org/docs/current/mod/core.html#allowoverride
[NginxConfig]: http://picocms.org/in-depth/nginx/
