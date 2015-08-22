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

trait JQueryPluginManagerAwareTrait
{
    /**
     * @var JQueryPluginManager
     */
    protected $jQueryPluginManager;

    /**
     * @return JQueryPluginManager
     */
    public function getJQueryPluginManager()
    {
        return $this->jQueryPluginManager;
    }

    /**
     * @param JQueryPluginManager $pluginManager
     * @return self
     */
    public function setJQueryPluginManager(JQueryPluginManager $pluginManager)
    {
        $this->jQueryPluginManager = $pluginManager;
        return $this;
    }
}