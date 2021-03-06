<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Users\Controller\Users' => 'Users\Controller\UsersController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'users' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/users[/:action][/:user_id]',
                    //'route'    => '/users[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'admin_id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Users',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'users' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);