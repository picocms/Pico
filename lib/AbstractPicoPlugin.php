<?php

/**
 * Abstract class to extend from when implementing a Pico plugin
 *
 * @see IPicoPlugin
 *
 * @author  Daniel Rudolf
 * @link    http://picocms.org
 * @license http://opensource.org/licenses/MIT
 * @version 1.0
 */
abstract class AbstractPicoPlugin implements IPicoPlugin
{
    /**
     * Current instance of Pico
     *
     * @var Pico
     * @see IPicoPlugin::__construct()
     * @see IPicoPlugin::getPico()
     */
    private $pico;

    /**
     * Boolean indicating if this plugin is enabled (true) or disabled (false)
     *
     * @var boolean
     * @see IPicoPlugin::isEnabled()
     * @see IPicoPlugin::setEnabled()
     */
    protected $enabled = true;

    /**
     * Boolean indicating if this plugin was ever enabled/disabled manually
     *
     * @var boolean
     * @see IPicoPlugin::isStatusChanged()
     */
    protected $statusChanged = false;

    /**
     * List of plugins this plugin depends on
     *
     * @var array<string>
     * @see IPicoPlugin::getDependencies()
     * @see AbstractPicoPlugin::checkDependencies()
     */
    protected $dependsOn = array();

    /**
     * List of plugin which depend on this plugin
     *
     * @var array<object>
     * @see IPicoPlugin::getDependants()
     * @see AbstractPicoPlugin::checkDependants()
     */
    private $dependants;

    /**
     * @see IPicoPlugin::__construct()
     */
    public function __construct(Pico $pico)
    {
        $this->pico = $pico;
    }

    /**
     * @see IPicoPlugin::handleEvent()
     */
    public function handleEvent($eventName, array $params)
    {
        // plugins can be enabled/disabled using the config
        if ($eventName === 'onConfigLoaded') {
            $pluginEnabled = $this->getConfig(get_called_class().'.enabled');
            if ($pluginEnabled !== null) {
                $this->setEnabled($pluginEnabled);
            }
        }

        if ($this->isEnabled() || ($eventName === 'onPluginsLoaded')) {
            if (method_exists($this, $eventName)) {
                call_user_func_array(array($this, $eventName), $params);
            }
        }
    }

    /**
     * @see IPicoPlugin::setEnabled()
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
     * @see IPicoPlugin::isEnabled()
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @see IPicoPlugin::isStatusChanged()
     */
    public function isStatusChanged()
    {
        return $this->statusChanged;
    }

    /**
     * @see IPicoPlugin::getPico()
     */
    public function getPico()
    {
        return $this->pico;
    }

    /**
     * Passes all not satisfiable method calls to {@link Pico}
     *
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
            'Call to undefined method '.get_class($this->getPico()).'::'.$methodName.'() '
            . 'through '.get_called_class().'::__call()'
        );
    }

    /**
     * Enables all plugins on which this plugin depends
     *
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
                    "Unable to enable plugin '" . get_called_class() . "':"
                    . "Required plugin '" . $pluginName . "' not found"
                );
            }

            // plugins which don't implement IPicoPlugin are always enabled
            if (is_a($plugin, 'IPicoPlugin') && !$plugin->isEnabled()) {
                if ($recursive) {
                    if (!$plugin->isStatusChanged()) {
                        $plugin->setEnabled(true, true, true);
                    } else {
                        throw new RuntimeException(
                            "Unable to enable plugin '" . get_called_class() . "':"
                            . "Required plugin '" . $pluginName . "' was disabled manually"
                        );
                    }
                } else {
                    throw new RuntimeException(
                        "Unable to enable plugin '" . get_called_class() . "':"
                        . "Required plugin '" . $pluginName . "' is disabled"
                    );
                }
            }
        }
    }

    /**
     * @see IPicoPlugin::getDependencies()
     */
    public function getDependencies()
    {
        return $this->dependsOn;
    }

    /**
     * Disables all plugins which depend on this plugin
     *
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
     * @see IPicoPlugin::getDependants()
     */
    public function getDependants()
    {
        if ($this->dependants === null) {
            $this->dependants = array();
            foreach ($this->getPlugins() as $pluginName => $plugin) {
                // only plugins which implement IPicoPlugin support dependencies
                if (is_a($plugin, 'IPicoPlugin')) {
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
