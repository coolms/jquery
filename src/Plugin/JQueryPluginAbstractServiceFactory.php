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
    Zend\ServiceManager\MutableCreationOptionsInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsJquery\View\Helper\Plugin;

class JQueryPluginAbstractServiceFactory implements AbstractFactoryInterface, MutableCreationOptionsInterface
{
    /**
     * @var array
     */
    protected $creationOptions = [];

    /**
     * {@inheritDoc}
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $plugins, $name, $requestedName)
    {
        if (!$plugins instanceof AbstractPluginManager) {
            throw new \BadMethodCallException('jQuery abstract plugin factory is meant to be used ' .
                'only with a plugin manager');
        }

        return true;
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

        $options = $this->creationOptions;
        if (empty($options['name'])) {
            $options['name'] = $requestedName;
        }

        return new Plugin($options);
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
