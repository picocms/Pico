---
toc:
    creating-content:
        _title: Creating Content
        text-file-markup: Text File Markup
        blogging: Blogging
nav: 2
---

## Creating Content

Pico is a flat file CMS, this means there is no administration backend or
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

If a file cannot be found, the file `content-sample/404.md` will be shown. You
can add `404.md` files to any directory, so if you want to use a special error
page for your blog, simply create `content-sample/blog/404.md`.

### Text File Markup

Text files are marked up using [Markdown][]. They can also contain regular HTML.

At the top of text files you can place a block comment and specify certain
attributes of the page. For example:

<pre><code>---
Title: Welcome
Description: This description will go in the meta description tag
Author: Joe Bloggs
Date: 2013/01/01
Robots: noindex,nofollow
Template: index
---</code></pre>

These values will be contained in the `{% raw %}{{ meta }}{% endraw %}` variable
in themes (see below).

There are also certain variables that you can use in your text files:

* <code>&#37;site_title&#37;</code> - The title of your Pico site
* <code>&#37;base_url&#37;</code> - The URL to your Pico site; internal links
  can be specified using <code>&#37;base_url&#37;?sub/page</code>
* <code>&#37;theme_url&#37;</code> - The URL to the currently used theme
* <code>&#37;meta.*&#37;</code> - Access any meta variable of the current page,
  e.g. <code>&#37;meta.author&#37;</code> is replaced with `Joe Bloggs`

### Blogging

Pico is not blogging software - but makes it very easy for you to use it as a
blog. You can find many plugins out there implementing typical blogging
features like authentication, tagging, pagination and social plugins. See the
below Plugins section for details.

If you want to use Pico as a blogging software, you probably want to do
something like the following:
<ol>
    <li>
        Put all your blog articles in a separate <code>blog</code> folder in your <code>content</code>
        directory. All these articles should have both a <code>Date</code> and <code>Template</code> meta
        header, the latter with e.g. <code>blog-post</code> as value (see Step 2).
    </li>
    <li>
        Create a new Twig template called <code>blog-post.twig</code> (this must match the
        <code>Template</code> meta header from Step 1) in your theme directory. This template
        probably isn't very different from your default <code>index.twig</code>, it specifies
        how your article pages will look like.
    </li>
    <li>
        Create a <code>blog.md</code> in your <code>content</code> folder and set its <code>Template</code> meta
        header to e.g. <code>blog</code>. Also create a <code>blog.twig</code> in your theme directory.
        This template will show a list of your articles, so you probably want to
        do something like this:

        {% raw %}<pre><code>{% for page in pages %}
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
        Let Pico sort pages by date by setting <code>$config['pages_order_by'] = 'date';</code>
        in your <code>config/config.php</code>. To use a descending order (newest articles
        first), also add <code>$config['pages_order'] = 'desc';</code>. The former won't affect
        pages without a <code>Date</code> meta header, but the latter does. To use ascending
        order for your page navigation again, add Twigs <code>reverse</code> filter to the
        navigation loop (<code>{&#37; for page in pages|reverse &#37;}...{&#37; endfor &#37;}}</code>)
        in your themes <code>index.twig</code>.
    </li>
    <li>
        Make sure to exclude the blog articles from your page navigation. You can
        achieve this by adding <code>{&#37; if not page starts with "blog/" &#37;}...{&#37; endif &#37;}</code>
        to the navigation loop.
    </li>
</ol>

[Markdown]: http://daringfireball.net/projects/markdown/syntax
