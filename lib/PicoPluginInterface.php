<?php
/**
 * This file is part of Pico. It's copyrighted by the contributors recorded
 * in the version control history of the file, available from the following
 * original location:
 *
 * <https://github.com/picocms/Pico/blob/master/lib/PicoPluginInterface.php>
 *
 * SPDX-License-Identifier: MIT
 * License-Filename: LICENSE
 */

/**
 * Common interface for Pico plugins
 *
 * For a list of supported events see {@see DummyPlugin}; you can use
 * {@see DummyPlugin} as template for new plugins. For a list of deprecated
 * events see {@see PicoDeprecated}.
 *
 * If you're developing a new plugin, you MUST both implement this interface
 * and define the class constant `API_VERSION`. You SHOULD always use the
 * API version of Pico's latest milestone when releasing a plugin. If you're
 * developing a new version of an existing plugin, it is strongly recommended
 * to update your plugin to use Pico's latest API version.
 *
 * @author  Daniel Rudolf
 * @link    http://picocms.org
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 2.1
 */
interface PicoPluginInterface
{
    /**
     * Handles a event that was triggered by Pico
     *
     * @param string $eventName name of the triggered event
     * @param array  $params    passed parameters
     */
    public function handleEvent($eventName, array $params);

    /**
     * Enables or disables this plugin
     *
     * @see PicoPluginInterface::isEnabled()
     * @see PicoPluginInterface::isStatusChanged()
     *
     * @param bool $enabled   enable (TRUE) or disable (FALSE) this plugin
     * @param bool $recursive when TRUE, enable or disable recursively.
     *     In other words, if you enable a plugin, all required plugins are
     *     enabled, too. When disabling a plugin, all depending plugins are
     *     disabled likewise. Recursive operations are only performed as long
     *     as a plugin wasn't enabled/disabled manually. This parameter is
     *     optional and defaults to TRUE.
     * @param bool $auto      enable or disable to fulfill a dependency. This
     *     parameter is optional and defaults to FALSE.
     *
     * @throws RuntimeException thrown when a dependency fails
     */
    public function setEnabled($enabled, $recursive = true, $auto = false);

    /**
     * Returns a boolean indicating whether this plugin is enabled or not
     *
     * You musn't rely on the return value when Pico's `onConfigLoaded` event
     * wasn't triggered on all plugins yet. This method might even return NULL
     * then. The plugin's status might change later.
     *
     * @see PicoPluginInterface::setEnabled()
     *
     * @return bool|null plugin is enabled (TRUE) or disabled (FALSE)
     */
    public function isEnabled();

    /**
     * Returns TRUE if the plugin was ever enabled/disabled manually
     *
     * @see PicoPluginInterface::setEnabled()
     *
     * @return bool plugin is in its default state (TRUE), FALSE otherwise
     */
    public function isStatusChanged();

    /**
     * Returns a list of names of plugins required by this plugin
     *
     * @return string[] required plugins
     */
    public function getDependencies();

    /**
     * Returns a list of plugins which depend on this plugin
     *
     * @return object[] dependant plugins
     */
    public function getDependants();

    /**
     * Returns the plugin's instance of Pico
     *
     * @see Pico
     *
     * @return Pico the plugin's instance of Pico
     */
    public function getPico();
}
