<?php

namespace Prova;

// Add this import statement:
use Prova\Model\UserTable;
use Prova\Model\AutoTable;
use Prova\Model\MailTable;
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
	
	// Add this method:
	public function getServiceConfig()
	{
		return array(
				'factories' => array(
						'Prova\Model\UserTable' =>  function($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$table     = new UserTable($dbAdapter);
							return $table;
						},
						'Prova\Model\AutoTable' =>  function($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$table     = new AutoTable($dbAdapter);
							return $table;
						},
						'Prova\Model\MailTable' =>  function($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$table     = new MailTable($dbAdapter);
							return $table;
						},
				),
		);
	}
}