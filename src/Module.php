<?php
/**
 * CoolMS2 jQuery Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/jquery for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsJquery;

use Zend\Loader\ClassMapAutoloader,
    Zend\Loader\StandardAutoloader,
    Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\ConfigProviderInterface,
    Zend\ModuleManager\Feature\InitProviderInterface,
    Zend\ModuleManager\ModuleManagerInterface,
    CmsJquery\Plugin\JQueryPluginProviderInterface;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    InitProviderInterface
{
    /**
     * @param ModuleManagerInterface $moduleManager
     */
    public function init(ModuleManagerInterface $moduleManager)
    {
        $moduleManager->loadModule('AssetManager');

        $sm = $moduleManager->getEvent()->getParam('ServiceManager');
        $serviceListener = $sm->get('ServiceListener');
        $serviceListener->addServiceManager(
            'JQueryPluginManager',
            'jquery_plugins',
            JQueryPluginProviderInterface::class,
            'getJQueryPluginConfig'
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return [
            ClassMapAutoloader::class => [
                __DIR__ . '/../autoload_classmap.php',
            ],
            StandardAutoloader::class => [
                'fallback_autoloader' => true,
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
