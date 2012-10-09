<?php

// module/Album/src/Album/Controller/AlbumController.php:
namespace Prova\Controller;



use Zend\Cache\Storage\Event;

use Prova\Event\EventLogged;

use Prova\Model\MyAuthenticationAdapter;

use Prova\Model\UserTable;

use Prova\Model\User;
use Prova\Model\MyStorage;

use Prova\Form\ProvaFormLogIn;
//use Zend\Mvc\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication;
use Prova\Form\ProvaFormIscriviti, 
	Zend\Authentication\Result,
	Zend\Authentication\AuthenticationService;

class ProvaController extends AbstractActionController
{
	protected $userTable;
	public function indexAction()
	{
		return new ViewModel(array('fabio' => "Ciao a tutti da Fabio!"));
	}
	public function iscrivitiAction(){
		$form = new ProvaFormIscriviti();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$use = new User();
			$form->setInputFilter($use->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$params = $form->getData();
				$use->setData($params);
				$this->getUserTable()->saveUser($use->getArray());
			}
		}
		return new ViewModel(array(
				'fabio' => "Ciao a tutti da Fabio!",
				'form' => $form
		));
	}
	
	public function loginAction(){
		// instantiate the authentication service
		$auth = new AuthenticationService();
	
		$form = new ProvaFormLogIn();
		$use = new User();
		$request = $this->getRequest();
		if($request->isPost()){
			$form->setInputFilter($use->getInputFilterLogIn());
			$form->setData($request->getPost());
			if($form->isValid()){
				$formData = $form->getData();

				//Verifica delle credenziali dell'utente
				$authAdapter = new MyAuthenticationAdapter(
					$formData["Mail"], 
					$formData["Psw"]
				);
				$authAdapter->setDbAdapter(
						$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
				// Attempt authentication, saving the result
				$result = $auth->authenticate($authAdapter);
				if (!$result->isValid()) {
					// Authentication failed; print the reasons why
					foreach ($result->getMessages() as $message) {
						echo "$message\n";
					}
				} else {
					$auth->getStorage()->write($authAdapter->getResultRowObject(null, array('Psw', 'Tipo_Patente')));
					$even = new EventLogged();
					//return $this->forward()->dispatch('Prova\Controller\Auto',array('action' => 'index'));
					$even->getEventManager()->attach('userLogged', function(){
						return $this->redirect()->toRoute('auto');
					});
					$even->userLogged();
					
				}
			}
		}
		if ($auth->hasIdentity()) {
	
		    $identity = $auth->getIdentity();
		}
				
		return new ViewModel(array('form' => $form));
	}
	
	public function getUserTable()
	{
		if (!$this->userTable) {
			$sm = $this->getServiceLocator();
			$this->userTable = $sm->get('Prova\Model\UserTable');
		}
		return $this->userTable;
	}
	
	public function logoutAction() 
	{
		$auth = new AuthenticationService();
		$auth->clearIdentity();
		return $this->forward()->dispatch('Prova\Controller\Prova',array('action' => 'index'));
	}

}