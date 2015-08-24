<?php 
/**
 * CoolMS2 jQuery Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/jquery for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsJquery\Options\Traits;

trait JQueryUiOptionsTrait
{
    /**
     * @var bool
     */
    protected $useUi = true;

    /**
     * @var string
     */
    protected $uiVersion = '1.11.4';

    /**
     * @var string
     */
    protected $uiTheme = 'smoothness';

    /**
     * @var int
     */
    protected $useUiCdn = false;

    /**
     * @var string
     */
    protected $uiFiles = [
        'assets/cms-jquery/ui/jquery-ui.min.js'
    ];

    /**
     * @var string
     */
    protected $uiCdnFiles = [
        '//ajax.googleapis.com/ajax/libs/jqueryui/%s/jquery-ui.min.js'
    ];

    /**
     * @var array
     */
    protected $uiCssFiles = [
        'assets/cms-jquery/ui/jquery-ui.min.css',
        'assets/cms-jquery/ui/jquery-ui.theme.min.css'
    ];

    /**
     * @var array
     */
    protected $uiCssCdnFiles = [
        '//ajax.googleapis.com/ajax/libs/jqueryui/%s/themes/%s/jquery-ui.css'
    ];

    /**
     * {@inheritDoc}
     */
    public function setUseUi($flag = true)
    {
        $this->useUi = (bool) $flag;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUseUi()
    {
        return $this->useUi;
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
    public function setUseUiCdn($flag = true)
    {
        $this->useUiCdn = (bool) $flag;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUseUiCdn()
    {
        return $this->useUiCdn;
    }

    /**
     * {@inheritDoc}
     */
    public function setUiFiles($files)
    {
        $this->uiFiles = (array) $files;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUiFiles()
    {
        return $this->uiFiles;
    }

    /**
     * {@inheritDoc}
     */
    public function setUiCdnFiles($files)
    {
        $this->uiCdnFiles = (array) $files;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUiCdnFiles()
    {
        return $this->uiCdnFiles;
    }

    /**
     * {@inheritDoc}
     */
    public function setUiCssFiles($files)
    {
        $this->uiCssFiles = (array) $files;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUiCssFiles()
    {
        return $this->uiCssFiles;
    }

    /**
     * {@inheritDoc}
     */
    public function setUiCssCdnFiles($files)
    {
        $this->uiCssCdnFiles = (array) $files;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUiCssCdnFiles()
    {
        return $this->uiCssCdnFiles;
    }
}
