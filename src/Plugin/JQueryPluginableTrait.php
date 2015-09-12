<?php
/**
 * CoolMS2 jQuery Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/jquery for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsJquery\Plugin;

use CmsJquery\View\Helper\Plugin\AbstractPlugin;

trait JQueryPluginableTrait
{
    /**
     * @var array
     */
    protected $plugins = [];

    /**
     * @param string $plugin
     * @return AbstractPlugin
     */
    public function __get($plugin)
    {
        if ($plugin = $this->getPlugin($plugin)) {
            return $plugin;
        }

        if (is_callable('parent::__get')) {
            return parent::__get($plugin);
        }
    }

    /**
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if ($plugin = $this->getPlugin($method)) {
            return call_user_func_array($plugin, $args);
        }

        if (is_callable('parent::__call')) {
            return parent::__call($method, $args);
        }
    }

    /**
     * @return self
     */
    protected function setupPlugins()
    {
        foreach ($this->getPlugins() as $plugin => $options) {
            if (is_array($options) && !empty($options['onload'])) {
                $this->getPlugin($plugin);
            }
        }

        return $this;
    }

    /**
     * @param string $name
     * @param array $options
     * @return AbstractPlugin
     */
    protected function getPlugin($name)
    {
        $plugins = $this->getPlugins();
        $name = $this->normalizeMethodName($name);
        if (isset($plugins[$name])) {
            if (!$plugins[$name] instanceof AbstractPlugin) {
                $this->plugins[$name] = $this->getJQueryPluginManager()->get($name, $plugins[$name]);
            }

            return $this->plugins[$name];
        }
    }

    /**
     * @param array $plugins
     * @return self
     */
    protected function setPlugins(array $plugins)
    {
        foreach ($plugins as $name => $options) {
            $name = $this->normalizeMethodName($name);
            $this->plugins[$name] = $options;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getPlugins()
    {
        return $this->plugins;
    }
}
