<?php

/**
 * Parses the contents of all pages
 *
 * This plugin exists for backward compatibility and is disabled by default.
 * It gets automatically enabled when {@link PicoDeprecated} is enabled. You
 * can avoid this by calling {@link PicoParsePagesContent::setEnabled()}.
 *
 * This plugin heavily impacts Pico's performance, you should avoid to enable
 * it whenever possible! If you must parse the contents of a page, do this
 * selectively and only for pages you really need to.
 *
 * @author  Daniel Rudolf
 * @link    http://picocms.org
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 1.0
 */
class PicoParsePagesContent extends AbstractPicoPlugin
{
    /**
     * This plugin is disabled by default
     *
     * @see AbstractPicoPlugin::$enabled
     */
    protected $enabled = false;

    /**
     * Parses the contents of all pages
     *
     * @see DummyPlugin::onSinglePageLoaded()
     */
    public function onSinglePageLoaded(array &$pageData)
    {
        if (!isset($pageData['content'])) {
            $pageData['content'] = $this->prepareFileContent($pageData['raw_content'], $pageData['meta']);
            $pageData['content'] = $this->parseFileContent($pageData['content']);
        }
    }
}
