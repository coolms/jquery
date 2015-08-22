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

/**
 * Property class to handle work with jQuery object property
 */
class ObjectProperty extends AbstractObject
{
    /**
     * Base object for property
     *
     * @var AbstractObject
     */
    private $owner;

    /**
     * Set up base Property options
     *
     * @param AbstractObject $owner
     * @param array $options
     */
    public function __construct($owner, array $options = [])
    {
        $this->setOwner($owner);
        $this->setOptions($options);
    }

    /**
     * Get owner property
     *
     * @return AbstractObject
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set owner property
     *
     * @param AbstractObject $owner owner to set
     * @return self
     */
    public function setOwner(AbstractObject $owner)
    {
        $this->owner = $owner;
        return $this;
    }
}
