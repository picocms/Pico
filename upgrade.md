---
layout: docs
title: Upgrade
headline: Upgrade Pico 0.X to Pico 1.0
description: We have worked hard to make the upgrade process to Pico 1.0 as easy as possible - and we think we made the grade.
toc:
    how-to-upgrade:
        _title: How to Upgrade
        for-users:
            _title: For Users
            general-instructions: General Instructions
            additional-information: Additional Information
            routing-system: Routing System
            ensure-restricted-access-to-content-directory: Ensure restricted access to `content` directory
        for-theme-designers:
            _title: For Theme Designers
            routing-system-1: Routing System
            drop-of--pagecontent--and-the-new-picoparsepagescontent-plugin: Drop of `{{ page.content }}`
            drop-of--pageexcerpt--and-the-new-picoexcerpt-plugin: Drop of `{{ page.excerpt }}`
        for-plugin-developers: For Plugin Developers
    whats-new:
        _title: What's New
        initialization: Initialization
        routing-system-2: Routing System
        plugin-system: Plugin System
        changelog: Changelog
nav-url: /docs.html
gh_release: v1.0.0
---

We worked hard to make the upgrade process to Pico 1.0 as easy as possible.  As a user, you shouldn't have to consider anything special when upgrading a existing Pico 0.8 or 0.9 installation to Pico 1.0.  Nevertheless you should always make sure you __create a backup of your Pico installation before upgrading__. You can follow the regular [Upgrade instructions][UpgradeInstructions] as if we updated the `MINOR` version.  For convenience, these instructions are also provided below, as well as additional steps for power-users and theme designers.

If you have a question about one of the new features of Pico 1.0, or about Pico in general, please check out the [Getting Help][GettingHelp] section of the docs and don't be afraid to open a new [Issue][Issues] on GitHub.

## How to Upgrade

### For Users

#### General Instructions

1. Create a backup of your Pico installation. You will need the files later!
2. Empty your installation directory and [install Pico ordinarily][InstallInstructions].
3. Copy the `config.php` from your backup to `config/config.php`. You don't have to change anything in this file.
4. Copy the `content` folder from your backup to Pico's installation directory. As a optional step, you can (but aren't required to) make your content files compatible with Pico's new routing system. You'll find detailed instructions on how to do this in the [Routing System](#routing-system) section below.
5. If applicable, also copy the folder of your custom theme within the `themes` directory of your backup to the `themes` folder of your Pico installation. Again you can (but aren't required to) make your theme compatible with Pico's new routing system.  Some themes may need to be modified for `Pico 1.0`, see the section [For Theme Designers](#for-theme-designers) below if you experience issues.
6. Provided that you're using plugins, also copy all of your plugins from the `plugins` directory. Don't copy the `plugins/pico_plugin.php` - this is not a real plugin, but Pico's old dummy plugin.

#### Additional Information

Pico 1.0 introduces a brand new routing system that is now compatible to any webserver. Even URL rewriting has become optional. If you don't use the `.htaccess` file provided by Pico, you must update your rewriting rules to let the webserver rewrite internal links correctly. URLs like `http://example.com/pico/sub/page` must now be rewritten to `/pico/?sub/page`. Please refer to Pico's [`.htaccess` file][RewriteFile] and the [corresponding section in the docs][RewriteDocs].

A potential source of problems for users with custom themes is the removal of `{% raw %}{{ page.content }}{% endraw %}` and `{% raw %}{{ page.excerpt }}{% endraw %}`. As long as you use old plugins, the newly introduced `PicoDeprecated` plugin ensures the further availability of these variables. However, this plugin won't get enabled when all of your plugins were updated to Pico 1.0. Furthermore we will drop the auto provision of `{% raw %}{{ page.content }}{% endraw %}` and `{% raw %}{{ page.excerpt }}{% endraw %}` with Pico 1.1. If you're using one of these variables in your theme, we highly recommend you to take the steps described in the [Drop of `{% raw %}{{ page.content }}{% endraw %}`](#drop-of--pagecontent--and-the-new-picoparsepagescontent-plugin) and [Drop of `{% raw %}{{ page.excerpt }}{% endraw %}`](#drop-of--pageexcerpt--and-the-new-picoexcerpt-plugin) sections below.

Besides the bigger new features (and their implications regarding a upgrade) explained below, Pico also introduces a vast number of smaller improvements and changes.

* Sorting pages by date now works as expected. With alphabetical sorting, index files (e.g. `sub/index.md`) are now always placed before their sub pages (e.g. `sub/foo.md`). You should ensure that your pages are still sorted as desired after updating.
* Paths (e.g. `$config['content_dir']` in your `config/config.php`) are now always interpreted to be relative to Pico's root directory. Make sure your paths are still correct!
* You can now use the YAML Front Matter syntax in Markdown files to enclose meta headers (`--- ... ---`) instead of C-style block comments (`/* ... */`). Make sure that your meta headers start on the first line of the file, otherwise they will be ignored!
* Meta headers are now parsed by the [YAML component][SymfonyYAML] of the [Symfony project][Symfony] and it isn't necessary to register new headers during the `onMetaHeaders` event anymore. The implicit availability of headers is supposed to be used by users and *pure* theme designers only. Therefore you can remove plugins whose only objective is to make custom Meta headers available.

#### Routing System

You are not required to update your internal links to meet the new routing system requirements, as long as you keep URL rewriting enabled.  If, however, you want to have the option to disable URL rewriting later, you should update your links.

In Markdown files (i.e. your `content` directory), replace all occurrences of e.g. `%base_url%/sub/page` with `%base_url%?sub/page`. If you're linking to the main page (i.e. just `%base_url%`), you either shouldn't change anything or replace it with `%base_url%?index` - even this isn't absolutely necessary. Pico replaces the `%base_url%` variable the same as always, but also removes the `?` when URL rewriting is enabled.

To see how these changes affect custom themes, see the [For Theme Designers](#routing-system-1) section below.

Please note that plugins or themes, which haven't been updated to Pico 1.0 yet, could force you to keep URL rewriting enabled.

#### Ensure restricted access to `content` directory

With Pico 1.0 we removed some empty `index.html` files, whose object was to prevent directory listing. However, directory listing doesn't address the security concerns in whole. Our `.htaccess` file already tries to achieve this automatically, nevertheless you should ensure that your webserver (especially when you're not using Apache) is configured as recommended.

Please make sure directory listing is disabled and users cannot browse to the `config`, `content`, `content-sample`, `lib` and `vendor` directories. Try it yourself by browsing to both your `lib` directory (e.g. `http://example.com/pico/lib/`) and `lib/Pico.php` file (e.g. `http://example.com/pico/lib/Pico.php`) - your webserver should either report `404 Not Found` or `403 Forbidden`.

If you were previously hosting content (images, downloads, etc.) inside your content directory, we'd recommended moving it to a dedicated `assets` directory in your Pico root and updating your links accordingly.

### For Theme Designers

#### Routing System

In Theme files (i.e. a custom theme folder in Pico's `themes` directory), required changes are quite similar to content changes.  Instead of using `{% raw %}{{ base_url }}{% endraw %}` directly, use the newly introduced `link` filter. Again, you can, but aren't required to make changes as long as you keep URL rewriting enabled.  Either don't change links to the main page (i.e. just `{% raw %}{{ base_url }}{% endraw %}`) or replace them with `{% raw %}{{ "index"|link }}{% endraw %}`. The `link` filter simply calls the [`Pico::getPageUrl()` method][PicoGetPageUrl].

#### Drop of `{% raw %}{{ page.content }}{% endraw %}` and the new `PicoParsePagesContent` plugin

With Version 0.6.1 Pico started parsing the Markdown contents of all pages. While making some things easier (like generating excerpts), this heavily impacted performance with a larger number of pages (e.g. blog posts). By popular request we removed this feature with Pico 1.0 and therefore significantly improved performance.

If you're using the `{% raw %}{{ page.content }}{% endraw %}` variable in your custom theme, you should at least replace it with `{% raw %}{{ page.id|content }}{% endraw %}`. We highly recommend you to over think the need to use the parsed page contents, it's likely that the raw page contents (`{% raw %}{{ page.raw_content }}{% endraw %}`) will fulfill your needs.

With Pico 1.0 we also introduced the `PicoParsePagesContent` plugin, whose objective is to parse the contents of all pages as it has since Pico 0.6.1. The plugin is disabled by default, but gets automatically enabled with `PicoDeprecated` when a plugin, that wasn't updated to Pico 1.0 yet, is loaded. Please note that we'll remove this automatic activation with Pico 1.1, so you will need to enable it manually.

We highly recommend you force the `PicoParsePagesContent` plugin to be disabled by adding `$config['PicoParsePagesContent.enabled'] = false;` to your `config/config.php`.

#### Drop of `{% raw %}{{ page.excerpt }}{% endraw %}` and the new `PicoExcerpt` plugin

The main reason Pico started parsing the Markdown contents of all pages (see above), was the desire for automatically generated page excerpts. We later realized that this is the wrong approach, then started searching for alternatives - and we think we found a good solution!

Given that you're using the `{% raw %}{{ page.excerpt }}{% endraw %}` variable in your custom theme, we recommend you part from the concept of automatically generated excerpts. Instead, you should use the `Description` meta header to write excerpts on your own. Starting with Pico 1.0 you can use `%meta.*%` placeholders in your Markdown files, so you don't have to repeat yourself - simply add `%meta.description%` to the page content and Pico will replace it with your excerpt.

As with `{% raw %}{{ page.content }}{% endraw %}` and the `PicoParsePagesContent` plugin, we also introduced the `PicoExcerpt` plugin, which continues to provide the `{% raw %}{{ page.excerpt }}{% endraw %}` variable. This plugin depends on the `PicoParsePagesContent` plugin (allowing plugins to depend on other plugins is one of Pico's great under-the-hood changes) and therefore heavily impacts performance. Likewise it gets automatically enabled with `PicoDeprecated`, something we'll drop with Pico 1.1.

We highly recommend you force the `PicoExcerpt` plugin to be disabled - just add `$config['PicoExcerpt.enabled'] = false;` to your `config/config.php`.

### For Plugin Developers

The new `PicoDeprecated` plugin ensures backward compatibility to Pico 0.9 and older. The plugin is disabled by default, but gets automatically enabled as soon as a old plugin is loaded. We will maintain backward compatibility for a long time, however, we recommend you to take the following steps to confine the necessity of `PicoDeprecated` to old plugins. If you don't use plugins or upgraded all plugins to be compatible to Pico 1.0, you must take these steps.

If you're a plugin developer, please refer to the new development docs, particularly the [Upgrade][PluginUpgrade] section of the [Plugin Development][PluginDev] page.

---

## What's New

`Pico 1.0` brings with it a complete code refactoring and overhaul of the plugin system, countless bug fixes, compatibility with all web servers, and enhanced documentation. Making Pico extremely simple, faster, and more flexible than ever. <sup> * </sup>Best of all, it's completely backwards compatible!

Detailed below is some of the most important changes to note when upgrading Pico from a `0.x` release to the new `Pico 1.0`

### Initialization
Initialization of Pico now works completely different: rather than defining constants (which are probably conflicting with other applications...), Pico now expects its paths to be passed as parameters to the [constructor]({{ site.base_url }}/phpDoc/master/classes/Pico.html#method___construct). The constructor doesn't start Pico's processing anymore, you now have to call the [`Pico::run()`]({{ site.base_url }}/phpDoc/master/classes/Pico.html#method_run) method, which returns the parsed page contents instead of directly echoing them. The [`PicoDeprecated`]({{ site.gh_project_url }}/blob/{{ site.gh_project_branch }}/plugins/00-PicoDeprecated.php) plugin defines the now deprecated constants `ROOT_DIR`, `LIB_DIR` etc., so old plugins can still use them. Those constants are defined before reading `config.php` in Pico's root folder, so upgrading users usually aren't bothered with e.g. a `PHP Notice: Use of undefined constant ROOT_DIR - assumed 'ROOT_DIR'` error when using `ROOT_DIR` in their `config.php` (so: no BC break). This change is reflected in the new [`index.php`]({{ site.gh_project_url }}/blob/{{ site.gh_project_branch }}/index.php) file.

New users don't need the constants anymore, relative paths are now always interpreted to be relative to Pico's root directory, so `$config['content_dir'] = 'content';` is always sufficient (previously this was depending on the webserver config). All these changes are supposed to improve Pico's interoperability with other applications and allows developers to integrate Pico in other applications, therefore there is a newly added [`Pico::setConfig()`]({{ site.base_url }}/phpDoc/master/classes/Pico.html#method_setConfig) method to even make the use of a `config.php` optional.

### Routing System
The new routing system now works out-of-the-box (even without rewriting) with any webserver using the QUERY_STRING routing method. Internal links now look like `?sub/page`, rewriting to remove the `?` is still possible and recommended. Contrary to Pico 0.9 every webserver should work just fine. Pico 0.9 required working URL rewriting, so if you want to use old plugins/themes/contents, a working rewrite setup may still be required. If you're not using the default .htaccess, you must update your rewrite rules to follow the new principles. Internal links in content files are declared with `%base_url%?sub/page`. Internal links in templates should be declared using the new link filter (e.g. `{{ "sub/page"|link }}`), what basically calls [`Pico::getPageUrl()`]({{ site.base_url }}/phpDoc/master/classes/Pico.html#method_getPageUrl)

### Plugin System
A whole new plugin system has been implemented while maintaining full backward compatibility. See the class docs of [PicoPluginInterface]({{ site.base_url }}/phpDoc/master/classes/PicoPluginInterface.html) for details. The new event system supports plugin dependencies as well as some new events. It was necessary to reliably distinct between old and new events, so __all events were renamed__. The new [PicoDeprecated]({{ site.gh_project_url }}/blob/{{ site.gh_project_branch }}/plugins/00-PicoDeprecated.php) plugin is crucial for backward compatibility, it's enabled on demand. Refer to its class docs for details.

It is important to note the performance issue with Pico 0.x releases is fixed only when the [PicoParsePagesContent]({{ site.gh_project_url }}/blob/{{ site.gh_project_branch }}/plugins/01-PicoParsePagesContent.php) plugin isn't enabled. It's disabled by default, but gets automatically enabled with [PicoDeprecated]({{ site.gh_project_url }}/blob/{{ site.gh_project_branch }}/plugins/00-PicoDeprecated.php) as soon as an old plugin is loaded. This is necessary to maintain backward compatibility. You can still disable it manually by executing` $pico->getPlugin('PicoParsePagesContent')->setEnabled(false);` or adding `$config['PicoParsePagesContent.enabled'] = false;` to your `config.php`.

If you're a plugin developer, please refer to the new development docs, particularly the [Upgrade][PluginUpgrade] section of the [Plugin Development][PluginDev] page.

Users, please refer to the websites of the plugins you're using to get updates for them.

### Changelog

 We've changed a lot in this new release of Pico.  For additional details please check the `1.0.0` section of the project [changelog][Changelog].

[UpgradeInstructions]: {{ site.base_url }}/docs.html#upgrade
[InstallInstructions]: {{ site.base_url }}/docs.html#install
[RewriteFile]: {{ site.gh_project_url }}/blob/{{ page.gh_release }}/.htaccess#L7
[RewriteDocs]: {{ site.base_url }}/docs.html#url-rewriting
[Symfony]: http://symfony.com/
[SymfonyYAML]: http://symfony.com/doc/current/components/yaml/introduction.html
[PicoGetPageUrl]: {{ site.gh_project_url }}/blob/{{ page.gh_release }}/lib/Pico.php#L1168-L1171
[PullRequest252]: https://github.com/picocms/Pico/pull/252
[PullRequest252Message]: https://github.com/picocms/Pico/pull/252#issue-103755569
[GettingHelp]: {{ site.base_url }}/docs.html#getting-help
[Issues]: {{ site.gh_project_url }}/issues
[Changelog]: {{ site.gh_project_url }}/blob/{{ site.gh_project_branch }}/CHANGELOG.md
[PluginDev]: {{ site.base_url }}/plugin-dev.html
[PluginUpgrade]: {{ site.base_url }}/plugin-dev.html#migrating-from-0x-to-10)
