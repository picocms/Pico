<?php

/**
 * Pico dummy plugin - a template for plugins
 *
 * You're a plugin developer? This template may be helpful :-)
 * Simply remove the events you don't need and add your own logic.
 *
 * @author  Daniel Rudolf
 * @link    http://picocms.org
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 2.0
 */
class DummyPlugin extends AbstractPicoPlugin
{
    /**
     * API version used by this plugin
     *
     * @var int
     */
    const API_VERSION = 2;

    /**
     * This plugin is disabled by default
     *
     * If you want to enable your plugin by default, simply remove this class
     * property.
     *
     * @see AbstractPicoPlugin::$enabled
     * @var boolean
     */
    protected $enabled = false;

    /**
     * This plugin depends on ...
     *
     * If your plugin doesn't depend on any other plugin, remove this class
     * property.
     *
     * @see AbstractPicoPlugin::$dependsOn
     * @var string[]
     */
    protected $dependsOn = array();

    /**
     * Triggered after Pico has loaded all available plugins
     *
     * This event is triggered nevertheless the plugin is enabled or not.
     * It is NOT guaranteed that plugin dependencies are fulfilled!
     *
     * @see    Pico::getPlugin()
     * @see    Pico::getPlugins()
     * @param  object[] $plugins loaded plugin instances
     * @return void
     */
    public function onPluginsLoaded(array $plugins)
    {
        // your code
    }

    /**
     * Triggered when Pico manually loads a plugin
     *
     * @see    Pico::getPlugin()
     * @see    Pico::getPlugins()
     * @param  object $plugin loaded plugin instance
     * @return void
     */
    public function onPluginManuallyLoaded($plugin)
    {
        // your code
    }

    /**
     * Triggered after Pico has read its configuration
     *
     * @see    Pico::getConfig()
     * @param  array &$config array of config variables
     * @return void
     */
    public function onConfigLoaded(array &$config)
    {
        // your code
    }

    /**
     * Triggered after Pico has evaluated the request URL
     *
     * @see    Pico::getRequestUrl()
     * @param  string &$url part of the URL describing the requested contents
     * @return void
     */
    public function onRequestUrl(&$url)
    {
        // your code
    }

    /**
     * Triggered after Pico has discovered the content file to serve
     *
     * @see    Pico::getBaseUrl()
     * @see    Pico::getRequestFile()
     * @param  string &$file absolute path to the content file to serve
     * @return void
     */
    public function onRequestFile(&$file)
    {
        // your code
    }

    /**
     * Triggered before Pico reads the contents of the file to serve
     *
     * @see    Pico::loadFileContent()
     * @see    DummyPlugin::onContentLoaded()
     * @return void
     */
    public function onContentLoading()
    {
        // your code
    }

    /**
     * Triggered before Pico reads the contents of a 404 file
     *
     * @see    Pico::load404Content()
     * @see    DummyPlugin::on404ContentLoaded()
     * @return void
     */
    public function on404ContentLoading()
    {
        // your code
    }

    /**
     * Triggered after Pico has read the contents of the 404 file
     *
     * @see    Pico::getRawContent()
     * @param  string &$rawContent raw file contents
     * @return void
     */
    public function on404ContentLoaded(&$rawContent)
    {
        // your code
    }

    /**
     * Triggered after Pico has read the contents of the file to serve
     *
     * If Pico serves a 404 file, this event is triggered with the raw contents
     * of said 404 file. Use {@see Pico::is404Content()} to check for this
     * case when necessary.
     *
     * @see    Pico::getRawContent()
     * @param  string &$rawContent raw file contents
     * @return void
     */
    public function onContentLoaded(&$rawContent)
    {
        // your code
    }

    /**
     * Triggered before Pico parses the meta header
     *
     * @see    Pico::parseFileMeta()
     * @see    DummyPlugin::onMetaParsed()
     * @return void
     */
    public function onMetaParsing()
    {
        // your code
    }

    /**
     * Triggered after Pico has parsed the meta header
     *
     * @see    Pico::getFileMeta()
     * @param  string[] &$meta parsed meta data
     * @return void
     */
    public function onMetaParsed(array &$meta)
    {
        // your code
    }

    /**
     * Triggered before Pico parses the pages content
     *
     * @see    Pico::prepareFileContent()
     * @see    DummyPlugin::prepareFileContent()
     * @see    DummyPlugin::onContentParsed()
     * @return void
     */
    public function onContentParsing()
    {
        // your code
    }

    /**
     * Triggered after Pico has prepared the raw file contents for parsing
     *
     * @see    Pico::parseFileContent()
     * @see    DummyPlugin::onContentParsed()
     * @param  string &$markdown Markdown contents of the requested page
     * @return void
     */
    public function onContentPrepared(&$markdown)
    {
        // your code
    }

    /**
     * Triggered after Pico has parsed the contents of the file to serve
     *
     * @see    Pico::getFileContent()
     * @param  string &$content parsed contents (HTML) of the requested page
     * @return void
     */
    public function onContentParsed(&$content)
    {
        // your code
    }

    /**
     * Triggered before Pico reads all known pages
     *
     * @see    Pico::readPages()
     * @see    DummyPlugin::onSinglePageLoading()
     * @see    DummyPlugin::onSinglePageContent()
     * @see    DummyPlugin::onSinglePageLoaded()
     * @see    DummyPlugin::onPagesDiscovered()
     * @see    DummyPlugin::onPagesLoaded()
     * @return void
     */
    public function onPagesLoading()
    {
        // your code
    }

    /**
     * Triggered before Pico loads a single page
     *
     * Set the `$skipFile` parameter to TRUE to remove this page from the pages
     * array. Pico usually passes NULL by default, unless it is a conflicting
     * page (i.e. `content/sub.md`, but there's also a `content/sub/index.md`),
     * then it passes TRUE. Don't change this value incautiously if it isn't
     * NULL! Someone likely set it to TRUE or FALSE on purpose...
     *
     * @see    DummyPlugin::onSinglePageContent()
     * @see    DummyPlugin::onSinglePageLoaded()
     * @see    DummyPlugin::onPagesDiscovered()
     * @see    DummyPlugin::onPagesLoaded()
     * @param  string    $id       relative path to the content file
     * @param  bool|null $skipPage set this to TRUE to remove this page from
     *     the pages array, otherwise leave it unchanged
     * @return void
     */
    public function onSinglePageLoading($id, &$skipPage)
    {
        // your code
    }

    /**
     * Triggered when Pico loads the raw contents of a single page
     *
     * Please note that this event isn't triggered when the currently processed
     * page is the requested page. The reason for this exception is that the
     * raw contents of this page were loaded already.
     *
     * @see    DummyPlugin::onSinglePageLoaded()
     * @see    DummyPlugin::onPagesDiscovered()
     * @see    DummyPlugin::onPagesLoaded()
     * @param  string $id          relative path to the content file
     * @param  string &$rawContent raw file contents
     * @return void
     */
    public function onSinglePageContent($id, &$rawContent)
    {
        // your code
    }

    /**
     * Triggered when Pico loads a single page
     *
     * The `$pageData` parameter consists of the following values:
     *
     * | Array key      | Type    | Description                                |
     * | -------------- | ------- | ------------------------------------------ |
     * | id             | string  | relative path to the content file          |
     * | url            | string  | URL to the page                            |
     * | title          | string  | title of the page (YAML header)            |
     * | description    | string  | description of the page (YAML header)      |
     * | author         | string  | author of the page (YAML header)           |
     * | time           | string  | timestamp derived from the Date header     |
     * | date           | string  | date of the page (YAML header)             |
     * | date_formatted | string  | formatted date of the page                 |
     * | hidden         | boolean | this page shouldn't be visible to the user |
     * | raw_content    | string  | raw, not yet parsed contents of the page   |
     * | meta           | string  | parsed meta data of the page               |
     * | previous_page  | &array  | reference to the previous page             |
     * | next_page      | &array  | reference to the next page                 |
     *
     * Please note that the `previous_page` and `next_page` keys won't be
     * available until the `onCurrentPageDiscovered` event was triggered.
     *
     * Set `$pageData` to `null` to remove this page from the pages array.
     *
     * @see    DummyPlugin::onPagesDiscovered()
     * @see    DummyPlugin::onPagesLoaded()
     * @param  array &$pageData data of the loaded page
     * @return void
     */
    public function onSinglePageLoaded(array &$pageData)
    {
        // your code
    }

    /**
     * Triggered after Pico has discovered all known pages
     *
     * See {@see DummyPlugin::onSinglePageLoaded()} for details about the
     * structure of the page data. Please note that the pages array isn't
     * sorted yet.
     *
     * @see    Pico::sortPages()
     * @see    DummyPlugin::onPagesLoaded()
     * @param  array[]    &$pages        data of all known pages
     * @return void
     */
    public function onPagesDiscovered(array &$pages)
    {
        // your code
    }

    /**
     * Triggered after Pico has sorted the pages array
     *
     * See {@see DummyPlugin::onSinglePageLoaded()} for details about the
     * structure of the page data.
     *
     * @see    Pico::getPages()
     * @param  array[]    &$pages        data of all known pages
     * @return void
     */
    public function onPagesLoaded(array &$pages)
    {
        // your code
    }

    /**
     * Triggered when Pico discovered the current, previous and next pages
     *
     * See {@see DummyPlugin::onSinglePageLoaded()} for details about the
     * structure of the page data.
     *
     * @see    Pico::discoverPageSiblings()
     * @see    Pico::discoverCurrentPage()
     * @see    Pico::getCurrentPage()
     * @see    Pico::getPreviousPage()
     * @see    Pico::getNextPage()
     * @param  array|null &$currentPage  data of the page being served
     * @param  array|null &$previousPage data of the previous page
     * @param  array|null &$nextPage     data of the next page
     * @return void
     */
    public function onCurrentPageDiscovered(
        array &$currentPage = null,
        array &$previousPage = null,
        array &$nextPage = null
    ) {
        // your code
    }

    /**
     * Triggered before Pico renders the page
     *
     * @see    Pico::getTwigTemplate()
     * @see    Pico::getTwigVariables()
     * @see    DummyPlugin::onPageRendered()
     * @param  string           &$templateName  file name of the template
     * @param  array            &$twigVariables template variables
     * @return void
     */
    public function onPageRendering(&$templateName, array &$twigVariables)
    {
        // your code
    }

    /**
     * Triggered after Pico has rendered the page
     *
     * @param  string &$output contents which will be sent to the user
     * @return void
     */
    public function onPageRendered(&$output)
    {
        // your code
    }

    /**
     * Triggered when Pico reads its known meta header fields
     *
     * @see    Pico::getMetaHeaders()
     * @param  string[] &$headers list of known meta header
     *     fields; the array value specifies the YAML key to search for, the
     *     array key is later used to access the found value
     * @return void
     */
    public function onMetaHeaders(array &$headers)
    {
        // your code
    }

    /**
     * Triggered when Pico registers the YAML parser
     *
     * @see    Pico::getYamlParser()
     * @param  \Symfony\Component\Yaml\Parser &$yamlParser YAML parser instance
     * @return void
     */
    public function onYamlParserRegistered(\Symfony\Component\Yaml\Parser &$yamlParser)
    {
        // your code
    }

    /**
     * Triggered when Pico registers the Parsedown parser
     *
     * @see    Pico::getParsedown()
     * @param  Parsedown &$parsedown Parsedown instance
     * @return void
     */
    public function onParsedownRegistered(Parsedown &$parsedown)
    {
        // your code
    }

    /**
     * Triggered when Pico registers the twig template engine
     *
     * @see    Pico::getTwig()
     * @param  Twig_Environment &$twig Twig instance
     * @return void
     */
    public function onTwigRegistered(Twig_Environment &$twig)
    {
        // your code
    }
}
