<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Audio\Controller\Audio' => 'Audio\Controller\AudioController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'audio' => array(
                'type'
                => 'segment',
                'options' => array(
                    'route'
                    => '/audio[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'
                        => '[a-zA-Z0-9_-]+',
                        ),
                    'defaults' => array(
                        'controller' => 'Audio\Controller\Audio',
                        'action'
                        => 'index',
                        ),
                    ),
                ),
            ),
        ),
    'view_manager' => array(
        'template_path_stack' => array(
            'audio' => __DIR__ . '/../view',
        ),
    ),
);