---
toc:
    creating-content:
        _title: Creating Content
        text-file-markup: Text File Markup
        blogging: Blogging
nav: 4
---

## Creating Content

Pico is a flat file CMS. This means there is no administration backend or database to deal with. You simply create `.md` files in the `content` folder and those files become your pages. For example, creating a file called `index.md` will make it show as your main landing page.

When you install Pico, it comes with a `content-sample` folder.  Inside this folder is a sample website that will display until you add your own content.  You should create your own `content` folder in Pico's root directory and place your files there.  No configuration is required, Pico will automatically use the `content` folder if it exists.

If you create a folder within the content folder (e.g. `content/sub`) and put an `index.md` inside it, you can access that folder at the URL `http://example.com/?sub`. If you want another page within the sub folder, simply create a text file with the corresponding name and you will be able to access it (e.g. `content/sub/page.md` is accessible from the URL `http://example.com/?sub/page`). Below we've shown some examples of locations and their corresponding URLs:

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
            <td>/</td>
        </tr>
        <tr>
            <td>content/sub.md</td>
            <td><del>?sub</del> (not accessible, see below)</td>
        </tr>
        <tr>
            <td>content/sub/index.md</td>
            <td>?sub (same as above)</td>
        </tr>
        <tr>
            <td>content/sub/page.md</td>
            <td>?sub/page</td>
        </tr>
        <tr>
            <td>content/a/very/long/url.md</td>
            <td>?a/very/long/url</td>
        </tr>
    </tbody>
</table>

If a file cannot be found, the file `content/404.md` will be shown. You can add `404.md` files to any directory. So, for example, if you wanted to use a special error page for your blog, you could simply create `content/blog/404.md`.

As a common practice, we recommend you to separate your contents and assets (like images, downloads, etc.). We even deny access to your `content` directory by default. If you want to use some assets (e.g. a image) in one of your content files, you should create an `assets` folder in Pico's root directory and upload your assets there.  You can then access them in your markdown using `%base_url/assets/` for example: `![Image Title](%base_url%/assets/image.png)`

### Text File Markup

Text files are marked up using [Markdown][]. They can also contain regular HTML.

At the top of text files you can place a block comment and specify certain meta attributes of the page using [YAML][] (the "YAML header"). For example:

<pre><code>---
Title: Welcome
Description: This description will go in the meta description tag
Author: Joe Bloggs
Date: 2013/01/01
Robots: noindex,nofollow
Template: index
---</code></pre>

These values will be contained in the `{% raw %}{{ meta }}{% endraw %}` variable in themes (see below).

There are also certain variables that you can use in your text files:

* `%site_title%` - The title of your Pico site
* `%base_url%` - The URL to your Pico site; internal links can be specified using `%base_url%?sub/page`
* `%theme_url%` - The URL to the currently used theme
* `%meta.*%` - Access any meta variable of the current page, e.g. `%meta.author%` is replaced with `Joe Bloggs`

### Blogging

Pico is not blogging software - but makes it very easy for you to use it as a blog. You can find many plugins out there implementing typical blogging features like authentication, tagging, pagination and social plugins. See the below Plugins section for details.

If you want to use Pico as a blogging software, you probably want to do something like the following:
<ol>
    <li>
        Put all your blog articles in a separate <code>blog</code> folder in your <code>content</code> directory. All these articles should have both a <code>Date</code> and <code>Template</code> meta header, the latter with e.g. <code>blog-post</code> as value (see Step 2).
    </li>
    <li>
        Create a new Twig template called <code>blog-post.twig</code> (this must match the <code>Template</code> meta header from Step 1) in your theme directory. This template probably isn't very different from your default <code>index.twig</code>, it specifies ow your article pages will look like.
    </li>
    <li>
        Create a <code>blog.md</code> in your <code>content</code> folder and set its <code>Template</code> meta header to e.g. <code>blog</code>. Also create a <code>blog.twig</code> in your theme directory. This template will show a list of your articles, so you probably want to do something like this:

        {% raw %}<pre><code>{% for page in pages|sort_by("time")|reverse %}
    {% if page.id starts with &quot;blog/&quot; %}
        &lt;div class=&quot;post&quot;&gt;
            &lt;h3&gt;&lt;a href=&quot;{{ page.url }}&quot;&gt;{{ page.title }}&lt;/a&gt;&lt;/h3&gt;
            &lt;p class=&quot;date&quot;&gt;{{ page.date_formatted }}&lt;/p&gt;
            &lt;p class=&quot;excerpt&quot;&gt;{{ page.description }}&lt;/p&gt;
        &lt;/div&gt;
    {% endif %}
{% endfor %}</code></pre>{% endraw %}
    </li>
    <li>
        Make sure to exclude the blog articles from your page navigation. You can achieve this by adding <code>{&#37; if not page starts with "blog/" &#37;}...{&#37; endif &#37;}</code> to the navigation loop (<code>{&#37; for page in pages &#37;}...{&#37; endfor &#37;}</code>) in your themes <code>index.twig</code>.
    </li>
</ol>

[Markdown]: http://daringfireball.net/projects/markdown/syntax
[YAML]: https://en.wikipedia.org/wiki/YAML
