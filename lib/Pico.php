<?php
/**
 * This file is part of Pico. It's copyrighted by the contributors recorded
 * in the version control history of the file, available from the following
 * original location:
 *
 * <https://github.com/picocms/Pico/blob/master/lib/Pico.php>
 *
 * The file has been renamed in the past; the version control history of the
 * original file applies accordingly, available from the following original
 * location:
 *
 * <https://github.com/picocms/Pico/blob/adc356251ecd79689935ec1446c7c846db167d46/lib/pico.php>
 *
 * SPDX-License-Identifier: MIT
 * License-Filename: LICENSE
 */

/**
 * Pico
 *
 * Pico is a stupidly simple, blazing fast, flat file CMS.
 *
 * - Stupidly Simple: Pico makes creating and maintaining a
 *   website as simple as editing text files.
 * - Blazing Fast: Pico is seriously lightweight and doesn't
 *   use a database, making it super fast.
 * - No Database: Pico is a "flat file" CMS, meaning no
 *   database woes, no MySQL queries, nothing.
 * - Markdown Formatting: Edit your website in your favourite
 *   text editor using simple Markdown formatting.
 * - Twig Templates: Pico uses the Twig templating engine,
 *   for powerful and flexible themes.
 * - Open Source: Pico is completely free and open source,
 *   released under the MIT license.
 *
 * See <http://picocms.org/> for more info.
 *
 * @author  Gilbert Pellegrom
 * @author  Daniel Rudolf
 * @link    http://picocms.org
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 2.1
 */
class Pico
{
    /**
     * Pico version
     *
     * @var string
     */
    const VERSION = '2.1.0';

    /**
     * Pico version ID
     *
     * @var int
     */
    const VERSION_ID = 20100;

    /**
     * Pico API version
     *
     * @var int
     */
    const API_VERSION = 3;

    /**
     * Sort files in alphabetical ascending order
     *
     * @see Pico::getFiles()
     * @var int
     */
    const SORT_ASC = 0;

    /**
     * Sort files in alphabetical descending order
     *
     * @see Pico::getFiles()
     * @var int
     */
    const SORT_DESC = 1;

    /**
     * Don't sort files
     *
     * @see Pico::getFiles()
     * @var int
     */
    const SORT_NONE = 2;

    /**
     * Root directory of this Pico instance
     *
     * @see Pico::getRootDir()
     * @var string
     */
    protected $rootDir;

    /**
     * Vendor directory of this Pico instance
     *
     * @see Pico::getVendorDir()
     * @var string
     */
    protected $vendorDir;

    /**
     * Config directory of this Pico instance
     *
     * @see Pico::getConfigDir()
     * @var string
     */
    protected $configDir;

    /**
     * Plugins directory of this Pico instance
     *
     * @see Pico::getPluginsDir()
     * @var string
     */
    protected $pluginsDir;

    /**
     * Themes directory of this Pico instance
     *
     * @see Pico::getThemesDir()
     * @var string
     */
    protected $themesDir;

    /**
     * Boolean indicating whether Pico started processing yet
     *
     * @var bool
     */
    protected $locked = false;

    /**
     * List of loaded plugins
     *
     * @see Pico::getPlugins()
     * @var object[]
     */
    protected $plugins = array();

    /**
     * List of loaded plugins using the current API version
     *
     * @var PicoPluginInterface[]
     */
    protected $nativePlugins = array();

    /**
     * Boolean indicating whether Pico loads plugins from the filesystem
     *
     * @see Pico::loadPlugins()
     * @see Pico::loadLocalPlugins()
     * @var bool
     */
    protected $enableLocalPlugins = true;

    /**
     * Current configuration of this Pico instance
     *
     * @see Pico::getConfig()
     * @var array|null
     */
    protected $config;

    /**
     * Theme in use
     *
     * @see Pico::getTheme()
     * @var string
     */
    protected $theme;

    /**
     * API version of the current theme
     *
     * @see Pico::getThemeApiVersion()
     * @var int
     */
    protected $themeApiVersion;

    /**
     * Additional meta headers of the current theme
     *
     * @var array<string,string>|null
     */
    protected $themeMetaHeaders;

    /**
     * Part of the URL describing the requested contents
     *
     * @see Pico::getRequestUrl()
     * @var string|null
     */
    protected $requestUrl;

    /**
     * Absolute path to the content file being served
     *
     * @see Pico::getRequestFile()
     * @var string|null
     */
    protected $requestFile;

    /**
     * Raw, not yet parsed contents to serve
     *
     * @see Pico::getRawContent()
     * @var string|null
     */
    protected $rawContent;

    /**
     * Boolean indicating whether Pico is serving a 404 page
     *
     * @see Pico::is404Content()
     * @var bool
     */
    protected $is404Content = false;

    /**
     * Symfony YAML instance used for meta header parsing
     *
     * @see Pico::getYamlParser()
     * @var \Symfony\Component\Yaml\Parser|null
     */
    protected $yamlParser;

    /**
     * List of known meta headers
     *
     * @see Pico::getMetaHeaders()
     * @var array<string,string>|null
     */
    protected $metaHeaders;

    /**
     * Meta data of the page to serve
     *
     * @see Pico::getFileMeta()
     * @var array|null
     */
    protected $meta;

    /**
     * Parsedown Extra instance used for markdown parsing
     *
     * @see Pico::getParsedown()
     * @var Parsedown|null
     */
    protected $parsedown;

    /**
     * Parsed content being served
     *
     * @see Pico::getFileContent()
     * @var string|null
     */
    protected $content;

    /**
     * List of known pages
     *
     * @see Pico::getPages()
     * @var array[]|null
     */
    protected $pages;

    /**
     * Data of the page being served
     *
     * @see Pico::getCurrentPage()
     * @var array|null
     */
    protected $currentPage;

    /**
     * Data of the previous page relative to the page being served
     *
     * @see Pico::getPreviousPage()
     * @var array|null
     */
    protected $previousPage;

    /**
     * Data of the next page relative to the page being served
     *
     * @see Pico::getNextPage()
     * @var array|null
     */
    protected $nextPage;

    /**
     * Tree structure of known pages
     *
     * @see Pico::getPageTree()
     * @var array[]|null
     */
    protected $pageTree;

    /**
     * Twig instance used for template parsing
     *
     * @see Pico::getTwig()
     * @var Twig_Environment|null
     */
    protected $twig;

    /**
     * Variables passed to the twig template
     *
     * @see Pico::getTwigVariables()
     * @var array|null
     */
    protected $twigVariables;

    /**
     * Name of the Twig template to render
     *
     * @see Pico::getTwigTemplate()
     * @var string|null
     */
    protected $twigTemplate;

    /**
     * Constructs a new Pico instance
     *
     * To carry out all the processing in Pico, call {@see Pico::run()}.
     *
     * @param string $rootDir            root dir of this Pico instance
     * @param string $configDir          config dir of this Pico instance
     * @param string $pluginsDir         plugins dir of this Pico instance
     * @param string $themesDir          themes dir of this Pico instance
     * @param bool   $enableLocalPlugins enables (TRUE; default) or disables
     *     (FALSE) loading plugins from the filesystem
     */
    public function __construct($rootDir, $configDir, $pluginsDir, $themesDir, $enableLocalPlugins = true)
    {
        $this->rootDir = rtrim($rootDir, '/\\') . '/';
        $this->vendorDir = dirname(__DIR__) . '/';
        $this->configDir = $this->getAbsolutePath($configDir);
        $this->pluginsDir = $this->getAbsolutePath($pluginsDir);
        $this->themesDir = $this->getAbsolutePath($themesDir);
        $this->enableLocalPlugins = (bool) $enableLocalPlugins;
    }

    /**
     * Returns the root directory of this Pico instance
     *
     * @return string root directory path
     */
    public function getRootDir()
    {
        return $this->rootDir;
    }

    /**
     * Returns the vendor directory of this Pico instance
     *
     * @return string vendor directory path
     */
    public function getVendorDir()
    {
        return $this->vendorDir;
    }

    /**
     * Returns the config directory of this Pico instance
     *
     * @return string config directory path
     */
    public function getConfigDir()
    {
        return $this->configDir;
    }

    /**
     * Returns the plugins directory of this Pico instance
     *
     * @return string plugins directory path
     */
    public function getPluginsDir()
    {
        return $this->pluginsDir;
    }

    /**
     * Returns the themes directory of this Pico instance
     *
     * @return string themes directory path
     */
    public function getThemesDir()
    {
        return $this->themesDir;
    }

    /**
     * Runs this Pico instance
     *
     * Loads plugins, evaluates the config file, does URL routing, parses
     * meta headers, processes Markdown, does Twig processing and returns
     * the rendered contents.
     *
     * @return string rendered Pico contents
     *
     * @throws Exception thrown when a irrecoverable error occurs
     */
    public function run()
    {
        // check lock
        if ($this->locked) {
            throw new LogicException('You cannot run the same Pico instance multiple times');
        }

        // lock Pico
        $this->locked = true;

        // load plugins
        $this->loadPlugins();
        $this->sortPlugins();
        $this->triggerEvent('onPluginsLoaded', array($this->plugins));

        // load config
        $this->loadConfig();
        $this->triggerEvent('onConfigLoaded', array(&$this->config));

        // check content dir
        if (!is_dir($this->getConfig('content_dir'))) {
            throw new RuntimeException('Invalid content directory "' . $this->getConfig('content_dir') . '"');
        }

        // load theme
        $this->theme = $this->config['theme'];
        $this->triggerEvent('onThemeLoading', array(&$this->theme));

        $this->loadTheme();
        $this->triggerEvent(
            'onThemeLoaded',
            array($this->theme, $this->themeApiVersion, &$this->config['theme_config'])
        );

        // evaluate request url
        $this->evaluateRequestUrl();
        $this->triggerEvent('onRequestUrl', array(&$this->requestUrl));

        // discover requested file
        $this->requestFile = $this->resolveFilePath($this->requestUrl);
        $this->triggerEvent('onRequestFile', array(&$this->requestFile));

        // load raw file content
        $this->triggerEvent('onContentLoading');

        $hiddenFileRegex = '/(?:^|\/)(?:_|404' . preg_quote($this->getConfig('content_ext'), '/') . '$)/';
        if (is_file($this->requestFile) && !preg_match($hiddenFileRegex, $this->requestFile)) {
            $this->rawContent = $this->loadFileContent($this->requestFile);
        } else {
            $this->triggerEvent('on404ContentLoading');

            $serverProtocol = !empty($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
            header($serverProtocol . ' 404 Not Found');

            $this->rawContent = $this->load404Content($this->requestFile);
            $this->is404Content = true;

            $this->triggerEvent('on404ContentLoaded', array(&$this->rawContent));
        }

        $this->triggerEvent('onContentLoaded', array(&$this->rawContent));

        // parse file meta
        $this->triggerEvent('onMetaParsing');
        $this->meta = $this->parseFileMeta($this->rawContent, $this->getMetaHeaders());
        $this->triggerEvent('onMetaParsed', array(&$this->meta));

        // parse file content
        $this->triggerEvent('onContentParsing');

        $markdown = $this->prepareFileContent($this->rawContent, $this->meta);
        $this->triggerEvent('onContentPrepared', array(&$markdown));

        $this->content = $this->parseFileContent($markdown);
        $this->triggerEvent('onContentParsed', array(&$this->content));

        // read pages
        $this->triggerEvent('onPagesLoading');

        $this->readPages();
        $this->triggerEvent('onPagesDiscovered', array(&$this->pages));

        $this->sortPages();
        $this->triggerEvent('onPagesLoaded', array(&$this->pages));

        $this->discoverPageSiblings();
        $this->discoverCurrentPage();
        $this->triggerEvent(
            'onCurrentPageDiscovered',
            array(&$this->currentPage, &$this->previousPage, &$this->nextPage)
        );

        $this->buildPageTree();
        $this->triggerEvent('onPageTreeBuilt', array(&$this->pageTree));

        // render template
        $this->twigVariables = $this->getTwigVariables();
        $this->twigTemplate = $this->getTwigTemplate();
        $this->triggerEvent('onPageRendering', array(&$this->twigTemplate, &$this->twigVariables));

        $output = $this->getTwig()->render($this->twigTemplate, $this->twigVariables);
        $this->triggerEvent('onPageRendered', array(&$output));

        return $output;
    }

    /**
     * Loads plugins from vendor/pico-plugin.php and Pico::$pluginsDir
     *
     * See {@see Pico::loadComposerPlugins()} for details about plugins loaded
     * from `vendor/pico-plugin.php` (i.e. plugins that were installed using
     * composer), and {@see Pico::loadLocalPlugins()} for details about plugins
     * installed to {@see Pico::$pluginsDir}. Pico loads plugins from the
     * filesystem only if {@see Pico::$enableLocalPlugins} is set to TRUE
     * (this is the default).
     *
     * Pico always loads plugins from `vendor/pico-plugin.php` first and
     * ignores conflicting plugins in {@see Pico::$pluginsDir}.
     *
     * The official PicoDeprecated plugin must be loaded when plugins that use
     * an older API version than Pico's API version ({@see Pico::API_VERSION})
     * are loaded.
     *
     * Please note that Pico will change the processing order when needed to
     * incorporate plugin dependencies. See {@see Pico::sortPlugins()} for
     * details.
     *
     * @see Pico::loadPlugin()
     * @see Pico::getPlugin()
     * @see Pico::getPlugins()
     *
     * @throws RuntimeException thrown when a plugin couldn't be loaded
     */
    protected function loadPlugins()
    {
        $composerPlugins = $this->loadComposerPlugins();

        if ($this->enableLocalPlugins) {
            $this->loadLocalPlugins($composerPlugins);
        }

        if (!isset($this->plugins['PicoDeprecated']) && (count($this->plugins) !== count($this->nativePlugins))) {
            throw new RuntimeException(
                "Plugins using an older API than version " . static::API_VERSION . " found, "
                . "but PicoDeprecated isn't loaded"
            );
        }
    }

    /**
     * Loads plugins from vendor/pico-plugin.php
     *
     * This method loads all plugins installed using composer and Pico's
     * `picocms/composer-installer` installer by reading the `pico-plugin.php`
     * in composer's `vendor` dir.
     *
     * @see Pico::loadPlugins()
     * @see Pico::loadLocalPlugins()
     *
     * @param string[] $pluginBlacklist class names of plugins not to load
     *
     * @return string[] installer names of the loaded plugins
     *
     * @throws RuntimeException thrown when a plugin couldn't be loaded
     */
    protected function loadComposerPlugins(array $pluginBlacklist = array())
    {
        $composerPlugins = array();
        if (is_file($this->getVendorDir() . 'vendor/pico-plugin.php')) {
            // composer root package
            $composerPlugins = require($this->getVendorDir() . 'vendor/pico-plugin.php') ?: array();
        } elseif (is_file($this->getVendorDir() . '../../../vendor/pico-plugin.php')) {
            // composer dependency package
            $composerPlugins = require($this->getVendorDir() . '../../../vendor/pico-plugin.php') ?: array();
        }

        $pluginBlacklist = array_fill_keys($pluginBlacklist, true);

        $loadedPlugins = array();
        foreach ($composerPlugins as $package => $pluginData) {
            $loadedPlugins[] = $pluginData['installerName'];

            foreach ($pluginData['classNames'] as $className) {
                $plugin = new $className($this);
                $className = get_class($plugin);

                if (isset($this->plugins[$className]) || isset($pluginBlacklist[$className])) {
                    continue;
                }

                if (!($plugin instanceof PicoPluginInterface)) {
                    throw new RuntimeException(
                        "Unable to load plugin '" . $className . "' via 'vendor/pico-plugin.php': "
                        . "Plugins installed by composer must implement 'PicoPluginInterface'"
                    );
                }

                $this->plugins[$className] = $plugin;

                if (defined($className . '::API_VERSION') && ($className::API_VERSION >= static::API_VERSION)) {
                    $this->nativePlugins[$className] = $plugin;
                }
            }
        }

        return $loadedPlugins;
    }

    /**
     * Loads plugins from Pico::$pluginsDir in alphabetical order
     *
     * Pico tries to load plugins from `<plugin name>/<plugin name>.php` and
     * `<plugin name>.php` only. Plugin names are treated case insensitive.
     * Pico will throw a RuntimeException if it can't load a plugin.
     *
     * Plugin files MAY be prefixed by a number (e.g. `00-PicoDeprecated.php`)
     * to indicate their processing order. Plugins without a prefix will be
     * loaded last. If you want to use a prefix, you MUST NOT use the reserved
     * prefixes `00` to `09`. Prefixes are completely optional, however, you
     * SHOULD take the following prefix classification into consideration:
     * - 10 to 19: Reserved
     * - 20 to 39: Low level code helper plugins
     * - 40 to 59: Plugins manipulating routing or the pages array
     * - 60 to 79: Plugins hooking into template or markdown parsing
     * - 80 to 99: Plugins using the `onPageRendered` event
     *
     * @see Pico::loadPlugins()
     * @see Pico::loadComposerPlugins()
     *
     * @param string[] $pluginBlacklist class names of plugins not to load
     *
     * @throws RuntimeException thrown when a plugin couldn't be loaded
     */
    protected function loadLocalPlugins(array $pluginBlacklist = array())
    {
        // scope isolated require()
        $includeClosure = function ($pluginFile) {
            require($pluginFile);
        };
        if (PHP_VERSION_ID >= 50400) {
            $includeClosure = $includeClosure->bindTo(null);
        }

        $pluginBlacklist = array_fill_keys($pluginBlacklist, true);

        $files = scandir($this->getPluginsDir()) ?: array();
        foreach ($files as $file) {
            if ($file[0] === '.') {
                continue;
            }

            $className = $pluginFile = null;
            if (is_dir($this->getPluginsDir() . $file)) {
                $className = preg_replace('/^[0-9]+-/', '', $file);
                $pluginFile = $file . '/' . $className . '.php';

                if (!is_file($this->getPluginsDir() . $pluginFile)) {
                    throw new RuntimeException(
                        "Unable to load plugin '" . $className . "' from '" . $pluginFile . "': File not found"
                    );
                }
            } elseif (substr($file, -4) === '.php') {
                $className = preg_replace('/^[0-9]+-/', '', substr($file, 0, -4));
                $pluginFile = $file;
            } else {
                throw new RuntimeException("Unable to load plugin from '" . $file . "': Not a valid plugin file");
            }

            if (isset($this->plugins[$className]) || isset($pluginBlacklist[$className])) {
                continue;
            }

            $includeClosure($this->getPluginsDir() . $pluginFile);

            if (class_exists($className, false)) {
                // class name and file name can differ regarding case sensitivity
                $plugin = new $className($this);
                $className = get_class($plugin);

                $this->plugins[$className] = $plugin;

                if ($plugin instanceof PicoPluginInterface) {
                    if (defined($className . '::API_VERSION') && ($className::API_VERSION >= static::API_VERSION)) {
                        $this->nativePlugins[$className] = $plugin;
                    }
                }
            } else {
                throw new RuntimeException(
                    "Unable to load plugin '" . $className . "' from '" . $pluginFile . "': Plugin class not found"
                );
            }
        }
    }

    /**
     * Manually loads a plugin
     *
     * Manually loaded plugins MUST implement {@see PicoPluginInterface}. They
     * are simply appended to the plugins array without any additional checks,
     * so you might get unexpected results, depending on *when* you're loading
     * a plugin. You SHOULD NOT load plugins after a event has been triggered
     * by Pico. In-depth knowledge of Pico's inner workings is strongly advised
     * otherwise, and you MUST NOT rely on {@see PicoDeprecated} to maintain
     * backward compatibility in such cases.
     *
     * If you e.g. load a plugin after the `onPluginsLoaded` event, Pico
     * doesn't guarantee the plugin's order ({@see Pico::sortPlugins()}).
     * Already triggered events won't get triggered on the manually loaded
     * plugin. Thus you SHOULD load plugins either before {@see Pico::run()}
     * is called, or via the constructor of another plugin (i.e. the plugin's
     * `__construct()` method; plugins are instanced in
     * {@see Pico::loadPlugins()}).
     *
     * This method triggers the `onPluginManuallyLoaded` event.
     *
     * @see Pico::loadPlugins()
     * @see Pico::getPlugin()
     * @see Pico::getPlugins()
     *
     * @param PicoPluginInterface|string $plugin either the class name of a
     *     plugin to instantiate or a plugin instance
     *
     * @return PicoPluginInterface instance of the loaded plugin
     *
     * @throws RuntimeException thrown when the plugin couldn't be loaded
     */
    public function loadPlugin($plugin)
    {
        if (!is_object($plugin)) {
            $className = (string) $plugin;
            if (class_exists($className)) {
                $plugin = new $className($this);
            } else {
                throw new RuntimeException("Unable to load plugin '" . $className . "': Class not found");
            }
        }

        $className = get_class($plugin);

        if (!($plugin instanceof PicoPluginInterface)) {
            throw new RuntimeException(
                "Unable to load plugin '" . $className . "': "
                . "Manually loaded plugins must implement 'PicoPluginInterface'"
            );
        }

        $this->plugins[$className] = $plugin;

        if (defined($className . '::API_VERSION') && ($className::API_VERSION >= static::API_VERSION)) {
            $this->nativePlugins[$className] = $plugin;
        }

        // trigger onPluginManuallyLoaded event
        // the event is also triggered on the newly loaded plugin, allowing you to distinguish manual and auto loading
        $this->triggerEvent('onPluginManuallyLoaded', array($plugin));

        return $plugin;
    }

    /**
     * Sorts all loaded plugins using a plugin dependency topology
     *
     * Execution order matters: if plugin A depends on plugin B, it usually
     * means that plugin B does stuff which plugin A requires. However, Pico
     * loads plugins in alphabetical order, so events might get fired on
     * plugin A before plugin B.
     *
     * Hence plugins need to be sorted. Pico sorts plugins using a dependency
     * topology, this means that it moves all plugins, on which a plugin
     * depends, in front of that plugin. The order isn't touched apart from
     * that, so they are still sorted alphabetically, as long as this doesn't
     * interfere with the dependency topology. Circular dependencies are being
     * ignored; their behavior is undefiend. Missing dependencies are being
     * ignored until you try to enable the dependant plugin.
     *
     * This method bases on Marc J. Schmidt's Topological Sort library in
     * version 1.1.0, licensed under the MIT license. It uses the `ArraySort`
     * implementation (class `\MJS\TopSort\Implementations\ArraySort`).
     *
     * @see Pico::loadPlugins()
     * @see Pico::getPlugins()
     * @see https://github.com/marcj/topsort.php
     *     Marc J. Schmidt's Topological Sort / Dependency resolver in PHP
     * @see https://github.com/marcj/topsort.php/blob/1.1.0/src/Implementations/ArraySort.php
     *     \MJS\TopSort\Implementations\ArraySort class
     */
    protected function sortPlugins()
    {
        $plugins = $this->plugins;
        $nativePlugins = $this->nativePlugins;
        $sortedPlugins = array();
        $sortedNativePlugins = array();
        $visitedPlugins = array();

        $visitPlugin = function ($plugin) use (
            $plugins,
            $nativePlugins,
            &$sortedPlugins,
            &$sortedNativePlugins,
            &$visitedPlugins,
            &$visitPlugin
        ) {
            $pluginName = get_class($plugin);

            // skip already visited plugins and ignore circular dependencies
            if (!isset($visitedPlugins[$pluginName])) {
                $visitedPlugins[$pluginName] = true;

                $dependencies = array();
                if ($plugin instanceof PicoPluginInterface) {
                    $dependencies = $plugin->getDependencies();
                }
                if (!isset($nativePlugins[$pluginName])) {
                    $dependencies[] = 'PicoDeprecated';
                }

                foreach ($dependencies as $dependency) {
                    // ignore missing dependencies
                    // this is only a problem when the user tries to enable this plugin
                    if (isset($plugins[$dependency])) {
                        $visitPlugin($plugins[$dependency]);
                    }
                }

                $sortedPlugins[$pluginName] = $plugin;
                if (isset($nativePlugins[$pluginName])) {
                    $sortedNativePlugins[$pluginName] = $plugin;
                }
            }
        };

        if (isset($this->plugins['PicoDeprecated'])) {
            $visitPlugin($this->plugins['PicoDeprecated']);
        }

        foreach ($this->plugins as $plugin) {
            $visitPlugin($plugin);
        }

        $this->plugins = $sortedPlugins;
        $this->nativePlugins = $sortedNativePlugins;
    }

    /**
     * Returns the instance of a named plugin
     *
     * Plugins SHOULD implement {@see PicoPluginInterface}, but you MUST NOT
     * rely on it. For more information see {@see PicoPluginInterface}.
     *
     * @see Pico::loadPlugins()
     * @see Pico::getPlugins()
     *
     * @param string $pluginName name of the plugin
     *
     * @return object instance of the plugin
     *
     * @throws RuntimeException thrown when the plugin wasn't found
     */
    public function getPlugin($pluginName)
    {
        if (isset($this->plugins[$pluginName])) {
            return $this->plugins[$pluginName];
        }

        throw new RuntimeException("Missing plugin '" . $pluginName . "'");
    }

    /**
     * Returns all loaded plugins
     *
     * @see Pico::loadPlugins()
     * @see Pico::getPlugin()
     *
     * @return object[]|null
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * Loads config.yml and any other *.yml from Pico::$configDir
     *
     * After loading {@path "config/config.yml"}, Pico proceeds with any other
     * existing `config/*.yml` file in alphabetical order. The file order is
     * crucial: Config values which have been set already, cannot be
     * overwritten by a succeeding file. This is also true for arrays, i.e.
     * when specifying `test: { foo: bar }` in `config/a.yml` and
     * `test: { baz: 42 }` in `config/b.yml`, `{{ config.test.baz }}` will be
     * undefined!
     *
     * @see Pico::setConfig()
     * @see Pico::getConfig()
     */
    protected function loadConfig()
    {
        // load config closure
        $yamlParser = $this->getYamlParser();
        $loadConfigClosure = function ($configFile) use ($yamlParser) {
            $yaml = file_get_contents($configFile);
            $config = $yamlParser->parse($yaml);
            return is_array($config) ? $config : array();
        };

        // load main config file (config/config.yml)
        $this->config = is_array($this->config) ? $this->config : array();
        if (is_file($this->getConfigDir() . 'config.yml')) {
            $this->config += $loadConfigClosure($this->getConfigDir() . 'config.yml');
        }

        // merge $config of config/*.yml files
        $configFiles = $this->getFilesGlob($this->getConfigDir() . '*.yml');
        foreach ($configFiles as $configFile) {
            if ($configFile !== $this->getConfigDir() . 'config.yml') {
                $this->config += $loadConfigClosure($configFile);
            }
        }

        // merge default config
        $this->config += array(
            'site_title' => 'Pico',
            'base_url' => null,
            'rewrite_url' => null,
            'debug' => null,
            'timezone' => null,
            'theme' => 'default',
            'theme_config' => null,
            'theme_meta' => null,
            'themes_url' => null,
            'twig_config' => null,
            'date_format' => '%D %T',
            'pages_order_by_meta' => 'author',
            'pages_order_by' => 'alpha',
            'pages_order' => 'asc',
            'content_dir' => null,
            'content_ext' => '.md',
            'content_config' => null,
            'assets_dir' => 'assets/',
            'assets_url' => null,
            'plugins_url' => null
        );

        if (!$this->config['base_url']) {
            $this->config['base_url'] = $this->getBaseUrl();
        } else {
            $this->config['base_url'] = rtrim($this->config['base_url'], '/') . '/';
        }

        if ($this->config['rewrite_url'] === null) {
            $this->config['rewrite_url'] = $this->isUrlRewritingEnabled();
        }

        if ($this->config['debug'] === null) {
            $this->config['debug'] = $this->isDebugModeEnabled();
        }

        if (!$this->config['timezone']) {
            // explicitly set a default timezone to prevent a E_NOTICE when no timezone is set;
            // the `date_default_timezone_get()` function always returns a timezone, at least UTC
            $this->config['timezone'] = @date_default_timezone_get();
        }
        date_default_timezone_set($this->config['timezone']);

        if (!$this->config['plugins_url']) {
            $this->config['plugins_url'] = $this->getUrlFromPath($this->getPluginsDir());
        } else {
            $this->config['plugins_url'] = $this->getAbsoluteUrl($this->config['plugins_url']);
        }

        if (!$this->config['themes_url']) {
            $this->config['themes_url'] = $this->getUrlFromPath($this->getThemesDir());
        } else {
            $this->config['themes_url'] = $this->getAbsoluteUrl($this->config['themes_url']);
        }

        if (!$this->config['content_dir']) {
            // try to guess the content directory
            if (is_file($this->getRootDir() . 'content/index' . $this->config['content_ext'])) {
                $this->config['content_dir'] = $this->getRootDir() . 'content/';
            } elseif (is_file($this->getRootDir() . 'content-sample/index' . $this->config['content_ext'])) {
                $this->config['content_dir'] = $this->getRootDir() . 'content-sample/';
            } else {
                $this->config['content_dir'] = $this->getVendorDir() . 'content-sample/';
            }
        } else {
            $this->config['content_dir'] = $this->getAbsolutePath($this->config['content_dir']);
        }

        $defaultContentConfig = array('extra' => true, 'breaks' => false, 'escape' => false, 'auto_urls' => true);
        if (!is_array($this->config['content_config'])) {
            $this->config['content_config'] = $defaultContentConfig;
        } else {
            $this->config['content_config'] += $defaultContentConfig;
        }

        if (!$this->config['assets_dir']) {
            $this->config['assets_dir'] = $this->getRootDir() . 'assets/';
        } else {
            $this->config['assets_dir'] = $this->getAbsolutePath($this->config['assets_dir']);
        }

        if (!$this->config['assets_url']) {
            $this->config['assets_url'] = $this->getUrlFromPath($this->config['assets_dir']);
        } else {
            $this->config['assets_url'] = $this->getAbsoluteUrl($this->config['assets_url']);
        }
    }

    /**
     * Sets Pico's config before calling Pico::run()
     *
     * This method allows you to modify Pico's config without creating a
     * {@path "config/config.yml"} or changing some of its variables before
     * Pico starts processing.
     *
     * You can call this method between {@see Pico::__construct()} and
     * {@see Pico::run()} only. Options set with this method cannot be
     * overwritten by {@path "config/config.yml"}.
     *
     * @see Pico::loadConfig()
     * @see Pico::getConfig()
     *
     * @param array $config array with config variables
     *
     * @throws LogicException thrown if Pico already started processing
     */
    public function setConfig(array $config)
    {
        if ($this->locked) {
            throw new LogicException("You cannot modify Pico's config after processing has started");
        }

        $this->config = $config;
    }

    /**
     * Returns either the value of the specified config variable or
     * the config array
     *
     * @see Pico::setConfig()
     * @see Pico::loadConfig()
     *
     * @param string $configName optional name of a config variable
     * @param mixed  $default    optional default value to return when the
     *     named config variable doesn't exist
     *
     * @return mixed if no name of a config variable has been supplied, the
     *     config array is returned; otherwise it returns either the value of
     *     the named config variable, or, if the named config variable doesn't
     *     exist, the provided default value or NULL
     */
    public function getConfig($configName = null, $default = null)
    {
        if ($configName !== null) {
            return isset($this->config[$configName]) ? $this->config[$configName] : $default;
        } else {
            return $this->config;
        }
    }

    /**
     * Loads a theme's config file (pico-theme.yml)
     *
     * @see Pico::getTheme()
     * @see Pico::getThemeApiVersion()
     */
    protected function loadTheme()
    {
        $themeConfig = array();

        // load theme config from pico-theme.yml
        $themeConfigFile = $this->getThemesDir() . $this->getTheme() . '/pico-theme.yml';
        if (is_file($themeConfigFile)) {
            $themeConfigYaml = file_get_contents($themeConfigFile);
            $themeConfig = $this->getYamlParser()->parse($themeConfigYaml);
            $themeConfig = is_array($themeConfig) ? $themeConfig : array();
        }

        $themeConfig += array(
            'api_version' => null,
            'meta' => array(),
            'twig_config' => array()
        );

        // theme API version
        if (is_int($themeConfig['api_version']) || preg_match('/^[0-9]+$/', $themeConfig['api_version'])) {
            $this->themeApiVersion = (int) $themeConfig['api_version'];
        } else {
            $this->themeApiVersion = 0;
        }

        unset($themeConfig['api_version']);

        // twig config
        $themeTwigConfig = array('autoescape' => 'html', 'strict_variables' => false, 'charset' => 'utf-8');
        foreach ($themeTwigConfig as $key => $_) {
            if (isset($themeConfig['twig_config'][$key])) {
                $themeTwigConfig[$key] = $themeConfig['twig_config'][$key];
            }
        }

        unset($themeConfig['twig_config']);

        $defaultTwigConfig = array('debug' => null, 'cache' => false, 'auto_reload' => null);
        $this->config['twig_config'] = is_array($this->config['twig_config']) ? $this->config['twig_config'] : array();
        $this->config['twig_config'] = array_merge($defaultTwigConfig, $themeTwigConfig, $this->config['twig_config']);

        if ($this->config['twig_config']['autoescape'] === true) {
            $this->config['twig_config']['autoescape'] = 'html';
        }
        if ($this->config['twig_config']['cache']) {
            $this->config['twig_config']['cache'] = $this->getAbsolutePath($this->config['twig_config']['cache']);
        }
        if ($this->config['twig_config']['debug'] === null) {
            $this->config['twig_config']['debug'] = $this->isDebugModeEnabled();
        }

        // meta headers
        $this->themeMetaHeaders = is_array($themeConfig['meta']) ? $themeConfig['meta'] : array();
        unset($themeConfig['meta']);

        // theme config
        if (!is_array($this->config['theme_config'])) {
            $this->config['theme_config'] = $themeConfig;
        } else {
            $this->config['theme_config'] += $themeConfig;
        }

        // check for theme compatibility
        if (!isset($this->plugins['PicoDeprecated']) && ($this->themeApiVersion < static::API_VERSION)) {
            throw new RuntimeException(
                'Current theme "' . $this->theme . '" uses API version ' . $this->themeApiVersion . ', but Pico '
                . 'provides API version ' . static::API_VERSION . ' and PicoDeprecated isn\'t loaded'
            );
        }
    }

    /**
     * Returns the name of the current theme
     *
     * @see Pico::loadTheme()
     * @see Pico::getThemeApiVersion()
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Returns the API version of the current theme
     *
     * @see Pico::loadTheme()
     * @see Pico::getTheme()
     *
     * @return int
     */
    public function getThemeApiVersion()
    {
        return $this->themeApiVersion;
    }

    /**
     * Evaluates the requested URL
     *
     * Pico uses the `QUERY_STRING` routing method (e.g. `/pico/?sub/page`)
     * to support SEO-like URLs out-of-the-box with any webserver. You can
     * still setup URL rewriting to basically remove the `?` from URLs.
     * However, URL rewriting requires some special configuration of your
     * webserver, but this should be "basic work" for any webmaster...
     *
     * With Pico 1.0 you had to setup URL rewriting (e.g. using `mod_rewrite`
     * on Apache) in a way that rewritten URLs follow the `QUERY_STRING`
     * principles. Starting with version 2.0, Pico additionally supports the
     * `REQUEST_URI` routing method, what allows you to simply rewrite all
     * requests to just `index.php`. Pico then reads the requested page from
     * the `REQUEST_URI` environment variable provided by the webserver.
     * Please note that `QUERY_STRING` takes precedence over `REQUEST_URI`.
     *
     * Pico 0.9 and older required Apache with `mod_rewrite` enabled, thus old
     * plugins, templates and contents may require you to enable URL rewriting
     * to work. If you're upgrading from Pico 0.9, you will probably have to
     * update your rewriting rules.
     *
     * We recommend you to use the `link` filter in templates to create
     * internal links, e.g. `{{ "sub/page"|link }}` is equivalent to
     * `{{ base_url }}/sub/page` and `{{ base_url }}?sub/page`, depending on
     * enabled URL rewriting. In content files you can use the `%base_url%`
     * variable; e.g. `%base_url%?sub/page` will be replaced accordingly.
     *
     * Heads up! Pico always interprets the first parameter as name of the
     * requested page (provided that the parameter has no value). According to
     * that you MUST NOT call Pico with a parameter without value as first
     * parameter (e.g. http://example.com/pico/?someBooleanParam), otherwise
     * Pico interprets `someBooleanParam` as name of the requested page. Use
     * `/pico/?someBooleanParam=` or `/pico/?index&someBooleanParam` instead.
     *
     * @see Pico::getRequestUrl()
     */
    protected function evaluateRequestUrl()
    {
        // use QUERY_STRING; e.g. /pico/?sub/page
        $pathComponent = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
        if ($pathComponent) {
            $pathComponent = strstr($pathComponent, '&', true) ?: $pathComponent;
            if (strpos($pathComponent, '=') === false) {
                $this->requestUrl = trim(rawurldecode($pathComponent), '/');
            }
        }

        // use REQUEST_URI (requires URL rewriting); e.g. /pico/sub/page
        if (($this->requestUrl === null) && $this->isUrlRewritingEnabled()) {
            $scriptName = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '/index.php';

            $basePath = dirname($scriptName);
            $basePath = !in_array($basePath, array('.', '/', '\\'), true) ? $basePath . '/' : '/';
            $basePathLength = strlen($basePath);

            $requestUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
            if ($requestUri && (substr($requestUri, 0, $basePathLength) === $basePath)) {
                $requestUri = substr($requestUri, $basePathLength);
                if ($requestUri && (($queryStringPos = strpos($requestUri, '?')) !== false)) {
                    $requestUri = substr($requestUri, 0, $queryStringPos);
                }
                if ($requestUri && ($requestUri !== basename($scriptName))) {
                    $this->requestUrl = rtrim(rawurldecode($requestUri), '/');
                }
            }
        }

        if ($this->requestUrl === null) {
            $this->requestUrl = '';
        }
    }

    /**
     * Returns the URL where a user requested the page
     *
     * @see Pico::evaluateRequestUrl()
     *
     * @return string|null request URL
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     * Resolves a given file path to its corresponding content file
     *
     * This method also prevents `content_dir` breakouts using malicious
     * request URLs. We don't use `realpath()`, because we neither want to
     * check for file existance, nor prohibit symlinks which intentionally
     * point to somewhere outside the `content_dir` folder. It is STRONGLY
     * RECOMMENDED to use PHP's `open_basedir` feature - always, not just
     * with Pico!
     *
     * @see Pico::getRequestFile()
     *
     * @param string $requestUrl path name (likely from a URL) to resolve
     *
     * @return string path to the resolved content file
     */
    public function resolveFilePath($requestUrl)
    {
        $contentDir = $this->getConfig('content_dir');
        $contentExt = $this->getConfig('content_ext');

        if (!$requestUrl) {
            return $contentDir . 'index' . $contentExt;
        } else {
            // normalize path and prevent content_dir breakouts
            $requestFile = $this->getNormalizedPath($requestUrl, false, false);

            // discover the content file to serve
            if (!$requestFile) {
                return $contentDir . 'index' . $contentExt;
            } elseif (is_dir($contentDir . $requestFile)) {
                // if no index file is found, try a accordingly named file in the previous dir
                // if this file doesn't exist either, show the 404 page, but assume the index
                // file as being requested (maintains backward compatibility to Pico < 1.0)
                $indexFile = $contentDir . $requestFile . '/index' . $contentExt;
                if (is_file($indexFile) || !is_file($contentDir . $requestFile . $contentExt)) {
                    return $indexFile;
                }
            }
            return $contentDir . $requestFile . $contentExt;
        }
    }

    /**
     * Returns the absolute path to the content file to serve
     *
     * @see Pico::resolveFilePath()
     *
     * @return string|null file pat
     */
    public function getRequestFile()
    {
        return $this->requestFile;
    }

    /**
     * Returns the raw contents of a file
     *
     * @see Pico::getRawContent()
     *
     * @param string $file file path
     *
     * @return string raw contents of the file
     */
    public function loadFileContent($file)
    {
        return file_get_contents($file);
    }

    /**
     * Returns the raw contents of the first found 404 file when traversing
     * up from the directory the requested file is in
     *
     * If no suitable `404.md` is found, fallback to a built-in error message.
     *
     * @see Pico::getRawContent()
     *
     * @param string $file path to requested (but not existing) file
     *
     * @return string raw contents of the 404 file
     */
    public function load404Content($file)
    {
        $contentDir = $this->getConfig('content_dir');
        $contentDirLength = strlen($contentDir);
        $contentExt = $this->getConfig('content_ext');

        if (substr($file, 0, $contentDirLength) === $contentDir) {
            $errorFileDir = substr($file, $contentDirLength);

            while ($errorFileDir !== '.') {
                $errorFileDir = dirname($errorFileDir);
                $errorFile = $errorFileDir . '/404' . $contentExt;

                if (is_file($contentDir . $errorFile)) {
                    return $this->loadFileContent($contentDir . $errorFile);
                }
            }
        } elseif (is_file($contentDir . '404' . $contentExt)) {
            // provided that the requested file is not in the regular
            // content directory, fallback to Pico's global `404.md`
            return $this->loadFileContent($contentDir . '404' . $contentExt);
        }

        // fallback to built-in error message
        $rawErrorContent = "---\n"
            . "Title: Error 404\n"
            . "Robots: noindex,nofollow\n"
            . "---\n\n"
            . "# Error 404\n\n"
            . "Woops. Looks like this page doesn't exist.\n";
        return $rawErrorContent;
    }

    /**
     * Returns the raw contents, either of the requested or the 404 file
     *
     * @see Pico::loadFileContent()
     * @see Pico::load404Content()
     *
     * @return string|null raw contents
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * Returns TRUE when Pico is serving a 404 page
     *
     * @see Pico::load404Content()
     *
     * @return bool TRUE if Pico is serving a 404 page, FALSE otherwise
     */
    public function is404Content()
    {
        return $this->is404Content;
    }

    /**
     * Returns known meta headers
     *
     * This method triggers the `onMetaHeaders` event when the known meta
     * headers weren't assembled yet.
     *
     * @return string[] known meta headers; the array key specifies the YAML
     *     key to search for, the array value is later used to access the
     *     found value
     */
    public function getMetaHeaders()
    {
        if ($this->metaHeaders === null) {
            $this->metaHeaders = array(
                'Title' => 'title',
                'Description' => 'description',
                'Author' => 'author',
                'Date' => 'date',
                'Formatted Date' => 'date_formatted',
                'Time' => 'time',
                'Robots' => 'robots',
                'Template' => 'template',
                'Hidden' => 'hidden'
            );

            if ($this->themeMetaHeaders) {
                $this->metaHeaders += $this->themeMetaHeaders;
            }

            $this->triggerEvent('onMetaHeaders', array(&$this->metaHeaders));
        }

        return $this->metaHeaders;
    }

    /**
     * Returns the Symfony YAML parser
     *
     * This method triggers the `onYamlParserRegistered` event when the Symfony
     * YAML parser wasn't initiated yet.
     *
     * @return \Symfony\Component\Yaml\Parser Symfony YAML parser
     */
    public function getYamlParser()
    {
        if ($this->yamlParser === null) {
            $this->yamlParser = new \Symfony\Component\Yaml\Parser();
            $this->triggerEvent('onYamlParserRegistered', array(&$this->yamlParser));
        }

        return $this->yamlParser;
    }

    /**
     * Parses the file meta from raw file contents
     *
     * Meta data MUST start on the first line of the file, either opened and
     * closed by `---` or C-style block comments (deprecated). The headers are
     * parsed by the YAML component of the Symfony project. If you're a plugin
     * developer, you MUST register new headers during the `onMetaHeaders`
     * event first. The implicit availability of headers is for users and
     * pure (!) theme developers ONLY.
     *
     * @see Pico::getFileMeta()
     *
     * @param string   $rawContent the raw file contents
     * @param string[] $headers    known meta headers
     *
     * @return array parsed meta data
     *
     * @throws \Symfony\Component\Yaml\Exception\ParseException thrown when the
     *     meta data is invalid
     */
    public function parseFileMeta($rawContent, array $headers)
    {
        $meta = array();
        $pattern = "/^(?:\xEF\xBB\xBF)?(\/(\*)|---)[[:blank:]]*(?:\r)?\n"
            . "(?:(.*?)(?:\r)?\n)?(?(2)\*\/|---)[[:blank:]]*(?:(?:\r)?\n|$)/s";
        if (preg_match($pattern, $rawContent, $rawMetaMatches) && isset($rawMetaMatches[3])) {
            $meta = $this->getYamlParser()->parse($rawMetaMatches[3]) ?: array();
            $meta = is_array($meta) ? $meta : array('title' => $meta);

            foreach ($headers as $name => $key) {
                if (isset($meta[$name])) {
                    // rename field (e.g. remove whitespaces)
                    if ($key != $name) {
                        $meta[$key] = $meta[$name];
                        unset($meta[$name]);
                    }
                } elseif (!isset($meta[$key])) {
                    // guarantee array key existance
                    $meta[$key] = '';
                }
            }

            if (!empty($meta['date']) || !empty($meta['time'])) {
                // workaround for issue #336
                // Symfony YAML interprets ISO-8601 datetime strings and returns timestamps instead of the string
                // this behavior conforms to the YAML standard, i.e. this is no bug of Symfony YAML
                if (is_int($meta['date'])) {
                    $meta['time'] = $meta['date'];
                    $meta['date'] = '';
                }

                if (empty($meta['time'])) {
                    $meta['time'] = strtotime($meta['date']) ?: '';
                } elseif (empty($meta['date'])) {
                    $rawDateFormat = (date('H:i:s', $meta['time']) === '00:00:00') ? 'Y-m-d' : 'Y-m-d H:i:s';
                    $meta['date'] = date($rawDateFormat, $meta['time']);
                }
            } else {
                $meta['date'] = $meta['time'] = '';
            }

            if (empty($meta['date_formatted'])) {
                $dateFormat = $this->getConfig('date_format');
                $meta['date_formatted'] = $meta['time'] ? utf8_encode(strftime($dateFormat, $meta['time'])) : '';
            }
        } else {
            // guarantee array key existance
            $meta = array_fill_keys($headers, '');
        }

        return $meta;
    }

    /**
     * Returns the parsed meta data of the requested page
     *
     * @see Pico::parseFileMeta()
     *
     * @return array|null parsed meta data
     */
    public function getFileMeta()
    {
        return $this->meta;
    }

    /**
     * Returns the Parsedown markdown parser
     *
     * This method triggers the `onParsedownRegistered` event when the
     * Parsedown markdown parser wasn't initiated yet.
     *
     * @return Parsedown Parsedown markdown parser
     */
    public function getParsedown()
    {
        if ($this->parsedown === null) {
            $className = $this->config['content_config']['extra'] ? 'ParsedownExtra' : 'Parsedown';
            $this->parsedown = new $className();

            $this->parsedown->setBreaksEnabled((bool) $this->config['content_config']['breaks']);
            $this->parsedown->setMarkupEscaped((bool) $this->config['content_config']['escape']);
            $this->parsedown->setUrlsLinked((bool) $this->config['content_config']['auto_urls']);

            $this->triggerEvent('onParsedownRegistered', array(&$this->parsedown));
        }

        return $this->parsedown;
    }

    /**
     * Applies some static preparations to the raw contents of a page
     *
     * This method removes the meta header and replaces `%...%` placeholders
     * by calling the {@see Pico::substituteFileContent()} method.
     *
     * @see Pico::substituteFileContent()
     * @see Pico::parseFileContent()
     * @see Pico::getFileContent()
     *
     * @param string $rawContent raw contents of a page
     * @param array  $meta       meta data to use for %meta.*% replacement
     *
     * @return string prepared Markdown contents
     */
    public function prepareFileContent($rawContent, array $meta = array())
    {
        // remove meta header
        $metaHeaderPattern = "/^(?:\xEF\xBB\xBF)?(\/(\*)|---)[[:blank:]]*(?:\r)?\n"
            . "(?:(.*?)(?:\r)?\n)?(?(2)\*\/|---)[[:blank:]]*(?:(?:\r)?\n|$)/s";
        $markdown = preg_replace($metaHeaderPattern, '', $rawContent, 1);

        // replace placeholders
        $markdown = $this->substituteFileContent($markdown, $meta);

        return $markdown;
    }

    /**
     * Replaces all %...% placeholders in a page's contents
     *
     * @param string $markdown Markdown contents of a page
     * @param array  $meta     meta data to use for %meta.*% replacement
     *
     * @return string substituted Markdown contents
     */
    public function substituteFileContent($markdown, array $meta = array())
    {
        $variables = array();

        // replace %version%
        $variables['%version%'] = static::VERSION;

        // replace %site_title%
        $variables['%site_title%'] = $this->getConfig('site_title');

        // replace %base_url%
        if ($this->isUrlRewritingEnabled()) {
            // always use `%base_url%?sub/page` syntax for internal links
            // we'll replace the links accordingly, depending on enabled rewriting
            $variables['%base_url%?'] = $this->getBaseUrl();
        } else {
            // actually not necessary, but makes the URL look a little nicer
            $variables['%base_url%?'] = $this->getBaseUrl() . '?';
        }
        $variables['%base_url%'] = rtrim($this->getBaseUrl(), '/');

        // replace %plugins_url%, %themes_url% and %assets_url%
        $variables['%plugins_url%'] = rtrim($this->getConfig('plugins_url'), '/');
        $variables['%themes_url%'] = rtrim($this->getConfig('themes_url'), '/');
        $variables['%assets_url%'] = rtrim($this->getConfig('assets_url'), '/');

        // replace %theme_url%
        $variables['%theme_url%'] = $this->getConfig('themes_url') . $this->getTheme();

        // replace %meta.*%
        if ($meta) {
            foreach ($meta as $metaKey => $metaValue) {
                if (is_scalar($metaValue) || ($metaValue === null)) {
                    $variables['%meta.' . $metaKey . '%'] = (string) $metaValue;
                }
            }
        }

        // replace %config.*%
        foreach ($this->config as $configKey => $configValue) {
            if (is_scalar($configValue) || ($configValue === null)) {
                $variables['%config.' . $configKey . '%'] = (string) $configValue;
            }
        }

        return str_replace(array_keys($variables), $variables, $markdown);
    }

    /**
     * Parses the contents of a page using ParsedownExtra
     *
     * @see Pico::prepareFileContent()
     * @see Pico::substituteFileContent()
     * @see Pico::getFileContent()
     *
     * @param string $markdown   Markdown contents of a page
     * @param bool   $singleLine whether to parse just a single line of markup
     *
     * @return string parsed contents (HTML)
     */
    public function parseFileContent($markdown, $singleLine = false)
    {
        $markdownParser = $this->getParsedown();
        return !$singleLine ? $markdownParser->text($markdown) : $markdownParser->line($markdown);
    }

    /**
     * Returns the cached contents of the requested page
     *
     * @see Pico::prepareFileContent()
     * @see Pico::substituteFileContent()
     * @see Pico::parseFileContent()
     *
     * @return string|null parsed contents
     */
    public function getFileContent()
    {
        return $this->content;
    }

    /**
     * Reads the data of all pages known to Pico
     *
     * The page data will be an array containing the following values:
     *
     * | Array key      | Type     | Description                              |
     * | -------------- | -------  | ---------------------------------------- |
     * | id             | string   | relative path to the content file        |
     * | url            | string   | URL to the page                          |
     * | title          | string   | title of the page (YAML header)          |
     * | description    | string   | description of the page (YAML header)    |
     * | author         | string   | author of the page (YAML header)         |
     * | time           | int      | timestamp derived from the Date header   |
     * | date           | string   | date of the page (YAML header)           |
     * | date_formatted | string   | formatted date of the page               |
     * | hidden         | bool     | this page shouldn't be visible           |
     * | raw_content    | string   | raw, not yet parsed contents of the page |
     * | meta           | string[] | parsed meta data of the page             |
     * | previous_page  | &array[] | reference to the previous page           |
     * | next_page      | &array[] | reference to the next page               |
     * | tree_node      | &array[] | reference to the page's tree node        |
     *
     * Please note that the `previous_page` and `next_page` keys don't
     * exist until the `onCurrentPageDiscovered` event is triggered
     * ({@see Pico::discoverPageSiblings()}). The `tree_node` key doesn't
     * exit until the `onPageTreeBuilt` event is triggered
     * ({@see Pico::buildPageTree()}).
     *
     * @see Pico::sortPages()
     * @see Pico::discoverPageSiblings()
     * @see Pico::getPages()
     */
    protected function readPages()
    {
        $contentDir = $this->getConfig('content_dir');
        $contentExt = $this->getConfig('content_ext');

        $this->pages = array();
        $files = $this->getFiles($contentDir, $contentExt, self::SORT_NONE);
        foreach ($files as $i => $file) {
            // skip 404 page
            if (basename($file) === '404' . $contentExt) {
                unset($files[$i]);
                continue;
            }

            $id = substr($file, strlen($contentDir), -strlen($contentExt));

            // trigger onSinglePageLoading event
            // skip inaccessible pages (e.g. drop "sub.md" if "sub/index.md" exists) by default
            $conflictFile = $contentDir . $id . '/index' . $contentExt;
            $skipFile = in_array($conflictFile, $files, true) ?: null;
            $this->triggerEvent('onSinglePageLoading', array($id, &$skipFile));

            if ($skipFile) {
                continue;
            }

            $url = $this->getPageUrl($id);
            if ($file !== $this->requestFile) {
                $rawContent = $this->loadFileContent($file);

                // trigger onSinglePageContent event
                $this->triggerEvent('onSinglePageContent', array($id, &$rawContent));

                $headers = $this->getMetaHeaders();
                try {
                    $meta = $this->parseFileMeta($rawContent, $headers);
                } catch (\Symfony\Component\Yaml\Exception\ParseException $e) {
                    $meta = $this->parseFileMeta('', $headers);
                    $meta['YAML_ParseError'] = $e->getMessage();
                }
            } else {
                $rawContent = &$this->rawContent;
                $meta = &$this->meta;
            }

            // build page data
            // title, description, author and date are assumed to be pretty basic data
            // everything else is accessible through $page['meta']
            $page = array(
                'id' => $id,
                'url' => $url,
                'title' => &$meta['title'],
                'description' => &$meta['description'],
                'author' => &$meta['author'],
                'time' => &$meta['time'],
                'date' => &$meta['date'],
                'date_formatted' => &$meta['date_formatted'],
                'hidden' => ($meta['hidden'] || preg_match('/(?:^|\/)_/', $id)),
                'raw_content' => &$rawContent,
                'meta' => &$meta
            );

            if ($file === $this->requestFile) {
                $page['content'] = &$this->content;
            }

            unset($rawContent, $meta);

            // trigger onSinglePageLoaded event
            $this->triggerEvent('onSinglePageLoaded', array(&$page));

            if ($page !== null) {
                $this->pages[$id] = $page;
            }
        }
    }

    /**
     * Sorts all pages known to Pico
     *
     * @see Pico::readPages()
     * @see Pico::getPages()
     */
    protected function sortPages()
    {
        // sort pages
        $order = strtolower($this->getConfig('pages_order'));
        $orderBy = strtolower($this->getConfig('pages_order_by'));

        if (($orderBy !== 'alpha') && ($orderBy !== 'date') && ($orderBy !== 'meta')) {
            return;
        }

        $alphaSortClosure = function ($a, $b) use ($order) {
            if (!empty($a['hidden']) xor !empty($b['hidden'])) {
                return (!empty($a['hidden']) - !empty($b['hidden'])) * (($order === 'desc') ? -1 : 1);
            }

            $aSortKey = (basename($a['id']) === 'index') ? dirname($a['id']) : $a['id'];
            $bSortKey = (basename($b['id']) === 'index') ? dirname($b['id']) : $b['id'];

            $cmp = strcmp($aSortKey, $bSortKey);
            return $cmp * (($order === 'desc') ? -1 : 1);
        };

        if ($orderBy === 'meta') {
            // sort by arbitrary meta value
            $orderByMeta = $this->getConfig('pages_order_by_meta');
            uasort($this->pages, function ($a, $b) use ($alphaSortClosure, $order, $orderByMeta) {
                $aSortValue = isset($a['meta'][$orderByMeta]) ? $a['meta'][$orderByMeta] : null;
                $aSortValueNull = ($aSortValue === null);

                $bSortValue = isset($b['meta'][$orderByMeta]) ? $b['meta'][$orderByMeta] : null;
                $bSortValueNull = ($bSortValue === null);

                $cmp = 0;
                if ($aSortValueNull || $bSortValueNull) {
                    $cmp = ($aSortValueNull - $bSortValueNull);
                } elseif ($aSortValue != $bSortValue) {
                    $cmp = ($aSortValue > $bSortValue) ? 1 : -1;
                }

                if ($cmp === 0) {
                    // never assume equality; fallback to alphabetical order
                    return $alphaSortClosure($a, $b);
                }

                return $cmp * (($order === 'desc') ? -1 : 1);
            });
        } elseif ($orderBy === 'date') {
            // sort by date
            uasort($this->pages, function ($a, $b) use ($alphaSortClosure, $order) {
                if (!empty($a['hidden']) xor !empty($b['hidden'])) {
                    return $alphaSortClosure($a, $b);
                }

                if (!$a['time'] || !$b['time']) {
                    $cmp = (!$a['time'] - !$b['time']);
                } else {
                    $cmp = ($b['time'] - $a['time']);
                }

                if ($cmp === 0) {
                    // never assume equality; fallback to alphabetical order
                    return $alphaSortClosure($a, $b);
                }

                return $cmp * (($order === 'desc') ? 1 : -1);
            });
        } else {
            // sort alphabetically
            uasort($this->pages, $alphaSortClosure);
        }
    }

    /**
     * Walks through the list of all known pages and discovers the previous and
     * next page respectively
     *
     * @see Pico::readPages()
     * @see Pico::getPages()
     */
    protected function discoverPageSiblings()
    {
        if (($this->getConfig('order_by') === 'date') && ($this->getConfig('order') === 'desc')) {
            $precedingPageKey = 'next_page';
            $succeedingPageKey = 'previous_page';
        } else {
            $precedingPageKey = 'previous_page';
            $succeedingPageKey = 'next_page';
        }

        $precedingPageId = null;
        foreach ($this->pages as $id => &$pageData) {
            $pageData[$precedingPageKey] = null;
            $pageData[$succeedingPageKey] = null;

            if (!empty($pageData['hidden'])) {
                continue;
            }

            if ($precedingPageId !== null) {
                $precedingPageData = &$this->pages[$precedingPageId];
                $pageData[$precedingPageKey] = &$precedingPageData;
                $precedingPageData[$succeedingPageKey] = &$pageData;
            }

            $precedingPageId = $id;
        }
    }

    /**
     * Returns the list of known pages
     *
     * @see Pico::readPages()
     *
     * @return array[]|null the data of all pages
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Discovers the page data of the requested page as well as the previous
     * and next page relative to it
     *
     * @see Pico::getCurrentPage()
     * @see Pico::getPreviousPage()
     * @see Pico::getNextPage()
     */
    protected function discoverCurrentPage()
    {
        $currentPageId = $this->getPageId($this->requestFile);
        if ($currentPageId && isset($this->pages[$currentPageId])) {
            $this->currentPage = &$this->pages[$currentPageId];
            $this->previousPage = &$this->pages[$currentPageId]['previous_page'];
            $this->nextPage = &$this->pages[$currentPageId]['next_page'];
        }
    }

    /**
     * Returns the data of the requested page
     *
     * @see Pico::discoverCurrentPage()
     *
     * @return array|null page data
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Returns the data of the previous page relative to the page being served
     *
     * @see Pico::discoverCurrentPage()
     *
     * @return array|null page data
     */
    public function getPreviousPage()
    {
        return $this->previousPage;
    }

    /**
     * Returns the data of the next page relative to the page being served
     *
     * @see Pico::discoverCurrentPage()
     *
     * @return array|null page data
     */
    public function getNextPage()
    {
        return $this->nextPage;
    }

    /**
     * Builds a tree structure containing all known pages
     *
     * Pico's page tree is a list of all the tree's branches (no matter the
     * depth). Thus, by iterating a array element, you get the nodes of a given
     * branch. All leaf nodes do represent a page, but inner nodes may or may
     * not represent a page (e.g. if there's a `sub/page.md`, but neither a
     * `sub/index.md` nor a `sub.md`, the inner node `sub`, that is the parent
     * of the `sub/page` node, represents no page itself).
     *
     * A page's file path describes its node's path in the tree (e.g. the page
     * `sub/page.md` is represented by the `sub/page` node, thus a child of the
     * `sub` node and a element of the `sub` branch). However, the index page
     * of a folder (e.g. `sub/index.md`), is *not* a node of the `sub` branch,
     * but rather of the `/` branch. The page's node is not `sub/index`, but
     * `sub`. If two pages are described by the same node (e.g. if both a
     * `sub/index.md` and a `sub.md` exist), the index page takes precedence.
     * Pico's main index page (i.e. `index.md`) is represented by the tree's
     * root node `/` and a special case: it is the only node of the `` (i.e.
     * the empty string) branch.
     *
     * A node is represented by an array with the keys `id`, `page` and
     * `children`. The `id` key contains a string with the node's name. If the
     * node represents a page, the `page` key is a reference to the page's
     * data array. If the node is a inner node, the `children` key is a
     * reference to its matching branch (i.e. a list of the node's children).
     * The order of a node's children matches the order in Pico's pages array.
     *
     * If you want to walk the whole page tree, start with the tree's root node
     * at `$pageTree[""]["/"]`, or rather, use `$pages["index"]["tree_node"]`.
     * The root node's `children` key is a reference to the `/` branch at
     * `$pageTree["/"]`, that is a list of the root node's direct child nodes
     * and their siblings.
     *
     * You MUST NOT iterate the page tree itself (i.e. the list of the tree's
     * branches), its order is undefined and the array will be replaced by a
     * non-iterable data structure with Pico 3.0.
     *
     * @see Pico::getPageTree()
     */
    protected function buildPageTree()
    {
        $this->pageTree = array();
        foreach ($this->pages as $id => &$pageData) {
            // main index page
            if ($id === 'index') {
                $this->pageTree['']['/']['id'] = '/';
                $this->pageTree['']['/']['page'] = &$pageData;
                $pageData['tree_node'] = &$this->pageTree['']['/'];
                continue;
            }

            // get a page's node and branch
            $basename = basename($id);
            $branch = dirname($id);

            $isIndexPage = ($basename === 'index');
            if ($isIndexPage) {
                $basename = basename($branch);
                $branch = dirname($branch);
            }

            $branch = ($branch !== '.') ? $branch : '/';
            $node = ($branch !== '/') ? $branch . '/' . $basename : $basename;

            // skip inaccessible pages (e.g. drop "sub.md" if "sub/index.md" exists)
            if (isset($this->pageTree[$branch][$node]['page']) && !$isIndexPage) {
                continue;
            }

            // add node to page tree
            $isNewBranch = !isset($this->pageTree[$branch]);
            $this->pageTree[$branch][$node]['id'] = $node;
            $this->pageTree[$branch][$node]['page'] = &$pageData;

            $pageData['tree_node'] = &$this->pageTree[$branch][$node];

            // add parent nodes to page tree, if necessary
            while ($isNewBranch && $branch) {
                $parentNode = $branch;
                $parentBranch = ($branch !== '/') ? dirname($parentNode) : '';
                $parentBranch = ($parentBranch !== '.') ? $parentBranch : '/';

                $isNewBranch = !isset($this->pageTree[$parentBranch]);
                $this->pageTree[$parentBranch][$parentNode]['id'] = $parentNode;
                $this->pageTree[$parentBranch][$parentNode]['children'] = &$this->pageTree[$branch];

                $branch = $parentBranch;
            }
        }
    }

    /**
     * Returns a tree structure of known pages
     *
     * @see Pico::buildPageTree()
     *
     * @return array[]|null the tree structure of all pages
     */
    public function getPageTree()
    {
        return $this->pageTree;
    }

    /**
     * Returns the Twig template engine
     *
     * This method triggers the `onTwigRegistered` event when the Twig template
     * engine wasn't initiated yet. When initiating Twig, this method also
     * registers Pico's core Twig filter `content` as well as Pico's
     * {@see PicoTwigExtension} Twig extension.
     *
     * @see Pico::getTwig()
     * @see http://twig.sensiolabs.org/ Twig website
     * @see https://github.com/twigphp/Twig Twig on GitHub
     *
     * @return Twig_Environment|null Twig template engine
     */
    public function getTwig()
    {
        if ($this->twig === null) {
            $twigConfig = $this->getConfig('twig_config');

            $twigLoader = new Twig_Loader_Filesystem($this->getThemesDir() . $this->getTheme());
            $this->twig = new Twig_Environment($twigLoader, $twigConfig);
            $this->twig->addExtension(new PicoTwigExtension($this));

            if (!empty($twigConfig['debug'])) {
                $this->twig->addExtension(new Twig_Extension_Debug());
            }

            // register content filter
            // we pass the $pages array by reference to prevent multiple parser runs for the same page
            // this is the reason why we can't register this filter as part of PicoTwigExtension
            $pico = $this;
            $pages = &$this->pages;
            $this->twig->addFilter(new Twig_SimpleFilter(
                'content',
                function ($page) use ($pico, &$pages) {
                    if (isset($pages[$page])) {
                        $pageData = &$pages[$page];
                        if (!isset($pageData['content'])) {
                            $markdown = $pico->prepareFileContent($pageData['raw_content'], $pageData['meta']);
                            $pageData['content'] = $pico->parseFileContent($markdown);
                        }
                        return $pageData['content'];
                    }
                    return null;
                },
                array('is_safe' => array('html'))
            ));

            // trigger onTwigRegistration event
            $this->triggerEvent('onTwigRegistered', array(&$this->twig));
        }

        return $this->twig;
    }

    /**
     * Returns the variables passed to the template
     *
     * URLs and paths don't add a trailing slash for historic reasons.
     *
     * @return array template variables
     */
    protected function getTwigVariables()
    {
        return array(
            'config' => $this->getConfig(),
            'base_url' => rtrim($this->getBaseUrl(), '/'),
            'plugins_url' => rtrim($this->getConfig('plugins_url'), '/'),
            'themes_url' => rtrim($this->getConfig('themes_url'), '/'),
            'assets_url' => rtrim($this->getConfig('assets_url'), '/'),
            'theme_url' => $this->getConfig('themes_url') . $this->getTheme(),
            'site_title' => $this->getConfig('site_title'),
            'meta' => $this->meta,
            'content' => new Twig_Markup($this->content, 'UTF-8'),
            'pages' => $this->pages,
            'previous_page' => $this->previousPage,
            'current_page' => $this->currentPage,
            'next_page' => $this->nextPage,
            'version' => static::VERSION
        );
    }

    /**
     * Returns the name of the Twig template to render
     *
     * @return string template name
     */
    protected function getTwigTemplate()
    {
        $templateName = !empty($this->meta['template']) ? $this->meta['template'] : 'index';
        return $templateName . '.twig';
    }

    /**
     * Returns the base URL of this Pico instance
     *
     * Security Notice: You MUST configure Pico's base URL explicitly when
     * using the base URL in contexts that are potentially vulnerable to
     * HTTP Host Header Injection attacks (e.g. when generating emails).
     *
     * @return string the base url
     */
    public function getBaseUrl()
    {
        $baseUrl = $this->getConfig('base_url');
        if ($baseUrl) {
            return $baseUrl;
        }

        $host = 'localhost';
        if (!empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
        } elseif (!empty($_SERVER['HTTP_HOST'])) {
            $host = $_SERVER['HTTP_HOST'];
        } elseif (!empty($_SERVER['SERVER_NAME'])) {
            $host = $_SERVER['SERVER_NAME'];
        }

        $port = 80;
        if (!empty($_SERVER['HTTP_X_FORWARDED_PORT'])) {
            $port = (int) $_SERVER['HTTP_X_FORWARDED_PORT'];
        } elseif (!empty($_SERVER['SERVER_PORT'])) {
            $port = (int) $_SERVER['SERVER_PORT'];
        }

        $hostPortPosition = ($host[0] === '[') ? strpos($host, ':', strrpos($host, ']') ?: 0) : strrpos($host, ':');
        if ($hostPortPosition !== false) {
            $port = (int) substr($host, $hostPortPosition + 1);
            $host = substr($host, 0, $hostPortPosition);
        }

        $protocol = 'http';
        if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            $secureProxyHeader = strtolower(current(explode(',', $_SERVER['HTTP_X_FORWARDED_PROTO'])));
            $protocol = in_array($secureProxyHeader, array('https', 'on', 'ssl', '1'), true) ? 'https' : 'http';
        } elseif (!empty($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] !== 'off')) {
            $protocol = 'https';
        } elseif ($port === 443) {
            $protocol = 'https';
        }

        $basePath = isset($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : '/';
        $basePath = !in_array($basePath, array('.', '/', '\\'), true) ? $basePath . '/' : '/';

        if ((($protocol === 'http') && ($port !== 80)) || (($protocol === 'https') && ($port !== 443))) {
            $host = $host . ':' . $port;
        }

        $this->config['base_url'] = $protocol . "://" . $host . $basePath;
        return $this->config['base_url'];
    }

    /**
     * Returns TRUE if URL rewriting is enabled
     *
     * @return bool TRUE if URL rewriting is enabled, FALSE otherwise
     */
    public function isUrlRewritingEnabled()
    {
        $urlRewritingEnabled = $this->getConfig('rewrite_url');
        if ($urlRewritingEnabled !== null) {
            return $urlRewritingEnabled;
        }

        if (isset($_SERVER['PICO_URL_REWRITING'])) {
            $this->config['rewrite_url'] = (bool) $_SERVER['PICO_URL_REWRITING'];
        } elseif (isset($_SERVER['REDIRECT_PICO_URL_REWRITING'])) {
            $this->config['rewrite_url'] = (bool) $_SERVER['REDIRECT_PICO_URL_REWRITING'];
        } else {
            $this->config['rewrite_url'] = false;
        }

        return $this->config['rewrite_url'];
    }

    /**
     * Returns TRUE if Pico's debug mode is enabled
     *
     * @return bool TRUE if Pico's debug mode is enabled, FALSE otherwise
     */
    public function isDebugModeEnabled()
    {
        $debugModeEnabled = $this->getConfig('debug');
        if ($debugModeEnabled !== null) {
            return $debugModeEnabled;
        }

        if (isset($_SERVER['PICO_DEBUG'])) {
            $this->config['debug'] = (bool) $_SERVER['PICO_DEBUG'];
        } elseif (isset($_SERVER['REDIRECT_PICO_DEBUG'])) {
            $this->config['debug'] = (bool) $_SERVER['REDIRECT_PICO_DEBUG'];
        } else {
            $this->config['debug'] = false;
        }

        return $this->config['debug'];
    }

    /**
     * Returns the URL to a given page
     *
     * This method can be used in Twig templates by applying the `link` filter
     * to a string representing a page ID.
     *
     * @param string            $page      ID of the page to link to
     * @param array|string|null $queryData either an array of properties to
     *     create a URL-encoded query string from, or a already encoded string
     * @param bool              $dropIndex if the last path component is
     *     "index", passing TRUE (default) will remove this path component
     *
     * @return string URL
     *
     * @throws InvalidArgumentException thrown when invalid arguments got passed
     */
    public function getPageUrl($page, $queryData = null, $dropIndex = true)
    {
        if (is_array($queryData)) {
            $queryData = http_build_query($queryData, '', '&');
        } elseif (($queryData !== null) && !is_string($queryData)) {
            throw new InvalidArgumentException(
                'Argument 2 passed to ' . __METHOD__ . ' must be of the type array or string, '
                . (is_object($queryData) ? get_class($queryData) : gettype($queryData)) . ' given'
            );
        }

        // drop "index"
        if ($dropIndex) {
            if ($page === 'index') {
                $page = '';
            } elseif (($pagePathLength = strrpos($page, '/')) !== false) {
                if (substr($page, $pagePathLength + 1) === 'index') {
                    $page = substr($page, 0, $pagePathLength);
                }
            }
        }

        if ($queryData) {
            $queryData = ($this->isUrlRewritingEnabled() || !$page) ? '?' . $queryData : '&' . $queryData;
        } else {
            $queryData = '';
        }

        if (!$page) {
            return $this->getBaseUrl() . $queryData;
        } elseif (!$this->isUrlRewritingEnabled()) {
            return $this->getBaseUrl() . '?' . rawurlencode($page) . $queryData;
        } else {
            return $this->getBaseUrl() . implode('/', array_map('rawurlencode', explode('/', $page))) . $queryData;
        }
    }

    /**
     * Returns the page ID of a given content file
     *
     * @param string $path path to the content file
     *
     * @return string|null either the corresponding page ID or NULL
     */
    public function getPageId($path)
    {
        $contentDir = $this->getConfig('content_dir');
        $contentDirLength = strlen($contentDir);

        if (substr($path, 0, $contentDirLength) !== $contentDir) {
            return null;
        }

        $contentExt = $this->getConfig('content_ext');
        $contentExtLength = strlen($contentExt);

        if (substr($path, -$contentExtLength) !== $contentExt) {
            return null;
        }

        return substr($path, $contentDirLength, -$contentExtLength) ?: null;
    }

    /**
     * Substitutes URL placeholders (e.g. %base_url%)
     *
     * This method is registered as the `url` Twig filter and often used to
     * allow users to specify absolute URLs in meta data utilizing the known
     * URL placeholders `%base_url%`, `%plugins_url%`, `%themes_url%`,
     * `%assets_url%` and `%theme_url%`.
     *
     * Don't confuse this with the `link` Twig filter, which takes a page ID as
     * parameter. However, you can indeed use this method to create page URLs,
     * e.g. `{{ "%base_url%?sub/page"|url }}`.
     *
     * @param string $url URL with placeholders
     *
     * @return string URL with replaced placeholders
     */
    public function substituteUrl($url)
    {
        $variables = array(
            '%base_url%?' => $this->getBaseUrl() . (!$this->isUrlRewritingEnabled() ? '?' : ''),
            '%base_url%' => rtrim($this->getBaseUrl(), '/'),
            '%plugins_url%' => rtrim($this->getConfig('plugins_url'), '/'),
            '%themes_url%' => rtrim($this->getConfig('themes_url'), '/'),
            '%assets_url%' => rtrim($this->getConfig('assets_url'), '/'),
            '%theme_url%' => $this->getConfig('themes_url') . $this->getTheme()
        );

        return str_replace(array_keys($variables), $variables, $url);
    }

    /**
     * Returns the URL of the themes folder of this Pico instance
     *
     * @see Pico::getUrlFromPath()
     *
     * @deprecated 2.1.0
     *
     * @return string
     */
    public function getBaseThemeUrl()
    {
        return $this->getConfig('themes_url');
    }

    /**
     * Returns the URL of a given absolute path within this Pico instance
     *
     * We assume that the given path is a arbitrary deep sub folder of the
     * script's base path (i.e. the directory {@path "index.php"} is in resp.
     * the `httpdocs` directory). If this isn't the case, we check whether it's
     * a sub folder of {@see Pico::$rootDir} (what is often identical to the
     * script's base path). If this isn't the case either, we fall back to
     * the basename of the given folder. This whole process ultimately allows
     * us to use {@see Pico::getBaseUrl()} as origin for the URL.
     *
     * This method is used to guess Pico's `plugins_url`, `themes_url` and
     * `assets_url`. However, guessing might fail, requiring a manual config.
     *
     * @param string $absolutePath the absolute path to interpret
     *
     * @return string the URL of the given folder
     */
    public function getUrlFromPath($absolutePath)
    {
        $absolutePath = str_replace('\\', '/', $absolutePath);

        $basePath = '';
        if (isset($_SERVER['SCRIPT_FILENAME']) && strrpos($_SERVER['SCRIPT_FILENAME'], '/')) {
            $basePath = dirname($_SERVER['SCRIPT_FILENAME']);
            $basePath = !in_array($basePath, array('.', '/', '\\'), true) ? $basePath . '/' : '/';
            $basePathLength = strlen($basePath);

            if ((substr($absolutePath, 0, $basePathLength) === $basePath) && ($basePath !== '/')) {
                return $this->getBaseUrl() . substr($absolutePath, $basePathLength);
            }
        }

        if ($basePath !== $this->getRootDir()) {
            $basePath = $this->getRootDir();
            $basePathLength = strlen($basePath);

            if (substr($absolutePath, 0, $basePathLength) === $basePath) {
                return $this->getBaseUrl() . substr($absolutePath, $basePathLength);
            }
        }

        return $this->getBaseUrl() . basename($absolutePath) . '/';
    }

    /**
     * Filters a URL GET parameter with a specified filter
     *
     * This method is just an alias for {@see Pico::filterVariable()}, see
     * {@see Pico::filterVariable()} for a detailed description. It can be
     * used in Twig templates by calling the `url_param` function.
     *
     * @see Pico::filterVariable()
     *
     * @param string                    $name    name of the URL GET parameter
     *     to filter
     * @param int|string                $filter  the filter to apply
     * @param mixed|array               $options either a associative options
     *     array to be used by the filter or a scalar default value
     * @param int|string|int[]|string[] $flags   flags and flag strings to be
     *     used by the filter
     *
     * @return mixed either the filtered data, FALSE if the filter fails, or
     *     NULL if the URL GET parameter doesn't exist and no default value is
     *     given
     */
    public function getUrlParameter($name, $filter = '', $options = null, $flags = null)
    {
        $variable = (isset($_GET[$name]) && is_scalar($_GET[$name])) ? $_GET[$name] : null;
        return $this->filterVariable($variable, $filter, $options, $flags);
    }

    /**
     * Filters a HTTP POST parameter with a specified filter
     *
     * This method is just an alias for {@see Pico::filterVariable()}, see
     * {@see Pico::filterVariable()} for a detailed description. It can be
     * used in Twig templates by calling the `form_param` function.
     *
     * @see Pico::filterVariable()
     *
     * @param string                    $name    name of the HTTP POST
     *     parameter to filter
     * @param int|string                $filter  the filter to apply
     * @param mixed|array               $options either a associative options
     *     array to be used by the filter or a scalar default value
     * @param int|string|int[]|string[] $flags   flags and flag strings to be
     *     used by the filter
     *
     * @return mixed either the filtered data, FALSE if the filter fails, or
     *     NULL if the HTTP POST parameter doesn't exist and no default value
     *     is given
     */
    public function getFormParameter($name, $filter = '', $options = null, $flags = null)
    {
        $variable = (isset($_POST[$name]) && is_scalar($_POST[$name])) ? $_POST[$name] : null;
        return $this->filterVariable($variable, $filter, $options, $flags);
    }

    /**
     * Filters a variable with a specified filter
     *
     * This method basically wraps around PHP's `filter_var()` function. It
     * filters data by either validating or sanitizing it. This is especially
     * useful when the data source contains unknown (or foreign) data, like
     * user supplied input. Validation is used to validate or check if the data
     * meets certain qualifications, but will not change the data itself.
     * Sanitization will sanitize the data, so it may alter it by removing
     * undesired characters. It doesn't actually validate the data! The
     * behaviour of most filters can optionally be tweaked by flags.
     *
     * Heads up! Input validation is hard! Always validate your input data the
     * most paranoid way you can imagine. Always prefer validation filters over
     * sanitization filters; be very careful with sanitization filters, you
     * might create cross-site scripting vulnerabilities!
     *
     * @see https://secure.php.net/manual/en/function.filter-var.php
     *     PHP's `filter_var()` function
     * @see https://secure.php.net/manual/en/filter.filters.validate.php
     *     Validate filters
     * @see https://secure.php.net/manual/en/filter.filters.sanitize.php
     *     Sanitize filters
     *
     * @param mixed                     $variable value to filter
     * @param int|string                $filter   ID (int) or name (string) of
     *     the filter to apply; if omitted, the method will return FALSE
     * @param mixed|array               $options  either a associative array
     *     of options to be used by the filter (e.g. `array('default' => 42)`),
     *     or a scalar default value that will be returned when the passed
     *     value is NULL (optional)
     * @param int|string|int[]|string[] $flags    either a bitwise disjunction
     *     of flags or a string with the significant part of a flag constant
     *     (the constant name is the result of "FILTER_FLAG_" and the given
     *     string in ASCII-only uppercase); you may also pass an array of flags
     *     and flag strings (optional)
     *
     * @return mixed with a validation filter, the method either returns the
     *     validated value or, provided that the value wasn't valid, the given
     *     default value or FALSE; with a sanitization filter, the method
     *     returns the sanitized value; if no value (i.e. NULL) was given, the
     *     method always returns either the provided default value or NULL
     */
    protected function filterVariable($variable, $filter = '', $options = null, $flags = null)
    {
        $defaultValue = null;
        if (is_array($options)) {
            $defaultValue = isset($options['default']) ? $options['default'] : null;
        } elseif ($options !== null) {
            $defaultValue = $options;
            $options = array('default' => $defaultValue);
        }

        if ($variable === null) {
            return $defaultValue;
        }

        $filter = $filter ? (is_string($filter) ? filter_id($filter) : (int) $filter) : false;
        if (!$filter) {
            return false;
        }

        $filterOptions = array('options' => $options, 'flags' => 0);
        foreach ((array) $flags as $flag) {
            if (is_numeric($flag)) {
                $filterOptions['flags'] |= (int) $flag;
            } elseif (is_string($flag)) {
                $flag = strtoupper(preg_replace('/[^a-zA-Z0-9_]/', '', $flag));
                if (($flag === 'NULL_ON_FAILURE') && ($filter === FILTER_VALIDATE_BOOLEAN)) {
                    $filterOptions['flags'] |= FILTER_NULL_ON_FAILURE;
                } else {
                    $filterOptions['flags'] |= (int) constant('FILTER_FLAG_' . $flag);
                }
            }
        }

        return filter_var($variable, $filter, $filterOptions);
    }

    /**
     * Recursively walks through a directory and returns all containing files
     * matching the specified file extension
     *
     * @param string $directory     start directory
     * @param string $fileExtension return files with the given file extension
     *     only (optional)
     * @param int    $order         specify whether and how files should be
     *     sorted; use Pico::SORT_ASC for a alphabetical ascending order (this
     *     is the default behaviour), Pico::SORT_DESC for a descending order
     *     or Pico::SORT_NONE to leave the result unsorted
     *
     * @return array list of found files
     */
    public function getFiles($directory, $fileExtension = '', $order = self::SORT_ASC)
    {
        $directory = rtrim($directory, '/');
        $fileExtensionLength = strlen($fileExtension);
        $result = array();

        $files = scandir($directory, $order);
        if ($files !== false) {
            foreach ($files as $file) {
                // exclude hidden files/dirs starting with a .; this also excludes the special dirs . and ..
                // exclude files ending with a ~ (vim/nano backup) or # (emacs backup)
                if (($file[0] === '.') || in_array(substr($file, -1), array('~', '#'), true)) {
                    continue;
                }

                if (is_dir($directory . '/' . $file)) {
                    // get files recursively
                    $result = array_merge($result, $this->getFiles($directory . '/' . $file, $fileExtension, $order));
                } elseif (!$fileExtension || (substr($file, -$fileExtensionLength) === $fileExtension)) {
                    $result[] = $directory . '/' . $file;
                }
            }
        }

        return $result;
    }

    /**
     * Returns all files in a directory matching a libc glob() pattern
     *
     * @see https://secure.php.net/manual/en/function.glob.php
     *     PHP's glob() function
     *
     * @param string $pattern the pattern to search for; see PHP's glob()
     *     function for details
     * @param int    $order   specify whether and how files should be sorted;
     *     use Pico::SORT_ASC for a alphabetical ascending order (this is the
     *     default behaviour), Pico::SORT_DESC for a descending order or
     *     Pico::SORT_NONE to leave the result unsorted
     *
     * @return array list of found files
     */
    public function getFilesGlob($pattern, $order = self::SORT_ASC)
    {
        $result = array();
        $sortFlag = ($order === self::SORT_NONE) ? GLOB_NOSORT : 0;

        $files = glob($pattern, GLOB_MARK | $sortFlag);
        if ($files) {
            foreach ($files as $file) {
                // exclude dirs and files ending with a ~ (vim/nano backup) or # (emacs backup)
                if (in_array(substr($file, -1), array('/', '~', '#'), true)) {
                    continue;
                }

                $result[] = $file;
            }
        }

        return ($order === self::SORT_DESC) ? array_reverse($result) : $result;
    }

    /**
     * Makes a relative path absolute to Pico's root dir
     *
     * @param string $path     relative or absolute path
     * @param string $basePath treat relative paths relative to the given path;
     *     defaults to Pico::$rootDir
     * @param bool   $endSlash whether to add a trailing slash to the absolute
     *     path or not (defaults to TRUE)
     *
     * @return string absolute path
     */
    public function getAbsolutePath($path, $basePath = null, $endSlash = true)
    {
        if ($basePath === null) {
            $basePath = $this->getRootDir();
        }

        if (DIRECTORY_SEPARATOR === '\\') {
            if (preg_match('/^(?>[a-zA-Z]:\\\\|\\\\\\\\)/', $path) !== 1) {
                $path = $basePath . $path;
            }
        } else {
            if ($path[0] !== '/') {
                $path = $basePath . $path;
            }
        }

        return rtrim($path, '/\\') . ($endSlash ? '/' : '');
    }

    /**
     * Normalizes a path by taking care of '', '.' and '..' parts
     *
     * @param string $path              path to normalize
     * @param bool   $allowAbsolutePath whether absolute paths are allowed
     * @param bool   $endSlash          whether to add a trailing slash to the
     *     normalized path or not (defaults to TRUE)
     *
     * @return string normalized path
     *
     * @throws UnexpectedValueException thrown when a absolute path is passed
     *     although absolute paths aren't allowed
     */
    public function getNormalizedPath($path, $allowAbsolutePath = false, $endSlash = true)
    {
        $absolutePath = '';
        if (DIRECTORY_SEPARATOR === '\\') {
            if (preg_match('/^(?>[a-zA-Z]:\\\\|\\\\\\\\)/', $path, $pathMatches) === 1) {
                $absolutePath = $pathMatches[0];
                $path = substr($path, strlen($absolutePath));
            }
        } else {
            if ($path[0] === '/') {
                $absolutePath = '/';
                $path = substr($path, 1);
            }
        }

        if ($absolutePath && !$allowAbsolutePath) {
            throw new UnexpectedValueException(
                'Argument 1 passed to ' . __METHOD__ . ' must be a relative path, absolute path "' . $path . '" given'
            );
        }

        $path = str_replace('\\', '/', $path);
        $pathParts = explode('/', $path);

        $resultParts = array();
        foreach ($pathParts as $pathPart) {
            if (($pathPart === '') || ($pathPart === '.')) {
                continue;
            } elseif ($pathPart === '..') {
                array_pop($resultParts);
                continue;
            }
            $resultParts[] = $pathPart;
        }

        if (!$resultParts) {
            return $absolutePath ?: '/';
        }

        return $absolutePath . implode('/', $resultParts) . ($endSlash ? '/' : '');
    }

    /**
     * Makes a relative URL absolute to Pico's base URL
     *
     * Please note that URLs starting with a slash are considered absolute URLs
     * even though they don't include a scheme and host.
     *
     * @param string $url      relative or absolute URL
     * @param string $baseUrl  treat relative URLs relative to the given URL;
     *     defaults to Pico::getBaseUrl()
     * @param bool $endSlash   whether to add a trailing slash to the absolute
     *     URL or not (defaults to TRUE)
     *
     * @return string absolute URL
     */
    public function getAbsoluteUrl($url, $baseUrl = null, $endSlash = true)
    {
        if (($url[0] !== '/') && !preg_match('#^[A-Za-z][A-Za-z0-9+\-.]*://#', $url)) {
            $url = (($baseUrl !== null) ? $baseUrl : $this->getBaseUrl()) . $url;
        }

        return rtrim($url, '/') . ($endSlash ? '/' : '');
    }

    /**
     * Triggers events on plugins using the current API version
     *
     * Plugins using older API versions are handled by {@see PicoDeprecated}.
     * Please note that {@see PicoDeprecated} also triggers custom events on
     * plugins using older API versions, thus you can safely use this method
     * to trigger custom events on all loaded plugins, no matter what API
     * version - the event will be triggered in any case.
     *
     * You MUST NOT trigger events of Pico's core with a plugin!
     *
     * @see PicoPluginInterface
     * @see AbstractPicoPlugin
     * @see DummyPlugin
     *
     * @param string $eventName name of the event to trigger
     * @param array  $params    optional parameters to pass
     */
    public function triggerEvent($eventName, array $params = array())
    {
        foreach ($this->nativePlugins as $plugin) {
            $plugin->handleEvent($eventName, $params);
        }
    }
}
