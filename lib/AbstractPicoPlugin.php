<?php

/**
 * Abstract class to extend from when implementing a Pico plugin
 *
 * @see PicoPluginInterface
 *
 * @author  Daniel Rudolf
 * @link    http://picocms.org
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 1.0
 */
abstract class AbstractPicoPlugin implements PicoPluginInterface
{
    /**
     * Current instance of Pico
     *
     * @see PicoPluginInterface::getPico()
     * @var Pico
     */
    private $pico;

    /**
     * Boolean indicating if this plugin is enabled (true) or disabled (false)
     *
     * @see PicoPluginInterface::isEnabled()
     * @see PicoPluginInterface::setEnabled()
     * @var boolean
     */
    protected $enabled = true;

    /**
     * Boolean indicating if this plugin was ever enabled/disabled manually
     *
     * @see PicoPluginInterface::isStatusChanged()
     * @var boolean
     */
    protected $statusChanged = false;

    /**
     * List of plugins which this plugin depends on
     *
     * @see AbstractPicoPlugin::checkDependencies()
     * @see PicoPluginInterface::getDependencies()
     * @var string[]
     */
    protected $dependsOn = array();

    /**
     * List of plugin which depend on this plugin
     *
     * @see AbstractPicoPlugin::checkDependants()
     * @see PicoPluginInterface::getDependants()
     * @var object[]
     */
    private $dependants;

    /**
     * @see PicoPluginInterface::__construct()
     */
    public function __construct(Pico $pico)
    {
        $this->pico = $pico;
    }

    /**
     * @see PicoPluginInterface::handleEvent()
     */
    public function handleEvent($eventName, array $params)
    {
        // plugins can be enabled/disabled using the config
        if ($eventName === 'onConfigLoaded') {
            $pluginEnabled = $this->getConfig(get_called_class() . '.enabled');
            if ($pluginEnabled !== null) {
                $this->setEnabled($pluginEnabled);
            } else {
                $pluginConfig = $this->getConfig(get_called_class());
                if (is_array($pluginConfig) && isset($pluginConfig['enabled'])) {
                    $this->setEnabled($pluginConfig['enabled']);
                } elseif ($this->enabled) {
                    // make sure dependencies are already fulfilled,
                    // otherwise the plugin needs to be enabled manually
                    try {
                        $this->checkDependencies(false);
                    } catch (RuntimeException $e) {
                        $this->enabled = false;
                    }
                }
            }
        }

        if ($this->isEnabled() || ($eventName === 'onPluginsLoaded')) {
            if (method_exists($this, $eventName)) {
                call_user_func_array(array($this, $eventName), $params);
            }
        }
    }

    /**
     * @see PicoPluginInterface::setEnabled()
     */
    public function setEnabled($enabled, $recursive = true, $auto = false)
    {
        $this->statusChanged = (!$this->statusChanged) ? !$auto : true;
        $this->enabled = (bool) $enabled;

        if ($enabled) {
            $this->checkDependencies($recursive);
        } else {
            $this->checkDependants($recursive);
        }
    }

    /**
     * @see PicoPluginInterface::isEnabled()
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @see PicoPluginInterface::isStatusChanged()
     */
    public function isStatusChanged()
    {
        return $this->statusChanged;
    }

    /**
     * @see PicoPluginInterface::getPico()
     */
    public function getPico()
    {
        return $this->pico;
    }

    /**
     * Passes all not satisfiable method calls to Pico
     *
     * @see    Pico
     * @param  string $methodName name of the method to call
     * @param  array  $params     parameters to pass
     * @return mixed              return value of the called method
     */
    public function __call($methodName, array $params)
    {
        if (method_exists($this->getPico(), $methodName)) {
            return call_user_func_array(array($this->getPico(), $methodName), $params);
        }

        throw new BadMethodCallException(
            'Call to undefined method ' . get_class($this->getPico()) . '::' . $methodName . '() '
            . 'through ' . get_called_class() . '::__call()'
        );
    }

    /**
     * Enables all plugins which this plugin depends on
     *
     * @see    PicoPluginInterface::getDependencies()
     * @param  boolean $recursive enable required plugins automatically
     * @return void
     * @throws RuntimeException   thrown when a dependency fails
     */
    protected function checkDependencies($recursive)
    {
        foreach ($this->getDependencies() as $pluginName) {
            try {
                $plugin = $this->getPlugin($pluginName);
            } catch (RuntimeException $e) {
                throw new RuntimeException(
                    "Unable to enable plugin '" . get_called_class() . "': "
                    . "Required plugin '" . $pluginName . "' not found"
                );
            }

            // plugins which don't implement PicoPluginInterface are always enabled
            if (is_a($plugin, 'PicoPluginInterface') && !$plugin->isEnabled()) {
                if ($recursive) {
                    if (!$plugin->isStatusChanged()) {
                        $plugin->setEnabled(true, true, true);
                    } else {
                        throw new RuntimeException(
                            "Unable to enable plugin '" . get_called_class() . "': "
                            . "Required plugin '" . $pluginName . "' was disabled manually"
                        );
                    }
                } else {
                    throw new RuntimeException(
                        "Unable to enable plugin '" . get_called_class() . "': "
                        . "Required plugin '" . $pluginName . "' is disabled"
                    );
                }
            }
        }
    }

    /**
     * @see PicoPluginInterface::getDependencies()
     */
    public function getDependencies()
    {
        return (array) $this->dependsOn;
    }

    /**
     * Disables all plugins which depend on this plugin
     *
     * @see    PicoPluginInterface::getDependants()
     * @param  boolean $recursive disabled dependant plugins automatically
     * @return void
     * @throws RuntimeException   thrown when a dependency fails
     */
    protected function checkDependants($recursive)
    {
        $dependants = $this->getDependants();
        if (!empty($dependants)) {
            if ($recursive) {
                foreach ($this->getDependants() as $pluginName => $plugin) {
                    if ($plugin->isEnabled()) {
                        if (!$plugin->isStatusChanged()) {
                            $plugin->setEnabled(false, true, true);
                        } else {
                            throw new RuntimeException(
                                "Unable to disable plugin '" . get_called_class() . "': "
                                . "Required by manually enabled plugin '" . $pluginName . "'"
                            );
                        }
                    }
                }
            } else {
                $dependantsList = 'plugin' . ((count($dependants) > 1) ? 's' : '') . ' ';
                $dependantsList .= "'" . implode("', '", array_keys($dependants)) . "'";
                throw new RuntimeException(
                    "Unable to disable plugin '" . get_called_class() . "': "
                    . "Required by " . $dependantsList
                );
            }
        }
    }

    /**
     * @see PicoPluginInterface::getDependants()
     */
    public function getDependants()
    {
        if ($this->dependants === null) {
            $this->dependants = array();
            foreach ($this->getPlugins() as $pluginName => $plugin) {
                // only plugins which implement PicoPluginInterface support dependencies
                if (is_a($plugin, 'PicoPluginInterface')) {
                    $dependencies = $plugin->getDependencies();
                    if (in_array(get_called_class(), $dependencies)) {
                        $this->dependants[$pluginName] = $plugin;
                    }
                }
            }
        }

        return $this->dependants;
    }
}
