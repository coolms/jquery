<?php
/**
 * CoolMS2 jQuery Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/jquery for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsJquery\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsJquery\Options\ModuleOptions,
    CmsJquery\View\Helper\JQuery;

class JQueryHelperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return JQuery
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();
        return new JQuery(
            $services->get(ModuleOptions::class),
            $services->get('JQueryPluginManager')
        );
    }
}
