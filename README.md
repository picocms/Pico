Pico
====

Pico is a stupidly simple, blazing fast, flat file CMS. See http://pico.dev7studios.com for more info.




###Running Pico on lighttpd

```
$HTTP["host"] == "mysite.com" {
    url.rewrite-once = (
        "^/pico/content/(.*)\.md" => "/pico/index.php"
    )

    url.rewrite-if-not-file = (
        "^/pico/(.*)$" => "/pico/index.php"
    )
}
```
