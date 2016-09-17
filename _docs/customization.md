---
toc:
    customization:
        _title: Customization
        themes: Themes
        plugins: Plugins
nav: 5
---

## Customization

Pico is highly customizable in two different ways: On the one hand you can change Pico's appearance by using themes, on the other hand you can add new functionality by using plugins. Doing the former includes changing Pico's HTML, CSS and JavaScript, the latter mostly consists of PHP programming.

This is all Greek to you? Don't worry, you don't have to spend time on these techie talk - it's very easy to use one of the great themes or plugins others developed and released to the public. Please refer to the next sections for details.

### Themes

You can create themes for your Pico installation in the `themes` folder. Check out the default theme for an example. Pico uses [Twig][] for template rendering. You can select your theme by setting the `$config['theme']` option in `config/config.php` to the name of your theme folder.

All themes must include an `index.twig` (or `index.html`) file to define the HTML structure of the theme. Below are the Twig variables that are available to use in your theme. Please note that paths (e.g. `{% raw %}{{ base_dir }}{% endraw %}`) and URLs (e.g. `{% raw %}{{ base_url }}{% endraw %}`) don't have a trailing slash.

* `{% raw %}{{ config }}{% endraw %}` - Contains the values you set in `config/config.php` (e.g. `{% raw %}{{ config.theme }}{% endraw %}` becomes `default`)
* `{% raw %}{{ base_dir }}{% endraw %}` - The path to your Pico root directory
* `{% raw %}{{ base_url }}{% endraw %}` - The URL to your Pico site; use Twigs `link` filter to specify internal links (e.g. `{% raw %}{{ "sub/page"|link }}{% endraw %}`), this guarantees that your link works whether URL rewriting is enabled or not
* `{% raw %}{{ theme_dir }}{% endraw %}` - The path to the currently active theme
* `{% raw %}{{ theme_url }}{% endraw %}` - The URL to the currently active theme
* `{% raw %}{{ rewrite_url }}{% endraw %}` - A boolean flag indicating enabled/disabled URL rewriting
* `{% raw %}{{ site_title }}{% endraw %}` - Shortcut to the site title (see `config/config.php`)
* `{% raw %}{{ meta }}{% endraw %}` - Contains the meta values from the current page
    * `{% raw %}{{ meta.title }}{% endraw %}`
    * `{% raw %}{{ meta.description }}{% endraw %}`
    * `{% raw %}{{ meta.author }}{% endraw %}`
    * `{% raw %}{{ meta.date }}{% endraw %}`
    * `{% raw %}{{ meta.date_formatted }}{% endraw %}`
    * `{% raw %}{{ meta.time }}{% endraw %}`
    * `{% raw %}{{ meta.robots }}{% endraw %}`
    * ...
* `{% raw %}{{ content }}{% endraw %}` - The content of the current page after it has been processed through Markdown)
* `{% raw %}{{ pages }}{% endraw %}` - A collection of all the content pages in your site
    * `{% raw %}{{ page.id }}{% endraw %}` - The relative path to the content file (unique ID)
    * `{% raw %}{{ page.url }}{% endraw %}` - The URL to the page
    * `{% raw %}{{ page.title }}{% endraw %}` - The title of the page (YAML header)
    * `{% raw %}{{ page.description }}{% endraw %}` - The description of the page (YAML header)
    * `{% raw %}{{ page.author }}{% endraw %}` - The author of the page (YAML header)
    * `{% raw %}{{ page.time }}{% endraw %}` - The timestamp derived from the `Date` header
    * `{% raw %}{{ page.date }}{% endraw %}` - The date of the page (YAML header)
    * `{% raw %}{{ page.date_formatted }}{% endraw %}` - The formatted date of the page
    * `{% raw %}{{ page.raw_content }}{% endraw %}` - The raw, not yet parsed contents of the page; use Twigs `content` filter to get the parsed contents of a page by passing its unique ID (e.g. `{% raw %}{{ "sub/page"|content }}{% endraw %}`)
    * `{% raw %}{{ page.meta }}{% endraw %}`- The meta values of the page
* `{% raw %}{{ prev_page }}{% endraw %}` - The data of the previous page (relative to `current_page`)
* `{% raw %}{{ current_page }}{% endraw %}` - The data of the current page
* `{% raw %}{{ next_page }}{% endraw %}` - The data of the next page (relative to `current_page`)
* `{% raw %}{{ is_front_page }}{% endraw %}` - A boolean flag for the front page

Pages can be used like the following:

{% raw %}<pre><code>&lt;ul class=&quot;nav&quot;&gt;
    {% for page in pages %}
        &lt;li&gt;&lt;a href=&quot;{{ page.url }}&quot;&gt;{{ page.title }}&lt;/a&gt;&lt;/li&gt;
    {% endfor %}
&lt;/ul&gt;</code></pre>{% endraw %}

Additional to Twigs extensive list of filters, functions and tags, Pico also provides some useful additional filters to make theming easier. You can parse any Markdown string to HTML using the `markdown` filter. Arrays can be sorted by one of its keys or a arbitrary deep sub-key using the `sort_by` filter (e.g. `{% raw %}{% for page in pages|sort_by([ 'meta', 'nav' ]) %}...{% endfor %}{% endraw %}` iterates through all pages, ordered by the `nav` meta header; please note the `[ 'meta', 'nav' ]` part of the example, it instructs Pico to sort by `page.meta.nav`). You can return all values of a given key or key path of an array using the `map` filter (e.g. `{% raw %}{{ pages|map("title") }}{% endraw %}` returns all page titles).

You can use different templates for different content files by specifying the `Template` meta header. Simply add e.g. `Template: blog-post` to a content file and Pico will use the `blog-post.twig` file in your theme folder to render the page.

You don't have to create your own theme if Pico's default theme isn't sufficient for you, you can use one of the great themes third-party developers and designers created in the past. As with plugins, you can find themes in [our Wiki][WikiThemes].

### Plugins

#### Plugins for users

Officially tested plugins can be found at [{{ site.github.url }}/customization/][OfficialPlugins], but there are many awesome third-party plugins out there! A good start point for discovery is [our Wiki][WikiPlugins].

Pico makes it very easy for you to add new features to your website. Simply upload the files of the plugin to the `plugins/` directory and you're done. Depending on the plugin you've installed, you may have to go through some more steps (e.g. specifying config variables), the plugin docs or `README` file will explain what to do.

Plugins which were written to work with Pico 1.0 can be enabled and disabled through your `config/config.php`. If you want to e.g. disable the `PicoExcerpt` plugin, add the following line to your `config/config.php`: `$config['PicoExcerpt.enabled'] = false;`. To force the plugin to be enabled replace `false` with `true`.

#### Plugins for developers

You're a plugin developer? We love you guys! You can find tons of information about how to develop plugins at [{{ site.github.url }}/development/][PluginDocs]. If you've developed a plugin for Pico 0.9 or older, you probably want to upgrade it to the brand new plugin system introduced with Pico 1.0. Please refer to the [upgrade section of the docs][PluginUpgrade].

[Twig]: http://twig.sensiolabs.org/documentation
[WikiThemes]: {{ site.gh_project_url }}/wiki/Pico-Themes
[WikiPlugins]: {{ site.gh_project_url }}/wiki/Pico-Plugins
[OfficialPlugins]: {{ site.github.url }}/customization/
[PluginDocs]: {{ site.github.url }}/development/
[PluginUpgrade]: {{ site.github.url }}/development/#upgrade
