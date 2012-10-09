<?php
namespace Prova\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

//use Zend\Crypt\PublicKey\Rsa\PublicKey;

class User 
{
	public $Id_User;
	public $Mail;
	public $Nome;
	public $Cognome;
	public $Tipo_Patente;
	public $Sesso;
	protected $inputFilter;
	//protected $userTable;
	protected $_data = array(
				'Id_User' => 0,
				"Mail" => "",
				"Psw" => "",
				"Nome" => "",
				"Cognome" => "",
				"Tipo_Patente" => "",
				"Sesso" => ""
			);
	
	public function __construct(){

	}
	public function exchangeArray($data){
		$this->Id_User     = (isset($data['Id_User'])) ? $data['Id_User'] : null;
		$this->Mail = (isset($data['Mail'])) ? $data['Mail'] : null;
		$this->Nome  = (isset($data['Nome'])) ? $data['Nome'] : null;
		$this->Cognome  = (isset($data['Cognome'])) ? $data['Cognome'] : null;
		$this->Tipo_Patente = (isset($data['Tipo_Patente'])) ? $data['Tipo_Patente'] : null;
		$this->Sesso = (isset($data['Sesso'])) ? $data['Sesso'] : null;
	
	}
	public function setData($params = array()){
		$params["Psw"] = sha1($params["Psw"]);
		$this->_data = array_merge($this->_data, $params);
	}
	public function getArray(){
		return $this->_data;
	}
	/*public function getUserById($id){
		return $this->getUserTable()->fetchUser($id);
	}*/
	public function getFullName(){
		return $this->_data["Nome"] . " " . $this->_data["Cognome"];
	}
	public function getInputFilter(){
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory     = new InputFactory();
	
			$inputFilter->add($factory->createInput(array(
					'name'     => 'Nome',
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
											'max'      => 100,
									),
							),
					),
			)));
	
			$inputFilter->add($factory->createInput(array(
					'name'     => 'Cognome',
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
											'max'      => 100,
									),
							),
					),
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'Mail',
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
											'min'      => 2,
											'max'      => 40,
									),
							),
					),
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'Psw',
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
											'min'      => 3,
											'max'      => 40,
									),
							),
					),
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'Tipo_Patente',
					'required' => true
					
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'Sesso',
					'required' => true
					
			)));
			$this->inputFilter = $inputFilter;
		}
	
		return $this->inputFilter;
	}
	public function getInputFilterLogIn(){
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory     = new InputFactory();
	
			$inputFilter->add($factory->createInput(array(
					'name'     => 'Mail',
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
											'min'      => 2,
											'max'      => 40,
									),
							),
					),
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'Psw',
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
											'min'      => 3,
											'max'      => 40,
									),
							),
					),
			)));
			$this->inputFilter = $inputFilter;
		}
	
		return $this->inputFilter;
	}
	/*public function getUserTable()
	{
		if (!$this->userTable) {
			$sm = $this->getServiceLocator();
			$this->userTable = $sm->get('Prova\Model\UserTable');
		}
		return $this->userTable;
	}*/
}