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

interface ModuleOptionsInterface
{
    /**
     * @param bool $flag
     * @return self
     */
    public function setEnabled($flag = true);

    /**
     * @return bool
     */
    public function getEnabled();

    /**
     * @param string $version
     * @return self
     */
    public function setVersion($version);

    /**
     * @return string
     */
    public function getVersion();

    /**
     * @param bool $flag
     * @return self
     */
    public function setUseCdn($flag);

    /**
     * @return bool
     */
    public function getUseCdn();

    /**
     * @param string $path
     * @return self
     */
    public function setPath($path);

    /**
     * @return string
     */
    public function getPath();

    /**
     * @param string $url
     * @return self
     */
    public function setCdnUrl($url);

    /**
     * @return string
     */
    public function getCdnUrl();

    /**
     * @param array|string $plugins
     */
    public function setPlugins($plugins);

    /**
     * @return array
     */
    public function getPlugins();

    /**
     * @param bool $flag
     * @return self
     */
    public function setUseUI($flag = true);

    /**
     * @return bool
     */
    public function getUseUI();

    /**
     * @param string $version
     * @return self
     */
    public function setUiVersion($version);

    /**
     * @return string
     */
    public function getUiVersion();

    /**
     * @param string $theme
     * @return self
     */
    public function setUiTheme($theme);

    /**
     * @return string
     */
    public function getUiTheme();

    /**
     * @param string $path
     * @return self
     */
    public function setUiPath($path);

    /**
     * @return string
     */
    public function getUiPath();

    /**
     * @param string $url
     * @return self
     */
    public function setUiCdnUrl($url);

    /**
     * @return string
     */
    public function getUiCdnUrl();

    /**
     * @param array|string $path
     * @return self
     */
    public function setUiCssPath($path);

    /**
     * @return array
     */
    public function getUiCssPath();

    /**
     * @param array|string $url
     * @return self
     */
    public function setUiCssCdnUrl($url);

    /**
     * @return array
     */
    public function getUiCssCdnUrl();

    /**
     * @param array|string $plugins
     */
    public function setUiPlugins($plugins);

    /**
     * @return array
     */
    public function getUiPlugins();
}
