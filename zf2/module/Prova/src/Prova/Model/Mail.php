<?php
namespace Prova\Model;

use Zend\Authentication\Storage\Session;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

//use Zend\Crypt\PublicKey\Rsa\PublicKey;

class Mail
{
	public $Id_Mess;
	public $Sender;
	public $Receiver;
	public $Message;
	public $Date;
	public $Hour;
	protected $inputFilter;
	protected $_data = array(
				"Sender" => "",
				"Receiver" => "",
				"Message" => "",
				"Date" => 0,
				"Hour" => 0
			);
	
	public function __construct(){
	}
	public function exchangeArray($data){
		$this->Id_Mess     = (isset($data['Id_Mess'])) ? $data['Id_Mess'] : null;
		$this->Sender = (isset($data['Sender'])) ? $data['Sender'] : null;
		$this->Receiver = (isset($data['Receiver'])) ? $data['Receiver'] : null;
		$this->Message   = (isset($data['Message'])) ? $data['Message'] : null;
		$this->Date   = (isset($data['Date'])) ? $data['Date'] : null;
		$this->Hour = (isset($data['Hour'])) ? $data['Hour'] : null;
	
	}
	public function setData($params = array()){
		$session = new Session();
		$this->_data["Sender"] = $session->read()->Id_User;
		$this->_data = array_merge($this->_data, $params);
		$this->_data["Date"] = date("Y-m-d");
		$this->_data["Hour"] = date("H:m:s");
	}
	
	
	public function getArray(){
		return $this->_data;
	}
	//Da implementare inputfilter!
	public function getInputFilterInserisci(){
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory     = new InputFactory();
	
			$inputFilter->add($factory->createInput(array(
					'name'     => 'Receiver',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 50,
									),
							),
					),
			)));
	
			$inputFilter->add($factory->createInput(array(
					'name'     => 'Message',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1
									),
							),
					),
			)));
			
			
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
	public function getInputFilterRispondi(){
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory     = new InputFactory();
			
			$inputFilter->add($factory->createInput(array(
					'name'     => 'Message',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1
									),
							),
					),
			)));
				
				
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}