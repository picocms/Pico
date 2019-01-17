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

### Szablony i templatki / tematy

Możesz dodawać i tworzyć tematy dla systemu Pico w folderze `themes`. Jako
przykład możesz wykorzystać kod domyślnego tematu. Pico używa [Twiga][Twig] do
renderowania gotowej witryny. W celu wskazania tematu, którego chcesz używać na
swojej stronie, użyj opcji `theme` w pliku `config/config.yml`, ustawiając
jej wartość na nazwę Twojego szablonu.

Wszystkie tematy muszą zawierać co najmniej jeden *szablon* - plik definiujący
strukturę strony i jej kod HTML. Obowiązkowym szablonem jest `index.twig`,
używany jako podstawowy. Oczywiście templatki mogą także zawierać więcej niż
jeden szablon, np. wspomniany w powyższej sekcji `blog-index.twig`.
All themes must include an `index.twig` file to define the HTML structure of
the theme. Below are the Twig variables that are available to use in your
theme. Please note that paths (e.g. `{{ base_dir }}`) and URLs
(e.g. `{{ base_url }}`) don't have a trailing slash.

* `{{ site_title }}` - Shortcut to the site title (see `config/config.yml`)
* `{{ config }}` - Contains the values you set in `config/config.yml`
                   (e.g. `{{ config.theme }}` becomes `default`)
* `{{ base_dir }}` - The path to your Pico root directory
* `{{ base_url }}` - The URL to your Pico site; use Twig's `link` filter to
                     specify internal links (e.g. `{{ "sub/page"|link }}`),
                     this guarantees that your link works whether URL rewriting
                     is enabled or not
* `{{ theme_dir }}` - The path to the currently active theme
* `{{ theme_url }}` - The URL to the currently active theme
* `{{ version }}` - Pico's current version string (e.g. `2.0.0`)
* `{{ meta }}` - Contains the meta values of the current page
    * `{{ meta.title }}`
    * `{{ meta.description }}`
    * `{{ meta.author }}`
    * `{{ meta.date }}`
    * `{{ meta.date_formatted }}`
    * `{{ meta.time }}`
    * `{{ meta.robots }}`
    * ...
* `{{ content }}` - The content of the current page after it has been processed
                    through Markdown
* `{{ pages }}` - A collection of all the content pages in your site
    * `{{ page.id }}` - The relative path to the content file (unique ID)
    * `{{ page.url }}` - The URL to the page
    * `{{ page.title }}` - The title of the page (YAML header)
    * `{{ page.description }}` - The description of the page (YAML header)
    * `{{ page.author }}` - The author of the page (YAML header)
    * `{{ page.time }}` - The [Unix timestamp][UnixTimestamp] derived from
                          the `Date` header
    * `{{ page.date }}` - The date of the page (YAML header)
    * `{{ page.date_formatted }}` - The formatted date of the page as specified
                                    by the `date_format` parameter in your
                                    `config/config.yml`
    * `{{ page.raw_content }}` - The raw, not yet parsed contents of the page;
                                 use Twig's `content` filter to get the parsed
                                 contents of a page by passing its unique ID
                                 (e.g. `{{ "sub/page"|content }}`)
    * `{{ page.meta }}`- The meta values of the page (see `{{ meta }}` above)
    * `{{ page.previous_page }}` - The data of the respective previous page
    * `{{ page.next_page }}` - The data of the respective next page
    * `{{ page.tree_node }}` - The page's node in Pico's page tree
* `{{ prev_page }}` - The data of the previous page (relative to `current_page`)
* `{{ current_page }}` - The data of the current page (see `{{ pages }}` above)
* `{{ next_page }}` - The data of the next page (relative to `current_page`)

Pages can be used like the following:

    <ul class="nav">
        {% for page in pages if not page.hidden %}
            <li><a href="{{ page.url }}">{{ page.title }}</a></li>
        {% endfor %}
    </ul>

Besides using the `{{ pages }}` list, you can also access pages using Pico's
page tree. The page tree allows you to iterate through Pico's pages using a tree
structure, so you can e.g. iterate just a page's direct children. It allows you
to build recursive menus (like dropdowns) and to filter pages more easily. Just
head over to Pico's [page tree documentation][FeaturesPageTree] for details.

To call assets from your theme, use `{{ theme_url }}`. For instance, to include
the CSS file `themes/my_theme/example.css`, add
`<link rel="stylesheet" href="{{ theme_url }}/example.css" type="text/css" />`
to your `index.twig`. This works for arbitrary files in your theme's folder,
including images and JavaScript files.

Additional to Twigs extensive list of filters, functions and tags, Pico also
provides some useful additional filters to make theming easier.

* Pass the unique ID of a page to the `link` filter to return the page's URL
  (e.g. `{{ "sub/page"|link }}` gets `%base_url%?sub/page`).
* To get the parsed contents of a page, pass its unique ID to the `content`
  filter (e.g. `{{ "sub/page"|content }}`).
* You can parse any Markdown string using the `markdown` filter (e.g. you can
  use Markdown in the `description` meta variable and later parse it in your
  theme using `{{ meta.description|markdown }}`). You can pass meta data as
  parameter to replace <code>&#37;meta.&#42;&#37;</code> placeholders (e.g.
  `{{ "Written *by %meta.author%*"|markdown(meta) }}` yields "Written by
  *John Doe*").
* Arrays can be sorted by one of its keys using the `sort_by` filter
  (e.g. `{% for page in pages|sort_by([ 'meta', 'nav' ]) %}...{% endfor %}`
  iterates through all pages, ordered by the `nav` meta header; please note the
  `[ 'meta', 'nav' ]` part of the example, it instructs Pico to sort by
  `page.meta.nav`). Items which couldn't be sorted are moved to the bottom of
  the array; you can specify `bottom` (move items to bottom; default), `top`
  (move items to top), `keep` (keep original order) or `remove` (remove items)
  as second parameter to change this behavior.
* You can return all values of a given array key using the `map` filter
  (e.g. `{{ pages|map("title") }}` returns all page titles).
* Use the `url_param` and `form_param` Twig functions to access HTTP GET (i.e.
  a URL's query string like `?some-variable=my-value`) and HTTP POST (i.e. data
  of a submitted form) parameters. This allows you to implement things like
  pagination, tags and categories, dynamic pages, and even more - with pure
  Twig! Simply head over to our [introductory page for accessing HTTP
  parameters][FeaturesHttpParams] for details.

You can use different templates for different content files by specifying the
`Template` meta header. Simply add e.g. `Template: blog` to the YAML header of
a content file and Pico will use the `blog.twig` template in your theme folder
to display the page.

Pico's default theme isn't really intended to be used for a productive website,
it's rather a starting point for creating your own theme. If the default theme
isn't sufficient for you, and you don't want to create your own theme, you can
use one of the great themes third-party developers and designers created in the
past. As with plugins, you can find themes in [our Wiki][WikiThemes] and on
[our website][OfficialThemes].

### Plugins

#### Plugins for users

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
