<?php

use Michelf\MarkdownExtra;

interface PageDao
{
    /**
     * Returns a list of pages.
     *
     * @param string $base_url the base URL of the site
     * @param string $order_by order by "alpha" or "date"
     * @param string $order order "asc" or "desc"
     * @param int $meta_max_length Maximum length of page meta section
     * @param int $excerpt_length Maximum length of the excerpt in words
     * @return array $sorted_pages an array of pages
     */
    function get_pages($base_url, $order_by = 'alpha', $order = 'asc', $meta_max_length = 2048, $excerpt_length = 50);
}

/**
 * Pico
 *
 * @author Gilbert Pellegrom
 * @link http://pico.dev7studios.com
 * @license http://opensource.org/licenses/MIT
 * @version 0.7
 */
class Pico
{
    /**
     * @var array
     */
    private $plugins;
    /**
     * @var PageDao
     */
    private $page_dao;

    /**
     * The constructor carries out all the processing in Pico.
     * Does URL routing, Markdown processing and Twig processing.
     */
    public function __construct()
    {
        // Load plugins
        $this->load_plugins();
        if (!isset($this->page_dao)) {
            // If plugin not found - fallback to FilePageDao
            @require_once(LIB_DIR . 'FilePageDao.php');
            $this->page_dao = new FilePageDao($this);
        }

        $this->run_hooks('plugins_loaded');

        // Get request url and script url
        $url = '';
        $request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
        $script_url = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';

        // Get our url path and trim the / of the left and the right
        if ($request_url != $script_url) $url = trim(preg_replace('/' . str_replace('/', '\/', str_replace('index.php', '', $script_url)) . '/', '', $request_url, 1), '/');
        $url = preg_replace('/\?.*/', '', $url); // Strip query string
        $this->run_hooks('request_url', array(&$url));

        // Get the file path
        if ($url) $file = CONTENT_DIR . $url;
        else $file = CONTENT_DIR . 'index';

        // Load the file
        if (is_dir($file)) $file = CONTENT_DIR . $url . '/index' . CONTENT_EXT;
        else $file .= CONTENT_EXT;

        $this->run_hooks('before_load_content', array(&$file));
        if (file_exists($file)) {
            $content = file_get_contents($file);
        } else {
            $this->run_hooks('before_404_load_content', array(&$file));
            $content = file_get_contents(CONTENT_DIR . '404' . CONTENT_EXT);
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
            $this->run_hooks('after_404_load_content', array(&$file, &$content));
        }
        $this->run_hooks('after_load_content', array(&$file, &$content));

        // Load the settings
        $settings = $this->get_config();
        $this->run_hooks('config_loaded', array(&$settings));

        $meta = $this->read_file_meta($content);
        $this->run_hooks('file_meta', array(&$meta));
        $content = $this->parse_content($content);
        $this->run_hooks('content_parsed', array(&$content));

        // Get all the pages
        $pages = $this->page_dao->get_pages(
            $settings['base_url'],
            $settings['pages_order_by'],
            $settings['pages_order'],
            $settings['excerpt_length']);
        $prev_page = array();
        $current_page = array();
        $next_page = array();
        while ($current_page = current($pages)) {
            if ((isset($meta['title'])) && ($meta['title'] == $current_page['title'])) {
                break;
            }
            next($pages);
        }
        $prev_page = next($pages);
        prev($pages);
        $next_page = prev($pages);
        $this->run_hooks('get_pages', array(&$pages, &$current_page, &$prev_page, &$next_page));

        // Load the theme
        $this->run_hooks('before_twig_register');
        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem(THEMES_DIR . $settings['theme']);
        $twig = new Twig_Environment($loader, $settings['twig_config']);
        $twig->addExtension(new Twig_Extension_Debug());
        $twig_vars = array(
            'config' => $settings,
            'base_dir' => rtrim(ROOT_DIR, '/'),
            'base_url' => $settings['base_url'],
            'theme_dir' => THEMES_DIR . $settings['theme'],
            'theme_url' => $settings['base_url'] . '/' . basename(THEMES_DIR) . '/' . $settings['theme'],
            'site_title' => $settings['site_title'],
            'meta' => $meta,
            'content' => $content,
            'pages' => $pages,
            'prev_page' => $prev_page,
            'current_page' => $current_page,
            'next_page' => $next_page,
            'is_front_page' => $url ? false : true,
        );
        // use a custom template if specified Template: [filename] in page meta e.g. Template: spesh to try and use spesh.html in theme folder
        $template = ((isset($meta['template']) && file_exists($twig_vars['theme_dir'] . '/' . $meta['template'] . $settings['template_ext'])) ? $meta['template'] . $settings['template_ext'] : 'index' . $settings['template_ext']);

        $this->run_hooks('before_render', array(&$twig_vars, &$twig));
        $output = $twig->render($template, $twig_vars);
        $this->run_hooks('after_render', array(&$output));
        echo $output;
    }

    /**
     * Load any plugins
     */
    private function load_plugins()
    {
        $this->plugins = array();
        $plugins = $this->get_files(PLUGINS_DIR, '.php');
        if (!empty($plugins)) {
            foreach ($plugins as $plugin) {
                include_once($plugin);
                $plugin_name = preg_replace("/\\.[^.\\s]{3}$/", '', basename($plugin));
                if (class_exists($plugin_name)) {
                    $obj = new $plugin_name;
                    $this->plugins[] = $obj;

                    if ($obj instanceof PageDao) {
                        $this->page_dao = $obj;
                    }
                }
            }
        }
    }

    /**
     * Helper function to recusively get all files in a directory
     *
     * @param string $directory start directory
     * @param string $ext optional limit to file extensions
     * @return array the matched files
     */
    static function get_files($directory, $ext = '')
    {
        $array_items = array();
        if ($handle = opendir($directory)) {
            while (false !== ($file = readdir($handle))) {
                if (preg_match("/^(^\.)/", $file) === 0) {
                    if (is_dir($directory . "/" . $file)) {
                        $array_items = array_merge($array_items, self::get_files($directory . "/" . $file, $ext));
                    } else {
                        $file = $directory . "/" . $file;
                        if (!$ext || strstr($file, $ext)) $array_items[] = preg_replace("/\/\//si", "/", $file);
                    }
                }
            }
            closedir($handle);
        }
        return $array_items;
    }

    /**
     * Processes any hooks and runs them
     *
     * @param string $hook_id the ID of the hook
     * @param array $args optional arguments
     */
    function run_hooks($hook_id, $args = array())
    {
        if (!empty($this->plugins)) {
            foreach ($this->plugins as $plugin) {
                if (is_callable(array($plugin, $hook_id))) {
                    call_user_func_array(array($plugin, $hook_id), $args);
                }
            }
        }
    }

    /**
     * Loads the config
     *
     * @return array $config an array of config values
     */
    private function get_config()
    {
        global $config;
        @include_once(ROOT_DIR . 'config.php');

        $defaults = array(
            'site_title' => 'Pico',
            'base_url' => $this->base_url(),
            'theme' => 'default',
            'date_format' => 'jS M Y',
            'twig_config' => array('cache' => false, 'autoescape' => false, 'debug' => false),
            'pages_order_by' => 'alpha',
            'pages_order' => 'asc',
            'excerpt_length' => 50,
            'template_ext' => '.html'
        );

        if (is_array($config)) $config = array_merge($defaults, $config);
        else $config = $defaults;

        return $config;
    }

    /**
     * Helper function to work out the base URL
     *
     * @return string the base url
     */
    private function base_url()
    {
        global $config;
        if (isset($config['base_url']) && $config['base_url']) return $config['base_url'];

        $url = '';
        $request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
        $script_url = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';
        if ($request_url != $script_url) $url = trim(preg_replace('/' . str_replace('/', '\/', str_replace('index.php', '', $script_url)) . '/', '', $request_url, 1), '/');

        $protocol = $this->get_protocol();
        return rtrim(str_replace($url, '', $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']), '/');
    }

    /**
     * Tries to guess the server protocol. Used in base_url()
     *
     * @return string the current protocol
     */
    private function get_protocol()
    {
        preg_match("|^HTTP[S]?|is", $_SERVER['SERVER_PROTOCOL'], $m);
        return strtolower($m[0]);
    }

    /**
     * Parses the file meta from the txt file header.
     * Meta keys are converted to lowercase automatically.
     *
     * @param string $content the raw txt content
     * @return array $headers an array of meta values
     */
    function read_file_meta($content)
    {
        global $config;

        $headers = array(
            'title' => 'Title',
            'description' => 'Description',
            'author' => 'Author',
            'date' => 'Date',
            'robots' => 'Robots'
        );

        // Add support for custom headers by hooking into the headers array
        $this->run_hooks('before_read_file_meta', array(&$headers));

        foreach ($headers as $field => $regex) {
            if (preg_match('/^[ \t\/*#@]*' . preg_quote($regex, '/') . ':(.*)$/mi', $content, $match) && $match[1]) {
                $headers[$field] = trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', $match[1]));
            } else {
                $headers[$field] = '';
            }
        }

        if (isset($headers['date'])) $headers['date_formatted'] = date($config['date_format'], strtotime($headers['date']));

        return $headers;
    }

    /**
     * Parses the content using Markdown
     *
     * @param string $content the raw txt content
     * @return string $content the Markdown formatted content
     */
    function parse_content(&$content)
    {
        $content = preg_replace('#/\*.+?\*/#s', '', $content); // Remove comments and meta
        $content = str_replace('%base_url%', $this->base_url(), $content);
        $content = MarkdownExtra::defaultTransform($content);

        return $content;
    }
}

