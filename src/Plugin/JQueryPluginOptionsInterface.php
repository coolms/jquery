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

interface JQueryPluginOptionsInterface
{
    /**
     * @param string $name
     * @return self
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $element
     * @return self
     */
    public function setElement($element);

    /**
     * @return string
     */
    public function getElement();

    /**
     * @param array $files
     * @return self
     */
    public function setDefaults($defaults);

    /**
     * @return array
     */
    public function getDefaults();

    /**
     * @param bool $flag
     * @return self
     */
    public function setOnload($flag);

    /**
     * @return bool
     */
    public function getOnload();

    /**
     * @param array $files
     * @return self
     */
    public function setFiles($files);

    /**
     * @return array
     */
    public function getFiles();

    /**
     * @param array $files
     * @return self
     */
    public function setCssFiles($files);

    /**
     * @return array
     */
    public function getCssFiles();
}
