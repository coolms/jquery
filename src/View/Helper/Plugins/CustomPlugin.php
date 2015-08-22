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
class CustomPlugin extends AbstractPlugin
{
    /**
     * @var array
     */
    private $paths = [];

    /**
     * @var array
     */
    private $cssPaths = [];

    /**
     * @var string
     */
    private $element;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $options = [];

    /**
     * __construct
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->paths = (array) $options['path'];

        if (!empty($options['cssPath'])) {
            $this->cssPaths = (array) $options['cssPath'];
        }

        if (!empty($options['element'])) {
            $this->element = $options['element'];
        }

        if (!empty($options['name'])) {
            $this->name = $options['name'];
        }

        if (!empty($options['options']) && is_array($options['options'])) {
            $this->options = $options['options'];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        foreach ($this->basePath($this->paths) as $path) {
            $this->headScript()->appendFile($path);
        }

        foreach ($this->basePath($this->cssPaths) as $path) {
            $this->headLink()->appendStylesheet($path);
        }

        if ($this->element && $this->name) {
            $options = $this->options ? $this->encode($this->options) : '';
            $this->headScript()->appendScript(<<<EOJ
$(function(){ $("{$this->element}").{$this->name}({$options}); });
EOJ
            );
        }
    }
}
