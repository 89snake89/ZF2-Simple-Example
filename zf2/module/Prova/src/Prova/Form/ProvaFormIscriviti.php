<?php
namespace Prova\Form;

use Zend\Form\Element\Radio;

use Zend\Form\Element\Select;

use Zend\Form\Element\Password;

use Zend\Form\Element\Submit;

use Zend\Form\Element\Email;

use Zend\Form\Element\Text;

use Zend\Form\Element;

use Zend\Form\Form;

class ProvaFormIscriviti extends Form
{
	public function __construct($name = null){
		// we want to ignore the name passed
		parent::__construct('prova');
		
		$this->setAttribute('method', 'post');
		$textNome = new Text('Nome');
		$textNome->setLabel("Nome");
		
		$this->add($textNome);
		
		$textCognome = new Text('Cognome');
		$textCognome->setLabel("Cognome");
		
		$this->add($textCognome);
		
		$textMail = new Email("Mail");
		$textMail->setLabel("E-Mail");
		$this->add($textMail);
		
		$textPsw = new Password("Psw");
		$textPsw->setLabel("Password");
		$this->add($textPsw);
		
		$textPsw = new Password("Psw");
		$textPsw->setLabel("Password");
		$this->add($textPsw);
		
		$selectPatente = new Select("Tipo_Patente");
		$selectPatente->setValueOptions(array(
											"A" => "A",
											"B" => "B",
											"C" => "C",
											"D" => "D",
											"BE" => "BE",
											"CE" => "CE",
											"DE" => "DE"							
										));
		
		$this->add($selectPatente);
		
		$sex = new Radio("Sesso");
		$sex->setValueOptions(array(
								"M" => "M",
								"F" => "F"
							));
		$this->add($sex);
		$input = new Submit("submit");
		//$input->setLabel("Iscriviti");
		$input->setValue("Iscriviti");
		$this->add($input);
		
	}
}