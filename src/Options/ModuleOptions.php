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

class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface
{
    /**
     * Turn off strict options mode
     *
     * @var bool
     */
    protected $__strictMode__ = false;

    /**
     * @var bool
     */
    protected $enabled = true;

    /**
     * @var string
     */
    protected $version = '1.11.3';

    /**
     * @var int
     */
    protected $useCdn = false;

    /**
     * @var string
     */
    protected $path = 'assets/cms-jquery/jquery.min.js';

    /**
     * @var string
     */
    protected $cdnUrl = '//ajax.googleapis.com/ajax/libs/jquery/%s/jquery.min.js';

    /**
     * @var string
     */
    protected $plugins = [];

    /**
     * @var bool
     */
    protected $useUI = true;

    /**
     * @var string
     */
    protected $uiVersion = '1.11.4';

    /**
     * @var string
     */
    protected $uiTheme = 'smoothness';

    /**
     * @var string
     */
    protected $uiPath = 'assets/cms-jquery/ui/jquery-ui.min.js';

    /**
     * @var string
     */
    protected $uiCdnUrl = '//ajax.googleapis.com/ajax/libs/jqueryui/%s/jquery-ui.min.js';

    /**
     * @var array
     */
    protected $uiCssPath = [
        'assets/cms-jquery/ui/jquery-ui.min.css',
        'assets/cms-jquery/ui/jquery-ui.theme.min.css'
    ];

    /**
     * @var array
     */
    protected $uiCssCdnUrl = [
        '//ajax.googleapis.com/ajax/libs/jqueryui/%s/themes/%s/jquery-ui.css'
    ];

    /**
     * @var unknown
     */
    protected $uiPlugins = [];

    /**
     * {@inheritDoc}
     */
    public function setEnabled($flag = true)
    {
        $this->enabled = (bool) $flag;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * {@inheritDoc}
     */
    public function setVersion($version)
    {
        $this->version = (string) $version;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * {@inheritDoc}
     */
    public function setUseCdn($flag)
    {
        $this->useCdn = (bool) $flag;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUseCdn()
    {
        return $this->useCdn;
    }

    /**
     * {@inheritDoc}
     */
    public function setPath($path)
    {
        $this->path = (string) $path;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritDoc}
     */
    public function setCdnUrl($url)
    {
        $this->cdnUrl = (string) $url;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCdnUrl()
    {
        return $this->cdnUrl;
    }

    /**
     * {@inheritDoc}
     */
    public function setPlugins($plugins)
    {
        $this->plugins = (array) $plugins;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * {@inheritDoc}
     */
    public function setUseUI($flag = true)
    {
        $this->useUI = (bool) $flag;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUseUI()
    {
        return $this->useUI;
    }

    /**
     * {@inheritDoc}
     */
    public function setUiVersion($version)
    {
        $this->uiVersion = (string) $version;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUiVersion()
    {
        return $this->uiVersion;
    }

    /**
     * {@inheritDoc}
     */
    public function setUiTheme($theme)
    {
        $this->uiTheme = $theme;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUiTheme()
    {
        return $this->uiTheme;
    }

    /**
     * {@inheritDoc}
     */
    public function setUiPath($path)
    {
        $this->uiPath = (string) $path;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUiPath()
    {
        return $this->uiPath;
    }

    /**
     * {@inheritDoc}
     */
    public function setUiCdnUrl($url)
    {
        $this->uiCdnUrl = (string) $url;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUiCdnUrl()
    {
        return $this->uiCdnUrl;
    }

    /**
     * {@inheritDoc}
     */
    public function setUiCssPath($path)
    {
        $this->uiCssPath = (array) $path;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUiCssPath()
    {
        return $this->uiCssPath;
    }

    /**
     * {@inheritDoc}
     */
    public function setUiCssCdnUrl($url)
    {
        $this->uiCssCdnUrl = (array) $url;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUiCssCdnUrl()
    {
        return $this->uiCssCdnUrl;
    }

    /**
     * {@inheritDoc}
     */
    public function setUiPlugins($plugins)
    {
        $this->uiPlugins = (array) $plugins;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUiPlugins()
    {
        return $this->uiPlugins;
    }
}
