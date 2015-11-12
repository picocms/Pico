Pico Changelog
==============

### Version 1.0.0
Released: -

```
* [New] This is Picos first stable release! The Pico Community wants to thank
        all contributors and users which made this possible!
* [New] New `markdown` filter for Twig to parse markdown strings; Note: If you
        want to parse the contents of a page, use the `content` filter instead
* [Changed] Reuse `ParsedownExtra` object; new `onParsedownRegistration` event
* [Fixed] Replace `urldecode()` (deprecated RFC 1738) with `rawurldecode()`
          (RFC 3986) in `Page::evaluateRequestUrl()`
* [Fixed] #272: Encode URLs using `rawurlencode()` in `Pico::getPageUrl()`
```

### Version 1.0.0-beta.1
Released: 2015-11-06

**Note:** This changelog only provides basic information about the enormous
          changes introduced with Pico 1.0.0-beta.1. Please refer to the
          UGPRADE section of the docs for details.

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
