/*
Title: Welcome
Description: This description will go in the meta description tag
*/

## Welcome to Pico

Congratulations, you have successfully installed [Pico](http://picocms.org/). Pico is a stupidly simple, blazing fast, flat file CMS.

### Creating Content

Pico is a flat file CMS, this means there is no administration backend and database to deal with. You simply create `.md` files in the "content"
folder and that becomes a page. For example, this file is called `index.md` and is shown as the main landing page. 

If you create a folder within the content folder (e.g. `content/sub`) and put an `index.md` inside it, you can access that folder at the URL 
`http://yousite.com/sub`. If you want another page within the sub folder, simply create a text file with the corresponding name (e.g. `content/sub/page.md`)
and you will be able to access it from the URL `http://yousite.com/sub/page`. Below we've shown some examples of content locations and their corresponing URL's:

<table>
	<thead>
		<tr><th>Physical Location</th><th>URL</th></tr>
	</thead>
	<tbody>
		<tr><td>content/index.md</td><td>/</td></tr>
		<tr><td>content/sub.md</td><td>/sub</td></tr>
		<tr><td>content/sub/index.md</td><td>/sub (same as above)</td></tr>
		<tr><td>content/sub/page.md</td><td>/sub/page</td></tr>
		<tr><td>content/a/very/long/url.md</td><td>/a/very/long/url</td></tr>
	</tbody>
</table>

If a file cannot be found, the file `content/404.md` will be shown.

### Text File Markup

Text files are marked up using [Markdown](http://daringfireball.net/projects/markdown/syntax). They can also contain regular HTML.

At the top of text files you can place a block comment and specify certain attributes of the page. For example:

	/*
	Title: Welcome
	Description: This description will go in the meta description tag
	Author: Joe Bloggs
	Date: 2013/01/01
	Robots: noindex,nofollow
	*/

These values will be contained in the `{{ meta }}` variable in themes (see below).

There are also certain variables that you can use in your text files:

* <code>&#37;base_url&#37;</code> - The URL to your Pico site

### Themes

You can create themes for your Pico installation in the "themes" folder. Check out the default theme for an example of a theme. Pico uses
[Twig](http://twig.sensiolabs.org/documentation) for it's templating engine. You can select your theme by setting the `$config['theme']` variable
in config.php to your theme folder.

All themes must include an `index.html` file to define the HTML structure of the theme. Below are the Twig variables that are available to use in your theme:

* `{{ config }}` - Conatins the values you set in config.php (e.g. `{{ config.theme }}` = "default")
* `{{ base_dir }}` - The path to your Pico root directory
* `{{ base_url }}` - The URL to your Pico site
* `{{ theme_dir }}` - The path to the Pico active theme directory
* `{{ theme_url }}` - The URL to the Pico active theme directory
* `{{ site_title }}` - Shortcut to the site title (defined in config.php)
* `{{ meta }}` - Contains the meta values from the current page
	* `{{ meta.title }}`
	* `{{ meta.description }}`
	* `{{ meta.author }}`
	* `{{ meta.date }}`
	* `{{ meta.date_formatted }}`
	* `{{ meta.robots }}`
* `{{ content }}` - The content of the current page (after it has been processed through Markdown)
* `{{ pages }}` - A collection of all the content in your site
	* `{{ page.title }}`
	* `{{ page.url }}`
	* `{{ page.author }}`
	* `{{ page.date }}`
	* `{{ page.date_formatted }}`
	* `{{ page.content }}`
	* `{{ page.excerpt }}`
* `{{ prev_page }}` - A page object of the previous page (relative to current_page)
* `{{ current_page }}` - A page object of the current_page
* `{{ next_page }}` - A page object of the next page (relative to current_page)
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

You can override the default Pico settings (and add your own custom settings) by editing config.php in the root Pico directory. The config.php file
lists all of the settings and their defaults. To override a setting, simply uncomment it in config.php and set your custom value.

### Documentation

For more help have a look at the Pico documentation at [http://picocms.org/docs](http://picocms.org/docs)
