<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Dashboard\Controller\Dashboard' => 'Dashboard\Controller\DashboardController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'dashboard' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/dashboard[/:action][/:admin_id]',
                    //'route'    => '/users[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'admin_id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Dashboard\Controller\Dashboard',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'dashboard' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);