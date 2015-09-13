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
     * This plugin is disabled by default
     *
     * @see AbstractPicoPlugin::$enabled
     */
    protected $enabled = false;

    /**
     * This plugin depends on {@link ...}
     *
     * @see AbstractPicoPlugin::$dependsOn
     */
    protected $dependsOn = array();

    /**
     * Triggered after Pico loaded all available plugins
     *
     * This event is triggered nevertheless the plugin is enabled or not.
     * It is NOT guaranteed that plugin dependencies are fulfilled!
     *
     * @see    Pico::getPlugin()
     * @see    Pico::getPlugins()
     * @param  array<object> &$plugins loaded plugin instances
     * @return void
     */
    public function onPluginsLoaded(&$plugins)
    {
        // your code
    }

    /**
     * Triggered after Pico readed its configuration
     *
     * @see    Pico::getConfig()
     * @param  array &$config array of config variables
     * @return void
     */
    public function onConfigLoaded(&$config)
    {
        // your code
    }

    /**
     * Triggered after Pico evaluated the request URL
     *
     * @see    Pico::getBaseUrl()
     * @see    Pico::getRequestUrl()
     * @param  string &$url request URL
     * @return void
     */
    public function onRequestUrl(&$url)
    {
        // your code
    }

    /**
     * Triggered after Pico discovered the content file to serve
     *
     * @see    Pico::getRequestFile()
     * @param  string &$file path to the content file to serve
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
     * @param  string &$file path to the file which contents will be read
     * @return void
     */
    public function onContentLoading(&$file)
    {
        // your code
    }

    /**
     * Triggered after Pico read the contents of the file to serve
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
     * Triggered before Pico reads the contents of the 404 file
     *
     * @see    Pico::load404Content()
     * @param  string &$file path to the file which contents were requested
     * @return void
     */
    public function on404ContentLoading(&$file)
    {
        // your code
    }

    /**
     * Triggered after Pico read the contents of the 404 file
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
     * @param  array<string> &$headers list of known meta header fields
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
     * @param  string &$rawContent raw file contents
     * @param  array  &$headers    known meta header fields
     * @return void
     */
    public function onMetaParsing(&$rawContent, &$headers)
    {
        // your code
    }

    /**
     * Triggered after Pico parsed the meta header
     *
     * @see    Pico::getFileMeta()
     * @param  array &$meta parsed meta data
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
     * @param  string &$rawContent raw file contents
     * @return void
     */
    public function onContentParsing(&$rawContent)
    {
        // your code
    }

    /**
     * Triggered after Pico prepared the raw file contents for parsing
     *
     * @see    Pico::parseFileContent()
     * @param  string &$content prepared file contents for parsing
     * @return void
     */
    public function prepareFileContent(&$content)
    {
        // your code
    }

    /**
     * Triggered after Pico parsed the contents of the file to serve
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
     * Triggered when Pico reads a single page for the list of all known pages
     *
     * @param  array &$pageData data of the loaded page
     * @return void
     */
    public function onSinglePageLoaded(&$pageData)
    {
        // your code
    }

    /**
     * Triggered after Pico read all known pages
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
     * @param  Twig_Environment &$twig          twig template engine
     * @param  array            &$twigVariables variables passed to the template
     * @param  string           &$templateName  name of the template to render
     * @return void
     */
    public function onPageRendering(&$twig, &$twigVariables, &$templateName)
    {
        // your code
    }

    /**
     * Triggered after Pico rendered the page
     *
     * @param  string &$output contents which will be sent to the user
     * @return void
     */
    public function onPageRendered(&$output)
    {
        // your code
    }
}
