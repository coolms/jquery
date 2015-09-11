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

use Zend\Filter\FilterChain,
    Zend\Filter\FilterInterface,
    Zend\Json\Json,
    Zend\Stdlib\AbstractOptions,
    Zend\Stdlib\InitializableInterface,
    Zend\View\Helper\AbstractHelper,
    Zend\View\Helper\HeadScript,
    Zend\View\Helper\InlineScript,
    Zend\View\Helper\Placeholder\Container,
    JSMin\JSMin,
    CmsCommon\Stdlib\ArrayUtils,
    CmsJquery\Stdlib\AbstractObject,
    CmsJquery\View\Helper\JQuery;

/**
 * @author Dmitry Popov <d.popov@altgraphic.com>
 *
 * @method \Zend\View\Helper\HeadLink headLink()
 * @method \Zend\View\Helper\HeadMeta headMeta()
 * @method \Zend\View\Helper\HeadStyle headStyle()
 * @method \Zend\View\Helper\HeadScript headScript()
 * @method \Zend\View\Helper\InlineScript inlineScript()
 */
abstract class AbstractPlugin extends AbstractHelper implements InitializableInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $element;

    /**
     * @var array
     */
    protected $defaults = [];

    /**
     * @var array
     */
    protected $files = [];

    /**
     * @var array
     */
    protected $cssFiles = [];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var bool
     */
    protected $onload = false;

    /**
     * @var string
     */
    protected $basePath = 'plugins/';

    /**
     * @var bool
     */
    protected $appendScript = true;

    /**
     * @var Container
     */
    private $script;

    /**
     * @var Container
     */
    private $markup;

    /**
     * @var bool
     */
    protected $minifyScript = false;

    /**
     * @var bool
     */
    protected $renderScriptAsTemplate = false;

    /**
     * @var string
     */
    protected $templateType = 'text/x-jquery-tmpl';

    /**
     * @var array
     */
    protected $templateScriptAttribs = [];

    /**
     * @var array
     */
    protected $defaultJsonEncodeOptions = [
        'enableJsonExprFinder' => true,
        'prettyPrint' => true,
    ];

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var FilterInterface
     */
    private $methodNameFilter;

    /**
     * __construct
     *
     * @param array|\Traversable $options
     */
    public function __construct($options = null)
    {
        if (null !== $options) {
            $this->setOptions($options);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $cssFiles = array_map([$this, 'basePath'], $this->getCssFiles());
        array_map([$this->headLink(), 'appendStylesheet'], $cssFiles);

        $files = array_map([$this, 'basePath'], $this->getFiles());
        array_map([$this->scriptHelper(), 'appendFile'], $files);

        if ($this->getElement() && $this->getName()) {
            $this->render($this->getElement());
        }
    }

    /**
     * @param mixed $element
     * @param array $options
     * @return array|string|self
     */
    public function __invoke($element = null, array $options = [])
    {
        if (0 === func_num_args()) {
            return $this;
        }

        return call_user_func_array([$this, 'render'], func_get_args());
    }

    /**
     * @param string $element
     * @param array $options
     * @return array|string|self
     */
    protected function render($element, array $options = [])
    {
        $jQuery = $this->jQuery()->getOptions()->getName();

        if (is_string($element)) {
            $options = $options ? array_merge($this->getDefaults(), $options) : $this->getDefaults();
            $this->script()->prepend(sprintf(<<<EOJ
%s("%s").%s(%s);
EOJ
                ,
                $jQuery,
                $element,
                $this->getName(),
                $options ? $this->encode($options) : ''
            ));
        }

        if ($this->getAppendScript()) {
            $script = <<<EOJ
;{$jQuery}(function(){ {$this->getScript()} });
EOJ;

            if ($this->getRenderScriptAsTemplate()) {
                $attribs = $this->templateScriptAttribs;

                $idNormalizer = null;
                $renderer = $this->getView();
                if (method_exists($renderer, 'plugin')) {
                    $idNormalizer = $renderer->plugin('idNormalizer');
                }

                if (is_string($element)) {
                    if ($idNormalizer) {
                        $element = $idNormalizer($element);
                    }

                    $attribs['id'] = "$element-script";
                }

                if (!isset($attribs['class'])) {
                    $name = $this->getName();
                    if ($idNormalizer) {
                        $name = $idNormalizer($name);
                    }

                    $attribs['class'] = "$name-script";
                }

                if (!isset($attribs['noescape'])) {
                    $attribs['noescape'] = true;
                }

                $this->scriptHelper()->setAllowArbitraryAttributes(true)
                    ->appendScript($script, $this->templateType, $attribs);
            } else {
                $this->scriptHelper()->appendScript($script);
            }
        }

        return (string) $this->markup();
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = (string) $name;
        return $this;
    }

    /**
     * @return string
     */
    protected function getName()
    {
        return $this->name;
    }

    /**
     * @param string $element
     * @return self
     */
    public function setElement($element)
    {
        $this->element = $element;
        return $this;
    }

    /**
     * @return string
     */
    protected function getElement()
    {
        return $this->element;
    }

    /**
     * @param array $defaults
     * @return self
     */
    public function setDefaults($defaults)
    {
        $this->defaults = (array) $defaults;
        return $this;
    }

    /**
     * @return array
     */
    protected function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * @param array|string $files
     * @return self
     */
    public function setFiles($files)
    {
        $this->files = (array) $files;
        return $this;
    }

    /**
     * @return array
     */
    protected function getFiles()
    {
        return $this->files;
    }

    /**
     * @param array|string $cssFiles
     * @return self
     */
    public function setCssFiles($files)
    {
        $this->cssFiles = (array) $files;
        return $this;
    }

    /**
     * @return array
     */
    protected function getCssFiles()
    {
        return $this->cssFiles;
    }

    /**
     * @param array|Traversable|AbsractOptions $options
     * @return self
     */
    public function setOptions($options)
    {
        if (!is_array($options)) {
            if ($options instanceof AbstractOptions) {
                $options = $options->toArray();
            } else {
                $options = ArrayUtils::iteratorToArray($options);
            }
        }

        foreach ($options as $name => $value) {
            $setter = $this->normalizeMethodName("set_$name");
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            } else {
                $this->options[$name] = $value;
            }
        }

        return $this;
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function getOption($name)
    {
        if (isset($this->options[$name])) {
            return $this->options[$name];
        }
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return $this->options;
    }

    /**
     * @return bool
     */
    protected function hasOptions()
    {
        return (bool) $this->options;
    }

    /**
     * @return bool $flag
     * @return self
     */
    public function setOnload($flag)
    {
        $this->onload = (bool) $flag;
        return $this;
    }

    /**
     * @return bool
     */
    protected function getOnload()
    {
        return $this->onload;
    }

    /**
     * @return string
     */
    public function getScript()
    {
        $script = (string) $this->script();
        if ($this->getMinifyScript()) {
            return $this->minifyScript($script);
        }

        return $script;
    }

    /**
     * @return Container
     */
    protected function script()
    {
        if (null === $this->script) {
            $this->script = new Container();
            $this->script->setSeparator(PHP_EOL);
        }

        return $this->script;
    }

    /**
     * @return Container
     */
    protected function markup()
    {
        if (null === $this->markup) {
            $this->markup = new Container();
        }

        return $this->markup;
    }

    /**
     * @param array|string $path
     * @return string
     */
    protected function basePath($path = null)
    {
        if (!$path) {
            return;
        }

        if (is_string($path)) {
            /* @var $assetPath \CmsCommon\View\Helper\AssetPath */
            $assetPath = $this->getView()->plugin('assetPath');
            $basePath  = $this->getBasePath();
            if ($path[0] === '/' || !$basePath) {
                return $assetPath($path, $this->getNamespace());
            }

            return $assetPath(rtrim($basePath, '/\\') . '/' . $path, $this->getNamespace());
        }

        return array_map([$this, 'basePath'], $path);
    }

    /**
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->jQuery(), $method], $args);
    }

    /**
     * @return JQuery
     */
    protected function jQuery()
    {
        $renderer = $this->getView();
        if (method_exists($renderer, 'plugin')) {
            return $renderer->plugin('jQuery');
        }
    }

    /**
     * @return HeadScript|InlineScript
     */
    protected function scriptHelper()
    {
        $scriptHelper = $this->getOnload() ? 'headScript' : 'inlineScript';
        return $this->$scriptHelper();
    }

    /**
     * @param mixed $content
     * @param array $encodeOptions
     * @return string
     */
    protected function encode($content, array $encodeOptions = [])
    {
        return Json::encode($content, false, $encodeOptions ?: $this->defaultJsonEncodeOptions);
    }

    /**
     * @param string $path
     * @return self
     */
    public function setBasePath($path)
    {
        $this->basePath = $path;
        return $this;
    }

    /**
     * @return string
     */
    protected function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param bool $flag
     * @return self
     */
    public function setAppendScript($flag)
    {
        $this->appendScript = (bool) $flag;
        return $this;
    }

    /**
     * @return bool
     */
    protected function getAppendScript()
    {
        return $this->appendScript;
    }

    /**
     * @param bool $flag
     * @return self
     */
    public function setMinifyScript($flag)
    {
        $this->minifyScript = (bool) $flag;
        return $this;
    }

    /**
     * @return bool
     */
    protected function getMinifyScript()
    {
        return $this->minifyScript;
    }

    /**
     * @param bool $flag
     * @return self
     */
    public function setRenderScriptAsTemplate($flag)
    {
        $this->renderScriptAsTemplate = (bool) $flag;
        return $this;
    }

    /**
     * @return bool
     */
    protected function getRenderScriptAsTemplate()
    {
        return $this->renderScriptAsTemplate;
    }

    /**
     * @param string $namespace
     * @return self
     */
    public function setNamespace($namespace)
    {
        $this->namespace = (string) $namespace;
        return $this;
    }

    /**
     * @return string
     */
    protected function getNamespace()
    {
        return $this->namespace ?: __NAMESPACE__;
    }

    /**
     * Minify JavaScript code, removes whitespaces
     *
     * @param $script
     * @return array
     */
    public function minifyScript($script)
    {
        return JsMin::minify($script);
    }

    /**
     * @param string $name
     * @return string
     */
    private function normalizeMethodName($name)
    {
        return lcfirst($this->getMethodNameFilter()->filter($name));
    }

    /**
     * @return FilterInterface
     */
    private function getMethodNameFilter()
    {
        if (null === $this->methodNameFilter) {
            $this->methodNameFilter = new FilterChain([
                'filters' => [
                    ['name' => 'WordUnderscoreToCamelCase'],
                    ['name' => 'WordDashToCamelCase'],
                    ['name' => 'WordSeparatorToCamelCase'],
                ],
            ]);
        }

        return $this->methodNameFilter;
    }
}
