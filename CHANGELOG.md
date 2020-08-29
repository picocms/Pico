Pico Changelog
==============

**Note:** This changelog only provides technical information about the changes
          introduced with a particular Pico version, and is meant to supplement
          the actual code changes. The information in this changelog are often
          insufficient to understand the implications of larger changes. Please
          refer to both the UPGRADE and NEWS sections of the docs for more
          details.

**Note:** Changes breaking backwards compatibility (BC) are marked with an `!`
          (exclamation mark). This doesn't include changes for which BC is
          preserved by Pico's official `PicoDeprecated` plugin. If a previously
          deprecated feature is later removed in `PicoDeprecated`, this change
          is going to be marked as BC-breaking change in both Pico's and
          `PicoDeprecated`'s changelog. Please note that BC-breaking changes
          are only possible with a new major version.

### Version 2.1.4
Released: 2020-08-29

```
* [Changed] Silence PHP errors in Parsedown
* [Fixed] #560: Improve charset guessing for formatted date strings using
          `strftime()` (Pico always uses UTF-8, but `strftime()` might not)
```

### Version 2.1.3
Released: 2020-07-10

```
* [New] Add `locale` option to `config/config.yml`
* [Changed] Improve Pico docs
```

### Version 2.1.2
Released: 2020-04-10

```
* [Fixed] Fix DummyPlugin declaring API version 3
```

### Version 2.1.1
Released: 2019-12-31

```
* [Fixed] Require Parsedown 1.8.0-beta-7 and Parsedown Extra 0.8.0-beta-1 due
          to changes in Parsedown and Parsedown Extra breaking BC beyond repair
* [Changed] #523: Check for hidden pages based on page ID instead of full paths
* [Changed] Improve Pico docs
```

### Version 2.1.0
Released: 2019-11-24

```
* [Changed] Add Pico's official logo and tagline to `content-sample/_meta.md`
* [Changed] Improve `content-sample/theme.md` to show Pico's official logo and
            the usage of the new image utility classes of Pico's default theme
* [Changed] Improve Pico docs and PHPDoc class docs
```

### Version 2.1.0-beta.1
Released: 2019-11-03

```
* [New] Introduce API version 3
* [New] Add `assets_dir`, `assets_url` and `plugins_url` config params
* [New] Add `%config.*%` Markdown placeholders for scalar config params and the
        `%assets_url%`, `%themes_url%` and `%plugins_url%` placeholders
* [New] Add `content-sample/theme.md` for theme testing purposes
* [New] Introduce API versioning for themes and support theme-specific configs
        using the new `pico-theme.yml` in a theme's directory; `pico-theme.yml`
        allows a theme to influence Pico's Twig config, to register known meta
        headers and to provide defaults for theme config params
* [New] Add `assets_url`, `themes_url` and `plugins_url` Twig variables
* [New] Add `pages` Twig function to deal with Pico's page tree; this function
        replaces the raw usage of Pico's `pages` array in themes
* [New] Add `url` Twig filter to replace URL placeholders (e.g. `%base_url%`)
        in strings using the new `Pico::substituteUrl()` method
* [New] Add `onThemeLoading` and `onThemeLoaded` events
* [New] Add `debug` config param and the `Pico::isDebugModeEnabled()` method,
        checking the `PICO_DEBUG` environment variable, to enable debugging
* [New] Add new `Pico::getNormalizedPath()` method to normalize a path; this
        method should be used to prevent content dir breakouts when dealing
        with paths provided by user input
* [New] Add new `Pico::getUrlFromPath()` method to guess a URL from a file path
* [New] Add new `Pico::getAbsoluteUrl()` method to make a relative URL absolute
* [New] #505: Create pre-built `.zip` release archives
* [Fixed] #461: Proberly handle content files with a UTF-8 BOM
* [Changed] Rename `theme_url` config param to `themes_url`; the `theme_url`
            Twig variable and Markdown placeholder are kept unchanged
* [Changed] Update to Parsedown Extra 0.8 and Parsedown 1.8 (both still beta)
* [Changed] Enable Twig's `autoescape` feature by default; outputting a
            variable now causes Twig to escape HTML markup; Pico's `content`
            variable is a notable exception, as it is marked as being HTML safe
* [Changed] Rename `prev_page` Twig variable to `previous_page`
* [Changed] Mark `markdown` and `content` Twig filters as well as the `content`
            variable as being HTML safe
* [Changed] Add `$singleLine` param to `markdown` Twig filter as well as the
            `Pico::parseFileContent()` method to parse just a single line of
            Markdown input
* [Changed] Add `AbstractPicoPlugin::configEnabled()` method to check whether
            a plugin should be enabled or disabled based on Pico's config
* [Changed] Deprecate the use of `AbstractPicoPlugin::__call()`, use
            `PicoPluginInterface::getPico()` instead
* [Changed] Update to Twig 1.36 as last version supporting PHP 5.3, use a
            Composer-based installation to use a newer Twig version
* [Changed] Add `$basePath` and `$endSlash` params to `Pico::getAbsolutePath()`
* [Changed] Deprecate `Pico::getBaseThemeUrl()`
* [Changed] Replace various `file_exists` calls with proper `is_file` calls
* [Changed] Refactor release & build system
* [Changed] Improve Pico docs and PHPDoc class docs
* [Changed] Various small improvements
* [Removed] Remove superfluous `base_dir` and `theme_dir` Twig variables
* [Removed] Remove `PicoPluginInterface::__construct()`
```

### Version 2.0.5-beta.1
Released: 2019-01-03

```
* [New] Add PHP 7.3 tests
* [New] Add `2.0.x-dev` alias for master branch to `composer.json`
* [Changed] Update to Parsedown Extra 0.8 and Parsedown 1.8 (both still beta)
* [Changed] Improve release & build process
```

### Version 2.0.4
Released: 2018-12-17

```
* [Fixed] Proberly handle hostnames with ports in `Pico::getBaseUrl()`
* [Changed] Improve documentation
```

### Version 2.0.3
Released: 2018-12-03

```
* [Fixed] Support alternative server ports in `Pico::getBaseUrl()`
* [Changed] Don't require server environment variables to be configured
* [Changed] Improve release & build process
* [Changed] Improve documentation
* [Changed] Improve PHP class docs
* [Changed] Various small improvements
```

### Version 2.0.2
Released: 2018-08-12

```
* [Fixed] Support Windows paths (`\` instead of `/`) in `Pico::evaluateRequestUrl()`
```

### Version 2.0.1
Released: 2018-07-29

```
* [Changed] Improve documentation
* [Changed] Add missing "Formatted Date", "Time" and "Hidden" meta headers; use
            the "Hidden" meta header to manually hide a page in the pages list
```

### Version 2.0.0
Released: 2018-07-01

```
* [New] Add Bountysource
* [Changed] Improve documentation
* [Changed] Improve release & build process
* [Changed] Add `Pico::setConfig()` example to `index.php.dist`
* [Fixed] Don't load `config/config.yml` multiple times
```

### Version 2.0.0-beta.3
Released: 2018-04-07

```
* [Changed] Add `README.md`, `CONTRIBUTING.md` and `CHANGELOG.md` of main repo
            to pre-bundled releases, keep `.gitignore`
* [Changed] Deny access to a possibly existing `composer.phar` in `.htaccess`
* [Changed] Disallow the use of the `callback` filter for the `url_param` and
            `form_param` Twig functions
* [Changed] Improve documentation
* [Fixed] Fix page tree when sorting pages by arbitrary values
* [Fixed] Fix sorting of `Pico::$nativePlugins`
```

### Version 2.0.0-beta.2
Released: 2018-01-21

```
* [New] Improve release & build process and move most build tools to the new
        `picocms/ci-tools` repo, allowing them to be used by other projects
* [New] Add page tree; refer to the `Pico::buildPageTree()` method for more
        details; also see the `onPageTreeBuilt` event
* [Changed] Update dependencies: Twig 1.35
* [Changed] ! Improve `.htaccess` and deny access to all dot files by default
* [Changed] ! Throw a `RuntimeException` when non-native plugins are loaded,
            but Pico's `PicoDeprecated` plugin is not loaded
* [Changed] ! Change `AbstractPicoPlugin::$enabled`'s behavior: setting it to
            TRUE now leads to throwing a `RuntimeException` when the plugin's
            dependencies aren't fulfilled; use NULL to maintain old behavior
* [Changed] ! Force themes to use `.twig` as file extension for Twig templates
* [Changed] Improve PHP class docs
* [Changed] Various small improvements
```

### Version 2.0.0-beta.1
Released: 2017-11-05

```
* [New] Pico is on its way to its second major release!
* [New] Improve Pico's release & build process
* [New] Add "Developer Certificate of Origin" to `CONTRIBUTING.md`
* [New] Add license & copyright header to all relevant files
* [New] Add Pico version constants (`Pico::VERSION` and `Pico::VERSION_ID`),
        and add a `version` Twig variable and `%version%` Markdown placeholder
* [New] Add Pico API versioning for plugins (see `Pico::API_VERSION` constant);
        Pico now triggers events on plugins using the latest API version only
        ("native" plugins), `PicoDeprecated` takes care of all other plugins;
        as a result, old plugin's always depend on `PicoDeprecated` now
* [New] Add a theme and plugin installer for composer; Pico now additionally
        uses the new `vendor/pico-plugin.php` file to discover plugins
        installed by composer and loads them using composer's autoloader;
        see the `picocms/composer-installer` repo for more details; Pico
        loads plugins installed by composer first and ignores conflicting
        plugins in Pico's `plugins/` dir
* [New] Add `$enableLocalPlugins` parameter to `Pico::__construct()` to allow
        website developers to disable local plugin discovery by scanning the
        `plugins/` dir (i.e. load plugins from `vendor/pico-plugin.php` only)
* [New] Add public `AbstractPicoPlugin::getPluginConfig()` method
* [New] Add public `Pico::loadPlugin()` method and the corresponding
        `onPluginManuallyLoaded` event
* [New] Add public `Pico::resolveFilePath()` method (replaces the protected
        `Pico::discoverRequestFile()` method)
* [New] Add public `Pico::is404Content()` method
* [New] Add public `Pico::getYamlParser()` method and the corresponding
        `onYamlParserRegistered` event
* [New] Add public `Pico::substituteFileContent()` method
* [New] Add public `Pico::getPageId()` method
* [New] Add public `Pico::getFilesGlob()` method
* [New] Add public `Pico::getVendorDir()` method, returning Pico's installation
        directory (i.e. `/var/www/pico/vendor/picocms/pico`); don't confuse
        this with composer's `vendor/` dir!
* [New] Add `$default` parameter to `Pico::getConfig()` method
* [New] Add empty `assets/` and `content/` dirs
* [New] #305: Add `url_param` and `form_param` Twig functions, and the public
        `Pico::getUrlParameter()` and `Pico::getFormParameter()` methods,
        allowing theme developers to access URL GET and HTTP POST parameters
* [New] Add `$meta` parameter to `markdown` Twig filter
* [New] Add `remove` fallback to `sort_by` Twig filter
* [New] Add `theme_url` config parameter
* [New] Add public `Pico::getBaseThemeUrl()` method
* [New] Add `REQUEST_URI` routing method, allowing one to simply rewrite all
        requests to `index.php` (e.g. use `FallbackResource` or `mod_rewrite`
        in your `.htaccess` for Apache, or use `try_files` for nginx)
* [New] #299: Add built-in 404 page as fallback when no `404.md` is found
* [New] Allow sorting pages by arbitrary meta values
* [New] Add `onSinglePageLoading` event, allowing one to skip a page
* [New] Add `onSinglePageContent` event
* [New] Add some config parameters to change Parsedown's behavior
* [Changed] ! Disallow running the same Pico instance multiple times by
            throwing a `RuntimeException` when calling `Pico::run()`
* [Changed] ! #203: Load plugins from `plugins/<plugin name>/<plugin name>.php`
            and `plugins/<plugin name>.php` only (directory and file name must
            match case-sensitive), and throw a `RuntimeException` when Pico is
            unable to load a plugin; also throw a `RuntimeException` when
            superfluous files or directories in `plugins/` are found; use a
            scope-isolated `require()` to include plugin files
* [Changed] ! Use a plugin dependency topology to sort `Pico::$plugins`,
            changing the execution order of plugins so that plugins, on which
            other plugins depend, are always executed before their dependants
* [Changed] ! Don't pass `$plugins` parameter to `onPluginsLoaded` event by
            reference anymore; use `Pico::loadPlugin()` instead
* [Changed] ! Leave `Pico::$pages` unsorted when a unknown sort method was
            configured; this usually means that a plugin wants to sort it
* [Changed] Overhaul page discovery events: add `onPagesDiscovered` event which
            is triggered right before `Pico::$pages` is sorted and move the
            `$currentPage`, `$previousPage` and `$nextPage` parameters of the
            `onPagesLoaded` event to the new `onCurrentPageDiscovered` event
* [Changed] Move the `$twig` parameter of the `onPageRendering` event to the
            `onTwigRegistered` event, replacing the `onTwigRegistration` event
* [Changed] Unify the `onParsedownRegistration` event by renaming it to
            `onParsedownRegistered` and add the `$parsedown` parameter
* [Changed] #330: Replace `config/config.php` by a modular YAML-based approach;
            you can now use a arbitrary number of `config/*.yml` files to
            configure Pico
* [Changed] ! When trying to auto-detect Pico's `content` dir, Pico no longer
            searches just for a (possibly empty) directory, but rather checks
            whether a `index.md` exists in this directory
* [Changed] ! Use the relative path between `index.php` and `Pico::$themesDir`
            for Pico's theme URL (also refer to the new `theme_url` config and
            the public `Pico::getBaseThemeUrl()` method for more details)
* [Changed] #347: Drop the superfluous trailing "/index" from Pico's URLs
* [Changed] Flip registered meta headers array, so that the array key is used
            to search for a meta value and the array value is used to store the
            found meta value (previously it was the other way round)
* [Changed] ! Add lazy loading for `Pico::$yamlParser`, `Pico::$parsedown` and
            `Pico::$twig`; the corresponding events are no longer part of
            Pico's event flow and are triggered on demand
* [Changed] ! Trigger the `onMetaHeaders` event just once; the event is no
            longer part of Pico's event flow and is triggered on demand
* [Changed] Don't lower meta headers on the first level of a page's meta data
            (i.e. `SomeKey: value` is accessible using `$meta['SomeKey']`)
* [Changed] Don't compare registered meta headers case-insensitive, require
            matching case
* [Changed] Allow users to explicitly set values for the `date_formatted` and
            `time` meta headers in a page's YAML front matter
* [Changed] Add page siblings for all pages
* [Changed] ! Treat pages or directories that are prefixed by `_` as hidden;
            when requesting a hidden page, Pico responds with a 404 page;
            hidden pages are still in `Pico::$pages`, but are moved to the end
            of the pages array when sorted alphabetically or by date
* [Changed] ! Don't treat explicit requests to a 404 page as successful request
* [Changed] Change method visibility of `Pico::getFiles()` to public
* [Changed] Change method visibility of `Pico::triggerEvent()` to public;
            at first glance this method triggers events on native plugins only,
            however, `PicoDeprecated` takes care of triggering events for other
            plugins, thus you can use this method to trigger (custom) events on
            all plugins; never use it to trigger Pico core events!
* [Changed] Move Pico's default theme to the new `picocms/pico-theme` repo; the
            theme was completely rewritten from scratch and is a much better
            starting point for creating your own theme; refer to the theme's
            `CHANGELOG.md` for more details
* [Changed] Move `PicoDeprecated` plugin to the new `picocms/pico-deprecated`
            repo; refer to the plugin's `CHANGELOG.md` for more details
* [Changed] Update dependencies: Twig 1.34, Symfony YAML 2.8, Parsedown 1.6
* [Changed] Improve Pico docs and PHP class docs
* [Changed] A vast number of small improvements and changes...
* [Removed] ! Remove `PicoParsePagesContent` plugin
* [Removed] ! Remove `PicoExcerpt` plugin
* [Removed] Remove `rewrite_url` and `is_front_page` Twig variables
* [Removed] Remove superfluous parameters of various events to reduce Pico's
            error-proneness (plugins hopefully interfere with each other less)
```

### Version 1.0.6
Released: 2017-07-25

```
* [Changed] Improve documentation
* [Changed] Improve handling of Pico's Twig config (`$config['twig_config']`)
* [Changed] Improve PHP platform requirement checks
```

### Version 1.0.5
Released: 2017-05-02

```
* [Changed] Improve documentation
* [Fixed] Improve hostname detection with proxies
* [Fixed] Fix detection of Windows-based server environments
* [Removed] Remove Twitter links
```

### Version 1.0.4
Released: 2016-10-04

```
* [New] Add Pico's social icons to default theme
* [Changed] Improve documentation
* [Changed] Add CSS flexbox rules to default theme
* [Fixed] Fix handling of non-YAML 1-line front matters
* [Fixed] Fix responsiveness in default theme
```

### Version 1.0.3
Released: 2016-05-11

```
* [Changed] Improve documentation
* [Changed] Heavily extend nginx configuration docs
* [Changed] Add CSS rules for definition lists to default theme
* [Changed] Always use `on404Content...` execution path when serving a `404.md`
* [Changed] Deny access to `.git` directory, `CHANGELOG.md`, `composer.json`
            and `composer.lock` (`.htaccess` file)
* [Changed] Use Pico's `404.md` to deny access to `.git`, `config`, `content`,
*           `content-sample`, `lib` and `vendor` dirs (`.htaccess` file)
* [Fixed] #342: Fix responsiveness in default theme
* [Fixed] #344: Improve HTTPS detection with proxies
* [Fixed] #346: Force HTTPS to load Google Fonts in default theme
```

### Version 1.0.2
Released: 2016-03-16

```
* [Changed] Various small improvements and changes...
* [Fixed] Check dependencies when a plugin is enabled by default
* [Fixed] Allow `Pico::$requestFile` to point to somewhere outside `content_dir`
* [Fixed] #336: Fix `Date` meta header parsing with ISO-8601 datetime strings
```

### Version 1.0.1
Released: 2016-02-27

```
* [Changed] Improve documentation
* [Changed] Replace `version_compare()` with `PHP_VERSION_ID` in
            `index.php.dist` (available since PHP 5.2.7)
* [Fixed] Suppress PHP warning when using `date_default_timezone_get()`
* [Fixed] #329: Force Apache's `MultiViews` feature to be disabled
```

### Version 1.0.0
Released: 2015-12-24

```
* [New] On Christmas Eve, we are happy to announce Pico's first stable release!
        The Pico Community wants to thank all contributors and users who made
        this possible. Merry Christmas and a Happy New Year 2016!
* [New] Adding `$queryData` parameter to `Pico::getPageUrl()` method
* [Changed] Improve documentation
* [Changed] Moving `LICENSE` to `LICENSE.md`
* [Changed] Throw `LogicException` instead of `RuntimeException` when calling
            `Pico::setConfig()` after processing has started
* [Changed] Default theme now highlights the current page and shows pages with
            a title in the navigation only
* [Changed] #292: Ignore YAML parse errors (meta data) in `Pico::readPages()`
* [Changed] Various small improvements and changes...
* [Fixed] Support empty meta header
* [Fixed] #307: Fix path handling on Windows
```

### Version 1.0.0-beta.2
Released: 2015-11-30

```
* [New] Introducing the `PicoTwigExtension` Twig extension
* [New] New `markdown` filter for Twig to parse markdown strings; Note: If you
        want to parse the contents of a page, use the `content` filter instead
* [New] New `sort_by` filter to sort an array by a specified key or key path
* [New] New `map` filter to get the values of the given key or key path
* [New] Introducing `index.php.dist` (used for pre-bundled releases)
* [New] Use PHP_CodeSniffer to auto-check source code (see `.phpcs.xml`)
* [New] Use Travis CI to generate phpDocs class docs automatically
* [Changed] Improve documentation
* [Changed] Improve table styling in default theme
* [Changed] Update composer version constraints; almost all dependencies will
            have pending updates, run `composer update`
* [Changed] Throw a RuntimeException when the `content` dir isn't accessible
* [Changed] Reuse `ParsedownExtra` object; new `onParsedownRegistration` event
* [Changed] `$config['rewrite_url']` is now always available
* [Changed] `DummyPlugin` class is now final
* [Changed] Remove `.git` dirs from `vendor/` when deploying
* [Changed] Various small improvements and changes...
* [Fixed] `PicoDeprecated`: Sanitize `content_dir` and `base_url` options when
          reading `config.php` in Picos root dir
* [Fixed] Replace `urldecode()` (deprecated RFC 1738) with `rawurldecode()`
          (RFC 3986) in `Page::evaluateRequestUrl()`
* [Fixed] #272: Encode URLs using `rawurlencode()` in `Pico::getPageUrl()`
* [Fixed] #274: Prevent double slashes in `base_url`
* [Fixed] #285: Make `index.php` work when installed as a composer dependency
* [Fixed] #291: Force `Pico::$requestUrl` to have no leading/trailing slash
```

### Version 1.0.0-beta.1
Released: 2015-11-06

```
* [Security] (9e2604a) Prevent content_dir breakouts using malicious URLs
* [New] Pico is on its way to its first stable release!
* [New] Provide pre-bundled releases
* [New] Heavily expanded documentation (inline code docs, user docs, dev docs)
* [New] New routing system using the QUERY_STRING method; Pico now works
        out-of-the-box with any webserver and without URL rewriting; use
        `%base_url%?sub/page` in markdown files and `{{ "sub/page"|link }}`
        in Twig templates to declare internal links
* [New] Brand new plugin system with dependencies (see `PicoPluginInterface`
        and `AbstractPicoPlugin`); if you're plugin dev, you really should
        take a look at the UPGRADE section of the docs!
* [New] Introducing the `PicoDeprecated` plugin to maintain full backward
        compatibility with Pico 0.9 and Pico 0.8
* [New] Support YAML-style meta header comments (`---`)
* [New] Various new placeholders to use in content files (e.g. `%site_title%`)
* [New] Provide access to all meta headers in content files (`%meta.*%`)
* [New] Provide access to meta headers in `$page` arrays (`$page['meta']`)
* [New] The file extension of content files is now configurable
* [New] Add `Pico::setConfig()` method to predefine config variables
* [New] Supporting per-directory `404.md` files
* [New] #103: Providing access to `sub.md` even when the `sub` directory
        exists, provided that there is no `sub/index.md`
* [New] #249: Support the `.twig` file extension for templates
* [New] #268, 269: Now using Travis CI; performing basic code tests and
        implementing an automatic release process
* [Changed] Complete code refactoring
* [Changed] Source code now follows PSR code styling
* [Changed] Replacing constants (e.g. `ROOT_DIR`) with constructor parameters
* [Changed] Paths (e.g. `content_dir`) are now relative to Pico's root dir
* [Changed] Adding `Pico::run()` method that performs Pico's processing and
            returns the rendered contents
* [Changed] Renaming all plugin events; adding some new events
* [Changed] `Pico_Plugin` is now the fully documented `DummyPlugin`
* [Changed] Meta data must start on the first line of the file now
* [Changed] Dropping the need to register meta headers for the convenience of
            users and pure (!) theme devs; plugin devs are still REQUIRED to
            register their meta headers during `onMetaHeaders`
* [Changed] Exclude inaccessible files from pages list
* [Changed] With alphabetical order, index files (e.g. `sub/index.md`) are
            now always placed before their sub pages (e.g. `sub/foo.md`)
* [Changed] Pico requires PHP >= 5.3.6 (due to `erusev/parsedown-extra`)
* [Changed] Pico now implicitly uses a existing `content` directory without
            the need to configure this in the `config/config.php` explicitly
* [Changed] Composer: Require a v0.7 release of `erusev/parsedown-extra`
* [Changed] Moving `license.txt` to `LICENSE`
* [Changed] Moving and reformatting `changelog.txt` to `CHANGELOG.md`
* [Changed] #116: Parse meta headers using the Symfony YAML component
* [Changed] #244: Replace opendir() with scandir()
* [Changed] #246: Move `config.php` to `config/` directory
* [Changed] #253: Assume HTTPS if page is requested through port 443
* [Changed] A vast number of small improvements and changes...
* [Fixed] Sorting by date now uses timestamps and works as expected
* [Fixed] Fixing `$currentPage`, `$nextPage` and `$previousPage`
* [Fixed] #99: Support content filenames with spaces
* [Fixed] #140, #241: Use file paths as page identifiers rather than titles
* [Fixed] #248: Always set a timezone; adding `$config['timezone']` option
* [Fixed] A vast number of small bugs...
* [Removed] Removing the default Twig cache dir
* [Removed] Removing various empty `index.html` files
* [Removed] Removing `$pageData['excerpt']`; recoverable with `PicoExcerpt`
* [Removed] #93, #158: Pico doesn't parse all content files anymore; moved to
            `PicoParsePagesContent`; i.e. `$pageData['content']` doesn't exist
            anymore, use `$pageData['raw_content']` when possible; otherwise
            use Twigs new `content` filter (e.g. `{{ "sub/page"|content }}`)
```

### Version 0.9
Released: 2015-04-28

```
* [New] Default theme is now mobile-friendly
* [New] Description meta now available in content areas
* [New] Add description to composer.json
* [Changed] content folder is now content-sample
* [Changed] config.php moved to config.php.template
* [Changed] Updated documentation & wiki
* [Changed] Removed Composer, Twig files in /vendor, you must run composer
            install now
* [Changed] Localized date format; strftime() instead of date()
* [Changed] Added ignore for tmp file extensions in the get_files() method
* [Changed] michelf/php-markdown is replaced with erusev/parsedown-extra
* [Changed] $config is no global variable anymore
* [Fixed] Pico now only removes the 1st comment block in .md files
* [Fixed] Issue wherein the alphabetical sorting of pages did not happen
```

### Version 0.8
Released: 2013-10-23

```
* [New] Added ability to set template in content meta
* [New] Added before_parse_content and after_parse_content hooks
* [Changed] content_parsed hook is now deprecated
* [Changed] Moved loading the config to nearer the beginning of the class
* [Changed] Only append ellipsis in limit_words() when word count exceeds max
* [Changed] Made private methods protected for better inheritance
* [Fixed] Fixed get_protocol() method to work in more situations
```

### Version 0.7
Released: 2013-09-04

```
* [New] Added before_read_file_meta and get_page_data plugin hooks to customize
        page meta data
* [Changed] Make get_files() ignore dotfiles
* [Changed] Make get_pages() ignore Emacs and temp files
* [Changed] Use composer version of Markdown
* [Changed] Other small tweaks
* [Fixed] Date warnings and other small bugs
```

### Version 0.6.2
Released: 2013-05-07

```
* [Changed] Replaced glob_recursive with get_files
```

### Version 0.6.1
Released: 2013-05-07

```
* [New] Added "content" and "excerpt" fields to pages
* [New] Added excerpt_length config setting
```

### Version 0.6
Released: 2013-05-06

```
* [New] Added plugin functionality
* [Changed] Other small cleanup
```

### Version 0.5
Released: 2013-05-03

```
* [New] Added ability to order pages by "alpha" or "date" (asc or desc)
* [New] Added prev_page, current_page, next_page and is_front_page template vars
* [New] Added "Author" and "Date" title meta fields
* [Changed] Added "twig_config" to settings
* [Changed] Updated documentation
* [Fixed] Query string 404 bug
```

### Version 0.4.1
Released: 2013-05-01

```
* [New] Added CONTENT_EXT global
* [Changed] Use .md files instead of .txt
```

### Version 0.4
Released: 2013-05-01

```
* [New] Add get_pages() function for listing content
* [New] Added changelog.txt
* [Changed] Updated default theme
* [Changed] Updated documentation
```

### Version 0.3
Released: 2013-04-27

```
* [Fixed] get_config() function
```

### Version 0.2
Released: 2013-04-26

```
* [Changed] Updated Twig
* [Changed] Better checking for HTTPS
* [Fixed] Add 404 header to 404 page
* [Fixed] Case sensitive folder bug
```

### Version 0.1
Released: 2012-04-04

```
* Initial release
```
