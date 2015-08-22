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

use Zend\I18n\Translator\TranslatorAwareInterface,
    Zend\ServiceManager\AbstractPluginManager,
    Zend\ServiceManager\ConfigInterface,
    Zend\Stdlib\InitializableInterface,
    Zend\View\Helper,
    Zend\View\Renderer,
    CmsJquery\View\Helper\Plugins\AbstractPlugin;

/**
 * Plugin manager implementation for jQuery plugins.
 *
 * Enforces that plugin retrieved are instances of AbstractPlugin.
 *
 * @method AbstractPlugin get()
 */
class JQueryPluginManager extends AbstractPluginManager
{
    /**
     * Whether or not to share by default
     *
     * @var bool
     */
    protected $shareByDefault = false;

    /**
     * @var Renderer\RendererInterface
     */
    protected $renderer;

    /**
     * __construct
     *
     * @param ConfigInterface $configuration
     * @param Renderer\RendererInterface $renderer
     */
    public function __construct(ConfigInterface $configuration = null, Renderer\RendererInterface $renderer = null)
    {
        parent::__construct($configuration);

        if ($renderer) {
            $this->setRenderer($renderer);
        }

        $this->addInitializer([$this, 'injectRenderer'])
             ->addInitializer([$this, 'injectTranslator'])
             ->addInitializer([$this, 'callInit'], false);
    }

    /**
     * Set renderer
     *
     * @param  Renderer\RendererInterface $renderer
     * @return HelperPluginManager
     */
    public function setRenderer(Renderer\RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     * Retrieve renderer instance
     *
     * @return null|Renderer\RendererInterface
     */
    public function getRenderer()
    {
        $locator = $this->getServiceLocator();
        if (null === $this->renderer && $locator->has('Zend\\View\\Renderer\\RendererInterface')) {
            $this->setRenderer($locator->get('Zend\\View\\Renderer\\RendererInterface'));
        }

        return $this->renderer;
    }

    /**
     * Inject a helper instance with the registered renderer
     *
     * @param  Helper\HelperInterface $helper
     * @return void
     */
    public function injectRenderer($helper)
    {
        $renderer = $this->getRenderer();
        if (null === $renderer) {
            return;
        }

        $helper->setView($renderer);
    }

    /**
     * Inject a helper instance with the registered translator
     *
     * @param  Helper\HelperInterface $helper
     * @return void
     */
    public function injectTranslator($helper)
    {
        if (!$helper instanceof TranslatorAwareInterface) {
            return;
        }

        $locator = $this->getServiceLocator();

        if (!$locator) {
            return;
        }

        if ($locator->has('MvcTranslator')) {
            $helper->setTranslator($locator->get('MvcTranslator'));
            return;
        }

        if ($locator->has('Zend\\I18n\\Translator\\TranslatorInterface')) {
            $helper->setTranslator($locator->get('Zend\\I18n\\Translator\\TranslatorInterface'));
            return;
        }

        if ($locator->has('Translator')) {
            $helper->setTranslator($locator->get('Translator'));
            return;
        }
    }

    /**
     * Call init() on any plugin that implements InitializableInterface
     *
     * @internal param $plugin
     */
    public function callInit($plugin)
    {
        if ($plugin instanceof InitializableInterface) {
            $plugin->init();
        }
    }

    /**
     * Validate the plugin
     *
     * Checks that the plugin is an instance of AbstractPlugin
     *
     * @param  mixed $plugin
     * @throws \InvalidArgumentException
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof AbstractPlugin) {
            return; // we're okay
        }

        throw new \InvalidArgumentException(sprintf(
            'Can\'t create jQuery plugin for %s; ' .
            'Plugin must be an instance of CmsJquery\View\Helper\Plugins\AbstractPlugin',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin))
        ));
    }
}
