<?php
namespace Prova\Model;

use Zend\Authentication\Storage\Session;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Prova\Model\Mail;

class MailTable extends AbstractTableGateway
{
	protected $table ='messages';

	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet();
		$this->resultSetPrototype->setArrayObjectPrototype(new Mail());
		$this->initialize();
		
	}
	public function fetchMailById($id){
		$mail = $this->select(array("Id_Mess" => $id));
		$keys = array('Id_Mess', 'Sender', 'Receiver', 'Message', 'Date', 'Hour');
		$values = array();
		foreach ($mail as $mex){
			foreach ($mex as $value){
				array_push($values, $value);
			}
			$params = array_combine($keys, $values);
		}
		$mail = new Mail();
		$mail->setData($params);
		//\Zend\Debug\Debug::dump($mail);
		return $mail;
	}
	public function fetchAllReceived()
	{
		$session = new Session();
		$userLogged = $session->read()->Id_User;
		$resultSet = $this->select(array("Receiver" => $userLogged));
		
		return $resultSet;
	}
	
	public function fetchAllSent()
	{
		$session = new Session();
		$userLogged = $session->read()->Id_User;
		$resultSet = $this->select(array('Sender' => $userLogged));
		return $resultSet;
	}
	
	public function saveMail($mail = array()){
		$this->insert($mail);
	}

}