---
toc:
    run: Run
nav: 3
---

Run
---

You have nothing to consider specially, simply navigate to your Pico install using your favorite web browser. Pico's default contents will explain how to use your brand new, stupidly simple, blazing fast, flat file CMS.

### You don't have a web server?
No worries! Starting with PHP 5.4 the easiest way to get started using Pico is with [PHP's built-in web server][PHPServer].

1. Navigate to Pico's installation directory using a shell.

2. Start PHPs built-in web server:

    ```
    $ php -S 127.0.0.1:8080
    ```

3. Access Pico from [http://localhost:8080](http://localhost:8080).

> Please note that PHPs built-in web server is for *development* and *testing* purposes *only!*

[PHPServer]: http://php.net/manual/en/features.commandline.webserver.php
