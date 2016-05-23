<?php

/**
 * Creates a excerpt for the contents of each page (as of Pico v0.9 and older)
 *
 * This plugin exists for backward compatibility and is disabled by default.
 * It gets automatically enabled when {@link PicoDeprecated} is enabled. You
 * can avoid this by calling {@link PicoExcerpt::setEnabled()}.
 *
 * This plugin doesn't do its job very well and depends on
 * {@link PicoParsePagesContent}, what heavily impacts Pico's performance. You
 * should either use the Description meta header field or write something own.
 * Best solution seems to be a filter for twig, see e.g.
 * {@link https://gist.github.com/james2doyle/6629712}.
 *
 * @author  Daniel Rudolf
 * @link    http://picocms.org
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 1.0
 */
class PicoExcerpt extends AbstractPicoPlugin
{
    /**
     * This plugin is disabled by default
     *
     * @see AbstractPicoPlugin::$enabled
     */
    protected $enabled = false;

    /**
     * This plugin depends on PicoParsePagesContent
     *
     * @see PicoParsePagesContent
     * @see AbstractPicoPlugin::$dependsOn
     */
    protected $dependsOn = array('PicoParsePagesContent');

    /**
     * Adds the default excerpt length of 50 words to the config
     *
     * @see DummyPlugin::onConfigLoaded()
     */
    public function onConfigLoaded(array &$config)
    {
        if (!isset($config['excerpt_length'])) {
            $config['excerpt_length'] = 50;
        }
    }

    /**
     * Creates a excerpt for the contents of each page
     *
     * @see PicoExcerpt::createExcerpt()
     * @see DummyPlugin::onSinglePageLoaded()
     */
    public function onSinglePageLoaded(array &$pageData)
    {
        if (!isset($pageData['excerpt'])) {
            $pageData['excerpt'] = $this->createExcerpt(
                strip_tags($pageData['content']),
                $this->getConfig('excerpt_length')
            );
        }
    }

    /**
     * Helper function to create a excerpt of a string
     *
     * @param  string $string    the string to create a excerpt from
     * @param  int    $wordLimit the maximum number of words the excerpt should be long
     * @return string            excerpt of $string
     */
    protected function createExcerpt($string, $wordLimit)
    {
        $words = explode(' ', $string);
        if (count($words) > $wordLimit) {
            return trim(implode(' ', array_slice($words, 0, $wordLimit))) . '&hellip;';
        }
        return $string;
    }
}
