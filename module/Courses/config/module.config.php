<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Courses\Controller\Courses' => 'Courses\Controller\CoursesController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'courses' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/courses[/:action][/:course_id]',
                    //'route'    => '/users[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'course_id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Courses\Controller\Courses',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'courses' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);