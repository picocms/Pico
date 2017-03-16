---
Title: Welcome
Description: Pico is a stupidly simple, blazing fast, flat file CMS.
social:
    - title: Visit us on GitHub
      url: https://github.com/picocms/Pico
      icon: octocat
    - title: Join us on Freenode IRC Webchat
      url: https://webchat.freenode.net/?channels=%23picocms
      icon: chat
---

## Welcome to Pico

Congratulations, you have successfully installed [Pico](http://picocms.org/).
%meta.description% <!-- replaced by the above Description meta header -->

## Creating Content

Pico is a flat file CMS. This means there is no administration backend or
database to deal with. You simply create `.md` files in the `content` folder
and those files become your pages. For example, this file is called `index.md`
and is shown as the main landing page.

When you install Pico, it comes with a `content-sample` folder. Inside this
folder is a sample website that will display until you add your own content.
You should create your own `content` folder in Pico's root directory and place
your files there. No configuration is required, Pico will automatically use the
`content` folder if it exists.

If you create a folder within the content folder (e.g. `content/sub`) and put
an `index.md` inside it, you can access that folder at the URL
`http://example.com/?sub`. If you want another page within the sub folder,
simply create a text file with the corresponding name and you will be able to
access it (e.g. `content/sub/page.md` is accessible from the URL
`http://example.com/?sub/page`). Below we've shown some examples of locations
and their corresponding URLs:

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

As a common practice, we recommend you to separate your contents and assets
(like images, downloads, etc.). We even deny access to your `content` directory
by default. If you want to use some assets (e.g. a image) in one of your content
files, you should create an `assets` folder in Pico's root directory and upload
your assets there. You can then access them in your markdown using
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
    Date: 2013/01/01
    Robots: noindex,nofollow
    Template: index
    ---

These values will be contained in the `{{ meta }}` variable in themes
(see below).

There are also certain variables that you can use in your text files:

* <code>&#37;site_title&#37;</code> - The title of your Pico site
* <code>&#37;base_url&#37;</code> - The URL to your Pico site; internal links
  can be specified using <code>&#37;base_url&#37;?sub/page</code>
* <code>&#37;theme_url&#37;</code> - The URL to the currently used theme
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
   directory. All these articles should have both a `Date` and `Template` meta
   header, the latter with e.g. `blog-post` as value (see Step 2).
2. Create a new Twig template called `blog-post.twig` (this must match the
   `Template` meta header from Step 1) in your theme directory. This template
   probably isn't very different from your default `index.twig`, it specifies
   how your article pages will look like.
3. Create a `blog.md` in your `content` folder and set its `Template` meta
   header to e.g. `blog`. Also create a `blog.twig` in your theme directory.
   This template will show a list of your articles, so you probably want to
   do something like this:
   ```
    {% for page in pages|sort_by("time")|reverse %}
        {% if page.id starts with "blog/" %}
            <div class="post">
                <h3><a href="{{ page.url }}">{{ page.title }}</a></h3>
                <p class="date">{{ page.date_formatted }}</p>
                <p class="excerpt">{{ page.description }}</p>
            </div>
        {% endif %}
    {% endfor %}
   ```
4. Make sure to exclude blog articles from your page navigation. You can achieve
   this by adding `{% if not (page.id starts with "blog/") %}...{% endif %}`
   to the navigation loop (`{% for page in pages %}...{% endfor %}`) in your
   theme's `index.twig`.

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
rendering. You can select your theme by setting the `$config['theme']` option
in `config/config.php` to the name of your theme folder.

All themes must include an `index.twig` (or `index.html`) file to define the
HTML structure of the theme. Below are the Twig variables that are available
to use in your theme. Please note that paths (e.g. `{{ base_dir }}`) and URLs
(e.g. `{{ base_url }}`) don't have a trailing slash.

* `{{ config }}` - Contains the values you set in `config/config.php`
                   (e.g. `{{ config.theme }}` becomes `default`)
* `{{ base_dir }}` - The path to your Pico root directory
* `{{ base_url }}` - The URL to your Pico site; use Twigs `link` filter to
                     specify internal links (e.g. `{{ "sub/page"|link }}`),
                     this guarantees that your link works whether URL rewriting
                     is enabled or not
* `{{ theme_dir }}` - The path to the currently active theme
* `{{ theme_url }}` - The URL to the currently active theme
* `{{ rewrite_url }}` - A boolean flag indicating enabled/disabled URL rewriting
* `{{ site_title }}` - Shortcut to the site title (see `config/config.php`)
* `{{ meta }}` - Contains the meta values from the current page
    * `{{ meta.title }}`
    * `{{ meta.description }}`
    * `{{ meta.author }}`
    * `{{ meta.date }}`
    * `{{ meta.date_formatted }}`
    * `{{ meta.time }}`
    * `{{ meta.robots }}`
    * ...
* `{{ content }}` - The content of the current page
                    (after it has been processed through Markdown)
* `{{ pages }}` - A collection of all the content pages in your site
    * `{{ page.id }}` - The relative path to the content file (unique ID)
    * `{{ page.url }}` - The URL to the page
    * `{{ page.title }}` - The title of the page (YAML header)
    * `{{ page.description }}` - The description of the page (YAML header)
    * `{{ page.author }}` - The author of the page (YAML header)
    * `{{ page.time }}` - The timestamp derived from the `Date` header
    * `{{ page.date }}` - The date of the page (YAML header)
    * `{{ page.date_formatted }}` - The formatted date of the page
    * `{{ page.raw_content }}` - The raw, not yet parsed contents of the page;
                                 use Twigs `content` filter to get the parsed
                                 contents of a page by passing its unique ID
                                 (e.g. `{{ "sub/page"|content }}`)
    * `{{ page.meta }}`- The meta values of the page
* `{{ prev_page }}` - The data of the previous page (relative to `current_page`)
* `{{ current_page }}` - The data of the current page
* `{{ next_page }}` - The data of the next page (relative to `current_page`)
* `{{ is_front_page }}` - A boolean flag for the front page

Pages can be used like the following:

    <ul class="nav">
        {% for page in pages %}
            <li><a href="{{ page.url }}">{{ page.title }}</a></li>
        {% endfor %}
    </ul>

Additional to Twigs extensive list of filters, functions and tags, Pico also
provides some useful additional filters to make theming easier. You can parse
any Markdown string to HTML using the `markdown` filter. Arrays can be sorted
by one of its keys or a arbitrary deep sub-key using the `sort_by` filter
(e.g. `{% for page in pages|sort_by([ 'meta', 'nav' ]) %}...{% endfor %}`
iterates through all pages, ordered by the `nav` meta header; please note the
`[ 'meta', 'nav' ]` part of the example, it instructs Pico to sort by
`page.meta.nav`). You can return all values of a given key or key path of an
array using the `map` filter (e.g. `{{ pages|map("title") }}` returns all
page titles).

You can use different templates for different content files by specifying the
`Template` meta header. Simply add e.g. `Template: blog-post` to a content file
and Pico will use the `blog-post.twig` file in your theme folder to render
the page.

You don't have to create your own theme if Pico's default theme isn't
sufficient for you, you can use one of the great themes third-party developers
and designers created in the past. As with plugins, you can find themes in
[our Wiki][WikiThemes] and on [our website][OfficialThemes].

### Plugins

#### Plugins for users

Officially tested plugins can be found at http://picocms.org/plugins/, but
there are many awesome third-party plugins out there! A good start point for
discovery is [our Wiki][WikiPlugins].

Pico makes it very easy for you to add new features to your website. Simply
upload the files of the plugin to the `plugins/` directory and you're done.
Depending on the plugin you've installed, you may have to go through some more
steps (e.g. specifying config variables), the plugin docs or `README` file will
explain what to do.

Plugins which were written to work with Pico 1.0 can be enabled and disabled
through your `config/config.php`. If you want to e.g. disable the `PicoExcerpt`
plugin, add the following line to your `config/config.php`:
`$config['PicoExcerpt.enabled'] = false;`. To force the plugin to be enabled
replace `false` with `true`.

#### Plugins for developers

You're a plugin developer? We love you guys! You can find tons of information
about how to develop plugins at http://picocms.org/development/. If you've
developed a plugin for Pico 0.9 or older, you probably want to upgrade it
to the brand new plugin system introduced with Pico 1.0. Please refer to the
[upgrade section of the docs][PluginUpgrade].

## Config

You can override the default Pico settings (and add your own custom settings)
by editing `config/config.php` in the Pico directory. For a brief overview of
the available settings and their defaults see `config/config.php.template`. To
override a setting, copy `config/config.php.template` to `config/config.php`,
uncomment the setting and set your custom value.

### URL Rewriting

Pico's default URLs (e.g. %base_url%/?sub/page) already are very user-friendly.
Additionally, Pico offers you a URL rewrite feature to make URLs even more
user-friendly (e.g. %base_url%/sub/page).

If you're using the Apache web server, URL rewriting probably already is
enabled - try it yourself, click on the [second URL](%base_url%/sub/page). If
you get an error message from your web server, please make sure to enable the
[`mod_rewrite` module][ModRewrite]. Assuming the second URL works, but Pico
still shows no rewritten URLs, force URL rewriting by setting
`$config['rewrite_url'] = true;` in your `config/config.php`.

If you're using Nginx, you can use the following configuration to enable URL
rewriting (lines `5` to `8`) and denying access to Pico's internal files
(lines `1` to `3`). You'll need to adjust the path (`/pico` on lines `1`, `5`
and `7`) to match your installation directory. Additionally, you'll need to
enable URL rewriting by setting `$config['rewrite_url'] = true;` in your
`config/config.php`. The Nginx configuration should provide the *bare minimum*
you need for Pico. Nginx is a very extensive subject. If you have any trouble,
please read through our [Nginx configuration docs][NginxConfig].

```
location ~ /pico/(\.htaccess|\.git|config|content|content-sample|lib|vendor|CHANGELOG\.md|composer\.(json|lock)) {
    return 404;
}

location ~ ^/pico(.*) {
    index index.php;
    try_files $uri $uri/ /pico/index.php?$1&$args;
}
```

## Documentation

For more help have a look at the Pico documentation at http://picocms.org/docs.

[Markdown]: http://daringfireball.net/projects/markdown/syntax
[MarkdownExtra]: https://michelf.ca/projects/php-markdown/extra/
[YAML]: https://en.wikipedia.org/wiki/YAML
[Twig]: http://twig.sensiolabs.org/documentation
[WikiThemes]: https://github.com/picocms/Pico/wiki/Pico-Themes
[WikiPlugins]: https://github.com/picocms/Pico/wiki/Pico-Plugins
[OfficialThemes]: http://picocms.org/themes/
[PluginUpgrade]: http://picocms.org/development/#upgrade
[ModRewrite]: https://httpd.apache.org/docs/current/mod/mod_rewrite.html
[NginxConfig]: http://picocms.org/in-depth/nginx/
