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

trait JQueryOptionsTrait
{
    /**
     * @var string
     */
    protected $name = 'jQuery';

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
    protected $files = [
        'assets/cms-jquery/jquery.min.js'
    ];

    /**
     * @var string
     */
    protected $cdnFiles = [
        '//ajax.googleapis.com/ajax/libs/jquery/%s/jquery.min.js'
    ];

    /**
     * @var string
     */
    protected $plugins = [];

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {
        $this->name = (string) $name;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

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
    public function setFiles($files)
    {
        $this->files = (string) $files;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * {@inheritDoc}
     */
    public function setCdnFiles($files)
    {
        $this->cdnFiles = (array) $files;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCdnFiles()
    {
        return $this->cdnFiles;
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
}
