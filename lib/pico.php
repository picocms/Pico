<?php

/**
 * Pico
 *
 * @author Gilbert Pellegrom
 * @link http://pico.dev7studios.com
 * @license http://opensource.org/licenses/MIT
 * @version 0.6.2
 */
class Pico {

	private $plugins;

	/**
	 * The constructor carries out all the processing in Pico.
	 * Does URL routing, Markdown processing and Twig processing.
	 */
	public function __construct()
	{
		// Load plugins
		$this->load_plugins();
		$this->run_hooks('plugins_loaded');
		
		// Get request url and script url
		$url = '';
		$request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
		$script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';

		// Get our url path and trim the / of the left and the right
		if($request_url != $script_url) $url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');
		$url = preg_replace('/\?.*/', '', $url); // Strip query string
		$this->run_hooks('request_url', array(&$url));

		// Get the file path
		if($url) $file = CONTENT_DIR . $url;
		else $file = CONTENT_DIR .'index';

		// Load the file
		if(is_dir($file)) $file = CONTENT_DIR . $url .'/index'. CONTENT_EXT;
		else $file .= CONTENT_EXT;

		$this->run_hooks('before_load_content', array(&$file));
		if(file_exists($file)){
			$content = file_get_contents($file);
		} else {
			$this->run_hooks('before_404_load_content', array(&$file));
			$content = file_get_contents(CONTENT_DIR .'404'. CONTENT_EXT);
			header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
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
		$pages = $this->get_pages($settings['base_url'], $settings['pages_order_by'], $settings['pages_order'], $settings['excerpt_length']);
		$prev_page = array();
		$current_page = array();
		$next_page = array();
		while($current_page = current($pages)){
			if($meta['title'] == $current_page['title']){
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
			'theme_url' => $settings['base_url'] .'/'. basename(THEMES_DIR) .'/'. $settings['theme'],
			'site_title' => $settings['site_title'],
			'meta' => $meta,
			'content' => $content,
			'pages' => $pages,
			'prev_page' => $prev_page,
			'current_page' => $current_page,
			'next_page' => $next_page,
			'is_front_page' => $url ? false : true,
		);
		$this->run_hooks('before_render', array(&$twig_vars, &$twig));
		$output = $twig->render('index.html', $twig_vars);
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
		if(!empty($plugins)){
			foreach($plugins as $plugin){
				include_once($plugin);
				$plugin_name = preg_replace("/\\.[^.\\s]{3}$/", '', basename($plugin));
				if(class_exists($plugin_name)){
					$obj = new $plugin_name;
					$this->plugins[] = $obj;
				}
			}
		}
	}

	/**
	 * Parses the content using Markdown
	 *
	 * @param string $content the raw txt content
	 * @return string $content the Markdown formatted content
	 */
	private function parse_content($content)
	{
		$content = preg_replace('#/\*.+?\*/#s', '', $content); // Remove comments and meta
		$content = str_replace('%base_url%', $this->base_url(), $content);
		$content = Markdown($content);

		return $content;
	}

	/**
	 * Parses the file meta from the txt file header
	 *
	 * @param string $content the raw txt content
	 * @return array $headers an array of meta values
	 */
	private function read_file_meta($content)
	{
		global $config;
		
		$headers = array(
			'title'       	=> 'Title',
			'description' 	=> 'Description',
			'author' 		=> 'Author',
			'date' 			=> 'Date',
			'robots'     	=> 'Robots'
		);

	 	foreach ($headers as $field => $regex){
			if (preg_match('/^[ \t\/*#@]*' . preg_quote($regex, '/') . ':(.*)$/mi', $content, $match) && $match[1]){
				$headers[ $field ] = trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', $match[1]));
			} else {
				$headers[ $field ] = '';
			}
		}
		
		if($headers['date']) $headers['date_formatted'] = date($config['date_format'], strtotime($headers['date']));

		return $headers;
	}

	/**
	 * Loads the config
	 *
	 * @return array $config an array of config values
	 */
	private function get_config()
	{
		if(!file_exists(ROOT_DIR .'config.php')) return array();
		
		global $config;
		require_once(ROOT_DIR .'config.php');

		$defaults = array(
			'site_title' => 'Pico',
			'base_url' => $this->base_url(),
			'theme' => 'default',
			'date_format' => 'jS M Y',
			'twig_config' => array('cache' => false, 'autoescape' => false, 'debug' => false),
			'pages_order_by' => 'alpha',
			'pages_order' => 'asc',
			'excerpt_length' => 50
		);

		if(is_array($config)) $config = array_merge($defaults, $config);
		else $config = $defaults;

		return $config;
	}
	
	/**
	 * Get a list of pages
	 *
	 * @param string $base_url the base URL of the site
	 * @param string $order_by order by "alpha" or "date"
	 * @param string $order order "asc" or "desc"
	 * @return array $sorted_pages an array of pages
	 */
	private function get_pages($base_url, $order_by = 'alpha', $order = 'asc', $excerpt_length = 50)
	{
		global $config;
		
		$pages = $this->get_files(CONTENT_DIR, CONTENT_EXT);
		$sorted_pages = array();
		$date_id = 0;
		foreach($pages as $key=>$page){
			// Skip 404
			if(basename($page) == '404'. CONTENT_EXT){
				unset($pages[$key]);
				continue;
			}
			
			// Get title and format $page
			$page_content = file_get_contents($page);
			$page_meta = $this->read_file_meta($page_content);
			$page_content = $this->parse_content($page_content);
			$url = str_replace(CONTENT_DIR, $base_url .'/', $page);
			$url = str_replace('index'. CONTENT_EXT, '', $url);
			$url = str_replace(CONTENT_EXT, '', $url);
			$data = array(
				'title' => $page_meta['title'],
				'url' => $url,
				'author' => $page_meta['author'],
				'date' => $page_meta['date'],
				'date_formatted' => date($config['date_format'], strtotime($page_meta['date'])),
				'content' => $page_content,
				'excerpt' => $this->limit_words(strip_tags($page_content), $excerpt_length)
			);
			if($order_by == 'date'){
				$sorted_pages[$page_meta['date'].$date_id] = $data;
				$date_id++;
			}
			else $sorted_pages[] = $data;
		}
		
		if($order == 'desc') krsort($sorted_pages);
		else ksort($sorted_pages);
		
		return $sorted_pages;
	}
	
	/**
	 * Processes any hooks and runs them
	 *
	 * @param string $hook_id the ID of the hook
	 * @param array $args optional arguments
	 */
	private function run_hooks($hook_id, $args = array())
	{
		if(!empty($this->plugins)){
			foreach($this->plugins as $plugin){
				if(is_callable(array($plugin, $hook_id))){
					call_user_func_array(array($plugin, $hook_id), $args);
				}
			}
		}
	}

	/**
	 * Helper function to work out the base URL
	 *
	 * @return string the base url
	 */
	private function base_url()
	{
		global $config;
		if(isset($config['base_url']) && $config['base_url']) return $config['base_url'];

		$url = '';
		$request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
		$script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';
		if($request_url != $script_url) $url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');

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
		preg_match("|^HTTP[S]?|is",$_SERVER['SERVER_PROTOCOL'],$m);
		return strtolower($m[0]);
	}
	     
	/**
	 * Helper function to recusively get all files in a directory
	 *
	 * @param string $directory start directory
	 * @param string $ext optional limit to file extensions
	 * @return array the matched files
	 */ 
	private function get_files($directory, $ext = '')
	{
	    $array_items = array();
	    if($handle = opendir($directory)){
	        while(false !== ($file = readdir($handle))){
	            if($file != "." && $file != ".."){
	                if(is_dir($directory. "/" . $file)){
	                    $array_items = array_merge($array_items, $this->get_files($directory. "/" . $file, $ext));
	                } else {
	                    $file = $directory . "/" . $file;
	                    if(!$ext || strstr($file, $ext)) $array_items[] = preg_replace("/\/\//si", "/", $file);
	                }
	            }
	        }
	        closedir($handle);
	    }
	    return $array_items;
	}
	
	/**
	 * Helper function to limit the words in a string
	 *
	 * @param string $string the given string
	 * @param int $word_limit the number of words to limit to
	 * @return string the limited string
	 */ 
	private function limit_words($string, $word_limit)
	{
		$words = explode(' ',$string);
		return trim(implode(' ', array_splice($words, 0, $word_limit))) .'...';
	}

}
