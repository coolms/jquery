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

use Zend\ServiceManager\ServiceLocatorInterface,
    CmsJquery\Plugin\AbstractJQueryPluginFactory,
    CmsJquery\View\Helper\Plugin\Ui;

class UiPluginHelperFactory extends AbstractJQueryPluginFactory
{
    /**
     * @var string
     */
    protected $optionsClass = 'CmsJquery\\Options\\ModuleOptions';

    /**
     * {@inheritDoc}
     *
     * @return Ui
     */
    public function createService(ServiceLocatorInterface $plugins)
    {
        $services = $plugins->getServiceLocator();
        return new Ui($this->getCreationOptions($services));
    }
}
