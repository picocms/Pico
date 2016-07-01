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
  screenshot-locations-and-dimensions: Screenshot Locations and Dimensions
  yaml-metadata-and-description: YAML Metadata and Description
nav-url: /docs/
---

## As Easy as Making a Pull Request

Submitting content to the website is easy, all you have to do is create a new [Pull Request][] on GitHub.  To make the submission process smoother, our [Themes][] and [Plugins][] pages are dynamically generated using a collection of Markdown files.  The guidelines on this page will explain the layout and structure those files.  While we don't anticipate having to turn anyone down, we do reserve the right to reject your submission at our own discretion.  More likely though, we will work with you to get your submission up to our satisfaction.

## The File Layout

Pico's website is found in the [`gh-pages` branch][gh-pages] on GitHub.  In this branch, you'll find two folders named `_themes` and `_plugins`.  These folders contain all the individual files that make up the [Themes][] and [Plugins][] pages respectively.

Each item has a minimum of *three* required files.

* A Markdown file, containing the YAML details of your submission.
* A `fullsize` screenshot of your item.
  * Optionally, you can provide multiple fullsize screenshots.  These will automatically cycle on the page as a carousel.
  * A plugin may optionally omit this screenshot and use a two-column layout instead.
* A `thumbnail` screenshot of your item.
  * A plugin may omit a thumbnail and instead use our default plugin thumbnail and style.

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

## Screenshot Locations and Dimensions

* fullsize: 1440x900
* thumbnails: 270x220


## YAML Metadata and Description

* Break down into a list of variables

```
---
heading: My Theme or Plugin
thumbnail: /_themes/images/thumbnails/my_theme_or_plugin.jpg
categories:
  - category1
  - category2
meta: A short description for the hover text.
link: https://github.com/octocat/Spoon-Knife
images:
  - /_themes/images/thumbnails/my_theme_or_plugin.jpg
  - /_themes/images/thumbnails/my_theme_or_plugin-2.jpg
  - /_themes/images/thumbnails/my_theme_or_plugin-3.jpg
info:
  By: "[The Octocat](https://github.com/octocat)"
#  Ported By: "[The Octocat](https://github.com/octocat)"
#  Original By: "[Someone Else](http://example.com/)"
  Last Updated: They don't have to be "By" and "Last Updated"
---
This is my Theme for Pico.

If it really existed, this is where I would write some details about it.
```

[Pull Request]: {{ site.gh_project_url }}/pull/new/gh-pages
[Themes]: /themes
[Plugins]: /plugins
[gh-pages]: {{ site.gh_project_url }}/tree/gh-pages
