<?php

/**
 * Common interface for Pico plugins
 *
 * For a list of supported events see {@link DummyPlugin}; you can use
 * {@link DummyPlugin} as template for new plugins. For a list of deprecated
 * events see {@link PicoDeprecated}.
 *
 * You SHOULD NOT use deprecated events when implementing this interface.
 * Deprecated events are triggered by the {@link PicoDeprecated} plugin, if
 * plugins which don't implement this interface are loaded. You can take
 * advantage from this behaviour if you want to do something only when old
 * plugins are loaded. Consequently the old events are never triggered when
 * your plugin is implementing this interface and no old plugins are present.
 *
 * If you're developing a new plugin, you MUST implement this interface. If
 * you're the developer of an old plugin, it is STRONGLY RECOMMENDED to use
 * the events introduced in Pico 1.0 when releasing a new version of your
 * plugin. If you want to use any of the new events, you MUST implement
 * this interface and update all other events you use.
 *
 * @author  Daniel Rudolf
 * @link    http://picocms.org
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 1.0
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
