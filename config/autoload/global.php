<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
     // ...

	'navigation' => array(
		'default' => array(
			array(
				'label' => 'Home',
				'route' => 'home',
				),
			array(
				'label' => 'Album',
				'route' => 'album',
				'pages' => array(
					array(
						'label' => 'Album',
						'route' => 'album',
						),
					),
				),
			array(
				'label' => 'FFMpeg',
				'route' => 'ffmpeg',
				),
			),
		),
	'service_manager' => array(
		'factories' => array(
			'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
			),
		),
	);