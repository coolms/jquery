<?php
/**
 * CoolMS2 Jquery module (http://www.coolms.com/)
 * 
 * @link      http://github.com/coolms/CmsJquery for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsJquery;

return [
    'asset_manager' => [
        'resolver_configs' => [
            'paths' => [
                __DIR__ . '/../public',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'CmsJquery\Controller\Admin' => 'CmsJquery\Controller\AdminController',
        ],
    ],
    'router' => [
        'routes' => [
            'cms-admin' => [
                'child_routes' => [
                    'jquery' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/jquery[/:controller[/:action[/:id]]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z\-]*',
                                'action' => '[a-zA-Z\-]*',
                                'id' => '[a-zA-Z0-9\-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'CmsJquery\Controller',
                                'controller' => 'Admin',
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'layout/jquery' => __DIR__ . '/../view/layout/jquery.phtml',
            'jquery' => __DIR__ . '/../view/layout/jquery.phtml',
        ],
        'template_path_stack' => [
            __NAMESPACE__ => __DIR__ . '/../view',
        ],
    ],
];
