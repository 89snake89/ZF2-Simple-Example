<?php
namespace Prova\Form;
use Zend\Form\Element\Password;

use Zend\Form\Element\Submit;

use Zend\Form\Element\Email;

use Zend\Form\Element\Text;

use Zend\Form\Element;

use Zend\Form\Form;

class ProvaFormLogIn extends Form
{
	public function __construct($name = null){
		// we want to ignore the name passed
		parent::__construct('prova');
		
		$this->setAttribute('method', 'post');
		
		$textMail = new Email("Mail");
		$textMail->setLabel("E-Mail");
		$textMail->setOptions(array('required' => true));
		$this->add($textMail);
		
		$textPsw = new Password("Psw");
		$textPsw->setLabel("Password");
		$textPsw->setOptions(array('required' => true));
		$this->add($textPsw);
		
		$input = new Submit("submit");
		//$input->setLabel("Iscriviti");
		$input->setValue("Entra");
		$this->add($input);
		
	}
}