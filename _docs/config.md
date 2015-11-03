---
toc:
    config:
        _title: Config
        url-rewriting: URL Rewriting
nav: 6
---

## Config

You can override the default Pico settings (and add your own custom settings) by editing `config/config.php` in the Pico directory. For a brief overview of the available settings and their defaults see [`config/config.php.template`][ConfigTemplate]. To override a setting, copy `config/config.php.template` to `config/config.php`, uncomment the setting and set your custom value.

### URL Rewriting

Picos default URLs (e.g. http://example.com/pico/?sub/page) already are very user friendly. Pico anyway offers you an URL rewrite feature to make URLs even more user friendly (e.g. http://example.com/pico/sub/page).

If you're using the Apache web server, URL rewriting should be enabled automatically. If you get an error message from your web server, please make sure to enable the `mod_rewrite` module. Assumed rewritten URLs work, but Pico still shows no rewritten URLs, force URL rewriting by setting `$config['rewrite_url'] = true;` in your `config/config.php`.

If you're using Nginx, you can use the following configuration to enable URL rewriting. Don't forget to adjust the path (`/pico/`; line `1` and `4`) to match your installation directory. You can then enable URL rewriting by setting `$config['rewrite_url'] = true;` in your `config/config.php`.

    location /pico/ {
        index index.php;
        try_files $uri $uri/ /pico/?$uri&$args;
    }

[ConfigTemplate]: {{ site.gh_project_url }}/blob/{{ site.gh_project_branch }}/config/config.php.template
