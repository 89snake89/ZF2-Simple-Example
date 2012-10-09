<?php
namespace Prova\Controller;

use Prova\Model\Mail;

use Prova\Form\ProvaFormRispondiMail;

use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail as SendmailTransport;
use Prova\Model\User;
use Zend\Db\TableGateway\AbstractTableGateway;

use Zend\View\Model\ViewModel;

use Prova\Form\ProvaFormInviaMail;

use Zend\Mvc\Controller\AbstractActionController;

class MailController extends AbstractActionController
{
	protected $mailTable;
	protected $userTable;
	public function indexAction(){
		
		$receivedMessage = $this->getMailTable()->fetchAllReceived();
		$received = array();
		
		foreach ($receivedMessage as $value){
			$sender = $this->getUserTable()->fetchUser($value->Sender);
			$value->Sender = $sender->getFullName();	
			array_push($received, $value);
		}
		$sentMessage = $this->getMailTable()->fetchAllSent();
		$sent = array();
		
		foreach ($sentMessage as $mex){
			$receiver = $this->getUserTable()->fetchUser($mex->Receiver);
			$mex->Receiver = $receiver->getFullName();
			array_push($sent, $mex);
		}
		return new ViewModel(array('receivedMessage' => $received,
									'sentMessage' => $sent
									));
	}
	public function inviaAction(){
		$form = new ProvaFormInviaMail();
		$user = new User();
		$righe = $this->getUserTable()->fetchAll();
		
		$form->get('Receiver')->setValueOptions($righe);
		$request = $this->getRequest();
		if($request->isPost()){
			//Creazione new mail e inserimento nel DB
			$mail = new \Prova\Model\Mail();
			$form->setInputFilter($mail->getInputFilterInserisci());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$params = $form->getData();
				$mail->setData($params);
				$this->getMailTable()->saveMail($mail->getArray());
				$message = new Message();
				$transport = new SendmailTransport();
				
				$message->addTo($this->getUserTable()->fetchUser($params['Receiver'])->getArray()["Mail"]);
				$message->setBody($params["Message"]);
				$transport->send($message);
			}
		}
		return new ViewModel(array('form' => $form));
	}
	public function rispondiAction(){
		$id = (int) $this->params()->fromRoute('id', 0);
		$form = new ProvaFormRispondiMail();
		$mail = $this->getMailTable()->fetchMailById($id);
		$form->setInputFilter($mail->getInputFilterRispondi());
		$request = $this->getRequest();
		if($request->isPost())
		{
			$form->setData($request->getPost());
			if ($form->isValid()) 
			{
				$params = $form->getData();
				$params['Receiver'] = $mail->getArray()['Sender'];
					
				$mex = new Mail();
				$mex->setData($params);
				$this->getMailTable()->saveMail($mex->getArray());
					
				$message = new Message();
				$transport = new SendmailTransport();
				$message->addTo($this->getUserTable()->fetchUser($params['Receiver'])->getArray()["Mail"]);
				$message->setBody($params["Message"]);
				$transport->send($message);
			}
		}
		
		return new ViewModel(array('form' => $form));
	}
	public function leggiAction(){
		$id = (int) $this->params()->fromRoute('id', 0);
		$mail = $this->getMailTable()->fetchMailById($id);
		$mittente = $this->getUserTable()->fetchUser($mail->getArray()['Sender'])->getFullName();
		$mittente .= " " . $this->getUserTable()->fetchUser($mail->getArray()['Sender'])->getArray()['Mail'];
		$ricevente = $this->getUserTable()->fetchUser($mail->getArray()['Receiver'])->getFullName();
		$ricevente .= " " . $this->getUserTable()->fetchUser($mail->getArray()['Receiver'])->getArray()['Mail'];
		
		return new ViewModel(array(
									'mittente' => $mittente,
									'ricevente' => $ricevente,
									'mail' => $mail
								));
		 
	}
	public function getMailTable()
	{
		if (!$this->mailTable) {
			$sm = $this->getServiceLocator();
			$this->mailTable = $sm->get('Prova\Model\MailTable');
	}
		return $this->mailTable;
	}
	public function getUserTable()
	{
		if (!$this->userTable) {
			$sm = $this->getServiceLocator();
			$this->userTable = $sm->get('Prova\Model\UserTable');
		}
		return $this->userTable;
	}
}