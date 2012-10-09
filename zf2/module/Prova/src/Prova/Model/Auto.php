<?php
namespace Prova\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

//use Zend\Crypt\PublicKey\Rsa\PublicKey;

class Auto 
{
	protected $inputFilter;
	protected $_data = array(
				"Marca" => "",
				"Modello" => "",
				"Colore" => "",
				"Prezzo" => 0,
				"Anno" => 0
			);
	
	public function __construct(){
	}
	public function setData($params = array()){
		$this->_data = array_merge($this->_data, $params);
	}
	public function exchangeArray(){}
	
	public function getArray(){
		return $this->_data;
	}
	public function getInputFilterInserisci(){
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory     = new InputFactory();
	
			$inputFilter->add($factory->createInput(array(
					'name'     => 'Marca',
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
											'max'      => 25,
									),
							),
					),
			)));
	
			$inputFilter->add($factory->createInput(array(
					'name'     => 'Modello',
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
											'max'      => 40,
									),
							),
					),
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'Colore',
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
					'name'     => 'Prezzo',
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
											'max'      => 10,
									),
							),
					),
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'Anno',
					'required' => true
						
			)));
			
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}