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

use CmsCommon\Stdlib\OptionsProviderTrait,
    CmsJquery\Options\ModuleOptionsInterface;

/**
 * @author Dmitry Popov <d.popov@altgraphic.com>
 *
 * @method Ui setOptions(\CmsJquery\Options\ModuleOptionsInterface $options)
 * @method \CmsJquery\Options\ModuleOptionsInterface getOptions()
 */
class Ui extends AbstractPlugin
{
    use OptionsProviderTrait;

    /**
     * __construct
     *
     * @param ModuleOptionsInterface $options
     */
    public function __construct(ModuleOptionsInterface $options)
    {
        $this->setOptions($options);
    }

    /**
     * @return self
     */
    public function init()
    {
        $options = $this->getOptions();

        if (!$options->getUseUI()) {
            return $this;
        }

        if ($options->getUseCdn()) {
            $path = $options->getUiCdnUrl();
            $cssPaths = $options->getUiCssCdnUrl();
        } else {
            $path = $this->getView()->basePath($options->getUiPath());
            $cssPaths = array_map([$this->getView(), 'basePath'], $options->getUiCssPath());
        }

        foreach ($cssPaths as $cssPath) {
            $this->headLink()->appendStylesheet(sprintf(
                $cssPath,
                $options->getUiVersion(),
                $options->getUiTheme()
            ));
        }

        $this->headScript()->appendFile(sprintf($path, $options->getUiVersion()))
            ->appendScript(<<<EOJ
$(function(){
  $.widget.bridge("uibutton", $.ui.button);
  $.widget.bridge("uitooltip", $.ui.tooltip);
});
EOJ
);

        foreach ($options->getUiPlugins() as $plugin => $options) {
            if (is_string($options)) {
                $plugin = $options;
                $options = [];
            }

            if (!empty($options['onLoad'])) {
                $this->jQueryPluginManager->get($plugin, $options);
            }
        }

        return $this;
    }
}
