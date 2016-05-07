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
    themes: Themes...
    plugins: Plugins...
  getting-started: Getting Started
nav-url: /about/
nav: 2
---

Pico is a stupidly simple, blazing fast, flat file CMS.  For those of us who aren't an expert webmaster, what does that even mean?  In the most basic sense, it means that there is no administration backend or database to deal with. You simply create .md files in the content folder and those files become your pages.  There's *much* more to Pico than that though.

![Pico's Default Theme]({{ site.github.url }}/style/images/docs/pico_about_default_theme.png)
Pico's default theme.  It's a bit bare... but that's intentional!

Let's get this out of the way: Pico is *not* a turn-key solution.  If your goal is to deploy a generic-looking website without getting your hands dirty, Pico is probably not for you.

That being said, Pico is incredibly extendable and customizable.  With a very small amount of configuration, you'll find yourself with a very personalized experience.  There's also a growing community creating ready-to-go [themes and plugins](#flexibility-and-customization) for Pico.  It is very possible to get started with Pico even with [no prior knowledge of HTML](#web-pages-without-html).  You'll find however that a little bit of coding knowledge will get you a long way.

![NotePaper Theme for Pico]({{ site.github.url }}/style/images/docs/pico_about_notepaper_theme.jpg)
NotePaper, a ready-to-go, community-developed theme.

* Probably move this later, but I didn't want to forget to include it in the same commit as the image file.
* Add example images for other themes.


* insert some images showing Pico in use.  Borrow from readme?
  * Can the site do thumbnails and lightboxing?
* Add a style for these images? Their lack of a border or shadow makes them hard to distinguish from the page background.
  * Again, can these be thumbnailed and lightboxed? That might work better.

* Larger "About" portion at the beginning.
  * Should contain all the "Why's" of Pico, before the "How's"

Now let's dive into what makes Pico different from other solutions.

## A Flat File CMS

Pico is a Content Management System, or CMS.  If you've heard the term before, it's likely in the context of WordPress, Joomla, Drupal (intentionally not linking to the competition ;P) or many of the other popular CMS's on the block.  A Content Management System makes creating a beautiful and well-organized website easy and frustration free.  It can also help those without extensive knowledge of programming on the web to achieve the same professional quality website as those that do.

 * Last sentence is a bit rough....
 * Add headers for CMS and Flat file or is that excessive?

Most Content Management Systems make use of extensive databases to hold their content.  These databases can sometimes require a confusing setup process, though this is often obscured by one-click setup utilities.  While they can be simple to set up thanks to these utilities, users may experience difficulty when trying to modify, edit, or migrate their content.  Everything that makes their site "what it is" is locked up in a hard-to-manage database.  Anyone who's tried to migrate their WordPress installation from one server to another has likely experienced this pain.

Pico is different.  With Pico, all your content is stored as "flat files", which is pretty much exactly as it sounds.  When using Pico, all your site content is stored as simple text files.  It remains readily available to modify, edit, organize, and migrate as you see fit.

There really isn't that much more to say about it.  The beauty of Pico is in its simplicity.  If you want to create a new page, you make a new file.  That's it.  But that's far from the end of the story.  Despite Pico's simplicity, you'll find it incredibly powerful, and ready to take on any task.

* ...That... was just the intro.

## Web Pages Without HTML

* Write an intro

### Markdown Makes Formatting Easy

Part of Pico's simplicity comes from the use of Markdown for formatting your pages.  Markdown is a formatting syntax that painlessly converts your writing into HTML.  A Markdown file is just a text file with an `.md` extension instead of `.txt`.  Markdown makes building new pages as easy as writing basic text.  Writing in Markdown is a lot quicker than coding in HTML, and much easier to learn.  Even this document was written using the simplicity of Markdown!

You can learn more about Markdown in its official documentation at [Daring Fireball](http://daringfireball.net/projects/markdown/).  Pico also uses the extensions to Markdown found in [Markdown Extra](https://michelf.ca/projects/php-markdown/extra/).  Markdown is a very common formatting syntax, and you'll find there are many other pieces of software that use it as well.  The basic Markdown syntax is universal across almost all software, but many will add their own unique extensions (like Markdown Extra).  Just keep the differences in mind if you decide to learn these extra features, as just about everyone has their own "flavor" of Markdown.

### Control Your Metadata With YAML

As we covered earlier, all of Pico's content is stored in flat files.  This includes the Metadata for your pages as well.

Metadata makes up all the little details that accompany your page.  Things like the title, author, description, post date, etc.  While other CMS's would store this data in the database with everything else, Pico simply places it at the beginning of the file.

Each Markdown-based page you create in Pico will have a small header at the top that contains all the metadata for that file.  The metadata is formatted using [YAML](https://en.wikipedia.org/wiki/YAML), which makes it really easy to manage.  We go more in-depth about [using YAML]({{ site.github.url }}/docs#text-file-markup) for your page header in our Documentation.

Let's say for instance that you have a page that you'd like to back-date to last January.  Maybe that was the date you started your project or organization and you want the page to reflect that.  All you do is... type in that date!  There's no hoops to jump through, you don't have to go into some management console to modify your post, you just change the date.  You also don't have to worry that that minor edit you made to an older file will silently change a page's date to today's, thoroughly confusing all your visitors.

## Flexibility and Customization

Pico is not just easy to use, it's *powerful*!  Pico has two very large avenues of customization, [Themes and Plugins]({{ site.github.url }}/customization/).

### Themes...

* Snappier section titles

Pico's default theme is *not* intended for production use.  It is provided as a great, but minimal starting place for you to develop your own customized website.  If you aren't familiar with HTML, fear not, we have an ever-growing variety of community-created themes available [here on our site]({{ site.github.url }}/customization/#themes), as well as some more on [our wiki]({{ site.gh_project_url }}/wiki/Pico-Themes).

Pico's "Themes" are built using [Twig Templates](http://twig.sensiolabs.org/).  Twig is a template engine which provides an easy and powerful way to customize your website.  You can use small amounts of Twig to add dynamic content to a mostly-static HTML website, or use large amounts of Twig to build in some really incredible features.

* link to cookbook? docs?

And if that's not enough creative power for you, you can check out Pico's Plugin system.

### Plugins...

Pico's Plugin system allows for users to extend Pico's functionality by hooking in their own PHP code.  Along with Themes, we also have a growing library of community-developed plugins you can use to add new features to your Pico site.  You can find these plugins [here on our site]({{ site.github.url }}/customization/#plugins), and even more on [our wiki]({{ site.gh_project_url }}/wiki/Pico-Plugins).

* **@PhrozenByte** any more to say about Plugins?

## Getting Started

Ready to try Pico for yourself?  Head on over to our [Download]({{ site.github.url }}/download/) page to get yourself a copy.  You can find more information on building your own Pico site in our [Documentation]({{ site.github.url }}/docs/).  And of course, **we're here to help**!  If you require any assistance, or if you find a bug in Pico, let us know!  Check out the [Getting Help]({{ site.github.url }}/docs/#getting-help) section of our Documentation, contact us on [Freenode IRC](https://webchat.freenode.net/?channels=%23picocms), or most importantly, create a [New Issue]({{ site.gh_project_url }}/issues) on GitHub!  We appreciate your feedback!  Pico is a community-driven project and we need *your* feedback to keep making it better!

* **General Notes**
* Footnote URLs
* Overview of Why's
* Expand YAML in main documentation.


* **VS Other CMS's**
* configuration
* migration
* interfaces - only way to configure
* limitations

* **Community**
* Start a discussion about how people got started with Pico.
  * LUP and maybe an interview to build community?
