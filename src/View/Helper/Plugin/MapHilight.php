<?php 
/**
 * CoolMS2 jQuery Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/jquery for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsJquery\View\Helper\Plugin;

/**
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
class MapHilight extends AbstractPlugin
{
    /**
     * {@inheritDoc}
     *
     * @param array $uitooltip
     */
    protected function render($element, array $options = [], array $uitooltip = [])
    {
        if ($uitooltip) {
            $this->script()->append(<<<EOJ
    $("{$element}-map area").uitooltip({$this->encode($uitooltip)});
EOJ
            );
        }

        return parent::render($element, $options);
    }
}
