---
Title: Welcome
Description: Pico is a stupidly simple, blazing fast, flat file CMS.
---

## Welcome to Pico

Congratulations, you have successfully installed [Pico](http://picocms.org/).
%meta.description%

### Creating Content

Pico is a flat file CMS, this means there is no administration backend and
database to deal with. You simply create `.md` files in the `content-sample`
folder and that becomes a page. For example, this file is called `index.md`
and is shown as the main landing page.

If you create a folder within the content folder (e.g. `content-sample/sub`)
and put an `index.md` inside it, you can access that folder at the URL
`http://yoursite.com/?sub`. If you want another page within the sub folder,
simply create a text file with the corresponding name and you will be able to
access it (e.g. `content-sample/sub/page.md` is accessible from the URL
`http://yoursite.com/?sub/page`). Below we've shown some examples of locations
and their corresponing URLs:

<table style="width: 100%; max-width: 40em;">
    <thead>
        <tr>
            <th style="width: 50%;">Physical Location</th>
            <th style="width: 50%;">URL</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>content-sample/index.md</td>
            <td><a href="%base_url%">/</a></td>
        </tr>
        <tr>
            <td>content-sample/sub.md</td>
            <td><del>?sub</del> (not accessible, see below)</td>
        </tr>
        <tr>
            <td>content-sample/sub/index.md</td>
            <td><a href="%base_url%?sub">?sub</a> (same as above)</td>
        </tr>
        <tr>
            <td>content-sample/sub/page.md</td>
            <td><a href="%base_url%?sub/page">?sub/page</a></td>
        </tr>
        <tr>
            <td>content-sample/a/very/long/url.md</td>
            <td><a href="%base_url%?a/very/long/url">?a/very/long/url</a> (doesn't exist)</td>
        </tr>
    </tbody>
</table>

If a file cannot be found, the file `content-sample/404.md` will be shown.

### Text File Markup

Text files are marked up using [Markdown][]. They can also contain regular HTML.

At the top of text files you can place a block comment and specify certain
attributes of the page. For example:

    ---
    Title: Welcome
    Description: This description will go in the meta description tag
    Author: Joe Bloggs
    Date: 2013/01/01
    Robots: noindex,nofollow
    ---

These values will be contained in the `{{ meta }}` variable in themes
(see below).

There are also certain variables that you can use in your text files:

* <code>&#37;site_title&#37;</code> - The title of your Pico site
* <code>&#37;base_url&#37;</code> - The URL to your Pico site; internal links
  can be specified using <code>&#37;base_url&#37;?sub/page</code>
* <code>&#37;theme_url&#37;</code> - The URL to the currently used theme
* <code>&#37;meta.*&#37;</code> - Access any meta variable of the current page,
  e.g. <code>&#37;meta.author&#37;</code> returns `Joe Bloggs`

### Themes

You can create themes for your Pico installation in the `themes` folder. Check
out the default theme for an example of a theme. Pico uses [Twig][] for
template rendering. You can select your theme by setting the `$config['theme']`
variable in `config/config.php` to your theme folder.

All themes must include an `index.twig` file to define the HTML structure of
the theme. Below are the Twig variables that are available to use in your
theme. Paths (e.g. `{{ base_dir }}``) and URLs (e.g. `{{ base_url }}`) don't
have a trailing slash.

* `{{ config }}` - Conatins the values you set in `config/config.php`
                   (e.g. `{{ config.theme }}` = "default")
* `{{ base_dir }}` - The path to your Pico root directory
* `{{ base_url }}` - The URL to your Pico site
* `{{ theme_dir }}` - The path to the Pico active theme directory
* `{{ theme_url }}` - The URL to the Pico active theme directory
* `{{ rewrite_url }}` - A boolean flag indicating enabled/disabled URL rewriting
* `{{ site_title }}` - Shortcut to the site title (see `config/config.php`)
* `{{ meta }}` - Contains the meta values from the current page
    * `{{ meta.title }}`
    * `{{ meta.description }}`
    * `{{ meta.author }}`
    * `{{ meta.date }}`
    * `{{ meta.date_formatted }}`
    * `{{ meta.robots }}`
* `{{ content }}` - The content of the current page
                    (after it has been processed through Markdown)
* `{{ pages }}` - A collection of all the content pages in your site
	* `{{ page.id }}`
    * `{{ page.url }}`
    * `{{ page.title }}`
    * `{{ page.description }}`
    * `{{ page.author }}`
    * `{{ page.time }}`
    * `{{ page.date }}`
    * `{{ page.date_formatted }}`
    * `{{ page.raw_content }}`
    * `{{ page.meta }}`
* `{{ prev_page }}` - The data of the previous page (relative to `current_page`)
* `{{ current_page }}` - The data of the current page
* `{{ next_page }}` - The data of the next page (relative to `current_page`)
* `{{ is_front_page }}` - A boolean flag for the front page

Pages can be used like:

<pre>&lt;ul class=&quot;nav&quot;&gt;
    {% for page in pages %}
    &lt;li&gt;&lt;a href=&quot;{{ page.url }}&quot;&gt;{{ page.title }}&lt;/a&gt;&lt;/li&gt;
    {% endfor %}
&lt;/ul&gt;</pre>

### Plugins

See [http://pico.dev7studios.com/plugins](http://picocms.org/plugins)

### Config

You can override the default Pico settings (and add your own custom settings)
by editing `config/config.php` in the Pico directory. For a brief overview of
the available settings and their defaults see `config/config.php.template`. To
override a setting copy `config/config.php.template` to `config/config.php`,
uncomment the setting and set your custom value.

### Documentation

For more help have a look at the Pico documentation at
[http://picocms.org/docs](http://picocms.org/docs)

[Twig]: http://twig.sensiolabs.org/documentation
[Markdown]: http://daringfireball.net/projects/markdown/syntax
