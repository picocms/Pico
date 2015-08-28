<?php

# First of all: Why? The sourcecode of existing forks like BaunCMS and
# PhilleCMS isn't "stupidly simple" anymore... You can read Picos sourcecode
# from top to down and even copy&paste programmers will understand what's going
# on. It's all about "understanding at first glance".
#
# Most important second: All changes are 100% backward compatible.
#
# I considered writing something own, but then caught up with Pico. The only
# thing missing was clean code - Picos concept, workflow and code really is
# "stupidly simple", but very powerful. Actually I just did a code refactoring.
# [I don't want to fork Pico](https://xkcd.com/927/) and I won't do it even
# if you reject my changes (obviously I'll still use it myself :smile:).
#
# This should be v1.0 ready. I recommend to release it as v1.0-beta, waiting
# some weeks to test it on a large user basis (I'll fix all appearing problems;
# btw: being a Collaborator would make this much easier) and finally releasing
# it as Pico 1.0 :smile:
#
# Please give me a hint if you'll merge this, I'll then update the homepage
# (`gh-pages` branch) accordingly.
#
# What did I do?
# - Fixes #79, Closes #93, Fixes #99, Closes #103, Closes #116, Fixes #140,
#   Fixes #158, Closes #171, Closes #241, Closes #244, Closes #246, Fixes #249
# - The code is now documented, code styling follows PSR. Pico superficially
#   grows from 400 LoC to 900 LoC, when removing all comments, Pico grows from
#   300 LoC to 450 LoC, mostly because of new public getter methods (= 50 LoC)
#   and PSR code styling. As said, there are no big functional changes, it's
#   more a code refactoring.
# - The new routing system now works out-of-the-box (even without rewriting)
#   with any webserver using the QUERY_STRING routing method. Internal links
#   now look like `?sub/page`, rewriting to basically remove the `?` is still
#   possible and recommended. Contrary to Pico 0.9 every webserver should work
#   just fine. Pico 0.9 required working URL rewriting, so if you want to use
#   old plugins/themes/contents, a working rewrite setup may still be required.
#   If you're not using the default `.htaccess`, your must update your rewrite
#   rules to follow the new principles. Internal links in content files are
#   declared with `%base_url%?sub/page`. Internal links in templates should be
#   declared using the new `link` filter (e.g. `{{ "sub/page"|link }}`), what
#   basically calls `Pico::getPageUrl()`. You musn't change anything if you
#   setup rewriting (what was required in Pico 0.9...), so I assume this to be
#   fully backward compatible :smile:
# - I've implemented a whole new plugin system while maintaining full backward
#   compatibility. See the class docs of `IPicoPlugin` for details. The new
#   event system supports plugin dependencies as well as some new events. It
#   was necessary to reliably distinct between old and new events, so all
#   events were renamed. The new `PicoDeprecated` plugin is crucial for
#   backward compatibility, it's enabled on demand. Refer to its class docs for
#   details.
# - The file extension of content files is now configurable
# - Heads up! #158 is fixed only when the `PicoParsePagesContent` plugin isn't
#   enabled. It's disabled by default, but gets automatically enabled with
#   `PicoDeprecated` as soon as an old plugin is loaded. This is necessary to
#   maintain backward compatibility. You can still disable it manually by
#   executing `$pico->getPlugin('PicoParsePagesContent')->setEnabled(false);`
#   or adding `$config['PicoParsePagesContent.enabled'] = false;` to your
#   `config.php`.
# - The meta headers are now parsed by the YAML component of the Symfony
#   project (see #116), but still requires you to register new headers during
#   the `onMetaHeaders` event. I'm uncertain about still requiring that. What
#   do you think?
# - Meta header variables are now accessible in content files using `%meta.*%`,
#   so you mustn't repeat yourself. You can now put an excerpt into the
#   `description` meta variable and output the same content at the beginning
#   of the article using `%meta.description%`.
# - I decided explicitly to NOT implement pages as objects ("stupidly simple",
#   see above). Anyway, I think plugin developers shouldn't manipulate data in
#   "wrong" events, this could lead us to unexpected behaviour. Sure, plugin
#   developers still can do this, we're passing variables by reference, but
#   it's not that obvious. I even thought about dereferencing the values after
#   the corrosponding event was called, but that would be backward incompatible.
#   What do you think?
# - How to fix the "composer problem" discussed in #221 and #223? There's a
#   very simple solution: When creating a release on GitHub (after you've
#   pushed the tag) you can upload "binaries". Simply execute composer locally,
#   create a ZIP archive and upload the result as "binary".
# - I didn't care much about #110, #238, #239 and #240 because I simply don't
#   need these features. But I think they are good ideas and the core should
#   support this. Just my 2 cents :smile:
# - #201 and #231 should be closed - this can easily be achieved with plugins.
#   In fact, there are already plugins adding support for these features...
# - Imo distinct documentations for users, theme designers and plugin devs is
#   MUCH more important than unit tests... Pico is a project with just about
#   500 LoC (+ comments), such a manageable project doesn't necessarily require
#   unit tests - they are nice to have, but that's it. Documentation should be
#   the top priority!
# - Note: I'm no english native speaker. Maybe someone should look through my
#   code comments :smile:
#

/**
 * Pico
 *
 * Pico is a stupidly simple, blazing fast, flat file CMS.
 * - Stupidly Simple: Picos makes creating and maintaining a
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
 * See <http://picocms.org/> for more info.
 *
 * @author  Gilbert Pellegrom
 * @author  Daniel Rudolf
 * @link    <http://picocms.org>
 * @license The MIT License <http://opensource.org/licenses/MIT>
 * @version 1.0
 */
class Pico
{
    /**
     * List of loaded plugins
     *
     * @see Pico::loadPlugins()
     * @var array<object>
     */
    protected $plugins;

    /**
     * Current configuration of this Pico instance
     *
     * @see Pico::loadConfig()
     * @var array
     */
    protected $config;

    /**
     * URL with which the user requested the page
     *
     * @see Pico::evaluateRequestUrl()
     * @var string
     */
    protected $requestUrl;

    /**
     * Path to the content file being served
     *
     * @see Pico::discoverRequestFile()
     * @var string
     */
    protected $requestFile;

    /**
     * Raw, not yet parsed contents to serve
     *
     * @see Pico::loadFileContent()
     * @var string
     */
    protected $rawContent;

    /**
     * Meta data of the page to serve
     *
     * @see Pico::parseFileMeta()
     * @var array
     */
    protected $meta;

    /**
     * Parsed content being served
     *
     * @see Pico::prepareFileContent()
     * @see Pico::parseFileContent()
     * @var string
     */
    protected $content;

    /**
     * List of known pages
     *
     * @see Pico::readPages()
     * @var array
     */
    protected $pages;

    /**
     * Data of the page being served
     *
     * @see Pico::discoverCurrentPage()
     * @var array
     */
    protected $currentPage;

    /**
     * Data of the previous page relative to the page being served
     *
     * @see Pico::discoverCurrentPage()
     * @var array
     */
    protected $previousPage;

    /**
     * Data of the next page relative to the page being served
     *
     * @see Pico::discoverCurrentPage()
     * @var array
     */
    protected $nextPage;

    /**
     * Twig instance used for template parsing
     *
     * @see Pico::registerTwig()
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * Variables passed to the twig template
     *
     * @var array
     */
    protected $twigVariables;

    /**
     * Constructs a new Pico instance
     *
     * The constructor carries out all the processing in Pico.
     * Does URL routing, Markdown processing and Twig processing.
     */
    public function __construct()
    {
        // load plugins
        $this->loadPlugins();
        $this->triggerEvent('onPluginsLoaded', array(&$this->plugins));

        // load config
        $this->loadConfig();
        $this->triggerEvent('onConfigLoaded', array(&$this->config));

        // evaluate request url
        $this->evaluateRequestUrl();
        $this->triggerEvent('onRequestUrl', array(&$this->requestUrl));

        // discover requested file
        $this->discoverRequestFile();
        $this->triggerEvent('onRequestFile', array(&$this->requestFile));

        // load raw file content
        $this->triggerEvent('onContentLoading', array(&$this->requestFile));

        if (file_exists($this->requestFile)) {
            $this->rawContent = $this->loadFileContent($this->requestFile);
        } else {
            $this->triggerEvent('on404ContentLoading', array(&$this->requestFile));

            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
            $this->rawContent = $this->load404Content();

            $this->triggerEvent('on404ContentLoaded', array(&$this->rawContent));
        }

        $this->triggerEvent('onContentLoaded', array(&$this->rawContent));

        // parse file meta
        $headers = $this->getMetaHeaders();

        $this->triggerEvent('onMetaParsing', array(&$this->rawContent, &$headers));
        $this->meta = $this->parseFileMeta($this->rawContent, $headers);
        $this->triggerEvent('onMetaParsed', array(&$this->meta));

        // parse file content
        $this->triggerEvent('onContentParsing', array(&$this->rawContent));

        $this->content = $this->prepareFileContent($this->rawContent);
        $this->triggerEvent('onContentPrepared', array(&$this->content));

        $this->content = $this->parseFileContent($this->content);
        $this->triggerEvent('onContentParsed', array(&$this->content));

        // read pages
        $this->triggerEvent('onPagesLoading');

        $this->readPages();
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
        if (file_exists(THEMES_DIR . $this->getConfig('theme') . '/' . $templateName . '.twig')) {
            $templateName .= '.twig';
        } else {
            $templateName .= '.html';
        }

        $this->triggerEvent('onPageRendering', array(&$this->twig, &$this->twigVariables, &$templateName));

        $output = $this->twig->render($templateName, $this->twigVariables);
        $this->triggerEvent('onPageRendered', array(&$output));

        echo $output;
    }

    /**
     * Loads plugins from PLUGINS_DIR in alphabetical order
     *
     * Plugin files may be prefixed by a number (e.g. 00-PicoDeprecated.php)
     * to indicate their processsing order. You MUST NOT use prefixes between
     * 00 and 19 (reserved for built-in plugins).
     *
     * @return void
     * @throws RuntimeException thrown when a plugin couldn't be loaded
     */
    protected function loadPlugins()
    {
        $this->plugins = array();
        $pluginFiles = $this->getFiles(PLUGINS_DIR, '.php');
        foreach ($pluginFiles as $pluginFile) {
            require_once($pluginFile);

            $className = preg_replace('/^[0-9]+-/', '', basename($pluginFile, '.php'));
            if (class_exists($className)) {
                $this->plugins[$className] = new $className($this);
            } else {
                // TODO: breaks backward compatibility
                //throw new RuntimeException("Unable to load plugin '".$className."'");
            }
        }
    }

    /**
     * Returns the instance of a named plugin
     *
     * Plugins SHOULD implement {@link IPicoPlugin}, but you MUST NOT rely on
     * it. For more information see {@link IPicoPlugin}.
     *
     * @see    Pico::loadPlugins()
     * @param  string           $pluginName name of the plugin
     * @return object                       instance of the plugin
     * @throws RuntimeException             thrown when the plugin wasn't found
     */
    public function getPlugin($pluginName)
    {
        if (isset($this->plugins[$pluginName])) {
            return $this->plugins[$pluginName];
        }

        throw new RuntimeException("Missing plugin '".$pluginName."'");
    }

    /**
     * Returns all loaded plugins
     *
     * @see    Pico::loadPlugins()
     * @return array<object>
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * Loads the config.php from CONFIG_DIR
     *
     * @return void
     */
    protected function loadConfig()
    {
        $defaultConfig = array(
            'site_title' => 'Pico',
            'base_url' => '',
            'rewrite_url' => null,
            'theme' => 'default',
            'date_format' => '%D %T',
            'twig_config' => array('cache' => false, 'autoescape' => false, 'debug' => false),
            'pages_order_by' => 'alpha',
            'pages_order' => 'asc',
            'content_dir' => ROOT_DIR . 'content-sample/',
            'content_ext' => '.md',
            'timezone' => ''
        );

        $config = require(CONFIG_DIR . 'config.php');
        $this->config = is_array($config) ? $config + $defaultConfig : $defaultConfig;

        if (empty($this->config['base_url'])) {
            $this->config['base_url'] = $this->getBaseUrl();
        }
        if (!empty($this->config['content_dir'])) {
            $this->config['content_dir'] = rtrim($this->config['content_dir'], '/') . '/';
        }
        if (!empty($this->config['timezone'])) {
            date_default_timezone_set($this->config['timezone']);
        } else {
            // explicitly set a default timezone to prevent a E_NOTICE
            // when no timezone is set; the `date_default_timezone_get()`
            // function always returns a timezone, at least UTC
            $defaultTimezone = date_default_timezone_get();
            date_default_timezone_set($defaultTimezone);
        }
    }

    /**
     * Returns either the value of the specified config variable or
     * the config array
     *
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
     * Pico 1.0 uses the QUERY_STRING routing method (e.g. /pico/?sub/page) to
     * support SEO-like URLs out-of-the-box with any webserver. You can still
     * setup URL rewriting (e.g. using mod_rewrite on Apache) to basically
     * remove the `?` from URLs, but your rewritten URLs must follow the
     * new QUERY_STRING principles. URL rewriting requires some special
     * configuration on your webserver, but this should be "basic work" for
     * any webmaster...
     *
     * Pico 0.9 and older required Apache with mod_rewrite enabled, thus old
     * plugins, templates and contents may require you to enable URL rewriting
     * to work. If you're upgrading from Pico 0.9, you probably have to update
     * your rewriting rules.
     *
     * We recommend you to use the `link` filter in templates to create
     * internal links, e.g. `{{ "sub/page"|link }}` is equivalent to
     * `{{ base_url }}sub/page`. In content files you can still use the
     * `%base_url%` variable; e.g. `%base_url%?sub/page` is automatically
     * replaced accordingly.
     *
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
        $pathComponent = $_SERVER['QUERY_STRING'];
        if (($pathComponentLength = strpos($pathComponent, '&')) !== false) {
            $pathComponent = substr($pathComponent, 0, $pathComponentLength);
        }
        $this->requestUrl = (strpos($pathComponent, '=') === false) ? urldecode($pathComponent) : '';
    }

    /**
     * Returns the URL with which the user requested the page
     *
     * @see    Pico::evaluateRequestUrl()
     * @return string request URL
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     * Uses the request URL to discover the content file to serve
     *
     * @return void
     */
    protected function discoverRequestFile()
    {
        if (empty($this->requestUrl)) {
            $this->requestFile = $this->getConfig('content_dir') . 'index' . $this->getConfig('content_ext');
        } else {
            $this->requestFile = $this->getConfig('content_dir') . $this->requestUrl;
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
     * Returns the path to the content file to serve
     *
     * @see    Pico::discoverRequestFile()
     * @return string file path
     */
    public function getRequestFile()
    {
        return $this->requestFile;
    }

    /**
     * Returns the raw contents of a file
     *
     * @param  string $file file path
     * @return string       raw contents of the file
     */
    public function loadFileContent($file)
    {
        return file_get_contents($file);
    }

    /**
     * Returns the raw contents of the 404 file if the requested file wasn't found
     *
     * @return string raw contents of the 404 file
     */
    public function load404Content()
    {
        return $this->loadFileContent($this->getConfig('content_dir') . '404' . $this->getConfig('content_ext'));
    }

    /**
     * Returns the cached raw contents, either of the requested or the 404 file
     *
     * @see    Pico::loadFileContent()
     * @return string raw contents
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
     * @return array known meta headers
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
     * closed by --- or C-style block comments (deprecated). The headers are
     * parsed by the YAML component of the Symfony project. You MUST register
     * new headers during the `onMetaHeaders` event first, otherwise they are
     * ignored and won't be returned.
     *
     * @see    <http://symfony.com/doc/current/components/yaml/introduction.html>
     * @param  string $content the raw file contents
     * @param  array  $headers a array containing the known headers
     * @return array           parsed meta data
     */
    public function parseFileMeta($rawContent, array $headers)
    {
        $meta = array();
        $pattern = "/^(\/(\*)|---)[[:blank:]]*(?:\r)?\n"
            . "(.*?)(?:\r)?\n(?(2)\*\/|---)[[:blank:]]*(?:(?:\r)?\n|$)/s";
        if (preg_match($pattern, $rawContent, $rawMetaMatches)) {
            $yamlParser = new \Symfony\Component\Yaml\Parser();
            $rawMeta = $yamlParser->parse($rawMetaMatches[3]);
            $rawMeta = array_change_key_case($rawMeta, CASE_LOWER);

            // TODO: maybe we should change this to pass all headers, no matter
            // they are registered during the `onMetaHeaders` event or not...
            foreach ($headers as $fieldId => $fieldName) {
                $fieldName = strtolower($fieldName);
                if (isset($rawMeta[$fieldName])) {
                    $meta[$fieldId] = $rawMeta[$fieldName];
                } else {
                    $meta[$fieldId] = '';
                }
            }

            if (!empty($meta['date'])) {
                $meta['time'] = strtotime($meta['date']);
                $meta['date_formatted'] = utf8_encode(strftime($this->getConfig('date_format'), $meta['time']));
            } else {
                $meta['time'] = $meta['date_formatted'] = '';
            }
        } else {
            foreach ($headers as $id => $field) {
                $meta[$id] = '';
            }

            $meta['time'] = $meta['date_formatted'] = '';
        }

        return $meta;
    }

    /**
     * Returns the parsed meta data of the requested page
     *
     * @see    Pico::parseFileMeta()
     * @return array parsed meta data
     */
    public function getFileMeta()
    {
        return $this->meta;
    }

    /**
     * Applies some static preparations to the raw contents of a page,
     * e.g. removing the meta header and replacing %base_url%
     *
     * @param  string $rawContent raw contents of a page
     * @return string             contents prepared for parsing
     */
    public function prepareFileContent($rawContent)
    {
        // remove meta header
        $metaHeaderPattern = "/^(\/(\*)|---)[[:blank:]]*(?:\r)?\n"
            . "(.*?)(?:\r)?\n(?(2)\*\/|---)[[:blank:]]*(?:(?:\r)?\n|$)/s";
        $content = preg_replace($metaHeaderPattern, '', $rawContent, 1);

        // replace %site_title%
        $content = str_replace('%site_title%', $this->getConfig('site_title'), $content);

        // replace %base_url%
        if ($this->isUrlRewritingEnabled()) {
            // always use `%base_url%?sub/page` syntax for internal links
            // we'll replace the links accordingly, depending on enabled rewriting
            $content = str_replace('%base_url%?', $this->getBaseUrl(), $content);
        } else {
            // actually not necessary, but makes the URLs look a little nicer
            $content = str_replace('%base_url%?', $this->getBaseUrl() . '?', $content);
        }
        $content = str_replace('%base_url%', rtrim($this->getBaseUrl(), '/'), $content);

        // replace %theme_url%
        $themeUrl = $this->getBaseUrl() . basename(THEMES_DIR) . '/' . $this->getConfig('theme');
        $content = str_replace('%theme_url%', $themeUrl, $content);

        // replace %meta.*%
        $metaKeys = array_map(function ($metaKey) {
            return '%meta.' . $metaKey . '%';
        }, array_keys($this->meta));
        $metaValues = array_values($this->meta);
        $content = str_replace($metaKeys, $metaValues, $content);

        return $content;
    }

    /**
     * Parses the contents of a page using ParsedownExtra
     *
     * @param  string $content raw contents of a page (Markdown)
     * @return string          parsed contents (HTML)
     */
    public function parseFileContent($content)
    {
        $parsedown = new ParsedownExtra();
        return $parsedown->text($content);
    }

    /**
     * Returns the cached contents of the requested page
     *
     * @see    Pico::parseFileContent()
     * @return string parsed contents
     */
    public function getFileContent()
    {
        return $this->content;
    }

    /**
     * Reads the data of all pages known to Pico
     *
     * @return void
     */
    protected function readPages()
    {
        $pages = array();
        $files = $this->getFiles($this->getConfig('content_dir'), $this->getConfig('content_ext'));
        foreach ($files as $i => $file) {
            // skip 404 page
            if (basename($file) == '404' . $this->getConfig('content_ext')) {
                unset($files[$i]);
                continue;
            }

            $id = substr($file, strlen($this->getConfig('content_dir')), -strlen($this->getConfig('content_ext')));
            $url = $this->getPageUrl($id);
            if ($file != $this->requestFile) {
                $rawContent = file_get_contents($file);
                $meta = $this->parseFileMeta($rawContent, $this->getMetaHeaders());
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

            if ($file == $this->requestFile) {
                $page['content'] = &$this->content;
            }

            unset($rawContent, $meta);

            // trigger event
            $this->triggerEvent('onSinglePageLoaded', array(&$page));

            $pages[$id] = $page;
        }

        // sort pages by date
        // Pico::getFiles() already sorts alphabetically
        $this->pages = $pages;
        if ($this->getConfig('pages_order_by') == 'date') {
            $pageIds = array_keys($this->pages);
            $order = $this->getConfig('pages_order');

            uasort($this->pages, function ($a, $b) use ($pageIds, $order) {
                if (empty($a['time']) || empty($b['time'])) {
                    $cmp = (empty($a['time']) - empty($b['time']));
                } else {
                    $cmp = ($b['time'] - $a['time']);
                }

                if ($cmp === 0) {
                    // never assume equality; fallback to the original order (= alphabetical)
                    $cmp = (array_search($b['id'], $pageIds) - array_search($a['id'], $pageIds));
                }

                return $cmp * (($order == 'desc') ? 1 : -1);
            });
        } elseif ($this->getConfig('pages_order') == 'desc') {
            $this->pages = array_reverse($this->pages);
        }
    }

    /**
     * Returns the list of known pages
     *
     * @see    Pico::readPages()
     * @return array the data of all pages
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Walks through the list of known pages and discovers the requested page
     * as well as the previous and next page relative to it
     *
     * @return void
     */
    protected function discoverCurrentPage()
    {
        $pageIds = array_keys($this->pages);

        $contentDir = $this->getConfig('content_dir');
        $contentExt = $this->getConfig('content_ext');
        $currentPageId = substr($this->requestFile, strlen($contentDir), -strlen($contentExt));
        $currentPageIndex = array_search($currentPageId, $pageIds);
        if ($currentPageIndex !== false) {
            $this->currentPage = &$this->pages[$currentPageId];

            if (($this->getConfig('order_by') == 'date') && ($this->getConfig('order') == 'desc')) {
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
     * @return array page data
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Returns the data of the previous page relative to the page being served
     *
     * @see    Pico::discoverCurrentPage()
     * @return array page data
     */
    public function getPreviousPage()
    {
        return $this->previousPage;
    }

    /**
     * Returns the data of the next page relative to the page being served
     *
     * @see    Pico::discoverCurrentPage()
     * @return array page data
     */
    public function getNextPage()
    {
        return $this->nextPage;
    }

    /**
     * Registers the twig template engine
     *
     * @return void
     */
    protected function registerTwig()
    {
        $twigLoader = new Twig_Loader_Filesystem(THEMES_DIR . $this->getConfig('theme'));
        $this->twig = new Twig_Environment($twigLoader, $this->getConfig('twig_config'));
        $this->twig->addExtension(new Twig_Extension_Debug());
        $this->twig->addFilter(new Twig_SimpleFilter('link', array($this, 'getPageUrl')));
    }

    /**
     * Returns the twig template engine
     *
     * @return Twig_Environment twig template engine
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * Returns the variables passed to the template
     *
     * URLs and paths (namely base_dir, base_url, theme_dir and theme_url)
     * don't add a trailing slash for historic reasons.
     *
     * @return array template variables
     */
    protected function getTwigVariables()
    {
        $frontPage = $this->getConfig('content_dir') . 'index' . $this->getConfig('content_ext');
        return array(
            'config' => $this->getConfig(),
            'base_dir' => rtrim(ROOT_DIR, '/'),
            'base_url' => rtrim($this->getBaseUrl(), '/'),
            'theme_dir' => THEMES_DIR . $this->getConfig('theme'),
            'theme_url' => $this->getBaseUrl() . basename(THEMES_DIR) . '/' . $this->getConfig('theme'),
            'rewrite_url' => $this->isUrlRewritingEnabled(),
            'site_title' => $this->getConfig('site_title'),
            'meta' => $this->meta,
            'content' => $this->content,
            'pages' => $this->pages,
            'prev_page' => $this->previousPage,
            'current_page' => $this->currentPage,
            'next_page' => $this->nextPage,
            'is_front_page' => ($this->requestFile == $frontPage),
        );
    }

    /**
     * Returns the base URL of this Pico instance
     *
     * @return string the base url
     */
    public function getBaseUrl()
    {
        if (!empty($this->getConfig('base_url'))) {
            return $this->getConfig('base_url');
        }

        if (
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
            || ($_SERVER['SERVER_PORT'] == 443)
            || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
        ) {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }

        $this->config['base_url'] =
            $protocol . "://" . $_SERVER['HTTP_HOST']
            . dirname($_SERVER['SCRIPT_NAME']) . '/';

        return $this->getConfig('base_url');
    }

    /**
     * Returns true if URL rewriting is enabled
     *
     * @return boolean true if URL rewriting is enabled, false otherwise
     */
    public function isUrlRewritingEnabled()
    {
        if (($this->getConfig('rewrite_url') === null) && isset($_SERVER['PICO_URL_REWRITING'])) {
            return (bool) $_SERVER['PICO_URL_REWRITING'];
        } elseif ($this->getConfig('rewrite_url')) {
            return true;
        }

        return false;
    }

    /**
     * Returns the URL to a given page
     *
     * @param  string $page identifier of the page to link to
     * @return string       URL
     */
    public function getPageUrl($page)
    {
        return $this->getBaseUrl() . ((!$this->isUrlRewritingEnabled() && !empty($page)) ? '?' : '') . $page;
    }

    /**
     * Recursively walks through a directory and returns all containing files
     * matching the specified file extension in alphabetical order
     *
     * @param  string $directory start directory
     * @param  string $ext       return files with this file extension only (optional)
     * @return array             list of found files
     */
    protected function getFiles($directory, $fileExtension = '')
    {
        $directory = rtrim($directory, '/');
        $result = array();

        // scandir() reads files in alphabetical order
        $files = scandir($directory);
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
                    $result = array_merge($result, $this->getFiles($directory . '/' . $file, $fileExtension));
                } elseif (empty($fileExtension) || (substr($file, -strlen($fileExtension)) === $fileExtension)) {
                    $result[] = $directory . '/' . $file;
                }
            }
        }

        return $result;
    }

    /**
     * Triggers events on plugins which implement {@link IPicoPlugin}
     *
     * Deprecated events (as used by plugins not implementing
     * {@link IPocPlugin}) are triggered by {@link PicoDeprecated}.
     *
     * @param  string $eventName name of the event to trigger
     * @param  array  $params    optional parameters to pass
     * @return void
     */
    protected function triggerEvent($eventName, array $params = array())
    {
        foreach ($this->plugins as $plugin) {
            // only trigger events for plugins that implement IPicoPlugin
            // deprecated events (plugins for Pico 0.9 and older) will be
            // triggered by the `PicoPluginDeprecated` plugin
            if (is_a($plugin, 'IPicoPlugin')) {
                $plugin->handleEvent($eventName, $params);
            }
        }
    }
}
