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

use CmsJquery\Plugin\AbstractJQueryPluginFactory,
    CmsJquery\Options\ModuleOptions,
    CmsJquery\View\Helper\Plugin\Ui;

class UiPluginHelperFactory extends AbstractJQueryPluginFactory
{
    /**
     * @var string
     */
    protected $pluginClass = Ui::class;

    /**
     * @var string
     */
    protected $optionsClass = ModuleOptions::class;
}
