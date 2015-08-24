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

use Zend\ServiceManager\AbstractFactoryInterface,
    Zend\ServiceManager\AbstractPluginManager,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsJquery\View\Helper\Plugin;

class JQueryPluginAbstractServiceFactory implements AbstractFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $plugins, $name, $requestedName)
    {
        if (!$plugins instanceof AbstractPluginManager) {
            throw new \BadMethodCallException('jQuery abstract plugin factory is meant to be used ' .
                'only with a plugin manager');
        }

        $services = $plugins->getServiceLocator();
        $options  = $services->get('CmsJquery\\Options\\ModuleOptions');

        $plugin = [];

        if (isset($options->getPlugins()[$requestedName])) {
            $plugin = $options->getPlugins()[$requestedName];
        }

        return is_string($plugin) || !empty($plugin['files']);
    }

    /**
     * {@inheritDoc}
     *
     * @return Plugin
     */
    public function createServiceWithName(ServiceLocatorInterface $plugins, $name, $requestedName)
    {
        if (!$this->canCreateServiceWithName($plugins, $name, $requestedName)) {
            throw new \BadMethodCallException("jQuery abstract plugin factory can't create " .
                "'$requestedName' plugin");
        }

        $services = $plugins->getServiceLocator();
        $options  = $services->get('CmsJquery\\Options\\ModuleOptions');

        $plugin = $options->getPlugins()[$requestedName];
        if (is_string($plugin)) {
            $plugin = ['files' => $plugin];
        }

        if (empty($plugin['name'])) {
            $plugin['name'] = $requestedName;
        }

        return new Plugin($plugin);
    }
}
