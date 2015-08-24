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

interface JQueryUiOptionsInterface
{
    /**
     * @param bool $flag
     * @return self
     */
    public function setUseUi($flag = true);

    /**
     * @return bool
     */
    public function getUseUi();

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
     * @param bool $flag
     * @return self
     */
    public function setUseUiCdn($flag = true);

    /**
     * {@inheritDoc}
     */
    public function getUseUiCdn();

    /**
     * @param array $files
     * @return self
     */
    public function setUiFiles($files);

    /**
     * @return array
     */
    public function getUiFiles();

    /**
     * @param array $files
     * @return self
     */
    public function setUiCdnFiles($files);

    /**
     * @return array
     */
    public function getUiCdnFiles();

    /**
     * @param array $files
     * @return self
     */
    public function setUiCssFiles($files);

    /**
     * @return array
     */
    public function getUiCssFiles();

    /**
     * @param array $files
     * @return self
     */
    public function setUiCssCdnFiles($files);

    /**
     * @return array
     */
    public function getUiCssCdnFiles();
}
