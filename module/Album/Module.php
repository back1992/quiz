<?php
namespace Album;
// Add these import statements:
use Album\Model\Album;
use Album\Model\AlbumTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use PhlyMongo\MongoCollectionFactory;
use PhlyMongo\MongoDbFactory;

class Module
{
	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\ClassMapAutoloader' => array(
				__DIR__ . '/autoload_classmap.php',
				),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
					),
				),
			);
	}
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
// getAutoloaderConfig() and getConfig() methods here
	public function getServiceConfig()
	{
		return array(
			'factories' => array(
				'Album\Model\AlbumTable' => function($sm) {
					$tableGateway = $sm->get('AlbumTableGateway');
					$table = new AlbumTable($tableGateway);
					return $table;
				},
				'AlbumTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Album());
					return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
				},	
				),
			);
	}

	// public function getServiceConfig()
	// {
	// 	return array('factories' => array(
	// 		'Album\Mongo'           => 'PhlyMongo\MongoConnectionFactory',
	// 		'Album\MongoDB'         => new MongoDbFactory('Album-site', 'Album\Mongo'),
	// 		'Album\MongoCollection' => new MongoCollectionFactory('some-stuff', 'Album\MongoDB'),
	// 		));
	// }
}
