---
title: Pluralize filter
description: How can I easily pluralize a string?
---

<div class="one-half">
    <h5>Twig macro</h5>

    {% highlight html %}{% raw %}
{% macro pluralize(number, singular, plural) %}
    {{ number }} {% if number == 1 %}{{ singular }}{% else %}{{ plural }}{% endif %}
{% endmacro %}
    {% endhighlight %}
</div>

<div class="one-half last">
    <h5>Usage</h5>

    {% highlight html %}{% raw %}
{% import _self as util %}
{{ util.pluralize(pages|length, "page", "pages") }}
    {% endraw %}{% endhighlight %}
</div>

<div class="clear"></div>