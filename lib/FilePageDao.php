<?php

class FilePageDao implements PageDao
{
    /**
     * @var Pico
     */
    private $pico;

    /**
     * @param Pico $pico
     */
    function __construct($pico)
    {
        $this->pico = $pico;
    }

    /**
     * @inheritdoc
     */
    function get_pages($base_url, $order_by = 'alpha', $order = 'asc', $meta_max_length = 2048, $excerpt_length = 50)
    {
        global $config;

        $pages = $this->pico->get_files(CONTENT_DIR, CONTENT_EXT);
        $sorted_pages = array();
        $date_id = 0;
        foreach ($pages as $key => $page) {
            // Skip 404
            if (basename($page) == '404' . CONTENT_EXT) {
                unset($pages[$key]);
                continue;
            }

            // Ignore Emacs (and Nano) temp files
            if (in_array(substr($page, -1), array('~', '#'))) {
                unset($pages[$key]);
                continue;
            }
            // Get title and format $page
            $page_content = file_get_contents($page, NULL, NULL, 0, $meta_max_length);
            $page_meta = $this->pico->read_file_meta($page_content);
            $page_content = $this->pico->parse_content($page_content);
            $url = str_replace(CONTENT_DIR, $base_url . '/', $page);
            $url = str_replace('index' . CONTENT_EXT, '', $url);
            $url = str_replace(CONTENT_EXT, '', $url);
            $data = array(
                'title' => isset($page_meta['title']) ? $page_meta['title'] : '',
                'url' => $url,
                'author' => isset($page_meta['author']) ? $page_meta['author'] : '',
                'date' => isset($page_meta['date']) ? $page_meta['date'] : '',
                'date_formatted' => isset($page_meta['date']) ? date($config['date_format'], strtotime($page_meta['date'])) : '',
                'content' => $page_content,
                'excerpt' => $this->limit_words(strip_tags($page_content), $excerpt_length),
                'last_modified' => new DateTime('@' . filemtime($page))
            );

            // Extend the data provided with each page by hooking into the data array
            $this->pico->run_hooks('get_page_data', array(&$data, $page_meta));

            if ($order_by == 'date' && isset($page_meta['date'])) {
                $sorted_pages[$page_meta['date'] . $date_id] = $data;
                $date_id++;
            } else $sorted_pages[] = $data;
        }

        if ($order == 'desc') krsort($sorted_pages);
        else ksort($sorted_pages);

        return $sorted_pages;
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
        $words = explode(' ', $string);
        return trim(implode(' ', array_splice($words, 0, $word_limit))) . '...';
    }

}