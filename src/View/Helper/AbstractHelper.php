<?php 
/**
 * CoolMS2 jQuery Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/jquery for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsJquery\View\Helper;

use Zend\Filter\FilterChain,
    Zend\Filter\FilterInterface,
    Zend\View\Helper\AbstractHelper as AbstractViewHelper;

/**
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
abstract class AbstractHelper extends AbstractViewHelper
{
    /**
     * @var FilterInterface
     */
    private $methodNameFilter;

    /**
     * @param string $name
     * @return string
     */
    protected function normalizeMethodName($name)
    {
        return lcfirst($this->getMethodNameFilter()->filter($name));
    }

    /**
     * @return FilterInterface
     */
    private function getMethodNameFilter()
    {
        if (null === $this->methodNameFilter) {
            $this->methodNameFilter = new FilterChain([
                'filters' => [
                    ['name' => 'WordUnderscoreToCamelCase'],
                    ['name' => 'WordDashToCamelCase'],
                    ['name' => 'WordSeparatorToCamelCase'],
                ],
            ]);
        }

        return $this->methodNameFilter;
    }
}
