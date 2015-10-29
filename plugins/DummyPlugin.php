<?php

/**
 * Pico dummy plugin - a template for plugins
 *
 * You're a plugin developer? This template may be helpful :-)
 * Simply remove the events you don't need and add your own logic.
 *
 * @author  Daniel Rudolf
 * @link    http://picocms.org
 * @license http://opensource.org/licenses/MIT
 * @version 1.0
 */
class DummyPlugin extends AbstractPicoPlugin
{
    /**
     * This plugin is enabled by default?
     *
     * @see AbstractPicoPlugin::$enabled
     * @var boolean
     */
    protected $enabled = false;

    /**
     * This plugin depends on ...
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
     * @param  object[] &$plugins loaded plugin instances
     * @return void
     */
    public function onPluginsLoaded(&$plugins)
    {
        // your code
    }

    /**
     * Triggered after Pico has read its configuration
     *
     * @see    Pico::getConfig()
     * @param  mixed[] &$config array of config variables
     * @return void
     */
    public function onConfigLoaded(&$config)
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
    public function onMetaHeaders(&$headers)
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
    public function onMetaParsing(&$rawContent, &$headers)
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
    public function onMetaParsed(&$meta)
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
    public function prepareFileContent(&$content)
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
     * @see    DummyPlugin::onSinglePageLoaded()
     * @see    DummyPlugin::onPagesLoaded()
     * @return void
     */
    public function onPagesLoading()
    {
        // your code
    }

    /**
     * Triggered when Pico reads a single page from the list of all known pages
     *
     * @see    DummyPlugin::onPagesLoaded()
     * @param array &$pageData {
     *     data of the loaded page
     *
     *     @var string $id             relative path to the content file
     *     @var string $url            URL to the page
     *     @var string $title          title of the page (YAML header)
     *     @var string $description    description of the page (YAML header)
     *     @var string $author         author of the page (YAML header)
     *     @var string $time           timestamp derived from the Date header
     *     @var string $date           date of the page (YAML header)
     *     @var string $date_formatted formatted date of the page
     *     @var string $raw_content    raw, not yet parsed contents of the page
     *     @var string $meta           parsed meta data of the page
     * }
     * @return void
     */
    public function onSinglePageLoaded(&$pageData)
    {
        // your code
    }

    /**
     * Triggered after Pico has read all known pages
     *
     * See {@link DummyPlugin::onSinglePageLoaded()} for details about the
     * structure of the page data.
     *
     * @see    Pico::getPages()
     * @see    Pico::getCurrentPage()
     * @see    Pico::getPreviousPage()
     * @see    Pico::getNextPage()
     * @param  array &$pages        data of all known pages
     * @param  array &$currentPage  data of the page being served
     * @param  array &$previousPage data of the previous page
     * @param  array &$nextPage     data of the next page
     * @return void
     */
    public function onPagesLoaded(&$pages, &$currentPage, &$previousPage, &$nextPage)
    {
        // your code
    }

    /**
     * Triggered before Pico registers the twig template engine
     *
     * @return void
     */
    public function onTwigRegistration()
    {
        // your code
    }

    /**
     * Triggered before Pico renders the page
     *
     * @see    Pico::getTwig()
     * @see    DummyPlugin::onPageRendered()
     * @param  Twig_Environment &$twig          twig template engine
     * @param  mixed[]          &$twigVariables template variables
     * @param  string           &$templateName  file name of the template
     * @return void
     */
    public function onPageRendering(&$twig, &$twigVariables, &$templateName)
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
}
