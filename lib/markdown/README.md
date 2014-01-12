# PHP Markdown Extra Extended

An fork of the [PHP Markdown (Extra) project](http://michelf.com/projects/php-markdown/) (<abbr title="PHP Markdown (Extra)">PME</abbr>), extended with extra syntax, especially focused on adding support for more HTML attributes to outputted HTML, and for outputting HTML5.

## Changes to syntax from PHP Markdown (Extra)
Unless explicitly specified, existing Markdown markup works exactly as it did before. The orginal syntax is documentated here:

- [Markdown syntax](http://daringfireball.net/projects/markdown/syntax)
- [Markdown Extra syntax](http://michelf.com/projects/php-markdown/extra/)

### Line break generates a `<br />`
In <abbr title="PHP Markdown (Extra)">PME</abbr>, when you want to insert a `<br />` break tag using Markdown, you end a line with two or more spaces, then type return. This turned out to be more annoying than helpful in my projects, so now you just have to type return. This is also how Markdown works with <abbr title="GitHub Flavored Markdown">GFM</abbr>.

Two returns does not insert a `<br />`, but instead creates a new paragraph as usual.

### Support for *cite* attribute on blockquotes
It is now possible to add the optional *cite* attribute to the *blockquote* element.

The new, optional, syntax is:

```markdown
> (cite url) Cited content follows ...
```

#### Example:

```markdown
> (http://www.whatwg.org/) Content inside a blockquote must be quoted 
> from another source, whose address, if it has one, 
> may be cited in the `cite` attribute.
```

Will result in the following HTML:

```html
<blockquote cite="http://www.whatwg.org/">
<p>Content inside a blockquote must be quoted 
from another source, whose address, if it has one, 
may be cited in the `cite` attribute.</p>
</blockquote>
```

#### Breaking changes from <abbr title="PHP Markdown (Extra)">PME</abbr>
The existing rules for and [formatting options](http://daringfireball.net/projects/markdown/syntax#blockquote) for blockquotes still apply. There is one small breaking changes with this addition. If your quote starts with "(" you have two have at least two spaces between the initial ">" and the "(". E.g.:

```markdown
>  (Ut brisket flank salami.) Cow cupidatat ex t-bone sirloin id. 
> Sunt flank pastrami spare ribs sint id, nulla nisi.
```

Will result in the following HTML:

```html
<blockquote>
  <p>(Ut brisket flank salami.) Cow cupidatat ex t-bone sirloin id.<br>
  Sunt flank pastrami spare ribs sint id, nulla nisi.</p>
</blockquote>
```

### Fenced code block with language support and alternating fence markers (```)
It is now possible to specify the language type of a code block, and use an alternatinge fence markers (```), enabling the same syntax as that of <abbr title="GitHub Flavored Markdown">GFM</abbr>.

This addition follows the [suggested way](http://dev.w3.org/html5/spec-author-view/the-code-element.html#the-code-element) to specify language by W3C.

#### Example:

	~~~html
	<p>Ut brisket flank salami.  Cow cupidatat ex t-bone sirloin id.</p>
	~~~

Using alternative fence markers:

	```html
	<p>Ut brisket flank salami.  Cow cupidatat ex t-bone sirloin id.</p>
	```

Both will output the following HTML:

```HTML
<pre><code class="language-html">
<p>Ut brisket flank salami.  Cow cupidatat ex t-bone sirloin id.</p>
</code></pre>
```

### Support for *figure* and *figcaption* tags
There is now experimental support for the the HTML5 tags *[figure](http://dev.w3.org/html5/markup/figure.html)* and *[figcaption](http://dev.w3.org/html5/markup/figcaption.html)*.

A *figure* is a block level element and is created by wrapping some other content in three or more equal (=) signs. 

A optional *figure caption* can be added to either the top of the figure or the bottom at the figure, right after the equal signs, wrapped in [ and ] signs.

#### Examples
This example shows a *figure* without a caption:

```markdown
===
![](img/reference.png)
===
```

This example shows a *figure* with a caption added before the content:

```markdown
=== [A **happy face** is good for web developers]
![](img/reference.png)
===
```

This example shows a *figure* with a caption added after the content:

```markdown
===
![](img/reference.png)
=== [A **happy face** is good for web developers]
``` 

## Usage
You need both the *markdown.php* and the *markdown_extended.php* files, but only needs to include *markdown_extended.php*.

```PHP
require_once('markdown_extended.php');

// Convert markdown formatted text in $markdown to HTML
$html = MarkdownExtended($markdown);
```

## License
PHP Markdown Extra Extended is licensed under the [MIT License](http://opensource.org/licenses/MIT). See the LICENSE file for details.