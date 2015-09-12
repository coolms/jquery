<?php 
/**
 * CoolMS2 jQuery Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/jquery for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsJquery\View\Helper;

use Zend\View\Helper\HeadLink,
    Zend\View\Helper\HeadMeta,
    Zend\View\Helper\HeadStyle,
    Zend\View\Helper\HeadScript,
    Zend\View\Helper\InlineScript,
    CmsCommon\Stdlib\OptionsProviderTrait,
    CmsJquery\Options\JQueryOptionsInterface,
    CmsJquery\Plugin\JQueryPluginableInterface,
    CmsJquery\Plugin\JQueryPluginableTrait,
    CmsJquery\Plugin\JQueryPluginManager,
    CmsJquery\Plugin\JQueryPluginManagerAwareTrait,
    CmsJquery\View\Helper\Plugin\AbstractPlugin;

/**
 * @author Dmitry Popov <d.popov@altgraphic.com>
 *
 * @method JQuery setOptions(\CmsJquery\Options\JQueryOptionsInterface $options)
 * @method \CmsJquery\Options\JQueryOptionsInterface getOptions()
 */
class JQuery extends AbstractHelper implements JQueryPluginableInterface
{
    use OptionsProviderTrait,
        JQueryPluginableTrait,
        JQueryPluginManagerAwareTrait;

    /**
     * @var HeadLink
     */
    protected $headLink;

    /**
     * @var HeadMeta
     */
    protected $headMeta;

    /**
     * @var HeadStyle
     */
    protected $headStyle;

    /**
     * @var HeadScript
     */
    protected $headScript;

    /**
     * @var \Closure
     */
    private $__initialized__;

    /**
     * __construct
     *
     * @param ModuleOptionsInterface $options
     * @param JQueryPluginManager $plugins
     */
    public function __construct(JQueryOptionsInterface $options, JQueryPluginManager $plugins)
    {
        $this->setOptions($options);
        $this->setJQueryPluginManager($plugins);

        $this->__initialized__ = function() {
            $this->init();
        };
    }

    /**
     * __invoke
     *
     * @return string
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @return self
     */
    public function init()
    {
        if (null === $this->__initialized__) {
            return $this;
        }

        $this->__initialized__ = null;

        $options = $this->getOptions();
        if ($options->getEnabled()) {
            $this->setup()->setupPlugins();
        }

        return $this;
    }

    /**
     * @return self
     */
    protected function setup()
    {
        $options = $this->getOptions();
        $files = $options->getUseCdn()
            ? $options->getCdnFiles()
            : array_map([$this->getView(), 'basePath'], $options->getFiles());

        $files = array_map('sprintf', $files, array_fill(0, count($files), $options->getVersion()));
        array_map([$this->headScript(), 'appendFile'], $files);

        return $this;
    }

    /**
     * @return self
     */
    protected function setupPlugins()
    {
        foreach ($this->getPlugins() as $plugin => $options) {
            $plugins = $this->getJQueryPluginManager();
            if (!$plugins->has($plugin)) {
                $plugins->setFactory($plugin, 'CmsJquery\\Plugin\\JQueryPluginFactory');
            }

            if (is_array($options) && !empty($options['onload'])) {
                $this->getPlugin($plugin);
            }
        }

        return $this;
    }

    /**
     * @param string $plugin
     * @return AbstractPlugin
     */
    public function __get($plugin)
    {
        $this->__initialized__ && $this->__initialized__->__invoke();

        return $this->getPlugin($plugin);
    }

    /**
     * @param string $method
     * @param array $args
     * @return AbstractPlugin
     */
    public function __call($method, $args)
    {
        $this->__initialized__ && $this->__initialized__->__invoke();

        if ($plugin = $this->getPlugin($method)) {
            return call_user_func_array($plugin, $args);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getPlugins()
    {
        if (!$this->plugins) {
            $this->setPlugins($this->getOptions()->getPlugins());
        }

        return $this->plugins;
    }

    /**
     * @return HeadLink
     */
    public function headLink()
    {
        $this->__initialized__ && $this->__initialized__->__invoke();

        if (null === $this->headLink) {
            $this->headLink = new HeadLink();
            $this->headLink->setView($this->view);
        }

        return $this->headLink;
    }

    /**
     * @return HeadMeta
     */
    public function headMeta()
    {
        $this->__initialized__ && $this->__initialized__->__invoke();

        if (null === $this->headMeta) {
            $this->headMeta = new HeadMeta();
            $this->headMeta->setView($this->view);
        }

        return $this->headMeta;
    }

    /**
     * @return HeadStyle
     */
    public function headStyle()
    {
        $this->__initialized__ && $this->__initialized__->__invoke();

        if (null === $this->headStyle) {
            $this->headStyle = new HeadStyle();
            $this->headStyle->setView($this->view);
        }

        return $this->headStyle;
    }

    /**
     * @return HeadScript
     */
    public function headScript()
    {
        $this->__initialized__ && $this->__initialized__->__invoke();

        if (null === $this->headScript) {
            $this->headScript = new HeadScript();
            $this->headScript->setView($this->view);
        }

        return $this->headScript;
    }

    /**
     * @return InlineScript
     */
    public function inlineScript()
    {
        $renderer = $this->getView();
        if (method_exists($renderer, 'plugin')) {
            return $renderer->plugin('inlineScript');
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        try {
            $this->__initialized__ && $this->__initialized__->__invoke();

            return <<<JQUERY
{$this->headMeta()}
{$this->headLink()}
{$this->headStyle()}
{$this->headScript()}
JQUERY;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
