---
toc:
    plugins:
        _title: Plugins
        your-first-plugin: Your First Plugin
nav: 3
---

## Plugins

At the heart of customizing Pico is a plugin. You can 'hook-in' to the Pico
engine at many different times during the rendering of your site and its content.
You will find a full example template in [plugins/DummyPlugin.php]({{ site.github.url }}/phpDoc/master/classes/DummyPlugin.html) to get you
started on building some great stuff. Otherwise, keep reading to learn how to
create your first plugin!

Officially tested plugins can be found at [{{ site.github.url }}/plugins/]({{ site.github.url }}/plugins/),
but there are many awesome third-party plugins out there! A good start point
for discovery is our [Wiki]({{ site.github.url }}/development/#plugin-wiki).

### Your First Plugin

#### 1. To get started, navigate to your `plugins` directory
![Step1]({{ site.github.url }}/style/images/docs/pico_plugins.jpg)

#### 2. Create a new folder and name it your desired name using CammelCase
![Step2]({{ site.github.url }}/style/images/docs/pico_plugins_myplugin.jpg)

> *Note:* It's not necessary to create the folder, if you do not have assets to
> include, you can simply skip this step and continue to Step 3

#### 3. Next, you should copy `DummyPlugin.php` inside your newly created folder and give it the same name as you did the folder
![Step3]({{ site.github.url }}/style/images/docs/pico_plugins_myplugin_php.jpg)

#### 4. You will need to name the `class` the same as the `folder` and the `.php` file
![Step4]({{ site.github.url }}/style/images/docs/pico_plugins_myplugin_php_class.jpg)

#### 5. From here, you will be able to hook-in to Pico's processing
Choose an event that makes sense for your situation. Do you need to load configuration values?
[onConfigLoaded]({{ site.github.url }}/phpDoc/master/classes/DummyPlugin.html#method_onConfigLoaded). You need to modify the content of the page before it is
rendered by markdown? [onPageRendering]({{ site.github.url }}/phpDoc/master/classes/DummyPlugin.html#method_onPageRendering). Etc... Plugin developers shouldn't
manipulate data in "wrong" events, this could lead to unexpected behavior.

> *Note:* Don't forget to set your plugins enabled/disabled state, either by default or
> through your sites `config/config.php` file.
