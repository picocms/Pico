<?php
/**
 * This file is part of Pico. It's copyrighted by the contributors recorded
 * in the version control history of the file, available from the following
 * original location:
 *
 * <https://github.com/picocms/Pico/blob/master/plugins/DummyPlugin.php>
 *
 * SPDX-License-Identifier: MIT
 * License-Filename: LICENSE
 */

declare(strict_types=1);

use Symfony\Component\Yaml\Parser as YamlParser;
use Twig\Environment as TwigEnvironment;

/**
 * Pico dummy plugin - a template for plugins
 *
 * You're a plugin developer? This template may be helpful :-)
 * Simply remove the events you don't need and add your own logic.
 *
 * @author  Daniel Rudolf
 * @link    https://picocms.org
 * @license https://opensource.org/licenses/MIT The MIT License
 * @version 3.0
 */
class DummyPlugin extends AbstractPicoPlugin
{
    /**
     * API version used by this plugin
     *
     * @var int
     */
    public const API_VERSION = 4;

    /**
     * This plugin is disabled by default
     *
     * Usually you should remove this class property (or set it to NULL) to
     * leave the decision whether this plugin should be enabled or disabled by
     * default up to Pico. If all the plugin's dependenies are fulfilled (see
     * {@see self::$dependsOn}), Pico enables the plugin by default. Otherwise
     * the plugin is silently disabled.
     *
     * If this plugin should never be disabled *silently* (e.g. when dealing
     * with security-relevant stuff like access control, or similar), set this
     * to TRUE. If Pico can't fulfill all the plugin's dependencies, it will
     * throw an RuntimeException.
     *
     * If this plugin rather does some "crazy stuff" a user should really be
     * aware of before using it, you can set this to FALSE. The user will then
     * have to enable the plugin manually. However, if another plugin depends
     * on this plugin, it might get enabled silently nevertheless.
     *
     * No matter what, the user can always explicitly enable or disable this
     * plugin in Pico's config.
     *
     * @see AbstractPicoPlugin::$enabled
     * @var bool|null
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
     * @see Pico::loadPlugin()
     * @see Pico::getPlugin()
     * @see Pico::getPlugins()
     *
     * @param object[] $plugins loaded plugin instances
     */
    public function onPluginsLoaded(array $plugins): void
    {
        // your code
    }

    /**
     * Triggered when Pico manually loads a plugin
     *
     * @see Pico::loadPlugin()
     * @see Pico::getPlugin()
     * @see Pico::getPlugins()
     *
     * @param object $plugin loaded plugin instance
     */
    public function onPluginManuallyLoaded(object $plugin): void
    {
        // your code
    }

    /**
     * Triggered after Pico has read its configuration
     *
     * @see Pico::getConfig()
     * @see Pico::getBaseUrl()
     * @see Pico::isUrlRewritingEnabled()
     *
     * @param array &$config array of config variables
     */
    public function onConfigLoaded(array &$config): void
    {
        // your code
    }

    /**
     * Triggered before Pico loads its theme
     *
     * @see Pico::loadTheme()
     * @see DummyPlugin::onThemeLoaded()
     *
     * @param string &$theme name of current theme
     */
    public function onThemeLoading(string &$theme): void
    {
        // your code
    }

    /**
     * Triggered after Pico loaded its theme
     *
     * @see DummyPlugin::onThemeLoading()
     * @see Pico::getTheme()
     * @see Pico::getThemeApiVersion()
     *
     * @param string $theme           name of current theme
     * @param int    $themeApiVersion API version of the theme
     * @param array  &$themeConfig    config array of the theme
     */
    public function onThemeLoaded(string $theme, int $themeApiVersion, array &$themeConfig): void
    {
        // your code
    }

    /**
     * Triggered after Pico has evaluated the request URL
     *
     * @see Pico::getRequestUrl()
     *
     * @param string &$url part of the URL describing the requested contents
     */
    public function onRequestUrl(string &$url): void
    {
        // your code
    }

    /**
     * Triggered after Pico has discovered the content file to serve
     *
     * @see Pico::resolveFilePath()
     * @see Pico::getRequestFile()
     *
     * @param string &$file absolute path to the content file to serve
     */
    public function onRequestFile(string &$file): void
    {
        // your code
    }

    /**
     * Triggered before Pico reads the contents of the file to serve
     *
     * @see Pico::loadFileContent()
     * @see DummyPlugin::onContentLoaded()
     */
    public function onContentLoading(): void
    {
        // your code
    }

    /**
     * Triggered before Pico reads the contents of a 404 file
     *
     * @see Pico::load404Content()
     * @see DummyPlugin::on404ContentLoaded()
     */
    public function on404ContentLoading(): void
    {
        // your code
    }

    /**
     * Triggered after Pico has read the contents of the 404 file
     *
     * @see DummyPlugin::on404ContentLoading()
     * @see Pico::getRawContent()
     * @see Pico::is404Content()
     *
     * @param string &$rawContent raw file contents
     */
    public function on404ContentLoaded(string &$rawContent): void
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
     * @see DummyPlugin::onContentLoading()
     * @see Pico::getRawContent()
     * @see Pico::is404Content()
     *
     * @param string &$rawContent raw file contents
     */
    public function onContentLoaded(string &$rawContent): void
    {
        // your code
    }

    /**
     * Triggered before Pico parses the meta header
     *
     * @see Pico::parseFileMeta()
     * @see DummyPlugin::onMetaParsed()
     */
    public function onMetaParsing(): void
    {
        // your code
    }

    /**
     * Triggered after Pico has parsed the meta header
     *
     * @see DummyPlugin::onMetaParsing()
     * @see Pico::getFileMeta()
     *
     * @param string[] &$meta parsed meta data
     */
    public function onMetaParsed(array &$meta): void
    {
        // your code
    }

    /**
     * Triggered before Pico parses the pages content
     *
     * @see Pico::prepareFileContent()
     * @see Pico::substituteFileContent()
     * @see DummyPlugin::onContentPrepared()
     * @see DummyPlugin::onContentParsed()
     */
    public function onContentParsing(): void
    {
        // your code
    }

    /**
     * Triggered after Pico has prepared the raw file contents for parsing
     *
     * @see DummyPlugin::onContentParsing()
     * @see Pico::parseFileContent()
     * @see DummyPlugin::onContentParsed()
     *
     * @param string &$markdown Markdown contents of the requested page
     */
    public function onContentPrepared(string &$markdown): void
    {
        // your code
    }

    /**
     * Triggered after Pico has parsed the contents of the file to serve
     *
     * @see DummyPlugin::onContentParsing()
     * @see DummyPlugin::onContentPrepared()
     * @see Pico::getFileContent()
     *
     * @param string &$content parsed contents (HTML) of the requested page
     */
    public function onContentParsed(string &$content): void
    {
        // your code
    }

    /**
     * Triggered before Pico reads all known pages
     *
     * @see DummyPlugin::onPagesDiscovered()
     * @see DummyPlugin::onPagesLoaded()
     */
    public function onPagesLoading(): void
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
     * @see DummyPlugin::onSinglePageContent()
     * @see DummyPlugin::onSinglePageLoaded()
     *
     * @param string    $id       relative path to the content file
     * @param bool|null $skipPage set this to TRUE to remove this page from the
     *     pages array, otherwise leave it unchanged
     */
    public function onSinglePageLoading(string $id, ?bool &$skipPage): void
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
     * @see DummyPlugin::onSinglePageLoading()
     * @see DummyPlugin::onSinglePageLoaded()
     *
     * @param string $id          relative path to the content file
     * @param string &$rawContent raw file contents
     */
    public function onSinglePageContent(string $id, string &$rawContent): void
    {
        // your code
    }

    /**
     * Triggered when Pico loads a single page
     *
     * Please refer to {@see Pico::readPages()} for information about the
     * structure of a single page's data.
     *
     * @see DummyPlugin::onSinglePageLoading()
     * @see DummyPlugin::onSinglePageContent()
     *
     * @param array &$pageData data of the loaded page
     */
    public function onSinglePageLoaded(array &$pageData): void
    {
        // your code
    }

    /**
     * Triggered after Pico has discovered all known pages
     *
     * Pico's pages array isn't sorted until the `onPagesLoaded` event is
     * triggered. Please refer to {@see Pico::readPages()} for information
     * about the structure of Pico's pages array and the structure of a single
     * page's data.
     *
     * @see DummyPlugin::onPagesLoading()
     * @see DummyPlugin::onPagesLoaded()
     *
     * @param array[] &$pages list of all known pages
     */
    public function onPagesDiscovered(array &$pages): void
    {
        // your code
    }

    /**
     * Triggered after Pico has sorted the pages array
     *
     * Please refer to {@see Pico::readPages()} for information about the
     * structure of Pico's pages array and the structure of a single page's
     * data.
     *
     * @see DummyPlugin::onPagesLoading()
     * @see DummyPlugin::onPagesDiscovered()
     * @see Pico::getPages()
     *
     * @param array[] &$pages sorted list of all known pages
     */
    public function onPagesLoaded(array &$pages): void
    {
        // your code
    }

    /**
     * Triggered when Pico discovered the current, previous and next pages
     *
     * If Pico isn't serving a regular page, but a plugin's virtual page, there
     * will neither be a current, nor previous or next pages. Please refer to
     * {@see Pico::readPages()} for information about the structure of a single
     * page's data.
     *
     * @see Pico::getCurrentPage()
     * @see Pico::getPreviousPage()
     * @see Pico::getNextPage()
     *
     * @param array|null &$currentPage  data of the page being served
     * @param array|null &$previousPage data of the previous page
     * @param array|null &$nextPage     data of the next page
     */
    public function onCurrentPageDiscovered(
        array &$currentPage = null,
        array &$previousPage = null,
        array &$nextPage = null
    ): void {
        // your code
    }

    /**
     * Triggered after Pico built the page tree
     *
     * Please refer to {@see Pico::buildPageTree()} for information about
     * the structure of Pico's page tree array.
     *
     * @see Pico::getPageTree()
     *
     * @param  array  &$pageTree page tree
     */
    public function onPageTreeBuilt(array &$pageTree): void
    {
        // your code
    }

    /**
     * Triggered before Pico renders the page
     *
     * @see DummyPlugin::onPageRendered()
     *
     * @param string &$templateName  file name of the template
     * @param array  &$twigVariables template variables
     */
    public function onPageRendering(string &$templateName, array &$twigVariables): void
    {
        // your code
    }

    /**
     * Triggered after Pico has rendered the page
     *
     * @see DummyPlugin::onPageRendering()
     *
     * @param string &$output contents which will be sent to the user
     */
    public function onPageRendered(string &$output): void
    {
        // your code
    }

    /**
     * Triggered when Pico reads its known meta header fields
     *
     * @see Pico::getMetaHeaders()
     *
     * @param string[] &$headers list of known meta header fields; the array
     *     key specifies the YAML key to search for, the array value is later
     *     used to access the found value
     */
    public function onMetaHeaders(array &$headers): void
    {
        // your code
    }

    /**
     * Triggered when Pico registers the YAML parser
     *
     * @see Pico::getYamlParser()
     *
     * @param YamlParser &$yamlParser YAML parser instance
     */
    public function onYamlParserRegistered(YamlParser &$yamlParser): void
    {
        // your code
    }

    /**
     * Triggered when Pico registers the Parsedown parser
     *
     * @see Pico::getParsedown()
     *
     * @param Parsedown &$parsedown Parsedown instance
     */
    public function onParsedownRegistered(Parsedown &$parsedown): void
    {
        // your code
    }

    /**
     * Triggered when Pico registers the twig template engine
     *
     * @see Pico::getTwig()
     *
     * @param TwigEnvironment &$twig Twig instance
     */
    public function onTwigRegistered(TwigEnvironment &$twig): void
    {
        // your code
    }
}
