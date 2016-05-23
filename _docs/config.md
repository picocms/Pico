---
toc:
    config:
        _title: Config
        url-rewriting: URL Rewriting
        apache: Apache
        nginx: Nginx
nav: 6
---

## Config

You can override the default Pico settings (and add your own custom settings) by editing `config/config.php` in the Pico directory. For a brief overview of the available settings and their defaults see [`config/config.php.template`][ConfigTemplate]. To override a setting, copy `config/config.php.template` to `config/config.php`, uncomment the setting and set your custom value.

### URL Rewriting

Pico's default URLs (e.g. http://example.com/pico/?sub/page) already are very user-friendly. Additionally, Pico offers you a URL rewrite feature to make URLs even more user-friendly (e.g. http://example.com/pico/sub/page).

#### Apache

If you're using the Apache web server, URL rewriting should be enabled automatically. If you get an error message from your web server, please make sure to enable the [`mod_rewrite` module][ModRewrite]. Assuming rewritten URLs work, but Pico still shows no rewritten URLs, force URL rewriting by setting `$config['rewrite_url'] = true;` in your `config/config.php`.

#### Nginx [Learn more…][NginxConfig]{:.learn-more}
{:#nginx}

If you're using Nginx, you can use the following configuration to enable URL rewriting (lines `5` to `8`) and denying access to Pico's internal files (lines `1` to `3`). You'll need to adjust the path (`/pico` on lines `1`, `5` and `7`) to match your installation directory. Additionally, you'll need to enable URL rewriting by setting `$config['rewrite_url'] = true;` in your `config/config.php`.

```
location ~ /pico/(\.htaccess|\.git|config|content|content-sample|lib|vendor|CHANGELOG\.md|composer\.(json|lock)) {
	return 404;
}

location ~ ^/pico(.*) {
	index index.php;
	try_files $uri $uri/ /pico/index.php?$1&$args;
}
```

This configuration should provide the *bare minimum* you need for Pico. Nginx is a very extensive subject. If you have any trouble, please read through our page on [Nginx Configuration][NginxConfig]. For additional assistance, please refer to the ["Getting Help" section][GettingHelp] below.

[ConfigTemplate]: {{ site.gh_project_url }}/blob/{{ site.gh_project_branch }}/config/config.php.template
[ModRewrite]: https://httpd.apache.org/docs/current/mod/mod_rewrite.html
[NginxConfig]: {{ site.github.url }}/in-depth/nginx/
[GettingHelp]: {{ site.github.url }}/docs/#getting-help
