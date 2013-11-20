<?php
namespace Audio;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
         'Zend\Loader\ClassMapAutoloader' => array(
            // File containing class map key/value pairs
            __DIR__ . '/../../library/autoloader_classmap.php',
            // Or provide an array with the class map instead...
            array( 
                'Application\Bootstrap' => __DIR__ . '/application/Bootstrap.php',
                'CL_Res_Chain_Mutable'  => __DIR__ . '/library/pathhere/Mutable.php',
                ),
            ),
         'Zend\Loader\StandardAutoloader' => array(
            'namespaces' => array(
                __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
         );
    }
}
