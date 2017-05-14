<?php

/**
 * Use Twig for templates
 * @author Simone Salerno
 * @version 1.0.0
 * @license MIT 
 */
class pico_twig {
    
    /**
     * Apply Twig template
     * @param string $output
     * @param array $settings
     * @param array $data
     * @param array $meta 
     */
    public function apply_template(&$output, array $settings, array $data, array $meta) {
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
                'content' => $data['content'],
                'pages' => $data['pages'],
                'prev_page' => $data['prev_page'],
                'current_page' => $data['current_page'],
                'next_page' => $data['next_page'],
                'is_front_page' => $data['url'] ? false : true,
        );

        $template = (isset($meta['template']) && $meta['template']) ? $meta['template'] : 'index';
        $output = $twig->render($template .'.html', $twig_vars);
    }
}
