<?php
/**
 * CoolMS2 jQuery Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/jquery for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsJquery\Stdlib;

use RuntimeException,
    Zend\Json\Json,
    Zend\Stdlib\JsonSerializable;

/**
 * Base class for implementing functionality to work with all jQuery objects
 */
abstract class AbstractObject implements JsonSerializable
{
    /**
     * An array of options
     *
     * @var array
     */
    private $options = [];

    /**
     * Override set to allow access to all possible options
     *
     * @param string $name  option name
     * @param mixed  $value option value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * Override get to allow access to all possible options
     *
     * @param string $name option name
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->options[$name])) {
            return $this->options[$name];
        }
    }

    /**
     * Get array of all options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set all options at once
     *
     * @param array $options  of all options
     * @return self
     */
    public function setOptions(array $options = [])
    {
        foreach ($options as $name => $value) {
            $this->setOption($name, $value);
        }

        return $this;
    }

    /**
     * Merge existing options with array of new options
     *
     * @param array $options array of all options
     * @return self
     */
    public function mergeOptions(array $options = [])
    {
        $this->options = array_replace_recursive($this->getOptions(), $options);
        return $this;
    }

    /**
     * Get single option
     *
     * @param string $name name of option
     * @return mixed
     */
    public function getOption($name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method) && $method !== __FUNCTION__) {
            return $this->$method();
        } elseif (isset($this->options[$name])) {
            return $this->options[$name];
        }
    }

    /**
     * Set single option
     *
     * @param string $name  name of option
     * @param mixed  $value value of option
     * @return self
     */
    public function setOption($name, $value)
    {
        $method = 'set' . ucfirst($name);
        if (method_exists($this, $method) && $method !== __FUNCTION__) {
            return $this->$method($value);
        }

        $this->options[$name] = $value;
        return $this;
    }

    /**
     * Magic method to work with all object options
     * without necessity to create tons of methods.
     * Provide overloading features.
     *
     * @param $name
     * @param $arguments
     * @return mixed|self
     * @throws RuntimeException
     */
    public function __call($name, $arguments)
    {
        // overload nonexistant set... methods to set particular object option
        if (substr($name, 0, 3) === 'set' && is_array($arguments) && count($arguments) === 1) {
            $value = $arguments[0];
            // overload nonexistant set...IfNotSet methods to set particular object option
            // only if there is no such an option yet
            if (substr($name, -8) === 'IfNotSet') {
                $propertyName = lcfirst(substr($name, 3, strlen($name) - 11));
                if (!$this->getOption($propertyName)) {
                    $this->setOption($propertyName, $value);
                }
            } else {
                $propertyName = lcfirst(substr($name, 3));
                $this->setOption($propertyName, $value);
            }

            return $this;
        }

        // overload nonexistant get... methods to get particular object option
        if (substr($name, 0, 3) === 'get') {
            return $this->getOption(lcfirst(substr($name, 3)));
        }

        // overload nonexistant merge... methods to merge option arrays
        if (substr($name, 0, 5) === 'merge' && is_array($arguments) && count($arguments) === 1) {

            $getter  = 'get' . ucfirst(substr($name, 5));

            $oldParameters = $this->$getter();
            if (is_object($oldParameters)) {
                if ($oldParameters instanceof $this) {
                    return $oldParameters->mergeOptions($arguments[0]);
                }

                if (method_exists($oldParameters, 'toArray')) {
                    $oldParameters = $oldParameters->toArray();
                }
            }

            if (!is_array($oldParameters)) {
                $oldParameters = [];
            }

            $setter  = 'set' . ucfirst(substr($name, 5));
            return $this->$setter(array_replace_recursive($oldParameters, $arguments[0]));
        }

        // throw an exception if method name doesn't match any known pattern
        if (!method_exists($this, $name)) {
            throw new RuntimeException(sprintf(
                'The required method "%s" does not exist for %s',
                $name, get_class($this)
            ));
        }
    }

    /**
     * Utility method to get all object properties as an array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getOptions();
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray() ?: new \stdClass();
    }
}
