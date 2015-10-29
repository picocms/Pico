---
toc:
    upgrade:
        _title: Upgrade
        initialization: Initialization
        routing-system: Routing System
        plugin-system: Plugin System
        tutorial: Tutorial
nav: 5
---

## Upgrade

`Pico 1.0.0-beta.1` brings with it a complete code refactoring and overhaul of the plugin system, countless bug fixes, compatibility with all web servers, and enhanced documentation. Making Pico extremely simple, faster, and more flexible than ever. <sup> * </sup>Best of all, it's completely backwards compatible! Click for a full [change log](https://github.com/picocms/Pico/blob/master/changelog.txt).

Detailed below is some of the most important changes to note when upgrading Pico from a `0.x` release to the new `Pico 1.0.0-beta.1`

### Initialization
Initialization of Pico now works completely different: rather than defining constants (which are probably conflicting with other applications...), Pico now expects its paths to be passed as parameters to the constructor. The constructor doesn't start Picos processing anymore, you now have to call the `Pico::run()` method, which returns the parsed page contents instead of directly echoing them. The `PicoDeprecated` plugin defines the now deprecated constants `ROOT_DIR`, `LIB_DIR` etc., so old plugins can still use them. Those constants are defined before reading `config.php` in Picos root folder, so upgrading users usually aren't bothered with e.g. a `PHP Notice: Use of undefined constant ROOT_DIR - assumed 'ROOT_DIR'` error when using `ROOT_DIR` in their `config.php` (so: no BC break).

New users don't need the constants anymore, relative paths are now always interpreted to be relative to Picos root dir, so `$config['content_dir'] = 'content';` is always sufficient (previously this was depending on the webserver config). All these changes are supposed to improve Picos interoperability with other applications and allows developers to integrate Pico in other applications, therefore there is a newly added `Pico::setConfig()` method to even make the use of a config.php optional.

### Routing System
The new routing system now works out-of-the-box (even without rewriting) with any webserver using the QUERY_STRING routing method. Internal links now look like `?sub/page`, rewriting to basically remove the `?` is still possible and recommended. Contrary to Pico 0.9 every webserver should work just fine. Pico 0.9 required working URL rewriting, so if you want to use old plugins/themes/contents, a working rewrite setup may still be required. If you're not using the default .htaccess, you must update your rewrite rules to follow the new principles. Internal links in content files are declared with `%base_url%?sub/page`. Internal links in templates should be declared using the new link filter (e.g. `{{ "sub/page"|link }}`), what basically calls `Pico::getPageUrl()`

### Plugin System
A whole new plugin system has been implemented while maintaining full backward compatibility. See the class docs of `IPicoPlugin` for details. The new event system supports plugin dependencies as well as some new events. It was necessary to reliably distinct between old and new events, so __all events were renamed__. The new `PicoDeprecated` plugin is crucial for backward compatibility, it's enabled on demand. Refer to its class docs for details.

It is important to note the performance issue with Pico 0.x releases is fixed only when the `PicoParsePagesContent` plugin isn't enabled. It's disabled by default, but gets automatically enabled with `PicoDeprecated` as soon as an old plugin is loaded. This is necessary to maintain backward compatibility. You can still disable it manually by executing` $pico->getPlugin('PicoParsePagesContent')->setEnabled(false);` or adding `$config['PicoParsePagesContent.enabled'] = false;` to your `config.php`.


__That's all fine, but what do I need to do to upgrade?__

### Tutorial
