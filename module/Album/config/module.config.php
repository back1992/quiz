<?php
namespace Album;
return array(
	'controllers' => array(
		'invokables' => array(
			'Album\Controller\Album' => 'Album\Controller\AlbumController',
			),
		),
// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'album' => array(
				'type'
				=> 'segment',
				'options' => array(
					'route'
					=> '/album[/][:action][/:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id'
						=> '[a-zA-Z0-9_-]+',
						),
					'defaults' => array(
						'controller' => 'Album\Controller\Album',
						'action'
						=> 'index',
						),
					),
				),
			),
		),
	'view_manager' => array(
		'template_path_stack' => array(
			'album' => __DIR__ . '/../view',
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

// < ?php    
    
// namespace Album;    
    
// return array(    
//     'controllers' => array(    
//         'invokables' => array(    
//             'album' => 'Album\Controller\AlbumController'    
//         ),  
//         // This was added  
//         'initializers' => array(  
//             function($instance, ServiceLocatorInterface $sl) {  
//                 if($instance instanceof DocumentManagerAwareInterface) {  
//                     $instance->setDocumentManager(  
//                         $sl->getServiceLocator()->get('doctrine.documentmanager.odm_default')  
//                     );  
//                 }  
//             }  
//         )  
//     ),    
    
//     'router' => array(    
//         'routes' => array(    
//             'ablum' => array(    
//                 'type'      => 'segment',    
//                 'options'   => array(    
//                     'route'         => '/album[/:action][/:id]',    
//                     'constraints'   => array(    
//                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',    
//                         'id'     => '[0-9]+'    
//                     ),    
//                     'defaults'      => array(    
//                         'controller' => 'album',    
//                         'action'     => 'index'    
//                     )    
//                 )    
//             )    
//         )    
//     ),    
        
//     // This was added    
//     'doctrine' => array(    
//         'driver' => array(    
//             __NAMESPACE__ . '_driver' => array(    
//                 'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',    
//                 'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Document')    
//             ),    
//             'odm_default' => array(    
//                 'drivers' => array(    
//                     __NAMESPACE__ . '\Document' => __NAMESPACE__ . '_driver'    
//                 )    
//             )    
//         )    
//     ),    
        
//     'view_manager' => array(    
//         'template_path_stack' => array(    
//             'album' => __DIR__ . '/../view'    
//         )    
//     )    
);



