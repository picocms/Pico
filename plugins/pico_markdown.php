<?php

/**
 * Write page content in Markdown
 * @author Simone Salerno 
 * @version 1.0.0
 * @license MIT
 */

class pico_markdown {
    
    /**
     * Parse Markdown content
     * @param array $data
     */
    public function get_page_data(&$data) {
        $this->parse_content($data['content']);
    }
    
    /**
     * Parse Markdown content
     * @param string $content
     */
    public function parse_content(&$content) {
        $content = preg_replace('#/\*.+?\*/#s', '', $content); // Remove comments and meta
        #$content = str_replace('%base_url%', $this->base_url(), $content);
        $content = Michelf\Markdown::defaultTransform($content);
    }
}
