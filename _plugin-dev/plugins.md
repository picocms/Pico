---
toc:
    plugins:
        _title: Plugins
        migrating-from-0x---10: Migrating 0.X -> 1.0
        your-first-plugin: Your First Plugin
nav: 3
---

#Plugins
At the heart of customizing Pico is a plugin. You can 'hook-in' to the Pico
engine at many different times during the rendering of your site and its content.
You will find a full example template in `plugins/DummyPlugin.php` to get you
started on building some great stuff. Otherwise, keep reading to learn how to
create your first plugin!

Officially tested plugins can be found at [http://picocms.org/plugins](http://picocms.org/plugins),
but there are many awesome third-party plugins out there! A good start point
for discovery is our [Wiki](#plugin-wiki).

#Migrating from 0.X -> 1.0
The new event system supports plugin dependencies as well as some new events.
You will be able to set an enabled/disabled state by default as well. If you
have previously cerated a plugin for Pico, it is *HIGHLY* recommended that you
update your class to extend from `AbstractPicoPlugin` and use the new events
to avoid activating the `PicoDeprecated` plugin.

    |---------------------|-----------------------------------------------------------|
    | Event               | ... triggers the deprecated event                         |
    |---------------------|-----------------------------------------------------------|
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
    |---------------------|-----------------------------------------------------------|

#Your First Plugin

## 1. To get started, navigate to your `plugins` directory
![Step1](style/images/docs/pico_plugins.jpg)

---

## 2. Create a new folder and name it your desired name using CammelCase
![Step2](style/images/docs/pico_plugins_myplugin.jpg)

> *Note:* It's not necessary to create the folder, if you do not have assets to
> include, you can simply skip this step and continue to Step 3

---

## 3. Next, you should copy `DummyPlugin.php` inside your newly created folder and give it the same name as you did the folder
![Step3](style/images/docs/pico_plugins_myplugin_php.jpg)

---

## 4. You will need to name the `class` the same as the `folder` and the `.php` file
![Step4](style/images/docs/pico_plugins_myplugin_php_class.jpg)

---

## 5. From here, you will be able to hook-in to Pico's processing
Choose an event that makes sense for your situation. Do you need to load configuration values?
`onConfigLoaded`. You need to modify the content of the page before it is
rendered by markdown? `onPageRendering`. Etc... Plugin developers shouldn't
manipulate data in "wrong" events, this could lead to unexpected behavior.

> *Note:* Don't forget to set your plugins enabled/disabled state, either by default or
> through your sites `config/config.php` file.

---
