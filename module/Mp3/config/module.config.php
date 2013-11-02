<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'Mp3\Controller\Mp3' => 'Mp3\Controller\Mp3Controller',
			),
		),
// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'mp3' => array(
				'type'
				=> 'segment',
				'options' => array(
					'route'
					=> '/mp3[/][:action][/:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id'
						=> '[0-9]+',
						),
					'defaults' => array(
						'controller' => 'Mp3\Controller\Mp3',
						'action'
						=> 'index',
						),
					),
				),
			),
		),
	'view_manager' => array(
		'template_path_stack' => array(
			'mp3' => __DIR__ . '/../view',
			),
		),
		// Doctrine config
	'doctrine' => array(
		'driver' => array(
			// __NAMESPACE__ . '_driver' => array(
			// 	'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
			// 	'cache' => 'array',
			// 	'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
			// 	),
			// 'orm_default' => array(
			// 	'drivers' => array(
			// 		__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
			// 		)
			// 	)

			'odm_driver' => array(
				'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
				'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Document')
				),
			'odm_default' => array(
				'drivers' => array(
					__NAMESPACE__ . '\Document' => 'odm_driver'
					)
				)  
			)
		),
	// 'Application\Controller\Mp3' => array(
	// 	'parameters' => array(
	// 		'documentManager' => 'mongo_dm'
	// 		)
	// 	),
	);
