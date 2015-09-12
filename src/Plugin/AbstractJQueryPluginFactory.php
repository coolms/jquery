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

use Zend\ServiceManager\AbstractPluginManager,
    Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\MutableCreationOptionsInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Stdlib\AbstractOptions,
    CmsCommon\Stdlib\ArrayUtils,
    CmsJquery\View\Helper\Plugin\AbstractPlugin;

abstract class AbstractJQueryPluginFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    /**
     * @var string
     */
    protected $pluginClass = 'CmsJquery\\View\\Helper\\Plugin';

    /**
     * @var string
     */
    protected $optionsClass;

    /**
     * @var array
     */
    protected $creationOptions = [];

    /**
     * {@inheritDoc}
     *
     * @return AbstractPlugin
     */
    public function createService(ServiceLocatorInterface $plugins)
    {
        if (!$plugins instanceof AbstractPluginManager) {
            throw new \BadMethodCallException('jQuery plugin factory is meant to be used ' .
                'only with a plugin manager');
        }

        $services = $plugins->getServiceLocator();
        $pluginClass = $this->pluginClass;
        $plugin = new $pluginClass($this->getCreationOptions($services));
        if ($plugin instanceof JQueryPluginableInterface) {
            foreach ($plugin->getPlugins() as $name => $options) {
                if (!$plugins->has($name)) {
                    $plugins->setFactory($name, 'CmsJquery\\Plugin\\JQueryPluginFactory');
                }
            }
        }
 
        return $plugin;
    }

    /**
     * @param ServiceLocatorInterface $services
     * @return array
     */
    protected function getCreationOptions(ServiceLocatorInterface $services)
    {
        if ($this->optionsClass && $services->has($this->optionsClass)) {
            $options = $services->get($this->optionsClass);
            if ($options instanceof AbstractOptions) {
                if ($options instanceof JQueryPluginOptionsInterface) {
                    return $options->setFromArray($this->creationOptions)->toArray();
                }

                $options = $options->toArray();
            }

            $options = ArrayUtils::iteratorToArray($options);
            if (is_array($options)) {
                return array_merge($options, $this->creationOptions);
            }
        }

        return $this->creationOptions;
    }

    /**
     * {@inheritDoc}
     */
    public function setCreationOptions(array $options)
    {
        $this->creationOptions = $options;
        return $this;
    }
}
