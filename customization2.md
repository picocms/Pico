---
layout: default
title: Customization(2)
headline: Pico Plugins &amp; Themes
description: |
    Below are some plugins and themes which extend the functionality of Pico and make it even more awesome.<br />
    Want to create a plugin or theme? Please refer to [our documentation](/docs/#plugins)!
nav: 4

portfolio:
  categories:
    theme: Themes
    plugin: Plugins
  categories2:
    theme: Themes2
    plugin: Plugins2

---

{% include portfolio.html portfolio=site.customization %}
{{ comment }}{% include portfolio.html portfolio=site.customization categories=page.portfolio.categories2 %}{{ endcomment }}

---

## More Plugins & Themes

On this page we just present a tiny selection of the vast number of awesome third-party plugins and themes out there! A good start point for discovery is [our Wiki]({{ site.gh_project_url }}/wiki), where you can find many more [plugins]({{ site.gh_project_url }}/wiki/Pico-Plugins) and [themes]({{ site.gh_project_url }}/wiki/Pico-Themes). For more information, especially about how you can create your own plugin or theme, please refer to the [docs]({{ site.github.url }}/docs/#customization).
