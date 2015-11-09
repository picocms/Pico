---
title: Table of contents
description: How to generate TOCs very easy?
---

<div class="one-half">
    <h5>YAML header</h5>

    {% highlight yaml %}
---
toc:
    item-on-level-1:
        _title: Item on Level 1
        item-on-level-2a: Item on Level 2 (a)
        item-on-level-2b: Item on Level 2 (b)
    another-level-1-item: Another Item on Level 1
---
    {% endhighlight %}
</div>

<div class="one-half last">
    <h5>Template snippet</h5>

    {% highlight html %}{% raw %}
<ul>
    {% for sectionKey, section in meta.toc %}
        <li>
            {% if section._title %}
                <a href="#{{ sectionKey }}">{{ section._title }}</a>
                <ul>
                    {% for subSectionKey, subSection in section if subSectionKey != "_title" %}
                        <li><a href="#{{ subSectionKey }}">{{ subSection }}</a></li>
                    {% endfor %}
                </ul>
            {% else %}
                <a href="#{{ sectionKey }}">{{ section }}</a>
            {% endif %}
        </li>
    {% endfor %}
</ul>
    {% endraw %}{% endhighlight %}
</div>

<div class="clear"></div>
