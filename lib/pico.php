<?php

/**
 * Pico
 *
 * @author Gilbert Pellegrom
 * @link http://pico.dev7studios.com/
 * @license http://opensource.org/licenses/MIT
 * @version 0.5
 */
class Pico {

	/**
	 * The constructor carries out all the processing in Pico.
	 * Does URL routing, Markdown processing and Twig processing.
	 */
	function __construct()
	{
		// Get request url and script url
		$url = '';
		$request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
		$script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';

		// Get our url path and trim the / of the left and the right
		if($request_url != $script_url) $url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');
		$url = preg_replace('/\?.*/', '', $url); // Strip query string

		// Get the file path
		if($url) $file = CONTENT_DIR . $url;
		else $file = CONTENT_DIR .'index';

		// Load the file
		if(is_dir($file)) $file = CONTENT_DIR . $url .'/index'. CONTENT_EXT;
		else $file .= CONTENT_EXT;

		if(file_exists($file)) $content = file_get_contents($file);
		else {
			$content = file_get_contents(CONTENT_DIR .'404'. CONTENT_EXT);
			header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
		}
		
		// Load the settings
		$settings = $this->get_config();

		$meta = $this->read_file_meta($content);
		$content = preg_replace('#/\*.+?\*/#s', '', $content); // Remove comments and meta
		$content = $this->parse_content($content);
		
		// Get all the pages
		$pages = $this->get_pages($settings['base_url'], $settings['pages_order_by'], $settings['pages_order']);
		$prev_page = array();
		$current_page = array();
		$next_page = current($pages);
		while($current_page = current($pages)){
			if($meta['title'] == $current_page['title']){
				if ($next_page['title'] == $current_page['title']){
					$next_page = array();
				}
				break;
			}
			$next_page = current($pages);
			next($pages);
		}
		$prev_page = next($pages);

		// Load the theme
		Twig_Autoloader::register();
		$loader = new Twig_Loader_Filesystem(THEMES_DIR . $settings['theme']);
		$twig = new Twig_Environment($loader, $settings['twig_config']);
		$twig->addExtension(new Twig_Extension_Debug());
		echo $twig->render('index.html', array(
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
		));
	}

	/**
	 * Parses the content using Markdown
	 *
	 * @param string $content the raw txt content
	 * @return string $content the Markdown formatted content
	 */
	function parse_content($content)
	{
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
	function read_file_meta($content)
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
	function get_config()
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
			'pages_order' => 'asc'
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
	function get_pages($base_url, $order_by = 'alpha', $order = 'asc')
	{
		global $config;
		
		$pages = $this->glob_recursive(CONTENT_DIR .'*'. CONTENT_EXT);
		$sorted_pages = array();
		foreach($pages as $key=>$page){
			// Skip 404
			if(basename($page) == '404'. CONTENT_EXT){
				unset($pages[$key]);
				continue;
			}
			
			// Get title and format $page
			$page_content = file_get_contents($page);
			$page_meta = $this->read_file_meta($page_content);
			$url = str_replace(CONTENT_DIR, $base_url .'/', $page);
			$url = str_replace('index'. CONTENT_EXT, '', $url);
			$url = str_replace(CONTENT_EXT, '', $url);
			$data = array(
				'title' => $page_meta['title'],
				'url' => $url,
				'author' => $page_meta['author'],
				'date' => $page_meta['date'],
				'date_formatted' => date($config['date_format'], strtotime($page_meta['date']))
			);
			if($order_by == 'date') $sorted_pages[$page_meta['date']] = $data;
			else $sorted_pages[] = $data;
		}
		
		if($order == 'desc') krsort($sorted_pages);
		else ksort($sorted_pages);
		
		return $sorted_pages;
	}

	/**
	 * Helper function to work out the base URL
	 *
	 * @return string the base url
	 */
	function base_url()
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
	function get_protocol()
	{
		preg_match("|^HTTP[S]?|is",$_SERVER['SERVER_PROTOCOL'],$m);
		return strtolower($m[0]);
	}
	     
	/**
	 * Helper function to make glob recursive
	 *
	 * @param string $pattern glob pattern
	 * @param int $flags glob flags
	 * @return array the matched files/directories
	 */ 
	function glob_recursive($pattern, $flags = 0)
	{
		$files = glob($pattern, $flags);
		foreach(glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir){
			$files = array_merge($files, $this->glob_recursive($dir.'/'.basename($pattern), $flags));
		}
		return $files;
	}

}

?>
