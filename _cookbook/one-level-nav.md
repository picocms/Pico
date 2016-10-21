---
title: One-level navigation
description: How to show only pages of the first level (i.e. `page.md` and `sub/index.md`, not `sub/page.md`) on the navigation?
---

<h5>Template snippet</h5>

{% highlight html %}{% raw %}
<ul>
    {% for page in pages if page.title %}
        {% set pageDepth = page.id|split('/')|length %}
        {% if (pageDepth == 2) and (page.id ends with "/index") or (pageDepth == 1) %}
            <li>
                <a href="{{ page.url }}">{{ page.title }}</a>
            </li>
        {% endif %}
    {% endfor %}
</ul>
{% endraw %}{% endhighlight %}
