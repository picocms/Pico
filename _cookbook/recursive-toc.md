---
title: Recursive table of contents
description: How can I realize a arbitrary deep TOC?
---

<div class="one-half">
    <h5>Twig Macro</h5>

    {% highlight html %}{% raw %}
{% macro rnav(toc) %}
    {% import _self as macros %}
    <ul>
        {% for sectionKey, section in toc %}
            {% if section._title %}
                <li>
                    <a href="#{{ sectionKey }}">{{ section._title }}</a>
                    {{ macros.rnav(section) }}
                </li>
            {% elseif sectionKey != "_title" %}
                <li>
                    <a href="#{{ sectionKey }}">{{ section }}</a>
                </li>
            {% endif %}
        {% endfor %}
    </ul>
{% endmacro %}
    {% endraw %}{% endhighlight %}
</div>

<div class="one-half last">
    <h5>Usage</h5>

    {% highlight html %}{% raw %}
{% import _self as macros %}
{% if meta.toc %}
    {{ macros.rnav(meta.toc) }}
{% endif %}
    {% endraw %}{% endhighlight %}
</div>

<div class="clear"></div>
