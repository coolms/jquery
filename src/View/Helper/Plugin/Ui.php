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

use CmsJquery\Options\JQueryUiOptionsInterface,
    CmsJquery\Options\Traits\JQueryUiOptionsTrait;

/**
 * @author Dmitry Popov <d.popov@altgraphic.com>
 *
 * @method Ui setOptions(\CmsJquery\Options\JQueryUiOptionsInterface $options)
 */
class Ui extends AbstractPlugin
{
    use JQueryUiOptionsTrait;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $options = $this->getOptions();

        if (!$this->getUseUi()) {
            return;
        }

        if ($this->getUseUiCdn()) {
            $files = $this->getUiCdnFiles();
            $cssFiles = $this->getUiCssCdnFiles();
        } else {
            $files = array_map([$this->getView(), 'basePath'], $this->getUiFiles());
            $cssFiles = array_map([$this->getView(), 'basePath'], $this->getUiCssFiles());
        }

        $files = array_map('sprintf', $files, array_fill(0, count($files), $this->getUiVersion()));
        array_map([$this->headScript(), 'appendFile'], $files);

        $cssFiles = array_map(
            'sprintf',
            $cssFiles,
            array_fill(0, count($cssFiles), $this->getUiVersion()),
            array_fill(0, count($cssFiles), $this->getUiTheme())
        );

        array_map([$this->headLink(), 'appendStylesheet'], $cssFiles);

        $jQuery = $this->jQuery()->getOptions()->getName();
        $this->headScript()->appendScript(<<<EOJ
{$jQuery}(function(){
  {$jQuery}.widget.bridge("uibutton", {$jQuery}.ui.button);
  {$jQuery}.widget.bridge("uitooltip", {$jQuery}.ui.tooltip);
});
EOJ
);
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke($element = null, array $options = [])
    {
        return $this;
    }
}
