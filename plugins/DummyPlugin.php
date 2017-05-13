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
     * @param  string &$file path to the file which contents will be read
     * @return void
     */
    public function onContentLoading(&$file)
    {
        // your code
    }

    /**
     * Triggered after Pico has read the contents of the file to serve
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
     * Triggered before Pico reads the contents of a 404 file
     *
     * @see    Pico::load404Content()
     * @see    DummyPlugin::on404ContentLoaded()
     * @param  string &$file path to the file which contents were requested
     * @return void
     */
    public function on404ContentLoading(&$file)
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
     * Triggered before Pico parses the meta header
     *
     * @see    Pico::parseFileMeta()
     * @see    DummyPlugin::onMetaParsed()
     * @param  string   &$rawContent raw file contents
     * @param  string[] &$headers    known meta header fields
     * @return void
     */
    public function onMetaParsing(&$rawContent, array &$headers)
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
     * @param  string &$rawContent raw file contents
     * @return void
     */
    public function onContentParsing(&$rawContent)
    {
        // your code
    }

    /**
     * Triggered after Pico has prepared the raw file contents for parsing
     *
     * @see    Pico::parseFileContent()
     * @see    DummyPlugin::onContentParsed()
     * @param  string &$content prepared file contents for parsing
     * @return void
     */
    public function onContentPrepared(&$content)
    {
        // your code
    }

    /**
     * Triggered after Pico has parsed the contents of the file to serve
     *
     * @see    Pico::getFileContent()
     * @param  string &$content parsed contents
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
     * Set `$id` to `null` to remove this page from the pages array.
     *
     * @see    DummyPlugin::onSinglePageLoaded()
     * @see    DummyPlugin::onPagesDiscovered()
     * @see    DummyPlugin::onPagesLoaded()
     * @param  string &$id relative path to the content file
     * @return void
     */
    public function onSinglePageLoading(&$id)
    {
        // your code
    }

    /**
     * Triggered when Pico loads a single page
     *
     * The `$pageData` parameter consists of the following values:
     *
     * | Array key      | Type   | Description                              |
     * | -------------- | ------ | ---------------------------------------- |
     * | id             | string | relative path to the content file        |
     * | url            | string | URL to the page                          |
     * | title          | string | title of the page (YAML header)          |
     * | description    | string | description of the page (YAML header)    |
     * | author         | string | author of the page (YAML header)         |
     * | time           | string | timestamp derived from the Date header   |
     * | date           | string | date of the page (YAML header)           |
     * | date_formatted | string | formatted date of the page               |
     * | raw_content    | string | raw, not yet parsed contents of the page |
     * | meta           | string | parsed meta data of the page             |
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
     * See {@link DummyPlugin::onSinglePageLoaded()} for details about the
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
     * See {@link DummyPlugin::onSinglePageLoaded()} for details about the
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
     * See {@link DummyPlugin::onSinglePageLoaded()} for details about the
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
