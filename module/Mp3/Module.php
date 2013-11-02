<?php
namespace Mp3;
// Add these import statements:
use Mp3\Model\Mp3;
use Mp3\Model\Mp3Table;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

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
// Add this method:
	public function getServiceConfig()
	{
		return array(
			'factories' => array(
				'Mp3\Model\Mp3Table' => function($sm) {
					$tableGateway = $sm->get('Mp3TableGateway');
					$table = new Mp3Table($tableGateway);
					return $table;
				},
				'Mp3TableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Mp3());
					return new TableGateway('mp3', $dbAdapter, null, $resultSetPrototype);
				},
				));
	}
}
