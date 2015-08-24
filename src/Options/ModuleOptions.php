<?php 
/**
 * CoolMS2 jQuery Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/jquery for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsJquery\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements JQueryOptionsInterface, JQueryUiOptionsInterface
{
    use Traits\JQueryOptionsTrait,
        Traits\JQueryUiOptionsTrait;

    /**
     * Turn off strict options mode
     *
     * @var bool
     */
    protected $__strictMode__ = false;
}
