<?php

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
 * @version 2.0
 */
interface PicoPluginInterface
{
    /**
     * Constructs a new instance of a Pico plugin
     *
     * @param Pico $pico current instance of Pico
     */
    public function __construct(Pico $pico);

    /**
     * Handles a event that was triggered by Pico
     *
     * @param  string $eventName name of the triggered event
     * @param  array  $params    passed parameters
     * @return void
     */
    public function handleEvent($eventName, array $params);

    /**
     * Enables or disables this plugin
     *
     * @see    PicoPluginInterface::isEnabled()
     * @see    PicoPluginInterface::isStatusChanged()
     * @param  boolean $enabled     enable (true) or disable (false) this plugin
     * @param  boolean $recursive   when true, enable or disable recursively
     *     In other words, if you enable a plugin, all required plugins are
     *     enabled, too. When disabling a plugin, all depending plugins are
     *     disabled likewise. Recursive operations are only performed as long
     *     as a plugin wasn't enabled/disabled manually. This parameter is
     *     optional and defaults to true.
     * @param  boolean $auto        enable or disable to fulfill a dependency
     *     This parameter is optional and defaults to false.
     * @return void
     * @throws RuntimeException     thrown when a dependency fails
     */
    public function setEnabled($enabled, $recursive = true, $auto = false);

    /**
     * Returns true if this plugin is enabled, false otherwise
     *
     * @see    PicoPluginInterface::setEnabled()
     * @return boolean plugin is enabled (true) or disabled (false)
     */
    public function isEnabled();

    /**
     * Returns true if the plugin was ever enabled/disabled manually
     *
     * @see    PicoPluginInterface::setEnabled()
     * @return boolean plugin is in its default state (true), false otherwise
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
     * Returns the plugins instance of Pico
     *
     * @see    Pico
     * @return Pico the plugins instance of Pico
     */
    public function getPico();
}
