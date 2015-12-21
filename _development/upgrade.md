---
toc:
    migrating-from-0x-to-10:
        _title: Migrating Pico 0.X to 1.0
        migrating-plugins: Migrating plugins
        initialization: Initialization
nav: 4
---

## Migrating from 0.X to 1.0

### Initialization

Initialization of Pico now works completely different: rather than defining constants (which are probably conflicting with other applications...), Pico now expects its paths to be passed as parameters to Pico's [constructor method]({{ site.github.url }}/phpDoc/master/classes/Pico.html#method___construct). The constructor doesn't start Pico's processing anymore, you now have to call the [`Pico::run()`]({{ site.github.url }}/phpDoc/master/classes/Pico.html#method_run) method, which returns the parsed page contents instead of directly echoing them. The [`PicoDeprecated`]({{ site.gh_project_url }}/blob/{{ site.gh_project_branch }}/plugins/00-PicoDeprecated.php) plugin defines the now deprecated constants `ROOT_DIR`, `LIB_DIR` etc., so old plugins can still use them. Those constants are defined before reading `config.php` in Pico's root folder, so upgrading users usually aren't bothered with e.g. a `PHP Notice: Use of undefined constant ROOT_DIR - assumed 'ROOT_DIR'` error when using `ROOT_DIR` in their `config.php` (so: no BC break). This change is reflected in the new [`index.php`]({{ site.gh_project_url }}/blob/{{ site.gh_project_branch }}/index.php) file.

New users don't need the constants anymore, relative paths are now always interpreted to be relative to Pico's root directory, so `$config['content_dir'] = 'content';` is always sufficient (previously this was depending on the webserver config). All these changes are supposed to improve Pico's interoperability with other applications and allows developers to integrate Pico in other applications, therefore there is a newly added [`Pico::setConfig()`]({{ site.github.url }}/phpDoc/master/classes/Pico.html#method_setConfig) method to even make the use of a `config.php` optional.

### Migrating plugins

A whole new plugin system has been implemented while maintaining full backward compatibility. See the class docs of [PicoPluginInterface]({{ site.github.url }}/phpDoc/master/classes/PicoPluginInterface.html) for details. The new event system supports plugin dependencies as well as some new events. It was necessary to reliably distinct between old and new events, so __all events were renamed__. The new [PicoDeprecated]({{ site.gh_project_url }}/blob/{{ site.gh_project_branch }}/plugins/00-PicoDeprecated.php) plugin is crucial for backward compatibility, it's enabled on demand. Refer to its class docs for details.

You will be able to set an enabled/disabled state by default as well. If you have previously created a plugin for Pico, it is *HIGHLY* recommended that you update your class to extend from [AbstractPicoPlugin]({{ site.github.url }}/phpDoc/master/classes/AbstractPicoPlugin.html) and use the new events to avoid activating the [PicoDeprecated]({{ site.gh_project_url }}/blob/{{ site.gh_project_branch }}/plugins/00-PicoDeprecated.php) plugin.

| Event               | ... triggers the deprecated event                         |
| ------------------- | --------------------------------------------------------- |
| onPluginsLoaded     | plugins_loaded()                                          |
| onConfigLoaded      | config_loaded($config)                                    |
| onRequestUrl        | request_url($url)                                         |
| onContentLoading    | before_load_content($file)                                |
| onContentLoaded     | after_load_content($file, $rawContent)                    |
| on404ContentLoading | before_404_load_content($file)                            |
| on404ContentLoaded  | after_404_load_content($file, $rawContent)                |
| onMetaHeaders       | before_read_file_meta($headers)                           |
| onMetaParsed        | file_meta($meta)                                          |
| onContentParsing    | before_parse_content($rawContent)                         |
| onContentParsed     | after_parse_content($content)                             |
| onContentParsed     | content_parsed($content)                                  |
| onSinglePageLoaded  | get_page_data($pages, $meta)                              |
| onPagesLoaded       | get_pages($pages, $currentPage, $previousPage, $nextPage) |
| onTwigRegistration  | before_twig_register()                                    |
| onPageRendering     | before_render($twigVariables, $twig, $templateName)       |
| onPageRendered      | after_render($output)                                     |
