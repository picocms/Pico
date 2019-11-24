---
Title: Welcome
Description: Pico is a stupidly simple, blazing fast, flat file CMS.
---

## Welcome to Pico

Congratulations, you have successfully installed [Pico][] %version%.
%meta.description% <!-- replaced by the above Description header -->

## Creating Content

Pico is a flat file CMS. This means there is no administration backend or
database to deal with. You simply create `.md` files in the `content` folder
and those files become your pages. For example, this file is called `index.md`
and is shown as the main landing page.

When you install Pico, it comes with some sample contents that will display
until you add your own content. Simply add some `.md` files to your `content`
folder in Pico's root directory. No configuration is required, Pico will
automatically use the `content` folder as soon as you create your own
`index.md`. Just check out [Pico's sample contents][SampleContents] for an
example!

If you create a folder within the content directory (e.g. `content/sub`) and
put an `index.md` inside it, you can access that folder at the URL
`%base_url%?sub`. If you want another page within the sub folder, simply create
a text file with the corresponding name and you will be able to access it
(e.g. `content/sub/page.md` is accessible from the URL `%base_url%?sub/page`).
Below we've shown some examples of locations and their corresponding URLs:

<table style="width: 100%; max-width: 40em;">
    <thead>
        <tr>
            <th style="width: 50%;">Physical Location</th>
            <th style="width: 50%;">URL</th>
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
            <td>content/sub/page.md</td>
            <td><a href="%base_url%?sub/page">?sub/page</a></td>
        </tr>
        <tr>
            <td>content/theme.md</td>
            <td><a href="%base_url%?theme">?theme</a> (hidden in menu)</td>
        </tr>
        <tr>
            <td>content/a/very/long/url.md</td>
            <td>
              <a href="%base_url%?a/very/long/url">?a/very/long/url</a>
              (doesn't exist)
            </td>
        </tr>
    </tbody>
</table>

If a file cannot be found, the file `content/404.md` will be shown. You can add
`404.md` files to any directory. So, for example, if you wanted to use a special
error page for your blog, you could simply create `content/blog/404.md`.

Pico strictly separates contents of your website (the Markdown files in your
`content` directory) and how these contents should be displayed (the Twig
templates in your `themes` directory). However, not every file in your `content`
directory might actually be a distinct page. For example, some themes (including
Pico's default theme) use some special "hidden" file to manage meta data (like
`_meta.md` in Pico's sample contents). Some other themes use a `_footer.md` to
represent the contents of the website's footer. The common point is the `_`: all
files and directories prefixed by a `_` in your `content` directory are hidden.
These pages can't be accessed from a web browser, Pico will show a 404 error
page instead.

As a common practice, we recommend you to separate your contents and assets
(like images, downloads, etc.). We even deny access to your `content` directory
by default. If you want to use some assets (e.g. a image) in one of your content
files, use Pico's `assets` folder. You can then access them in your Markdown
using the <code>&#37;assets_url&#37;</code> placeholder, for example:
<code>!\[Image Title\](&#37;assets_url&#37;/image.png)</code>

### Text File Markup

Text files are marked up using [Markdown][] and [Markdown Extra][MarkdownExtra].
They can also contain regular HTML.

At the top of text files you can place a block comment and specify certain meta
attributes of the page using [YAML][] (the "YAML header"). For example:

    ---
    Title: Welcome
    Description: This description will go in the meta description tag
    Author: Joe Bloggs
    Date: 2001-04-25
    Robots: noindex,nofollow
    Template: index
    ---

These values will be contained in the `{{ meta }}` variable in themes (see
below). Meta headers sometimes have a special meaning: For instance, Pico not
only passes through the `Date` meta header, but rather evaluates it to really
"understand" when this page was created. This comes into play when you want to
sort your pages not just alphabetically, but by date. Another example is the
`Template` meta header: It controls what Twig template Pico uses to display
this page (e.g. if you add `Template: blog`, Pico uses `blog.twig`).

In an attempt to separate contents and styling, we recommend you to not use
inline CSS in your Markdown files. You should rather add appropriate CSS
classes to your theme. For example, you might want to add some CSS classes to
your theme to rule how much of the available space a image should use (e.g.
`img.small { width: 80%; }`). You can then use these CSS classes in your
Markdown files, for example:
<code>!\[Image Title\](&#37;assets_url&#37;/image.png) {.small}</code>

There are also certain variables that you can use in your text files:

* <code>&#37;site_title&#37;</code> - The title of your Pico site
* <code>&#37;base_url&#37;</code> - The URL to your Pico site; internal links
  can be specified using <code>&#37;base_url&#37;?sub/page</code>
* <code>&#37;theme_url&#37;</code> - The URL to the currently used theme
* <code>&#37;assets_url&#37;</code> - The URL to Pico's `assets` directory
* <code>&#37;themes_url&#37;</code> - The URL to Pico's `themes` directory;
  don't confuse this with <code>&#37;theme_url&#37;</code>
* <code>&#37;plugins_url&#37;</code> - The URL to Pico's `plugins` directory
* <code>&#37;version&#37;</code> - Pico's current version string (e.g. `2.0.0`)
* <code>&#37;meta.&#42;&#37;</code> - Access any meta variable of the current
  page, e.g. <code>&#37;meta.author&#37;</code> is replaced with `Joe Bloggs`
* <code>&#37;config.&#42;&#37;</code> - Access any scalar config variable,
  e.g. <code>&#37;config.theme&#37;</code> is replaced with `default`

### Blogging

Pico is not blogging software - but makes it very easy for you to use it as a
blog. You can find many plugins out there implementing typical blogging
features like authentication, tagging, pagination and social plugins. See the
below Plugins section for details.

If you want to use Pico as a blogging software, you probably want to do
something like the following:

1. Put all your blog articles in a separate `blog` folder in your `content`
   directory. All these articles should have a `Date` meta header.
2. Create a `blog.md` or `blog/index.md` in your `content` directory. Add
   `Template: blog-index` to the YAML header of this page. It will later show a
   list of all your blog articles (see step 3).
3. Create the new Twig template `blog-index.twig` (the file name must match the
   `Template` meta header from Step 2) in your theme directory. This template
   probably isn't very different from your default `index.twig` (i.e. copy
   `index.twig`), it will create a list of all your blog articles. Add the
   following Twig snippet to `blog-index.twig` near `{{ content }}`:
   ```
    {% for page in pages("blog")|sort_by("time")|reverse if not page.hidden %}
        <div class="post">
            <h3><a href="{{ page.url }}">{{ page.title }}</a></h3>
            <p class="date">{{ page.date_formatted }}</p>
            <p class="excerpt">{{ page.description }}</p>
        </div>
    {% endfor %}
   ```

## Customization

Pico is highly customizable in two different ways: On the one hand you can
change Pico's appearance by using themes, on the other hand you can add new
functionality by using plugins. Doing the former includes changing Pico's HTML,
CSS and JavaScript, the latter mostly consists of PHP programming.

This is all Greek to you? Don't worry, you don't have to spend time on these
techie talk - it's very easy to use one of the great themes or plugins others
developed and released to the public. Please refer to the next sections for
details.

### Themes

You can create themes for your Pico installation in the `themes` folder. Pico
uses [Twig][] for template rendering. You can select your theme by setting the
`theme` option in `config/config.yml` to the name of your theme folder.

[Pico's default theme][PicoTheme] isn't really intended to be used for a
productive website, it's rather a starting point for creating your own theme.
If the default theme isn't sufficient for you, and you don't want to create
your own theme, you can use one of the great themes third-party developers and
designers created in the past. As with plugins, you can find themes in
[our Wiki][WikiThemes] and on [our website][OfficialThemes].

All themes must include an `index.twig` file to define the HTML structure of
the theme, and a `pico-theme.yml` to set the necessary config parameters. Just
refer to Pico's default theme as an example. You can use different templates
for different content files by specifying the `Template` meta header. Simply
add e.g. `Template: blog` to the YAML header of a content file and Pico will
use the `blog.twig` template in your theme folder to display the page.

Below are the Twig variables that are available to use in themes. Please note
that URLs (e.g. `{{ base_url }}`) never include a trailing slash.

* `{{ site_title }}` - Shortcut to the site title (see `config/config.yml`)
* `{{ config }}` - Contains the values you set in `config/config.yml`
                   (e.g. `{{ config.theme }}` becomes `default`)
* `{{ base_url }}` - The URL to your Pico site; use Twig's `link` filter to
                     specify internal links (e.g. `{{ "sub/page"|link }}`),
                     this guarantees that your link works whether URL rewriting
                     is enabled or not
* `{{ theme_url }}` - The URL to the currently active theme
* `{{ assets_url }}` - The URL to Pico's `assets` directory
* `{{ themes_url }}` - The URL to Pico's `themes` directory; don't confuse this
                       with `{{ theme_url }}`
* `{{ plugins_url }}` - The URL to Pico's `plugins` directory
* `{{ version }}` - Pico's current version string (e.g. `%version%`)
* `{{ meta }}` - Contains the meta values of the current page
    * `{{ meta.title }}` - The `Title` YAML header
    * `{{ meta.description }}` - The `Description` YAML header
    * `{{ meta.author }}` - The `Author` YAML header
    * `{{ meta.date }}` - The `Date` YAML header
    * `{{ meta.date_formatted }}` - The formatted date of the page as specified
                                    by the `date_format` parameter in your
                                    `config/config.yml`
    * `{{ meta.time }}` - The [Unix timestamp][UnixTimestamp] derived from the
                          `Date` YAML header
    * `{{ meta.robots }}` - The `Robots` YAML header
    * ...
* `{{ content }}` - The content of the current page after it has been processed
                    through Markdown
* `{{ previous_page }}` - The data of the previous page, relative to
                          `current_page`
* `{{ current_page }}` - The data of the current page; refer to the "Pages"
                         section below for details
* `{{ next_page }}` - The data of the next page, relative to `current_page`

To call assets from your theme, use `{{ theme_url }}`. For instance, to include
the CSS file `themes/my_theme/example.css`, add
`<link rel="stylesheet" href="{{ theme_url }}/example.css" type="text/css" />`
to your `index.twig`. This works for arbitrary files in your theme's folder,
including images and JavaScript files.

Please note that Twig escapes HTML in all strings before outputting them. So
for example, if you add `headline: My <strong>favorite</strong> color` to the
YAML header of a page and output it using `{{ meta.headline }}`, you'll end up
seeing `My <strong>favorite</strong> color` - yes, including the markup! To
actually get it parsed, you must use `{{ meta.headline|raw }}` (resulting in
the expected <code>My **favorite** color</code>). Notable exceptions to this
are Pico's `content` variable (e.g. `{{ content }}`), Pico's `content` filter
(e.g. `{{ "sub/page"|content }}`), and Pico's `markdown` filter, they all are
marked as HTML safe.

#### Dealing with pages

There are several ways to access Pico's pages list. You can access the current
page's data using the `current_page` variable, or use the `prev_page` and/or
`next_page` variables to access the respective previous/next page in Pico's
pages list. But more importantly there's the `pages()` function. No matter how
you access a page, it will always consist of the following data:

* `{{ id }}` - The relative path to the content file (unique ID)
* `{{ url }}` - The URL to the page
* `{{ title }}` - The title of the page (`Title` YAML header)
* `{{ description }}` - The description of the page (`Description` YAML header)
* `{{ author }}` - The author of the page (`Author` YAML header)
* `{{ date }}` - The date of the page (`Date` YAML header)
* `{{ date_formatted }}` - The formatted date of the page as specified by the
                           `date_format` parameter in your `config/config.yml`
* `{{ time }}` - The [Unix timestamp][UnixTimestamp] derived from the page's
                 date
* `{{ raw_content }}` - The raw, not yet parsed contents of the page; use the
                        filter to get the parsed contents of a page by passing
                        its unique ID (e.g. `{{ "sub/page"|content }}`)
* `{{ meta }}` - The meta values of the page (see global `{{ meta }}` above)
* `{{ prev_page }}` - The data of the respective previous page
* `{{ next_page }}` - The data of the respective next page
* `{{ tree_node }}` - The page's node in Pico's page tree; check out Pico's
                      [page tree documentation][FeaturesPageTree] for details

Pico's `pages()` function is the best way to access all of your site's pages.
It uses Pico's page tree to easily traverse a subset of Pico's pages list. It
allows you to filter pages and to build recursive menus (like dropdowns). By
default, `pages()` returns a list of all main pages (e.g. `content/page.md` and
`content/sub/index.md`, but not `content/sub/page.md` or `content/index.md`).
If you want to return all pages below a specific folder (e.g. `content/blog/`),
pass the folder name as first parameter to the function (e.g. `pages("blog")`).
Naturally you can also pass variables to the function. For example, to return a
list of all child pages of the current page, use `pages(current_page.id)`.
Check out the following code snippet:

    <section class="articles">
        {% for page in pages(current_page.id) if not page.hidden %}
            <article>
                <h2><a href="{{ page.url }}">{{ page.title }}</a></h2>
                {{ page.id|content }}
            </article>
        {% endfor %}
    </section>

The `pages()` function is very powerful and also allows you to return not just
a page's child pages by passing the `depth` and `depthOffset` params. For
example, if you pass `pages(depthOffset=-1)`, the list will also include Pico's
main index page (i.e. `content/index.md`). This one is commonly used to create
a theme's main navigation. If you want to learn more, head over to Pico's
complete [`pages()` function documentation][FeaturesPagesFunction].

If you want to access the data of a particular page, use Pico's `pages`
variable. Just take `content/_meta.md` in Pico's sample contents for an
example: `content/_meta.md` contains some meta data you might want to use in
your theme. If you want to output the page's `tagline` meta value, use
`{{ pages["_meta"].meta.logo }}`. Don't ever try to use Pico's `pages` variable
as an replacement for Pico's `pages()` function. Its usage looks very similar,
it will kinda work and you might even see it being used in old themes, but be
warned: It slows down Pico. Always use Pico's `pages()` function when iterating
Pico's page list (e.g. `{% for page in pages() %}…{% endfor %}`).

#### Twig filters and functions

Additional to [Twig][]'s extensive list of filters, functions and tags, Pico
also provides some useful additional filters and functions to make theming
even easier.

* Pass the unique ID of a page to the `link` filter to return the page's URL
  (e.g. `{{ "sub/page"|link }}` gets `%base_url%?sub/page`).
* You can replace URL placeholders (like <code>&#37;base_url&#37;</code>) in
  arbitrary strings using the `url` filter. This is helpful together with meta
  variables, e.g. if you add <code>image: &#37;assets_url&#37;/stock.jpg</code>
  to the YAML header of a page, `{{ meta.image|url }}` will return
  `%assets_url%/stock.jpg`.
* To get the parsed contents of a page, pass its unique ID to the `content`
  filter (e.g. `{{ "sub/page"|content }}`).
* You can parse any Markdown string using the `markdown` filter. For example,
  you might use Markdown in the `description` meta variable and later parse it
  in your theme using `{{ meta.description|markdown }}`. You can also pass meta
  data as parameter to replace <code>&#37;meta.&#42;&#37;</code> placeholders
  (e.g. `{{ "Written by *%meta.author%*"|markdown(meta) }}` yields "Written by
  *John Doe*"). However, please note that all contents will be wrapped inside
  HTML paragraph elements (i.e. `<p>…</p>`). If you want to parse just a single
  line of Markdown markup, pass the `singleLine` param to the `markdown` filter
  (e.g. `{{ "This really is a *single* line"|markdown(singleLine=true) }}`).
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
[PicoTheme]: https://github.com/picocms/pico-theme
[SampleContents]: https://github.com/picocms/Pico/tree/master/content-sample
[Markdown]: http://daringfireball.net/projects/markdown/syntax
[MarkdownExtra]: https://michelf.ca/projects/php-markdown/extra/
[YAML]: https://en.wikipedia.org/wiki/YAML
[Twig]: http://twig.sensiolabs.org/documentation
[UnixTimestamp]: https://en.wikipedia.org/wiki/Unix_timestamp
[Composer]: https://getcomposer.org/
[FeaturesHttpParams]: http://picocms.org/in-depth/features/http-params/
[FeaturesPageTree]: http://picocms.org/in-depth/features/page-tree/
[FeaturesPagesFunction]: http://picocms.org/in-depth/features/pages-function/
[WikiThemes]: https://github.com/picocms/Pico/wiki/Pico-Themes
[WikiPlugins]: https://github.com/picocms/Pico/wiki/Pico-Plugins
[OfficialThemes]: http://picocms.org/themes/
[PluginUpgrade]: http://picocms.org/development/#upgrade
[ModRewrite]: https://httpd.apache.org/docs/current/mod/mod_rewrite.html
[AllowOverride]: https://httpd.apache.org/docs/current/mod/core.html#allowoverride
[NginxConfig]: http://picocms.org/in-depth/nginx/
