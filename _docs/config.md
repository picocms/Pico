---
toc:
    config:
        _title: Config
        url-rewriting: URL Rewriting
        nginx-configuration: Nginx Configuration
nav: 6
---

## Config

You can override the default Pico settings (and add your own custom settings) by editing `config/config.php` in the Pico directory. For a brief overview of the available settings and their defaults see [`config/config.php.template`][ConfigTemplate]. To override a setting, copy `config/config.php.template` to `config/config.php`, uncomment the setting and set your custom value.

### URL Rewriting

Pico's default URLs (e.g. http://example.com/pico/?sub/page) already are very user-friendly. Additionally, Pico offers you a URL rewrite feature to make URLs even more user-friendly (e.g. http://example.com/pico/sub/page).

If you're using the Apache web server, URL rewriting should be enabled automatically. If you get an error message from your web server, please make sure to enable the [`mod_rewrite` module][ModRewrite]. Assuming rewritten URLs work, but Pico still shows no rewritten URLs, force URL rewriting by setting `$config['rewrite_url'] = true;` in your `config/config.php`.

#### Nginx Configuration

If you're using Nginx, you can use the following configuration to enable URL rewriting. Don't forget to adjust the path (`/pico`; line `1` and `4`) to match your installation directory. You can then enable URL rewriting by setting `$config['rewrite_url'] = true;` in your `config/config.php`.
```
location ~ ^/pico(.*) {
	index index.php;
	try_files $uri $uri/ /pico/?$1&$args;
}
```
Nginx is a very extensive subject.  If you have any trouble, please read through our page on [Nginx Configuration][NginxConfig].  Don't be afraid to open a [new issue](https://github.com/picocms/Pico/issues) on GitHub or contact us at [#picocms on Freenode IRC](https://webchat.freenode.net/?channels=%23picocms) for additional assistance.

[ConfigTemplate]: {{ site.gh_project_url }}/blob/{{ site.gh_project_branch }}/config/config.php.template
[ModRewrite]: https://httpd.apache.org/docs/current/mod/mod_rewrite.html
[NginxConfig]: {{ site.github.url }}/nginx/
