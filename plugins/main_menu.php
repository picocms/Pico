<?php

/**
 * Main Menu plugin for Pico
 *
 * @author Andrew Meyer
 * @link http://rewdy.com
 * @license http://opensource.org/licenses/MIT
 */

class Main_Menu {

	public $menu_items = array();

	public function get_pages(&$pages, &$current_page, &$prev_page, &$next_page)
	{

		foreach($pages as $key=>$page) {
			if (!$page['date']) {
				$show_pages[$key] = $page;
				if ($page['url'] == $current_page['url']) {
					$show_pages[$key]['current'] = true;
				} else {
					$show_pages[$key]['current'] = false;
				}
			}
		}
		
		$this->menu_items = $show_pages;
	}

	public function before_render(&$twig_vars, &$twig)
	{
		$twig_vars['menu_items'] = $this->menu_items;
	}
}