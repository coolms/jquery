<?php
/**
 * CoolMS2 jQuery Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/jquery for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsJquery\Factory;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsJquery\Options\ModuleOptions,
    CmsJquery\Options\ModuleOptionsInterface;

class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return ModuleOptionsInterface
     */
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        $config = $serviceManager->get('Config');
        return new ModuleOptions(isset($config['cmsjquery']) ? $config['cmsjquery'] : []);
    }
}
