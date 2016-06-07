---
toc:
    run: Run
nav: 3
---

## Run

You have nothing to consider specially, simply navigate to your Pico install using your favorite web browser. Pico's default contents will explain how to use your brand new, stupidly simple, blazing fast, flat file CMS.

### You don't have a web server?
Starting with PHP 5.4 the easiest way to *try* Pico is using PHP's own [built-in web server][PHPServer]. **Please Note** that PHP's built-in web server is for development and testing purposes only!  It is **not** suitable for production use.

* If you decide you like Pico, but need help setting up a more permanent solution, please see our [some section below about server configuration]().
* Also, only mentioning PHP's internal server seems a bit like a wasted page.  Do we even need a "Run" section?


* If they don't have a web server, perhaps we should recommend one or link to a guide for setting up their own.
* I feel like not using PHP's internal web server should be more emphasized... or maybe not even recommended in the first place...
* Wait... if they don't have a web server... why do they have PHP?  Why not just recommend downloading Apache or something?*
  * To be honest, I have no idea what installing Apache on Windows would look like.  I guess you'd probably need to download PHP separately or something.  Sometimes I forget how backwards they do things. ;P

#### Step 1
Navigate to Pico's installation directory using a shell.

#### Step 2
Start PHPs built-in web server:
<pre><code>$ php -S 127.0.0.1:8080</code></pre>

#### Step 3
Access Pico from http://localhost:8080.

[PHPServer]: http://php.net/manual/en/features.commandline.webserver.php
