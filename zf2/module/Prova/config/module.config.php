<?php 
return array(
		'controllers' => array(
				'invokables' => array(
						'Prova\Controller\Prova' => 'Prova\Controller\ProvaController',
						'Prova\Controller\Auto' => 'Prova\Controller\AutoController',
						'Prova\Controller\Mail' => 'Prova\Controller\MailController',
				),
		),
		// The following section is new and should be added to your file
		// Router
		'router' => array(
				'routes' => array(
						'prova' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/prova[/:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Prova\Controller\Prova',
												'action'     => 'index',
										),
								),
						),
						'auto' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/auto[/:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Prova\Controller\Auto',
												'action'     => 'index',
										),
								),
						),
						'mail' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/mail[/:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Prova\Controller\Mail',
												'action'     => 'index',
										),
								),
						),
				),
		),
		'view_manager' => array(
				'template_path_stack' => array(
						'prova' => __DIR__ . '/../view',
						'auto' => __DIR__ . '/../view',
				),
				
		),
);

