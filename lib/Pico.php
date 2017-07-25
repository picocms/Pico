<?php

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
 * @version 1.0
 */
class Pico
{
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
     * @var boolean
     */
    protected $locked = false;

    /**
     * List of loaded plugins
     *
     * @see Pico::getPlugins()
     * @var object[]|null
     */
    protected $plugins;

    /**
     * Current configuration of this Pico instance
     *
     * @see Pico::getConfig()
     * @var array|null
     */
    protected $config;

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
     * @var ParsedownExtra|null
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
     * Twig instance used for template parsing
     *
     * @see Pico::getTwig()
     * @var Twig_Environment|null
     */
    protected $twig;

    /**
     * Variables passed to the twig template
     *
     * @see Pico::getTwigVariables
     * @var array|null
     */
    protected $twigVariables;

    /**
     * Constructs a new Pico instance
     *
     * To carry out all the processing in Pico, call {@link Pico::run()}.
     *
     * @param string $rootDir    root directory of this Pico instance
     * @param string $configDir  config directory of this Pico instance
     * @param string $pluginsDir plugins directory of this Pico instance
     * @param string $themesDir  themes directory of this Pico instance
     */
    public function __construct($rootDir, $configDir, $pluginsDir, $themesDir)
    {
        $this->rootDir = rtrim($rootDir, '/\\') . '/';
        $this->configDir = $this->getAbsolutePath($configDir);
        $this->pluginsDir = $this->getAbsolutePath($pluginsDir);
        $this->themesDir = $this->getAbsolutePath($themesDir);
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
     * @return string           rendered Pico contents
     * @throws Exception thrown when a not recoverable error occurs
     */
    public function run()
    {
        // lock Pico
        $this->locked = true;

        // load plugins
        $this->loadPlugins();
        $this->triggerEvent('onPluginsLoaded', array(&$this->plugins));

        // load config
        $this->loadConfig();
        $this->triggerEvent('onConfigLoaded', array(&$this->config));

        // check content dir
        if (!is_dir($this->getConfig('content_dir'))) {
            throw new RuntimeException('Invalid content directory "' . $this->getConfig('content_dir') . '"');
        }

        // evaluate request url
        $this->evaluateRequestUrl();
        $this->triggerEvent('onRequestUrl', array(&$this->requestUrl));

        // discover requested file
        $this->discoverRequestFile();
        $this->triggerEvent('onRequestFile', array(&$this->requestFile));

        // load raw file content
        $this->triggerEvent('onContentLoading', array(&$this->requestFile));

        $notFoundFile = '404' . $this->getConfig('content_ext');
        if (file_exists($this->requestFile) && (basename($this->requestFile) !== $notFoundFile)) {
            $this->rawContent = $this->loadFileContent($this->requestFile);
        } else {
            $this->triggerEvent('on404ContentLoading', array(&$this->requestFile));

            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
            $this->rawContent = $this->load404Content($this->requestFile);

            $this->triggerEvent('on404ContentLoaded', array(&$this->rawContent));
        }

        $this->triggerEvent('onContentLoaded', array(&$this->rawContent));

        // parse file meta
        $headers = $this->getMetaHeaders();

        $this->triggerEvent('onMetaParsing', array(&$this->rawContent, &$headers));
        $this->meta = $this->parseFileMeta($this->rawContent, $headers);
        $this->triggerEvent('onMetaParsed', array(&$this->meta));

        // register parsedown
        $this->triggerEvent('onParsedownRegistration');
        $this->registerParsedown();

        // parse file content
        $this->triggerEvent('onContentParsing', array(&$this->rawContent));

        $this->content = $this->prepareFileContent($this->rawContent, $this->meta);
        $this->triggerEvent('onContentPrepared', array(&$this->content));

        $this->content = $this->parseFileContent($this->content);
        $this->triggerEvent('onContentParsed', array(&$this->content));

        // read pages
        $this->triggerEvent('onPagesLoading');

        $this->readPages();
        $this->sortPages();
        $this->discoverCurrentPage();

        $this->triggerEvent('onPagesLoaded', array(
            &$this->pages,
            &$this->currentPage,
            &$this->previousPage,
            &$this->nextPage
        ));

        // register twig
        $this->triggerEvent('onTwigRegistration');
        $this->registerTwig();

        // render template
        $this->twigVariables = $this->getTwigVariables();
        if (isset($this->meta['template']) && $this->meta['template']) {
            $templateName = $this->meta['template'];
        } else {
            $templateName = 'index';
        }
        if (file_exists($this->getThemesDir() . $this->getConfig('theme') . '/' . $templateName . '.twig')) {
            $templateName .= '.twig';
        } else {
            $templateName .= '.html';
        }

        $this->triggerEvent('onPageRendering', array(&$this->twig, &$this->twigVariables, &$templateName));

        $output = $this->twig->render($templateName, $this->twigVariables);
        $this->triggerEvent('onPageRendered', array(&$output));

        return $output;
    }

    /**
     * Loads plugins from Pico::$pluginsDir in alphabetical order
     *
     * Plugin files MAY be prefixed by a number (e.g. 00-PicoDeprecated.php)
     * to indicate their processing order. Plugins without a prefix will be
     * loaded last. If you want to use a prefix, you MUST consider the
     * following directives:
     * - 00 to 19: Reserved
     * - 20 to 39: Low level code helper plugins
     * - 40 to 59: Plugins manipulating routing or the pages array
     * - 60 to 79: Plugins hooking into template or markdown parsing
     * - 80 to 99: Plugins using the `onPageRendered` event
     *
     * @see    Pico::getPlugin()
     * @see    Pico::getPlugins()
     * @return void
     * @throws RuntimeException thrown when a plugin couldn't be loaded
     */
    protected function loadPlugins()
    {
        $this->plugins = array();
        $pluginFiles = $this->getFiles($this->getPluginsDir(), '.php');
        foreach ($pluginFiles as $pluginFile) {
            require_once($pluginFile);

            $className = preg_replace('/^[0-9]+-/', '', basename($pluginFile, '.php'));
            if (class_exists($className)) {
                // class name and file name can differ regarding case sensitivity
                $plugin = new $className($this);
                $className = get_class($plugin);

                $this->plugins[$className] = $plugin;
            } else {
                // TODO: breaks backward compatibility
                //throw new RuntimeException("Unable to load plugin '".$className."'");
            }
        }
    }

    /**
     * Returns the instance of a named plugin
     *
     * Plugins SHOULD implement {@link PicoPluginInterface}, but you MUST NOT
     * rely on it. For more information see {@link PicoPluginInterface}.
     *
     * @see    Pico::loadPlugins()
     * @see    Pico::getPlugins()
     * @param  string           $pluginName name of the plugin
     * @return object                       instance of the plugin
     * @throws RuntimeException             thrown when the plugin wasn't found
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
     * @see    Pico::loadPlugins()
     * @see    Pico::getPlugin()
     * @return object[]|null
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * Loads the config.php from Pico::$configDir
     *
     * @see    Pico::setConfig()
     * @see    Pico::getConfig()
     * @return void
     */
    protected function loadConfig()
    {
        $config = null;
        if (file_exists($this->getConfigDir() . 'config.php')) {
            require($this->getConfigDir() . 'config.php');
        }

        $defaultConfig = array(
            'site_title' => 'Pico',
            'base_url' => '',
            'rewrite_url' => null,
            'theme' => 'default',
            'date_format' => '%D %T',
            'twig_config' => null,
            'pages_order_by' => 'alpha',
            'pages_order' => 'asc',
            'content_dir' => null,
            'content_ext' => '.md',
            'timezone' => ''
        );

        $this->config = is_array($this->config) ? $this->config : array();
        $this->config += is_array($config) ? $config + $defaultConfig : $defaultConfig;

        if (empty($this->config['base_url'])) {
            $this->config['base_url'] = $this->getBaseUrl();
        } else {
            $this->config['base_url'] = rtrim($this->config['base_url'], '/') . '/';
        }

        if ($this->config['rewrite_url'] === null) {
            $this->config['rewrite_url'] = $this->isUrlRewritingEnabled();
        }

        $defaultTwigConfig = array('cache' => false, 'autoescape' => false, 'debug' => false);
        if (!is_array($this->config['twig_config'])) {
            $this->config['twig_config'] = $defaultTwigConfig;
        } else {
            $this->config['twig_config'] += $defaultTwigConfig;
        }

        if (empty($this->config['content_dir'])) {
            // try to guess the content directory
            if (is_dir($this->getRootDir() . 'content')) {
                $this->config['content_dir'] = $this->getRootDir() . 'content/';
            } else {
                $this->config['content_dir'] = $this->getRootDir() . 'content-sample/';
            }
        } else {
            $this->config['content_dir'] = $this->getAbsolutePath($this->config['content_dir']);
        }

        if (empty($this->config['timezone'])) {
            // explicitly set a default timezone to prevent a E_NOTICE
            // when no timezone is set; the `date_default_timezone_get()`
            // function always returns a timezone, at least UTC
            $this->config['timezone'] = @date_default_timezone_get();
        }
        date_default_timezone_set($this->config['timezone']);
    }

    /**
     * Sets Pico's config before calling Pico::run()
     *
     * This method allows you to modify Pico's config without creating a
     * {@path "config/config.php"} or changing some of its variables before
     * Pico starts processing.
     *
     * You can call this method between {@link Pico::__construct()} and
     * {@link Pico::run()} only. Options set with this method cannot be
     * overwritten by {@path "config/config.php"}.
     *
     * @see    Pico::loadConfig()
     * @see    Pico::getConfig()
     * @param  array $config  array with config variables
     * @return void
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
     * @see    Pico::setConfig()
     * @see    Pico::loadConfig()
     * @param  string $configName optional name of a config variable
     * @return mixed              returns either the value of the named config
     *     variable, null if the config variable doesn't exist or the config
     *     array if no config name was supplied
     */
    public function getConfig($configName = null)
    {
        if ($configName !== null) {
            return isset($this->config[$configName]) ? $this->config[$configName] : null;
        } else {
            return $this->config;
        }
    }

    /**
     * Evaluates the requested URL
     *
     * Pico 1.0 uses the `QUERY_STRING` routing method (e.g. `/pico/?sub/page`)
     * to support SEO-like URLs out-of-the-box with any webserver. You can
     * still setup URL rewriting (e.g. using `mod_rewrite` on Apache) to
     * basically remove the `?` from URLs, but your rewritten URLs must follow
     * the new `QUERY_STRING` principles. URL rewriting requires some special
     * configuration on your webserver, but this should be "basic work" for
     * any webmaster...
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
     * @see    Pico::getRequestUrl()
     * @return void
     */
    protected function evaluateRequestUrl()
    {
        // use QUERY_STRING; e.g. /pico/?sub/page
        // if you want to use rewriting, you MUST make your rules to
        // rewrite the URLs to follow the QUERY_STRING method
        //
        // Note: you MUST NOT call the index page with /pico/?someBooleanParameter;
        // use /pico/?someBooleanParameter= or /pico/?index&someBooleanParameter instead
        $pathComponent = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
        if (($pathComponentLength = strpos($pathComponent, '&')) !== false) {
            $pathComponent = substr($pathComponent, 0, $pathComponentLength);
        }
        $this->requestUrl = (strpos($pathComponent, '=') === false) ? rawurldecode($pathComponent) : '';
        $this->requestUrl = trim($this->requestUrl, '/');
    }

    /**
     * Returns the URL where a user requested the page
     *
     * @see    Pico::evaluateRequestUrl()
     * @return string|null request URL
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     * Uses the request URL to discover the content file to serve
     *
     * @see    Pico::getRequestFile()
     * @return void
     */
    protected function discoverRequestFile()
    {
        if (empty($this->requestUrl)) {
            $this->requestFile = $this->getConfig('content_dir') . 'index' . $this->getConfig('content_ext');
        } else {
            // prevent content_dir breakouts using malicious request URLs
            // we don't use realpath() here because we neither want to check for file existance
            // nor prohibit symlinks which intentionally point to somewhere outside the content_dir
            // it is STRONGLY RECOMMENDED to use open_basedir - always, not just with Pico!
            $requestUrl = str_replace('\\', '/', $this->requestUrl);
            $requestUrlParts = explode('/', $requestUrl);

            $requestFileParts = array();
            foreach ($requestUrlParts as $requestUrlPart) {
                if (($requestUrlPart === '') || ($requestUrlPart === '.')) {
                    continue;
                } elseif ($requestUrlPart === '..') {
                    array_pop($requestFileParts);
                    continue;
                }

                $requestFileParts[] = $requestUrlPart;
            }

            if (empty($requestFileParts)) {
                $this->requestFile = $this->getConfig('content_dir') . 'index' . $this->getConfig('content_ext');
                return;
            }

            // discover the content file to serve
            // Note: $requestFileParts neither contains a trailing nor a leading slash
            $this->requestFile = $this->getConfig('content_dir') . implode('/', $requestFileParts);
            if (is_dir($this->requestFile)) {
                // if no index file is found, try a accordingly named file in the previous dir
                // if this file doesn't exist either, show the 404 page, but assume the index
                // file as being requested (maintains backward compatibility to Pico < 1.0)
                $indexFile = $this->requestFile . '/index' . $this->getConfig('content_ext');
                if (file_exists($indexFile) || !file_exists($this->requestFile . $this->getConfig('content_ext'))) {
                    $this->requestFile = $indexFile;
                    return;
                }
            }
            $this->requestFile .= $this->getConfig('content_ext');
        }
    }

    /**
     * Returns the absolute path to the content file to serve
     *
     * @see    Pico::discoverRequestFile()
     * @return string|null file path
     */
    public function getRequestFile()
    {
        return $this->requestFile;
    }

    /**
     * Returns the raw contents of a file
     *
     * @see    Pico::getRawContent()
     * @param  string $file file path
     * @return string       raw contents of the file
     */
    public function loadFileContent($file)
    {
        return file_get_contents($file);
    }

    /**
     * Returns the raw contents of the first found 404 file when traversing
     * up from the directory the requested file is in
     *
     * @see    Pico::getRawContent()
     * @param  string $file     path to requested (but not existing) file
     * @return string           raw contents of the 404 file
     * @throws RuntimeException thrown when no suitable 404 file is found
     */
    public function load404Content($file)
    {
        $contentDir = $this->getConfig('content_dir');
        $contentDirLength = strlen($contentDir);

        if (substr($file, 0, $contentDirLength) === $contentDir) {
            $errorFileDir = substr($file, $contentDirLength);

            while ($errorFileDir !== '.') {
                $errorFileDir = dirname($errorFileDir);
                $errorFile = $errorFileDir . '/404' . $this->getConfig('content_ext');

                if (file_exists($this->getConfig('content_dir') . $errorFile)) {
                    return $this->loadFileContent($this->getConfig('content_dir') . $errorFile);
                }
            }
        } elseif (file_exists($this->getConfig('content_dir') . '404' . $this->getConfig('content_ext'))) {
            // provided that the requested file is not in the regular
            // content directory, fallback to Pico's global `404.md`
            return $this->loadFileContent($this->getConfig('content_dir') . '404' . $this->getConfig('content_ext'));
        }

        $errorFile = $this->getConfig('content_dir') . '404' . $this->getConfig('content_ext');
        throw new RuntimeException('Required "' . $errorFile . '" not found');
    }

    /**
     * Returns the raw contents, either of the requested or the 404 file
     *
     * @see    Pico::loadFileContent()
     * @see    Pico::load404Content()
     * @return string|null raw contents
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * Returns known meta headers and triggers the onMetaHeaders event
     *
     * Heads up! Calling this method triggers the `onMetaHeaders` event.
     * Keep this in mind to prevent a infinite loop!
     *
     * @return string[] known meta headers; the array value specifies the
     *     YAML key to search for, the array key is later used to access the
     *     found value
     */
    public function getMetaHeaders()
    {
        $headers = array(
            'title' => 'Title',
            'description' => 'Description',
            'author' => 'Author',
            'date' => 'Date',
            'robots' => 'Robots',
            'template' => 'Template'
        );

        $this->triggerEvent('onMetaHeaders', array(&$headers));
        return $headers;
    }

    /**
     * Parses the file meta from raw file contents
     *
     * Meta data MUST start on the first line of the file, either opened and
     * closed by `---` or C-style block comments (deprecated). The headers are
     * parsed by the YAML component of the Symfony project, keys are lowered.
     * If you're a plugin developer, you MUST register new headers during the
     * `onMetaHeaders` event first. The implicit availability of headers is
     * for users and pure (!) theme developers ONLY.
     *
     * @see    Pico::getFileMeta()
     * @see    http://symfony.com/doc/current/components/yaml/introduction.html
     * @param  string   $rawContent the raw file contents
     * @param  string[] $headers    known meta headers
     * @return array                parsed meta data
     * @throws \Symfony\Component\Yaml\Exception\ParseException thrown when the
     *     meta data is invalid
     */
    public function parseFileMeta($rawContent, array $headers)
    {
        $meta = array();
        $pattern = "/^(\/(\*)|---)[[:blank:]]*(?:\r)?\n"
            . "(?:(.*?)(?:\r)?\n)?(?(2)\*\/|---)[[:blank:]]*(?:(?:\r)?\n|$)/s";
        if (preg_match($pattern, $rawContent, $rawMetaMatches) && isset($rawMetaMatches[3])) {
            $yamlParser = new \Symfony\Component\Yaml\Parser();
            $meta = $yamlParser->parse($rawMetaMatches[3]);

            if ($meta !== null) {
                // the parser may return a string for non-YAML 1-liners
                // assume that this string is the page title
                $meta = is_array($meta) ? array_change_key_case($meta, CASE_LOWER) : array('title' => $meta);
            } else {
                $meta = array();
            }

            foreach ($headers as $fieldId => $fieldName) {
                $fieldName = strtolower($fieldName);
                if (isset($meta[$fieldName])) {
                    // rename field (e.g. remove whitespaces)
                    if ($fieldId != $fieldName) {
                        $meta[$fieldId] = $meta[$fieldName];
                        unset($meta[$fieldName]);
                    }
                } elseif (!isset($meta[$fieldId])) {
                    // guarantee array key existance
                    $meta[$fieldId] = '';
                }
            }

            if (!empty($meta['date'])) {
                // workaround for issue #336
                // Symfony YAML interprets ISO-8601 datetime strings and returns timestamps instead of the string
                // this behavior conforms to the YAML standard, i.e. this is no bug of Symfony YAML
                if (is_int($meta['date'])) {
                    $meta['time'] = $meta['date'];

                    $rawDateFormat = (date('H:i:s', $meta['time']) === '00:00:00') ? 'Y-m-d' : 'Y-m-d H:i:s';
                    $meta['date'] = date($rawDateFormat, $meta['time']);
                } else {
                    $meta['time'] = strtotime($meta['date']);
                }
                $meta['date_formatted'] = utf8_encode(strftime($this->getConfig('date_format'), $meta['time']));
            } else {
                $meta['time'] = $meta['date_formatted'] = '';
            }
        } else {
            // guarantee array key existance
            $meta = array_fill_keys(array_keys($headers), '');
            $meta['time'] = $meta['date_formatted'] = '';
        }

        return $meta;
    }

    /**
     * Returns the parsed meta data of the requested page
     *
     * @see    Pico::parseFileMeta()
     * @return array|null parsed meta data
     */
    public function getFileMeta()
    {
        return $this->meta;
    }

    /**
     * Registers the Parsedown Extra markdown parser
     *
     * @see    Pico::getParsedown()
     * @return void
     */
    protected function registerParsedown()
    {
        $this->parsedown = new ParsedownExtra();
    }

    /**
     * Returns the Parsedown Extra markdown parser
     *
     * @see    Pico::registerParsedown()
     * @return ParsedownExtra|null Parsedown Extra markdown parser
     */
    public function getParsedown()
    {
        return $this->parsedown;
    }

    /**
     * Applies some static preparations to the raw contents of a page,
     * e.g. removing the meta header and replacing %base_url%
     *
     * @see    Pico::parseFileContent()
     * @see    Pico::getFileContent()
     * @param  string $rawContent raw contents of a page
     * @param  array  $meta       meta data to use for %meta.*% replacement
     * @return string             contents prepared for parsing
     */
    public function prepareFileContent($rawContent, array $meta)
    {
        // remove meta header
        $metaHeaderPattern = "/^(\/(\*)|---)[[:blank:]]*(?:\r)?\n"
            . "(?:(.*?)(?:\r)?\n)?(?(2)\*\/|---)[[:blank:]]*(?:(?:\r)?\n|$)/s";
        $content = preg_replace($metaHeaderPattern, '', $rawContent, 1);

        // replace %site_title%
        $content = str_replace('%site_title%', $this->getConfig('site_title'), $content);

        // replace %base_url%
        if ($this->isUrlRewritingEnabled()) {
            // always use `%base_url%?sub/page` syntax for internal links
            // we'll replace the links accordingly, depending on enabled rewriting
            $content = str_replace('%base_url%?', $this->getBaseUrl(), $content);
        } else {
            // actually not necessary, but makes the URL look a little nicer
            $content = str_replace('%base_url%?', $this->getBaseUrl() . '?', $content);
        }
        $content = str_replace('%base_url%', rtrim($this->getBaseUrl(), '/'), $content);

        // replace %theme_url%
        $themeUrl = $this->getBaseUrl() . basename($this->getThemesDir()) . '/' . $this->getConfig('theme');
        $content = str_replace('%theme_url%', $themeUrl, $content);

        // replace %meta.*%
        if (!empty($meta)) {
            $metaKeys = $metaValues = array();
            foreach ($meta as $metaKey => $metaValue) {
                if (is_scalar($metaValue) || ($metaValue === null)) {
                    $metaKeys[] = '%meta.' . $metaKey . '%';
                    $metaValues[] = strval($metaValue);
                }
            }
            $content = str_replace($metaKeys, $metaValues, $content);
        }

        return $content;
    }

    /**
     * Parses the contents of a page using ParsedownExtra
     *
     * @see    Pico::prepareFileContent()
     * @see    Pico::getFileContent()
     * @param  string $content raw contents of a page (Markdown)
     * @return string          parsed contents (HTML)
     */
    public function parseFileContent($content)
    {
        if ($this->parsedown === null) {
            throw new LogicException("Unable to parse file contents: Parsedown instance wasn't registered yet");
        }

        return $this->parsedown->text($content);
    }

    /**
     * Returns the cached contents of the requested page
     *
     * @see    Pico::prepareFileContent()
     * @see    Pico::parseFileContent()
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
     * @see    Pico::sortPages()
     * @see    Pico::getPages()
     * @return void
     */
    protected function readPages()
    {
        $this->pages = array();
        $files = $this->getFiles($this->getConfig('content_dir'), $this->getConfig('content_ext'), Pico::SORT_NONE);
        foreach ($files as $i => $file) {
            // skip 404 page
            if (basename($file) === '404' . $this->getConfig('content_ext')) {
                unset($files[$i]);
                continue;
            }

            $id = substr($file, strlen($this->getConfig('content_dir')), -strlen($this->getConfig('content_ext')));

            // drop inaccessible pages (e.g. drop "sub.md" if "sub/index.md" exists)
            $conflictFile = $this->getConfig('content_dir') . $id . '/index' . $this->getConfig('content_ext');
            if (in_array($conflictFile, $files, true)) {
                continue;
            }

            $url = $this->getPageUrl($id);
            if ($file != $this->requestFile) {
                $rawContent = file_get_contents($file);

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
                'raw_content' => &$rawContent,
                'meta' => &$meta
            );

            if ($file === $this->requestFile) {
                $page['content'] = &$this->content;
            }

            unset($rawContent, $meta);

            // trigger event
            $this->triggerEvent('onSinglePageLoaded', array(&$page));

            $this->pages[$id] = $page;
        }
    }

    /**
     * Sorts all pages known to Pico
     *
     * @see    Pico::readPages()
     * @see    Pico::getPages()
     * @return void
     */
    protected function sortPages()
    {
        // sort pages
        $order = $this->getConfig('pages_order');
        $alphaSortClosure = function ($a, $b) use ($order) {
            $aSortKey = (basename($a['id']) === 'index') ? dirname($a['id']) : $a['id'];
            $bSortKey = (basename($b['id']) === 'index') ? dirname($b['id']) : $b['id'];

            $cmp = strcmp($aSortKey, $bSortKey);
            return $cmp * (($order === 'desc') ? -1 : 1);
        };

        if ($this->getConfig('pages_order_by') === 'date') {
            // sort by date
            uasort($this->pages, function ($a, $b) use ($alphaSortClosure, $order) {
                if (empty($a['time']) || empty($b['time'])) {
                    $cmp = (empty($a['time']) - empty($b['time']));
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
     * Returns the list of known pages
     *
     * @see    Pico::readPages()
     * @see    Pico::sortPages()
     * @return array[]|null the data of all pages
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Walks through the list of known pages and discovers the requested page
     * as well as the previous and next page relative to it
     *
     * @see    Pico::getCurrentPage()
     * @see    Pico::getPreviousPage()
     * @see    Pico::getNextPage()
     * @return void
     */
    protected function discoverCurrentPage()
    {
        $pageIds = array_keys($this->pages);

        $contentDir = $this->getConfig('content_dir');
        $contentDirLength = strlen($contentDir);

        // the requested file is not in the regular content directory, therefore its ID
        // isn't specified and it's impossible to determine the current page automatically
        if (substr($this->requestFile, 0, $contentDirLength) !== $contentDir) {
            return;
        }

        $contentExt = $this->getConfig('content_ext');
        $currentPageId = substr($this->requestFile, $contentDirLength, -strlen($contentExt));
        $currentPageIndex = array_search($currentPageId, $pageIds);
        if ($currentPageIndex !== false) {
            $this->currentPage = &$this->pages[$currentPageId];

            if (($this->getConfig('order_by') === 'date') && ($this->getConfig('order') === 'desc')) {
                $previousPageOffset = 1;
                $nextPageOffset = -1;
            } else {
                $previousPageOffset = -1;
                $nextPageOffset = 1;
            }

            if (isset($pageIds[$currentPageIndex + $previousPageOffset])) {
                $previousPageId = $pageIds[$currentPageIndex + $previousPageOffset];
                $this->previousPage = &$this->pages[$previousPageId];
            }

            if (isset($pageIds[$currentPageIndex + $nextPageOffset])) {
                $nextPageId = $pageIds[$currentPageIndex + $nextPageOffset];
                $this->nextPage = &$this->pages[$nextPageId];
            }
        }
    }

    /**
     * Returns the data of the requested page
     *
     * @see    Pico::discoverCurrentPage()
     * @return array|null page data
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Returns the data of the previous page relative to the page being served
     *
     * @see    Pico::discoverCurrentPage()
     * @return array|null page data
     */
    public function getPreviousPage()
    {
        return $this->previousPage;
    }

    /**
     * Returns the data of the next page relative to the page being served
     *
     * @see    Pico::discoverCurrentPage()
     * @return array|null page data
     */
    public function getNextPage()
    {
        return $this->nextPage;
    }

    /**
     * Registers the twig template engine
     *
     * This method also registers Pico's core Twig filters `link` and `content`
     * as well as Pico's {@link PicoTwigExtension} Twig extension.
     *
     * @see    Pico::getTwig()
     * @return void
     */
    protected function registerTwig()
    {
        $twigLoader = new Twig_Loader_Filesystem($this->getThemesDir() . $this->getConfig('theme'));
        $this->twig = new Twig_Environment($twigLoader, $this->getConfig('twig_config'));
        $this->twig->addExtension(new Twig_Extension_Debug());
        $this->twig->addExtension(new PicoTwigExtension($this));

        // register link filter
        $this->twig->addFilter(new Twig_SimpleFilter('link', array($this, 'getPageUrl')));

        // register content filter
        // we pass the $pages array by reference to prevent multiple parser runs for the same page
        // this is the reason why we can't register this filter as part of PicoTwigExtension
        $pico = $this;
        $pages = &$this->pages;
        $this->twig->addFilter(new Twig_SimpleFilter('content', function ($page) use ($pico, &$pages) {
            if (isset($pages[$page])) {
                $pageData = &$pages[$page];
                if (!isset($pageData['content'])) {
                    $pageData['content'] = $pico->prepareFileContent($pageData['raw_content'], $pageData['meta']);
                    $pageData['content'] = $pico->parseFileContent($pageData['content']);
                }
                return $pageData['content'];
            }
            return null;
        }));
    }

    /**
     * Returns the twig template engine
     *
     * @see    Pico::registerTwig()
     * @return Twig_Environment|null Twig template engine
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * Returns the variables passed to the template
     *
     * URLs and paths (namely `base_dir`, `base_url`, `theme_dir` and
     * `theme_url`) don't add a trailing slash for historic reasons.
     *
     * @return array template variables
     */
    protected function getTwigVariables()
    {
        $frontPage = $this->getConfig('content_dir') . 'index' . $this->getConfig('content_ext');
        return array(
            'config' => $this->getConfig(),
            'base_dir' => rtrim($this->getRootDir(), '/'),
            'base_url' => rtrim($this->getBaseUrl(), '/'),
            'theme_dir' => $this->getThemesDir() . $this->getConfig('theme'),
            'theme_url' => $this->getBaseUrl() . basename($this->getThemesDir()) . '/' . $this->getConfig('theme'),
            'rewrite_url' => $this->isUrlRewritingEnabled(),
            'site_title' => $this->getConfig('site_title'),
            'meta' => $this->meta,
            'content' => $this->content,
            'pages' => $this->pages,
            'prev_page' => $this->previousPage,
            'current_page' => $this->currentPage,
            'next_page' => $this->nextPage,
            'is_front_page' => ($this->requestFile === $frontPage),
        );
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
        if (!empty($baseUrl)) {
            return $baseUrl;
        }

        $protocol = 'http';
        if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            $secureProxyHeader = strtolower(current(explode(',', $_SERVER['HTTP_X_FORWARDED_PROTO'])));
            $protocol = in_array($secureProxyHeader, array('https', 'on', 'ssl', '1')) ? 'https' : 'http';
        } elseif (!empty($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] !== 'off')) {
            $protocol = 'https';
        } elseif ($_SERVER['SERVER_PORT'] == 443) {
            $protocol = 'https';
        }

        $host = $_SERVER['SERVER_NAME'];
        if (!empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
        } elseif (!empty($_SERVER['HTTP_HOST'])) {
            $host = $_SERVER['HTTP_HOST'];
        }

        $this->config['base_url'] = $protocol . "://" . $host . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';

        return $this->getConfig('base_url');
    }

    /**
     * Returns true if URL rewriting is enabled
     *
     * @return boolean true if URL rewriting is enabled, false otherwise
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

        return $this->getConfig('rewrite_url');
    }

    /**
     * Returns the URL to a given page
     *
     * @param  string       $page      identifier of the page to link to
     * @param  array|string $queryData either an array containing properties to
     *     create a URL-encoded query string from, or a already encoded string
     * @return string                  URL
     */
    public function getPageUrl($page, $queryData = null)
    {
        if (is_array($queryData)) {
            $queryData = http_build_query($queryData, '', '&');
        } elseif (($queryData !== null) && !is_string($queryData)) {
            throw new InvalidArgumentException(
                'Argument 2 passed to ' . get_called_class() . '::getPageUrl() must be of the type array or string, '
                . (is_object($queryData) ? get_class($queryData) : gettype($queryData)) . ' given'
            );
        }
        if (!empty($queryData)) {
            $page = !empty($page) ? $page : 'index';
            $queryData = $this->isUrlRewritingEnabled() ? '?' . $queryData : '&' . $queryData;
        }

        if (empty($page)) {
            return $this->getBaseUrl() . $queryData;
        } elseif (!$this->isUrlRewritingEnabled()) {
            return $this->getBaseUrl() . '?' . rawurlencode($page) . $queryData;
        } else {
            return $this->getBaseUrl() . implode('/', array_map('rawurlencode', explode('/', $page))) . $queryData;
        }
    }

    /**
     * Recursively walks through a directory and returns all containing files
     * matching the specified file extension
     *
     * @param  string $directory     start directory
     * @param  string $fileExtension return files with the given file extension
     *     only (optional)
     * @param  int    $order         specify whether and how files should be
     *     sorted; use Pico::SORT_ASC for a alphabetical ascending order (this
     *     is the default behaviour), Pico::SORT_DESC for a descending order
     *     or Pico::SORT_NONE to leave the result unsorted
     * @return array                 list of found files
     */
    protected function getFiles($directory, $fileExtension = '', $order = self::SORT_ASC)
    {
        $directory = rtrim($directory, '/');
        $result = array();

        // scandir() reads files in alphabetical order
        $files = scandir($directory, $order);
        $fileExtensionLength = strlen($fileExtension);
        if ($files !== false) {
            foreach ($files as $file) {
                // exclude hidden files/dirs starting with a .; this also excludes the special dirs . and ..
                // exclude files ending with a ~ (vim/nano backup) or # (emacs backup)
                if ((substr($file, 0, 1) === '.') || in_array(substr($file, -1), array('~', '#'))) {
                    continue;
                }

                if (is_dir($directory . '/' . $file)) {
                    // get files recursively
                    $result = array_merge($result, $this->getFiles($directory . '/' . $file, $fileExtension, $order));
                } elseif (empty($fileExtension) || (substr($file, -$fileExtensionLength) === $fileExtension)) {
                    $result[] = $directory . '/' . $file;
                }
            }
        }

        return $result;
    }

    /**
     * Makes a relative path absolute to Pico's root dir
     *
     * This method also guarantees a trailing slash.
     *
     * @param  string $path relative or absolute path
     * @return string       absolute path
     */
    public function getAbsolutePath($path)
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            if (preg_match('/^([a-zA-Z]:\\\\|\\\\\\\\)/', $path) !== 1) {
                $path = $this->getRootDir() . $path;
            }
        } else {
            if (substr($path, 0, 1) !== '/') {
                $path = $this->getRootDir() . $path;
            }
        }
        return rtrim($path, '/\\') . '/';
    }

    /**
     * Triggers events on plugins which implement PicoPluginInterface
     *
     * Deprecated events (as used by plugins not implementing
     * {@link PicoPluginInterface}) are triggered by {@link PicoDeprecated}.
     *
     * @see    PicoPluginInterface
     * @see    AbstractPicoPlugin
     * @see    DummyPlugin
     * @param  string $eventName name of the event to trigger
     * @param  array  $params    optional parameters to pass
     * @return void
     */
    protected function triggerEvent($eventName, array $params = array())
    {
        if (!empty($this->plugins)) {
            foreach ($this->plugins as $plugin) {
                // only trigger events for plugins that implement PicoPluginInterface
                // deprecated events (plugins for Pico 0.9 and older) will be triggered by `PicoDeprecated`
                if (is_a($plugin, 'PicoPluginInterface')) {
                    $plugin->handleEvent($eventName, $params);
                }
            }
        }
    }
}
