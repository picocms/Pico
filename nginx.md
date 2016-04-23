---
layout: docs
title: Nginx Configuration
headline: How to Configure Nginx for Pico
description: Nginx can be very powerful, but it takes a little extra configuration with Pico - Let's break it down.
toc:
  getting-started: Getting Started
  general-server-configuration: General Server Configuration
  denying-access-to-picos-internal-files: Denying Access to Pico's Internal Files
  php-configuration: PHP Configuration
  url-rewriting:
    _title: URL Rewriting
    pico-in-document-root: Pico in Document Root
    pico-in-a-subfolder:
      _title: Pico in a Subfolder
      regex-and-nginxs-processing-order: Regex and Nginx's Processing Order
  advanced-configuration-tips:
    _title: Advanced Configuration Tips
    modular-pico-config: Modular Pico Config
nav-url: /docs/
---

[Nginx](https://www.nginx.com/) has quickly become a solid contender in the realm of web servers.  While most of the web still uses Apache for serving web content, we acknowledge that a growing portion of our users may be interested in deploying Pico on Nginx instead of Apache.  Deploying Pico on Apache at the moment is relatively painless, with Pico's `.htaccess` file providing almost all the configuration necessary.

Unlike Apache, Nginx uses a ["Centralized" configuration](https://www.digitalocean.com/community/tutorials/apache-vs-nginx-practical-considerations#distributed-vs-centralized-configuration).  Apache scours every folder it hosts in search of `.htaccess` files.  These files hold extra configuration options, often deployed with hosted software to make their setup easy.  Pico is no exception to this, and in most cases, Pico's `.htaccess` provides all the settings required to get it up and running without user interaction.

This "Distributed" configuration can make it hard to understand what's really going on behind the scenes.  Apache's configuration can be spread out into as many folders as your webapps (or your own content) provide.

In comparison, Nginx's "Centralized" configuration is all located in one place.  On a Linux server, this configuration would usually be located in `/etc/nginx`, but this may vary by distro and OS.  While configuration of Nginx as a  whole is out of the scope of this document, we hope to provide you with enough information to get over any hurdles you may encounter.

## Getting Started

While the [example]({{ site.github.url }}/docs#nginx-configuration) provided on the previous page is a good starting point, it will likely not be enough to fully configure your Pico installation.

There are three main parts to configuring a Pico site under Nginx, in addition to general server configuration.  The three sets of rules we will be developing provide the following functions: Denying access to Pico's internal files, configuring PHP, and setting up Pico's url-rewriting.  Although it's arguably the most important function, we'll be configuring url-rewriting last due to the order that Nginx processes its config.  We'll discuss that in more detail when we get to it below.

## General Server Configuration

Nginx's server configuration is broken into sections called `blocks`.  Each website has its own `server` block inside your Nginx config.  While configuration of Nginx sites, virtual hosts, and other aspects of this topic are outside the scope of this guide, we'll provide enough to at least get you started with Pico.

```
server {
	listen 80;

	server_name www.example.com example.com;
	root /var/www/example;

	index index.php;
}
```

Let's break down this example.  The first line, `listen 80` tells Nginx to listen on port 80 for incoming connections.  This is the default port used by web traffic, and what you'll want to use 99% of the time.  `server_name` is where you specify what domain name or names match this configuration.  You'll likely want to include your domain both with and without the `www.` subdomain.  `root` lets you specify the Document Root for this site.  This is usually going to be where you've installed Pico, but ultimately it depends on your configuration.  `index index.php` tells Nginx that your site's index file will be called `index.php`.  This is necessary for Pico, however you can use something like `index index.html index.htm index.php` if you'd like Nginx to also search for a non-Pico html index file.

Below we'll add a few more sections to this server configuration.  All of the following examples should be placed **inside** the server block, before the closing `}`

## Denying Access to Pico's Internal Files

One of the important features provided by Pico's `.htaccess` is the denial of access to some of Pico's directories.  There are two simple reasons for this, added security, and ease-of-use.  We don't want anyone snooping around and reading files they shouldn't be (like our Pico `config.php`), but we also don't want people accidentally navigating to a raw markdown file or viewing directory indexes (not actually an issue, since they're disabled unless specified in Nginx, but this isn't always the case in Apache).

There are two rules you should always use in the Nginx config of your Pico site:

```
location ~* /\.ht {
	deny all;
}

location ~* /(config|content|content-sample|lib|vendor) {
	return 404;
}
```

The first rule denies access to Pico's `.htaccess` file if it exists.  Remember, this is a configuration file for Apache, and Apache would have denied access to it automatically.  While it doesn't do anything under Nginx, you may have unknowingly left it in your Pico directory, as it is hidden by default.  While you can safely remove `.htaccess` from your Pico installation, we'd recommend you use this rule anyway just in case.  For example, you may upgrade Pico in the future and forget to remove it!  In general though, this rule is for security, and usually recommend in Nginx, even outside of running Pico.

The next rule returns a 404 (file not found) page if the user tries to navigate into Pico's internal file structure.  We recommend this rule as it's generally a good practice.  Users's don't need access to these files, so why allow it?

## PHP Configuration

This is a topic outside the realm of this document.  Unlike Apache (which sends every document to PHP automatically), Nginx is more streamlined.  It needs to be *told* to send a file to an external PHP processor.  It does not handle PHP itself.

Configuring PHP is a topic that is largely up to the OS you are using.  The examples I'm going to provide here apply to Ubuntu 14.04, but they also require external configuration of `php-fpm` or another php processor.

Your PHP configuration will look something like this:

```
location ~ [^/]\.php(/|$) {
	fastcgi_split_path_info ^(.+?\.php)(/.*)$;

	# Protection Against "cgi.fix_pathinfo = 1"
	if (!-f $document_root$fastcgi_script_name) {
		return 404;
	}

	fastcgi_pass unix:/var/run/php5-fpm.sock;
	fastcgi_index index.php;
	include fastcgi_params;

	# Inform Pico we will be rewriting URL's for it.
	fastcgi_param PICO_URL_REWRITING 1;
}
```

Please note that this is only provided as an **example**.  You should write your own PHP location block based on your personal system configuration.

This `location` rule tells Nginx to send all pages ending in `.php` to an external php processor called `php-fpm`.  Again, setting this up is outside the scope of this document.  There are many tutorials available online.  Here is one for [Ubuntu 14.04](https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-on-ubuntu-14-04#3-install-php-for-processing).

By default, `php-fpm` comes with a very insecure setting that can allow unauthorized code execution.  We've included a small `if` statement here that will protect you from this vulnerability.  If you've changed php-fpm's `cgi.fix_pathinfo` setting to `0`, you do not need this statement.

The line `fastcgi_param PICO_URL_REWRITING 1;` informs Pico that we will be rewriting url's in Nginx.  This prevents Pico from using its own url-rewriting, and gives us nicer url's.

## URL Rewriting

There are several ways to approach Pico's url-rewriting in Nginx.  We'll be covering two different approaches in this document, but there really is no right answer.

### Pico in Document Root

If your Pico installation is in the `Document Root` of your website, then configuration is relatively easy.

```
location / {
	try_files $uri $uri/ /?$uri&$args;
}
```

This rule tells Nginx that whenever it looks up a url within your site, it should first look for a file of that name, then a directory, and finally, if neither exist, it should rewrite the url for Pico.  When the url is rewritten for Pico, it is formatted as `/` followed by a query string (starts with `?`) containing the file path (`$uri`) and then followed by any other query arguments (`$args`).  By referencing `/`, Nginx will load `index.php` (as defined in our server config above) and pass the rendering along to your php processor.

### Pico in a Subfolder

If your Pico installation is in a subfolder, configuration is slightly more complicated, but should be easy if you follow along.

```
location ~ ^/pico(.*) {
	try_files $uri $uri/ /pico/?$1&$args;
}
```

You'll notice that similar to our last example, we're sending Nginx to `index.php` with a query string of the url, but this time in a subfolder named `pico`.  What's different is that we're using `$1` to reference the page url instead of `$uri`.  This is because `$uri` will contain the entire url from the Document Root, but we only want the part that comes *after* the `/pico` subfolder.  Since we can't use `$uri` for this, we're using a Regular Expression (also called "regex") to determine the url for us.  This `location` rule looks for any url that starts with `/pico`, and takes note of whatever comes afterward.  In your own configuration, you'll need to replace `pico` on both lines with the location of your own subfolder.

Since this `location` rule uses regex, it's slightly less efficient then the rule for Pico in Document Root.  While this is unlikely to make a real-world difference, it's something to keep in mind when deciding which rule to use.

#### Regex and Nginx's Processing Order

When we're using a Regular Expression for a `location` block in Nginx, we need to pay close attention to the order of our config.  When analyzing your `location` blocks, Nginx first looks at any absolute locations, then tries to match against any regex rules. When it's trying to match the url to a regex rule, it stops checking after it finds the first matching rule.  The Subfolder rule above is very *very* broad.  It matches *anything* inside the `pico` subfolder.  Because of this, it also matches any `.php` files, `.htaccess`, and any of the folders we denied access to earlier.

This means that the Pico rewrite rule must come **last** in your server configuration.  If any of the other rules we've defined are after it, they will never be used.  Nginx will stop once it gets to the rewrite rule since it will be the first match.

## Advanced Configuration Tips

### Modular Pico Config

Let's say you're a real Pico enthusiast and have several Pico websites running on the same server.  You may get tired of writing all these rules into each and every server configuration.  An easier solution might be to place all the common components (index, access denials, php rules) into a separate file and include it using `include /absolute/path/to/file`.  You could also add the rewrite rule to this file, but a better option would be to include a second file, that way you can chose to include it *only* when Pico is located in your Document Root.

{% comment %}

* Revise previous page example and include php rewrite line

* Include `try_files $uri $uri/ @pico` method?

* Deny `.htaccess` vs 404?

* link to Nginx documetation where "out of scope"
* link entire https://www.digitalocean.com/community/tutorials/apache-vs-nginx-practical-considerations ?

{% endcomment %}
