<?php 
/**
 * CoolMS2 jQuery Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/jquery for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsJquery\View\Helper\Plugins;

/**
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
class MapHilight extends AbstractPlugin
{
    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->inlineScript()->appendFile($this->basePath('jquery.maphilight.min.js'));
    }

    /**
     * @param string $imageId
     * @param array $options
     * @param array $uitooltip
     * @return array
     */
    protected function renderContent($imageId, array $options = [], array $uitooltip = [])
    {
        if (!$options) {
            $options = new \stdClass();
        }

        $inlineScript[] = <<<EOJ
    $("#{$imageId}").maphilight({$this->encode($options)});
EOJ;

        if ($uitooltip) {
            $inlineScript[] = <<<EOJ
    $("#{$imageId}-map area").uitooltip({$this->encode($uitooltip)});
EOJ;
        }

        return [null, null, implode("\n", $inlineScript)];
    }
}
