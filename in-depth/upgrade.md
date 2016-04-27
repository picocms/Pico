---
layout: docs
title: Upgrade
headline: Upgrade Pico 0.8 or 0.9 to Pico 1.0
description: We have worked hard to make the upgrade process to Pico 1.0 as easy as possible - and we think we made the grade.
toc:
    upgrading-to-pico-10:
        _title: Upgrading to Pico 1.0
        general-instructions: General instructions
        additional-information: Additional information
        routing-system: Routing system
        ensure-restricted-access-to-content-directory: Ensure restricted access to `content` directory
    how-to-upgrade-a-custom-theme:
        _title: How to upgrade a custom theme
        routing-system-1: Routing system
        drop-of--pagecontent--and-the-new-picoparsepagescontent-plugin: Drop of `{{ page.content }}`
        drop-of--pageexcerpt--and-the-new-picoexcerpt-plugin: Drop of `{{ page.excerpt }}`
    notes-for-plugin-developers: Notes for plugin developers
nav-url: /docs/
gh_release: v1.0.0
redirect_from:
    - /upgrade/index.html
    - /upgrade.html
---

With the release of Pico 1.0 we did a complete code refactoring, overhauled the plugin system, fixed countless bugs and problems, created compatibility to any web server and massively enhanced documentation. Making Pico extremely simple, faster, and more flexible than ever. Best of all, it's completely backwards compatible!

If you have a question about one of the new features of Pico 1.0, the upgrade process, or about Pico in general, please check out the ["Getting Help" section][GettingHelp] of the docs and don't be afraid to open a new [Issue][Issues] on GitHub.

## Upgrading to Pico 1.0

We worked hard to make the upgrade process to Pico 1.0 as easy as possible. As a user, you shouldn't have to consider anything special when upgrading a existing Pico 0.8 or 0.9 installation to Pico 1.0. Nevertheless you should always make sure you **create a backup of your Pico installation before upgrading**. You can follow the regular [Upgrade instructions][UpgradeInstructions] as if we updated the `MINOR` version. For convenience, these instructions are also provided below, including some recommended, additional steps.

For a complete list of what we have changed with Pico 1.0, please refer to our [`CHANGELOG.md`][Changelog].

### General instructions

1. Create a backup of your Pico installation. You will need the files later!
2. Empty your installation directory and [install Pico ordinarily][InstallInstructions].
3. Copy the `config.php` from your backup to `config/config.php`. You don't have to change anything in this file.
4. Copy the `content` folder from your backup to Pico's installation directory. As a optional step, you can (but aren't required to) make your content files compatible with Pico's new routing system. You'll find detailed instructions on how to do this in the ["Routing System" section][UpgradeDetailsRoutingSystem] below.
5. If applicable, also copy the folder of your custom theme within the `themes` directory of your backup to the `themes` folder of your Pico installation. Again you can (but aren't required to) make your theme compatible with Pico's new routing system. Please refer to the ["How to upgrade a custom theme" section][UpgradeDetailsThemes] if you experience issues.
6. Provided that you're using plugins, also copy all of your plugins from the `plugins` directory. Don't copy the `plugins/pico_plugin.php` - this is not a real plugin, but Pico's old dummy plugin. We highly recommend you to check the websites of all plugins you're using to receive updates for them.

### Additional information

Pico 1.0 introduces a brand new routing system that is now compatible to any webserver. Even URL rewriting has become optional. If you don't use the `.htaccess` file provided by Pico, you must update your rewriting rules to let the webserver rewrite internal links correctly. URLs like `http://example.com/pico/sub/page` must now be rewritten to `/pico/?sub/page`. Please refer to Pico's [`.htaccess` file][RewriteFile] and the [corresponding section in the docs][RewriteDocs].

A potential source of problems for users with custom themes is the removal of `{% raw %}{{ page.content }}{% endraw %}` and `{% raw %}{{ page.excerpt }}{% endraw %}`. As long as you use old plugins, the newly introduced `PicoDeprecated` plugin ensures the further availability of these variables. However, this plugin won't get enabled when all of your plugins were updated to Pico 1.0. Furthermore we will drop the auto provision of `{% raw %}{{ page.content }}{% endraw %}` and `{% raw %}{{ page.excerpt }}{% endraw %}` with Pico 1.1. If you're using one of these variables in your theme, we highly recommend you to take the steps described in the ["Drop of `{% raw %}{{ page.content }}{% endraw %}`"][UpgradeDetailsPageContent] and ["Drop of `{% raw %}{{ page.excerpt }}{% endraw %}`"][UpgradeDetailsPageExcerpt] sections below.

Besides the bigger new features (and their implications regarding an upgrade) explained below, Pico also introduces a vast number of smaller improvements and changes:

* Sorting pages by date now works as expected. With alphabetical sorting, index files (e.g. `sub/index.md`) are now always placed before their sub pages (e.g. `sub/foo.md`). You should ensure that your pages are still sorted as desired after upgrading.
* Paths (e.g. `$config['content_dir']` in your `config/config.php`) are now always interpreted to be relative to Pico's root directory. Make sure your paths are still correct! Please also make sure to remove any use of Pico's old `ROOT_DIR` constant.
* You can now use the YAML Front Matter syntax in Markdown files to enclose meta headers (`--- ... ---`) instead of C-style block comments (`/* ... */`). Make sure that your meta headers start on the first line of the file, otherwise they will be ignored!
* Meta headers are now parsed by the [YAML component][SymfonyYAML] of the [Symfony project][Symfony] and it isn't necessary to register new headers during the `onMetaHeaders` event anymore. The implicit availability of headers is supposed to be used by users and *pure* theme designers only. Therefore you can remove plugins whose only objective is to make custom Meta headers available.

### Routing system

The new routing system works out-of-the-box (even without rewriting) with any webserver using the `QUERY_STRING` routing method. Internal links now look like `?sub/page`, rewriting to remove the `?` is still possible and recommended. Contrary to Pico 0.9 every webserver now works just fine. You are not required to update your internal links to meet the new routing system principles, as long as you keep URL rewriting enabled. If, however, you want to have the option to disable URL rewriting later, you should update your links.

In Markdown files (i.e. your `content` directory), replace all occurrences of e.g. `%base_url%/sub/page` with `%base_url%?sub/page`. If you're linking to the main page (i.e. just `%base_url%`), you either shouldn't change anything or replace it with `%base_url%?index` - even this isn't absolutely necessary. Pico replaces the `%base_url%` variable the same as always, but also removes the `?` when URL rewriting is enabled.

Provided that you want to disable URL rewriting and you're using a custom theme, please refer to the [theme-related "Routing system" section][UpgradeDetailsRoutingSystemThemes] below.

Please note that plugins or themes, which haven't been updated to Pico 1.0 yet, could force you to keep URL rewriting enabled.

### Ensure restricted access to `content` directory

With Pico 1.0 we removed some empty `index.html` files, whose object was to prevent directory listing. However, directory listing doesn't address the security concerns in whole. Our `.htaccess` file already tries to achieve this automatically, nevertheless you should ensure that your webserver (especially when you're not using Apache) is configured as recommended.

Please make sure directory listing is disabled and users cannot browse to the `config`, `content`, `content-sample`, `lib` and `vendor` directories. Try it yourself by browsing to both your `lib` directory (e.g. `http://example.com/pico/lib/`) and `lib/Pico.php` file (e.g. `http://example.com/pico/lib/Pico.php`) - your webserver should either report `404 Not Found` or `403 Forbidden`.

If you were previously hosting assets (images, downloads, etc.) inside your content directory, we recommend you to move them to a dedicated `assets` folder in Pico's root directory. Don't forget to update your links accordingly.

## How to upgrade a custom theme

If you're using a custom theme, we recommend you to check the website of the theme you're using to receive updates for it. If you're in fact a theme designer, you should consider the following paragraphs about how to upgrade your theme to Pico 1.0.

### Routing System

In theme files (i.e. a custom theme folder in Pico's `themes` directory), required changes regarding Pico's new routing system are quite similar to the changes in Markdown files. Again, you can, but aren't required to make changes as long as you keep URL rewriting enabled. Instead of using `{% raw %}{{ base_url }}{% endraw %}` directly, use the newly introduced `link` filter (i.e. `{% raw %}{{ base_url }}/sub/page{% endraw %}` becomes `{% raw %}{{ "sub/page"|link }}{% endraw %}`). Either don't change links to the main page (i.e. just `{% raw %}{{ base_url }}{% endraw %}`) or replace them with `{% raw %}{{ "index"|link }}{% endraw %}`. The `link` filter does nothing more than calling the [`Pico::getPageUrl()` method][PicoGetPageUrl].

### Drop of `{% raw %}{{ page.content }}{% endraw %}` and the new `PicoParsePagesContent` plugin

With Version 0.6.1 Pico started parsing the Markdown contents of all pages. While making some things easier (like generating excerpts), this heavily impacted performance with a larger number of pages (e.g. blog posts). By popular request we removed this feature with Pico 1.0 and therefore significantly improved performance.

If you're using the `{% raw %}{{ page.content }}{% endraw %}` variable in your custom theme, you should at least replace it with `{% raw %}{{ page.id|content }}{% endraw %}`. We highly recommend you to think over the need to use the parsed page contents, it's likely that the raw page contents (`{% raw %}{{ page.raw_content }}{% endraw %}`) will fulfill your needs.

With Pico 1.0 we also introduced the `PicoParsePagesContent` plugin, whose objective is to parse the contents of all pages as it has since Pico 0.6.1. The plugin is disabled by default, but gets automatically enabled with `PicoDeprecated` when a plugin, that wasn't updated to Pico 1.0 yet, is loaded. Please note that we'll remove this automatic activation with Pico 1.1, so you will need to enable it manually.

We highly recommend you force the `PicoParsePagesContent` plugin to be disabled by adding `$config['PicoParsePagesContent.enabled'] = false;` to your `config/config.php`.

### Drop of `{% raw %}{{ page.excerpt }}{% endraw %}` and the new `PicoExcerpt` plugin

The main reason Pico started parsing the Markdown contents of all pages (see above), was the desire for automatically generated page excerpts. We later realized that this is the wrong approach, then started searching for alternatives - and we think we found a good solution!

Given that you're using the `{% raw %}{{ page.excerpt }}{% endraw %}` variable in your custom theme, we recommend you part from the concept of automatically generated excerpts. Instead, you should use the `Description` meta header to write excerpts on your own. Starting with Pico 1.0 you can use `%meta.*%` placeholders in your Markdown files, so you don't have to repeat yourself - simply add `%meta.description%` to the page content and Pico will replace it with your excerpt.

As with `{% raw %}{{ page.content }}{% endraw %}` and the `PicoParsePagesContent` plugin, we also introduced the `PicoExcerpt` plugin, which continues to provide the `{% raw %}{{ page.excerpt }}{% endraw %}` variable. This plugin depends on the `PicoParsePagesContent` plugin (allowing plugins to depend on other plugins is one of Pico's great under-the-hood changes) and therefore heavily impacts performance. Likewise it gets automatically enabled with `PicoDeprecated`, something we'll drop with Pico 1.1.

We highly recommend you force the `PicoExcerpt` plugin to be disabled - just add `$config['PicoExcerpt.enabled'] = false;` to your `config/config.php`.

## Notes for plugin developers

The new `PicoDeprecated` plugin ensures backward compatibility to Pico 0.9 and older. The plugin is disabled by default, but gets automatically enabled as soon as a old plugin is loaded. We will maintain backward compatibility for a long time, however, we recommend you to take the steps described in the ["Upgrade" section][PluginUpgrade] of our [developer docs][PluginDev] to confine the necessity of `PicoDeprecated` as far as possible.

[GettingHelp]: {{ site.github.url }}/docs/#getting-help
[Issues]: {{ site.gh_project_url }}/issues
[UpgradeDetailsThemes]: {{ site.github.url }}/in-depth/upgrade/#how-to-upgrade-a-custom-theme
[UpgradeDetailsPageContent]: {{ site.github.url }}/in-depth/upgrade/#drop-of--pagecontent--and-the-new-picoparsepagescontent-plugin
[UpgradeDetailsPageExcerpt]: {{ site.github.url }}/in-depth/upgrade/#drop-of--pageexcerpt--and-the-new-picoexcerpt-plugin
[UpgradeDetailsRoutingSystem]: {{ site.github.url }}/in-depth/upgrade/#routing-system
[UpgradeDetailsRoutingSystemThemes]: {{ site.github.url }}/in-depth/upgrade/#routing-system-1
[Changelog]: {{ site.gh_project_url }}/blob/{{ page.gh_release }}/CHANGELOG.md
[PicoGetPageUrl]: {{ site.github.url }}/phpDoc/{{ page.gh_release }}/classes/Pico.html#method_getPageUrl
[RewriteFile]: {{ site.gh_project_url }}/blob/{{ page.gh_release }}/.htaccess#L7
[RewriteDocs]: {{ site.github.url }}/docs/#url-rewriting
[Symfony]: http://symfony.com/
[SymfonyYAML]: http://symfony.com/doc/current/components/yaml/introduction.html
[UpgradeInstructions]: {{ site.github.url }}/docs/#upgrade
[InstallInstructions]: {{ site.github.url }}/docs/#install
[PluginDev]: {{ site.github.url }}/development/
[PluginUpgrade]: {{ site.github.url }}/development/#migrating-from-0x-to-10
