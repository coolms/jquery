<?php
/**
 * CoolMS2 jQuery Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/jquery for the canonical source repository
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
    'cmsjquery' => [
        'plugins' => [
            'ui' => ['onload' => true],
            'placeholder' => [
                'files' => 'jquery.placeholder.min.js',
                'element' => 'input,textarea',
                'onload' => true,
            ],
            'cookie' => [
                'files' => 'jquery.cookie.min.js',
                'onload' => true,
            ],
            'nicescroll' => [
                'files' => 'nicescroll/jquery.nicescroll.min.js',
                'onload' => true,
            ],
            'verticalaligncenter' => [
                'files' => 'jquery.verticalaligncenter.js',
                'name' => 'verticalAlignCenter',
                'element' => '.verticalcenter',
                'onload' => true,
            ],
            'maphilight' => [
                'files' => 'jquery.maphilight.min.js',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'CmsJquery\Controller\Admin' => 'CmsJquery\Mvc\Controller\AdminController',
        ],
    ],
    'jquery_plugins' => [
        'abstract_factories' => [
            'CmsJquery\Plugin\JQueryPluginAbstractServiceFactory'
                => 'CmsJquery\Plugin\JQueryPluginAbstractServiceFactory',
        ],
        'aliases' => [
            'ui' => 'CmsJquery\View\Helper\Plugins\Ui',
        ],
        'factories' => [
            'CmsJquery\View\Helper\Plugins\Ui' => 'CmsJquery\Factory\View\Helper\UiHelperFactory',
        ],
        'invokables' => [
            'maphilight' => 'CmsJquery\View\Helper\Plugins\MapHilight',
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
    'service_manager' => [
        'aliases' => [
            'CmsJquery\Options\ModuleOptionsInterface' => 'CmsJquery\Options\ModuleOptions',
            'JQueryPluginManager' => 'CmsJquery\Plugin\JQueryPluginManager',
        ],
        'factories' => [
            'CmsJquery\Options\ModuleOptions' => 'CmsJquery\Factory\ModuleOptionsFactory',
            'CmsJquery\Plugin\JQueryPluginManager' => 'CmsJquery\Factory\JQueryPluginManagerFactory',
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'jQuery' => 'CmsJquery\View\Helper\JQuery',
        ],
        'factories' => [
            'CmsJquery\View\Helper\JQuery' => 'CmsJquery\Factory\View\Helper\JQueryHelperFactory',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __NAMESPACE__ => __DIR__ . '/../view',
        ],
    ],
];
