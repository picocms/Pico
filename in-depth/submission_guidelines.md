---
layout: docs
title: Theme & Plugin Submission Guidelines
headline: Theme & Plugin Submission Guidelines
description: |
  Submitting your Theme or Plugin for inclusion on the website is very easy.<br>
  We've written some guidelines here to walk you through the process.
toc:
  as-easy-as-making-a-pull-request: As Easy as Making a Pull Request
  the-file-layout: The File Layout
  screenshot-specifics: Screenshot Specifics
  metadata-breakdown: Metadata Breakdown
  markdownyaml-template: Markdown/YAML Template
  getting-started: Getting Started
nav-url: /docs/
---

## As Easy as Making a Pull Request

Submitting content to the website is easy, all you have to do is create a new [Pull Request][] on GitHub.  To make the submission process smoother, our [Themes][] and [Plugins][] pages are dynamically generated using a collection of Markdown files.  The guidelines on this page will explain the layout and structure those files.

And if, for whatever reason, we don't feel that your submission is up to par, we'll work with you to improve it.

## The File Layout

Pico's website is found in the [gh-pages branch][gh-pages] on GitHub.  In this branch, you'll find two folders named `_themes` and `_plugins`.  These folders contain all the individual files that make up the [Themes][] and [Plugins][] pages respectively.

Each item has three types of files:

* A Markdown file, containing the YAML details of your submission.
* A `fullsize` screenshot of your item.
  * Optionally, you can provide multiple fullsize screenshots.  These will automatically cycle on the page as a carousel.
  * While we require a fullsize image for themes, a plugin can omit one if it is impractical or abstract to screenshot.  In this case, a default image will be used instead.
* A `thumbnail` screenshot of your item.
  * If you omit a thumbnail image, the page will automatically use our default thumbnail with your submission's name and description overlaid onto it.

Here's an example of how we keep these files organized:

```
.
├── _plugins
│   ├── images
│   │   ├── fullsize
│   │   │   ├── plugin_1.png
│   │   │   ├── plugin_1-2.png
│   │   │   └── plugin_2.png
│   │   └── thumbnails
│   │       ├── plugin_1.png
│   │       └── plugin_2.png
│   ├── plugin_1.md
│   └── plugin_2.md
└── _themes
    ├── images
    │   ├── fullsize
    │   │   ├── theme_1.png
    │   │   ├── theme_1-2.png
    │   │   └── theme_2.png
    │   └── thumbnails
    │       ├── theme_1.png
    │       └── theme_2.png
    ├── theme_1.md
    └── theme_2.md
```

## Screenshot Specifics

Each section, [Themes][gh-themes] and [Plugins][gh-plugins], has an `images` folder.  `images` is further separated into `fullsize` and `thumbnails` folders.  It's pretty self explanatory that fullsize and thumbnail images should go in their respective folders.

Our recommended naming convention is to name all three of your files (the markdown and the two images) with the same name, but their respective extensions.  In the previous section's example, this would be `theme2.md`, `fullsize/theme2.png`, and `thumbnails/theme2.png`.  Any additional `fullsize` image names should start with this name, but you are free to add your own variation to distinguish between them (`theme2_blog.png`, `theme2_front_page.png`, `theme2-2.png`, etc).  This naming convention will help us and others better identify which images belong to which item.

For your image format, we'd ask that you pick whichever format best optimizes your image size vs its quality.  If your image has large blank or simplistic sections, a `.png` image will provide the best quality at a reasonable file size.  If your image is busy or has a lot of fine detail, we'd recommend you using a `.jpg` with a slightly reduced quality (80-95% should provide a good balance).  If you're unfamiliar with the differences between these formats, you can experiment to determine which option will provide the best balance of quality and file size.  If you have any questions, we are [here to help][GettingHelp].

For thumbnail images, you should use a resolution of `270x220`.  The thumbnails are a locked size on the website, so providing a different resolution will result in your image being squashed.

Fullsize image resolution isn't as strict.  These images will be proportionally scaled to the right size.  We do however recommend a resolution of at least `1440x900`, as these images can be viewed fullscreen by clicking on their magnifying glass icon.

### Specifications

* Match the filename of your `.md`
* Choose an Optimal Format, `.png` or `.jpg`
* Fullsize: `1440x900` or larger
* Thumbnails: `270x220`

## Metadata Breakdown

Heading

: The name of your theme or plugin.

Thumbnail

: The absolute location of your thumbnail image.  See [Screenshot Specifics](#screenshot-specifics) above for more information.

Categories

: These categories are displayed along the top of the page.  By clicking them, you can filter the results to just those of the category.  Each category below has a special short-name to use in your YAML.  We may add more categories in the future (let us know if you have any suggestions).

  Available Categories:

  **Themes**

  * Single Page (`single-page`) - A single page website, where all content is displayed on the `index` page.
  * Portfolio (`portfolio`) - A theme intended to be used as a portfolio of your work or to establish an online presence on your personal domain.
  * Blog-Style (`blog`) - A theme styled with blogging or news posts in mind.

  **Plugins**

  * Administration (`admin`) - A plugin that adds administration capabilities to Pico.
  * Utility (`utility`) - A plugin that offers more developer-focused functionality.
  * Theming Extensions (`theming`) - A plugin that extends Twig by adding extra variables or functionality to your templates.

Description

: A short, one-line, description of your theme/plugin that displays below its title.

Link

: The URL of the "Learn More" link, at the bottom of your description.

Button

: Specify custom text for the "Learn More" button.  This is an optional value, not included in the example below.  We don't recommended changing this text, so be ready to convince us as to why you feel the change is necessary.

Images

: These are your `fullsize` images.  Specify the absolute location of each image.  See [Screenshot Specifics](#screenshot-specifics) above for more information.

Info

: Here you can specify a few lines of "info" that will display above your description.  The recommended items are `By` and `Last Updated`, but you can create your own items if they'd better fit the context of your theme or plugin.

  If your entry is a port of someone else's work, please use the `Ported By` and `Original By` lines instead of the regular `By`.  We'd like to make sure that the original content creators receive proper credit for their work.

  Also, as visible in the template below, you can add links to these `info` items.  You can easily link your `By` line to your GitHub profile or another location.  If you're using the `Original By` line, you should also link to the original source in this manner.  You can use either HTML or Markdown links, but if you use Markdown, you'll want to wrap the entire string in quotes.  This is because the `[]` characters have a special meaning in YAML and must be escaped.

  You can also use `_` as the first character of your item's identifier to create a line without a visible identifier.  For example, using `_item: An Example Message` would simply display `An Example Message`).  You can have several of these lines, as long as they have unique names.

Content

: Finally, your main content should go after the YAML, in the Markdown body.  This content can be as long as you'd like, but keep in mind that, for themes, the content area is very narrow (it's roughly 40 characters wide).  Plugins are given a much larger space for their content.

## Markdown/YAML Template

The following code block is a template for your submission's `.md` file.  Copy and paste this section into your document and edit it to create your submission.

```
---
heading: My Theme or Plugin
thumbnail: /_themes/images/thumbnails/my_theme_or_plugin.jpg
categories:
  - category1
  - category2
description: A short description for the hover text.
link: https://github.com/octocat/Spoon-Knife
images:
  - /_themes/images/thumbnails/my_theme_or_plugin.jpg
#  - /_themes/images/thumbnails/my_theme_or_plugin-2.jpg
#  - /_themes/images/thumbnails/my_theme_or_plugin-3.jpg
info:
  By: "[The Octocat](https://github.com/octocat)"
#  Ported By: "[The Octocat](https://github.com/octocat)"
#  Original By: "[Someone Else](http://example.com/)"
  Last Updated: They don't have to be "By" and "Last Updated"
---

This is my Theme for Pico.

Or maybe it's a Plugin...

Either way, if it really existed, this is where I would write some details about it.
```

## Getting Started

So you've read all of our Guidelines and you're ready to make your submission.  What now?

For those unfamiliar, there are many ways to interact with Git and GitHub.  For simplicity, we'll be covering the command line version of Git, but there are many graphical Git clients as well.  For those on Mac and Windows, you can check out [GitHub Desktop][], GitHub's official Git client.

If you're new to Open Source, or haven't contributed to a project before, we'd also recommend checking out GitHub's [Contributing to Open Source on GitHub][Contributing Guide] Guide.

Finally, GitHub also provides an excellent overview of the process we're about to embark on.  Check out their guide on [Forking Projects][] to learn all you'll need to know.

Don't forget, we're here to help!  See our [Getting Help][] section for assistance, and don't be afraid to contact us.

1. **Fork** - Ready to go?  You can start by creating a [Fork][] of our Git Repository on GitHub.  To do this, visit our [GitHub Page][] and click the "<svg aria-hidden="true" class="octicon octicon-repo-forked" height="16" version="1.1" viewBox="0 0 10 16" width="10"><path d="M8 1a1.993 1.993 0 0 0-1 3.72V6L5 8 3 6V4.72A1.993 1.993 0 0 0 2 1a1.993 1.993 0 0 0-1 3.72V6.5l3 3v1.78A1.993 1.993 0 0 0 5 15a1.993 1.993 0 0 0 1-3.72V9.5l3-3V4.72A1.993 1.993 0 0 0 8 1zM2 4.2C1.34 4.2.8 3.65.8 3c0-.65.55-1.2 1.2-1.2.65 0 1.2.55 1.2 1.2 0 .65-.55 1.2-1.2 1.2zm3 10c-.66 0-1.2-.55-1.2-1.2 0-.65.55-1.2 1.2-1.2.65 0 1.2.55 1.2 1.2 0 .65-.55 1.2-1.2 1.2zm3-10c-.66 0-1.2-.55-1.2-1.2 0-.65.55-1.2 1.2-1.2.65 0 1.2.55 1.2 1.2 0 .65-.55 1.2-1.2 1.2z"></path></svg> Fork" Button in the top right.

    You will of course need to have a GitHub account to do this.

2. **Clone** - Next you need to [Clone][] your new Repository down to your local machine.  From the command line, this would be:

    `git clone https://github.com/YOUR USER NAME/Pico.git`

3. **Checkout** - From there, you want to Checkout the `gh-pages` branch, where our website is stored.

      `git checkout gh-pages`

4. **Make Changes** - Now, create your submission using the information we provided above.  Remember, Themes go in `_themes`, while Plugins go in `_plugins`.

5. **Commit** - Once you're done, you can Commit your changes to your local Git Repository using the following command.  Remember to replace `YOUR SUBMISSION NAME` with the actual name of your submission.

    `git commit -am "Submission: YOUR SUBMISSION NAME"`

6. **Push** - Finally, Push your Commit back up to your GitHub account with:

    `git push`

7. **Pull Request** - Back on GitHub you'll need to create a [Pull Request][].  In the top left of your Repo, you'll want to click `Branch: master` and change it to say `Branch: gh-pages`.

    Then, click `New Pull Request`.

    Give your PR a name and a brief description and click `Create Pull Request`.

    We'll take it from there.  Be sure to check back and see if we have feedback or changes to request.

[GitHub Page]: {{ site.gh_project_url }}
[Themes]: /themes
[Plugins]: /plugins
[gh-pages]: {{ site.gh_project_url }}/tree/gh-pages
[GettingHelp]: {{ site.github.url }}/docs/#getting-help
[gh-themes]: {{ site.gh_project_url }}/tree/gh-pages/_themes
[gh-plugins]: {{ site.gh_project_url }}/tree/gh-pages/_themes
[GitHub Desktop]: https://desktop.github.com/
[Contributing Guide]: https://guides.github.com/activities/contributing-to-open-source/
[Forking Projects]: https://guides.github.com/activities/forking/
[Getting Help]: {{ site.github.url }}/docs/#getting-help
[Fork]: https://help.github.com/articles/fork-a-repo/
[Clone]: https://help.github.com/articles/cloning-a-repository/
[Pull Request]: https://help.github.com/articles/creating-a-pull-request/
