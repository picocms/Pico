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
files, you should create an `assets` folder in Pico's root directory and upload
your assets there. You can then access them in your Markdown using
<code>&#37;base_url&#37;/assets/</code> for example:
<code>!\[Image Title\](&#37;base_url&#37;/assets/image.png)</code>

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
<code>!\[Image Title\](&#37;base_url&#37;/assets/image.png) {.small}</code>

There are also certain variables that you can use in your text files:

* <code>&#37;site_title&#37;</code> - The title of your Pico site
* <code>&#37;base_url&#37;</code> - The URL to your Pico site; internal links
  can be specified using <code>&#37;base_url&#37;?sub/page</code>
* <code>&#37;theme_url&#37;</code> - The URL to the currently used theme
* <code>&#37;version&#37;</code> - Pico's current version string (e.g. `2.0.0`)
* <code>&#37;meta.&#42;&#37;</code> - Access any meta variable of the current
  page, e.g. <code>&#37;meta.author&#37;</code> is replaced with `Joe Bloggs`

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

You can create themes for your Pico installation in the `themes` folder. Check
out the default theme for an example. Pico uses [Twig][] for template
rendering. You can select your theme by setting the `theme` option in
`config/config.yml` to the name of your theme folder.

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
