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

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\MutableCreationOptionsInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Stdlib\AbstractOptions,
    CmsCommon\Stdlib\ArrayUtils;

abstract class AbstractJQueryPluginFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    /**
     * @var array
     */
    protected $creationOptions = [];

    /**
     * @var string
     */
    protected $optionsClass;

    /**
     * @param ServiceLocatorInterface $services
     * @return array
     */
    protected function getCreationOptions(ServiceLocatorInterface $services)
    {
        if ($this->optionsClass && $services->has($this->optionsClass)) {
            $options = $services->get($this->optionsClass);
            if ($options instanceof AbstractOptions) {
                if ($options instanceof JQueryPluginOptionsInterface) {
                    return $options->setFromArray($this->creationOptions)->toArray();
                }

                $options = $options->toArray();
            }

            $options = ArrayUtils::iteratorToArray($options);
            if (is_array($options)) {
                return array_merge($options, $this->creationOptions);
            }
        }

        return $this->creationOptions;
    }

    /**
     * {@inheritDoc}
     */
    public function setCreationOptions(array $options)
    {
        $this->creationOptions = $options;
        return $this;
    }
}
