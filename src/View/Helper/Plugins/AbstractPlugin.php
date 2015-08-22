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

use Zend\Json\Json,
    Zend\Stdlib\InitializableInterface,
    Zend\View\Helper\AbstractHelper,
    JSMin\JSMin;

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
    protected $subPath = 'plugins/';

    /**
     * @var bool
     */
    protected $appendScript = true;

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
    protected $templateScriptAttribs = [
        'class' => 'jquery-script',
    ];

    /**
     * @var array
     */
    protected $defaultJsonEncodeOptions = [
        'enableJsonExprFinder' => true,
        'prettyPrint' => true,
    ];

    /**
     * {@inheritDoc}
     */
    public function init() {}

    /**
     * @param mixed $content
     * @param bool  $appendScript
     * @param bool  $renderScriptAsTemplate
     * @return array|string|self
     */
    public function __invoke($content = null, $appendScript = null, $renderScriptAsTemplate = null)
    {
        if (0 === func_num_args()) {
            return $this;
        }

        if (null !== $appendScript) {
            $this->setAppendScript($appendScript);
        }

        if (null !== $renderScriptAsTemplate) {
            $this->setRenderScriptAsTemplate($renderScriptAsTemplate);
        }

        return call_user_func_array([$this, 'render'], func_get_args());
    }

    /**
     * @param mixed $content
     * @param bool  $appendScript
     * @param bool  $renderScriptAsTemplate
     * @return array|string|self
     */
    public function render($content, $appendScript = null, $renderScriptAsTemplate = null)
    {
        if (method_exists($this, 'renderContent')) {
            $funcArgs = [];
            if (func_num_args() > 3) {
                $funcArgs = array_slice(func_get_args(), 3);
            }

            array_unshift($funcArgs, $content);
            $content = call_user_func_array([$this, 'renderContent'], $funcArgs);
        }

        if (!is_array($content)) {
            return (string) $content;
        }

        $html           = '';
        $headScript     = '';
        $inlineScript   = '';
        $contentId      = null;

        switch (count($content)) {
            case 1:
                list($html) = $content;
                break;
            case 2:
                list($html, $headScript) = $content;
                break;
            case 3:
                list($html, $headScript, $inlineScript) = $content;
                break;
            case 4:
                list($html, $headScript, $inlineScript, $contentId) = $content;
                break;
            default:
                return '';
        }

        if (null === $appendScript) {
            $appendScript = $this->getAppendScript();
        }

        if (null === $renderScriptAsTemplate) {
            $appendScript = $this->getAppendScript();
        }

        if ($this->getMinifyScript()) {
            if ($headScript) {
                $headScript = $this->minifyScript($headScript);
            }

            if ($inlineScript) {
                $inlineScript = $this->minifyScript($inlineScript);
            }
        }

        if ($appendScript) {
            if ($headScript) {
                $this->headScript()->appendScript($headScript);
            }

            if ($inlineScript) {
                $inlineScript = <<<EOJ
;jQuery(function(){ {$inlineScript} });
EOJ;
                if ($this->getRenderScriptAsTemplate()) {
                    $attribs = $this->templateScriptAttribs;
                    if ($contentId) {
                        $attribs['id'] = $contentId . '_script';
                    }

                    if (!isset($attribs['noescape'])) {
                        $attribs['noescape'] = true;
                    }

                    $this->inlineScript()->setAllowArbitraryAttributes(true)
                        ->appendScript($inlineScript, $this->templateType, $attribs);
                } else {
                    $this->inlineScript()->appendScript($inlineScript);
                }
            }

            return $html;
        } else {
            return compact('html', 'headScript', 'inlineScript', 'templateId');
        }
    }

    /**
     * @param array|string $path
     * @return string
     */
    protected function basePath($path = null)
    {
        if (is_string($path)) {
            /* @var $assetPath \CmsCommon\View\Helper\AssetPath */
            $assetPath = $this->getView()->plugin('assetPath');
            return $assetPath($this->getSubPath() . ltrim((string) $path, '/\\'), $this->getNamespace());
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
     * {@inheritDoc}
     */
    protected function jQuery()
    {
        return $this->getView()->plugin('jQuery');
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
    public function setSubPath($path)
    {
        $this->subPath = $path;
        return $this;
    }

    /**
     * @return string
     */
    protected function getSubPath()
    {
        return $this->subPath;
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
     * @return string
     */
    protected function getNamespace()
    {
        return __NAMESPACE__;
    }

    /**
     * Minify JavaScript code, removes whitespaces
     *
     * @param $script
     * @return array
     */
    protected function minifyScript($script)
    {
        return JsMin::minify($script);
    }
}
