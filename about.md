---
layout: docs
title: About
headline: All About Pico
description: What *is* a "stupidly simple, blazing fast, flat file CMS" anyway?
toc:
  a-flat-file-cms: A Flat File CMS
  web-pages-without-html:
    _title: Web Pages Without HTML
    markdown-makes-formatting-easy: Markdown Makes Formatting Easy
    control-your-metadata-with-yaml: Control Your Metadata With YAML
  flexibility-and-customization:
    _title: Flexibility and Customization
    theming-with-twig-templates: Theming With Twig Templates
    plugins-extend-picos-php: Plugins Extend Pico's PHP
  pico-is-open-source: Pico is Open Source
  getting-started: Getting Started
nav-url: /about/
nav: 2
galleries:
  standalone:
    style: magnify
    images:
      -
        heading: Pico's Default Theme
        description: It's a bit bare... but that's intentional!
        thumbnail: /style/images/docs/about/thumbnails/default_theme.png
        fullsize: /style/images/docs/about/fullsize/default_theme.png
        styles: "float: right; margin-left: 2em; border: 1px solid #CCC; border-top: none;"
  workflow:
    headline: Pico's Workflow
    description: Creating content with Pico couldn't be simpler!
    style: carousel-box
    images:
      -
        heading: Installation is Easy!
        description: Simply upload Pico's files to your server and you're done!  This is what Pico's folder looks like after installation.
        thumbnail: /style/images/docs/about/thumbnails/pico_folder.png
        fullsize: /style/images/docs/about/fullsize/pico_folder.png
      -
        heading: Configuration is Easy Too!
        description: Configuring Pico is as simple as uncommenting a few lines in the included config template.
        thumbnail: /style/images/docs/about/thumbnails/config.png
        fullsize: /style/images/docs/about/fullsize/config.png
      -
        heading: Your Content, Your Way
        description: Creating content with Pico is easy.  You simply create Markdown files and they become pages on your website.  You can also organize your content however you'd like, just create some folders.  Here's an example of a content folder in Pico.  This one is from a writing website.
        thumbnail: /style/images/docs/about/thumbnails/content_folder.png
        fullsize: /style/images/docs/about/fullsize/content_folder.png
      -
        heading: Web Pages Made Easy
        description: Creating content with Markdown couldn't be easier.  While Markdown makes formatting simple, HTML can also be used if you need more advanced options.
        thumbnail: /style/images/docs/about/thumbnails/editing_markdown.png
        fullsize: /style/images/docs/about/fullsize/editing_markdown.png
      -
        heading: Theming your Site with Twig
        description: Editing an HTML/Twig theme isn't so scary.  Pico's default theme is rather simplistic, but Twig's power will allow you to go above and beyond the confines of a standard HTML page.
        thumbnail: /style/images/docs/about/thumbnails/theme_template.png
        fullsize: /style/images/docs/about/fullsize/theme_template.png
      -
        heading: Developing Plugins with PHP
        description: If you know PHP and you'd like to add some functionality to Pico, you can create a plugin!  Pico's DummyPlugin provides a great base for coding your own.
        thumbnail: /style/images/docs/about/thumbnails/dummy_plugin.png
        fullsize: /style/images/docs/about/fullsize/dummy_plugin.png
  themes:
    headline: Community Themes
    description: Ready-to-go, community developed themes to customize your Pico website.
    style: carousel-box
    images:
      -
        heading: NotePaper
        description: "[NotePaper](http://development.sjmcdougall.com/pico-themes/NotePaper/) - A highly customizable theme, designed exclusively for Pico."
        thumbnail: /style/images/docs/about/thumbnails/notepaper.jpg
        fullsize: /style/images/docs/about/fullsize//notepaper.jpg
      -
        heading: Identity
        description: "[Identity](https://html5up.net/identity/) theme from [HTML5 UP](https://html5up.net/), [ported to Pico](https://github.com/BesrourMS/single)."
        thumbnail: /style/images/docs/about/thumbnails/identity.jpg
        fullsize: /style/images/docs/about/fullsize/identity.jpg
      -
        heading: SimpleTwo
        description: "[SimpleTwo](https://github.com/sonst-was/simpleTwo) is a simple theme with two columns for picoCMS."
        thumbnail: /style/images/docs/about/thumbnails/simpletwo.png
        fullsize: /style/images/docs/about/fullsize/simpletwo.png
      -
        heading: Magazine
        description: "[Magazine](http://freehtml5.co/preview/?item=magazine-free-html5-bootstrap-template) theme from [FreeHTML5.co](http://freehtml5.co/), [ported to Pico](https://github.com/BesrourMS/magazine)."
        thumbnail: /style/images/docs/about/thumbnails/magazine.jpg
        fullsize: /style/images/docs/about/fullsize/magazine.jpg
      -
        heading: Clean Blog
        description: "[Clean Blog](http://startbootstrap.com/template-overviews/clean-blog/) theme from [Start Bootstrap](http://startbootstrap.com/), [ported to Pico](https://github.com/BesrourMS/clean-blog)."
        thumbnail: /style/images/docs/about/thumbnails/clean_blog.jpg
        fullsize: /style/images/docs/about/fullsize/clean_blog.jpg
---

Pico is a stupidly simple, blazing fast, flat file CMS.  That's definitely a mouthful, what does it even mean?  In the most basic sense, it means that there is no administration backend or database to deal with. You simply create markdown files in the content folder and those files become your pages.  There's *much* more to Pico than that though.

{% include gallery.html gallery='standalone' %}

Let's get this out of the way: Pico is *not* a turn-key solution.  Pico trades one-click setups and complex management interfaces for blazing speed, flexibility, and a lightweight footprint.  If a little bit of reading and some basic configuration sounds like too much then Pico is probably not for you.

That being said, Pico is incredibly extendable and customizable.  With a very small amount of configuration, you'll find yourself with a very personalized experience.  There's also a growing community creating ready-to-go [themes and plugins](#flexibility-and-customization) for Pico.  It is very possible to get started with Pico even with [no prior knowledge of HTML](#web-pages-without-html).  You'll find however that a little bit of coding knowledge will get you a long way.

Now let's dive into what makes Pico different from other solutions.

## A Flat File CMS

Pico is a Content Management System, or CMS.  If you've heard the term before, it's likely in the context of WordPress, Joomla, Drupal or many of the other popular CMS's on the block.  A Content Management System makes creating a beautiful and well-organized website easy and frustration free.  It can also help those without extensive knowledge of programming on the web to achieve the same professional quality website as those that do.

Most Content Management Systems make use of extensive databases to hold their content.  These databases can sometimes require a confusing setup process, though this is often obscured by one-click setup utilities.  While they can be simple to set up thanks to these utilities, users may experience difficulty when trying to modify, edit, or migrate their content.  Everything that makes their site "what it is" is locked up in a hard-to-manage database.  Anyone who's tried to migrate their WordPress installation from one server to another has likely experienced this pain.

Pico is different.  With Pico, all your content is stored as "flat files", which is pretty much exactly as it sounds.  When using Pico, all your site content is stored as simple text files.  It remains readily available to modify, edit, organize, and migrate as you see fit.

Unlike a traditional CMS, Pico doesn't require write access on your server to function.  This makes it more secure by design and reduces difficult PHP configuration.  Since Pico doesn't use a database for its backend, it has very low system requirements and will run on almost any web space.  Databases can often be a bottleneck on your site's performance, especially with a larger website.  For a smaller site, a database-driven CMS is often overkill.

If you've ever found yourself frustrated, trying to navigate the complicated administration interface of a traditional CMS and not being able to find that *one* setting you need to change, Pico could be a refreshing change of pace.  Pico's configuration is all located in one text file, and is provided as a template with your installation.  Themes and Plugins may have additional options, but Pico's core requires only a small amount of configuration.  In fact, you'll likely leave most of this file commented out, only changing the options that matter to you.

There really isn't much more to say about it.  The beauty of Pico is in its simplicity.  If you want to create a new page, you make a new file.  That's it.  But that's far from the end of the story.  Despite Pico's simplicity, you'll find it incredibly powerful, and ready to take on any task.

{% include gallery.html gallery='workflow' %}

## Web Pages Without HTML

Writing HTML is annoying.  Traditionally, if you wanted to build a web page, you had no choice but to fumble around with HTML.  Every paragraph of your site would be contained in a <code><strong>&lt;p&gt;</strong>paragraph tag<strong>&lt;/p&gt;</strong></code>, links would have an <code><strong>&lt;a&nbsp;href="http://example.com"&gt;</strong>anchor tag<strong>&lt;/a&gt;</strong></code> wrapped around them, and lists would require a heck of a lot of <code><strong>&lt;li&gt;</strong>list item tags<strong>&lt;/li&gt;</strong></code>, a pair around each item.  If you've written a traditional HTML page before, you know how this can be a tedious, repetitive, and error-prone process.

That's where a CMS comes in, allowing you the freedom to write a page the same way you'd write any other document.  The CMS handles the heavy lifting of formatting of your page to be compatible with the web.

Pico is no different.  It leverages Markdown to provide quick and uncomplicated formatting and uses YAML to manage your metadata.  Every page is just a plain text file that you can open in any editor.  Once you understand the basics (and maybe you already do), you'll be churning out pages in no time at all.

### Markdown Makes Formatting Easy

Part of Pico's simplicity comes from the use of Markdown for formatting your pages.  According to its creator, John Gruber, "Markdown allows you to write using an easy-to-read, easy-to-write plain text format, then convert it to structurally valid XHTML (or HTML)."

Writing in Markdown is a lot quicker than coding in HTML, and much easier to learn.  Markdown makes building new pages as easy as writing basic text.  A Markdown file is just a plain text document with an `.md` extension instead of `.txt`.  Even this page was written using the simplicity of Markdown!

You can learn more about Markdown on [Wikipedia][WikiMarkdown].  There's also a [good example][WikiMarkdownExample] there showing the before and after of how Markdown works, so be sure to check that out!

You can learn how to use Markdown in its official documentation at [Daring Fireball][Markdown].  Pico also uses the extensions to Markdown found in [Markdown Extra][MarkdownExtra].  Markdown is a very common formatting syntax, and you'll find there are many other pieces of software that use it as well.  The basic [Markdown syntax][MarkdownSyntax] is universal across almost all software, but many will add their own unique extensions (like Markdown Extra).  Just keep the differences in mind if you decide to learn these extra features, as just about everyone has their own "flavor" of Markdown.

```
## Sally's Flower Shop

Welcome to Sally's Flower Shop.  We have a *large* assortment to chose from.

Please browse our [catalog](%base_url%?catalog) for an extensive selection of flowers.
Our catalog also contains some varieties not found in our store which we can ship to you for free!

![hydrangea](%base_url%/assets/hydrangea.jpg)

This week, the following varieties are on sale:

* Red Roses
* Tiger Lilies
* Daisies

All sale prices are highlighted in the catalog for quick reference.

**Please Note:** All sales are final.
Due to the limited window of delivery, we are unable to offer any refunds.
```

### Control Your Metadata With YAML

As we covered earlier, all of Pico's content is stored in flat files.  This includes the Metadata for your pages as well.

Metadata makes up all the little details that accompany your page.  Things like the title, author, description, post date, etc.  While other CMS's would store this data in the database with everything else, Pico simply places it at the beginning of the file.

Each Markdown-based page you create in Pico will have a small header at the top that contains all the metadata for that file.  The metadata is formatted using [YAML][YAML], which makes it really easy to manage.  We go more in-depth about [using YAML][DocsYAML] for your page header in our Documentation.

Let's say for instance that you have a page that you'd like to back-date to last January.  Maybe that was the date you started your project or organization and you want the page to reflect that.  All you do is... type in that date!  There's no hoops to jump through, you don't have to go into some management console to modify your post, you just change the date.  You also don't have to worry that that minor edit you made to an older file will silently change a page's date to today's, thoroughly confusing all your visitors.

```
---
Title: Welcome
Description: |
  Welcome to Sally's Flower Shop!
  There's a special sale running this week, browse our catalog for more details.
Author: Sally Flora
Date: 2016-05-10
social:
  - title: Visit us on Facebook
    url: https://example.com/sallysflowers
    icon: facebook
  - title: Check us out on Twitter
    url: https://example.com/sallyflora
    icon: twitter
  - title: Contact us by Email!
    url: mailto:sallysflowershop@example.com
    icon: mail
---
```

## Flexibility and Customization

Pico's code base aims to be just as "stupidly simple" as Pico is easy to use.  While the core of Pico remains slim and lightweight, Pico has two very large avenues of customization, [Themes][] and [Plugins][].

These aren't just new "skins" or "widgets" you can apply to your website either.  These underlying technologies are *powerful* frameworks you can leverage to make your website truly unique.

### Theming With Twig Templates

Pico's default theme is *not* intended for production use.  It is provided as a great, but minimal starting place for you to develop your own customized website.  If you aren't familiar with HTML, fear not, we have an ever-growing variety of community-created themes available [here on our site][Themes], as well as some more on [our wiki][WikiThemes].

Pico's themes are built using [Twig Templates][Twig].  Twig is a template engine which provides an easy and powerful way to customize your website.  You can use small amounts of Twig to add dynamic content to a mostly-static HTML website, or use large amounts of Twig to build in some really incredible features.  Twig is so powerful that you'll find it can accomplish most tasks by itself, eliminating the need for plugins.  You can find more information on making your own templates in [Twig's Documentation][TwigDocs] and see how they relate to Pico in our own [Documentation][DocsThemes].

{% include gallery.html gallery='themes' %}

And if that's still not enough creative power for you, you can check out Pico's Plugin system.

### Plugins Extend Pico's PHP

Pico's Plugin system allows for users to extend Pico's functionality by hooking in their own PHP code.  Along with Themes, we also have a growing library of community-developed plugins you can use to add new features to your Pico site.  You can find these plugins [here on our site][Plugins], and even more on [our wiki][WikiPlugins].

[Hooking][] is a simple, but extremely powerful way to alter or augment Pico's behavior.  Pico basically triggers a bunch of well defined events when it reaches a specific point in its processing procedure.  For instance, when Pico reads what pages you've created (the files in your `content` directory), it triggers the `onPagesLoaded` event and passes a list of those pages as parameter.  This allows a plugin developer to modify it as required.  Just have a look at [Pico's "Drafts" plugin][DraftsPluginExample] for an example.  Pico provides a extensive list of events - just have a look at [Pico's dummy plugin][DummyPlugin] (`plugins/DummyPlugin.php`) for a complete list of hooks.  You want to create your own plugin?  Simply copy the dummy plugin, remove the events you don't need and add your code.

You don't understand anything of this crazy tech talk?  Don't worry!  You don't have to be a developer to use Pico.  *Using* plugins is no more than copying some `.php` file to your `plugins/` directory.  Really, it's that easy!  However, if you're a developer, you will immediately notice how damn simple developing plugins for Pico is.  You don't have to pore over hundreds of pages of documentation, you can simply start developing.

## Pico is Open Source

Best of all, Pico is open source software!  This means that Pico is, and always will be free.  Free to use, and free to modify.  Pico is released under the [MIT license][License].

Because Pico is open source, we welcome and appreciate any contributions.  If you'd like to help make Pico better, please check out the [Contribute][] section of our documentation.  We'd love to have your help.

## Getting Started

Ready to try Pico for yourself?  Head on over to our [Download][] page to get yourself a copy.  You can find more information on building your own Pico site in our [Documentation][Docs].  And of course, **we're here to help**!  If you require any assistance, or if you find a bug in Pico, let us know!  Check out the [Getting Help][GettingHelp] section of our Documentation for more details.  We appreciate your feedback!  Pico is a community-driven project and we need *your* feedback to keep making it better!

{% comment %}

* **General Notes**
* Include a larger "About" portion at the beginning?
  * Should contain all the "Why's" of Pico, before the "How's".
  * Explain what Pico is better *before* talking about other CMS's.
* Better image captions (Already updated some of them.)

* **Disadvantages of Other CMS's**
* Difficulties with configuration and having to work through an overcomplicated interface / admin panel.
* limitations when customizing, harder to create your own unique look and feel if you aren't satisfied with existing themes.

{% endcomment %}

[Docs]: {{ site.github.url }}/docs/
[DocsYAML]: {{ site.github.url }}/docs#text-file-markup
[DocsThemes]: {{ site.github.url }}/docs#themes
[GettingHelp]: {{ site.github.url }}/docs/#getting-help
[Download]: {{ site.github.url }}/download/
[Contribute]: {{ site.github.url }}/docs/#contribute
[License]: {{ site.gh_project_url }}/blob/{{ site.gh_project_branch }}/LICENSE.md

[Themes]: {{ site.github.url }}/customization/#themes
[WikiThemes]: {{ site.gh_project_url }}/wiki/Pico-Themes
[Plugins]: {{ site.github.url }}/customization/#plugins
[WikiPlugins]: {{ site.gh_project_url }}/wiki/Pico-Plugins

[WikiMarkdown]: https://en.wikipedia.org/wiki/Markdown
[WikiMarkdownExample]: https://en.wikipedia.org/wiki/Markdown#Example
[Markdown]: https://daringfireball.net/projects/markdown/basics
[MarkdownSyntax]: https://daringfireball.net/projects/markdown/syntax
[MarkdownExtra]: https://michelf.ca/projects/php-markdown/extra/
[Twig]: http://twig.sensiolabs.org/
[TwigDocs]: http://twig.sensiolabs.org/documentation
[YAML]: https://en.wikipedia.org/wiki/YAML
[Hooking]: https://en.wikipedia.org/wiki/Hooking
[DraftsPluginExample]: {{ site.github.url }}/plugins/drafts-example/
[DummyPlugin]: {{ site.gh_project_url }}/blob/{{ site.gh_project_branch }}/plugins/DummyPlugin.php
