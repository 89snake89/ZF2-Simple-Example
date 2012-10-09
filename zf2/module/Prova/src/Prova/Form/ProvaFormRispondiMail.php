<?php
namespace Prova\Form;

use Prova\Controller\ProvaController;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Submit;
use Zend\Form\Form;

class ProvaFormRispondiMail extends Form
{
	public function __construct($name = null){
		// we want to ignore the name passed
		parent::__construct('prova');
		$this->setAttribute('method', 'post');
		
		$textMessage = new Textarea('Message');
		$textMessage->setLabel("Messaggio");
		$textMessage->setAttributes(array('cols' => 1000, 'rows' => 20));
		$this->add($textMessage);
		
		$input = new Submit("submit");
		//$input->setLabel("Iscriviti");
		$input->setValue("Rispondi");
		$this->add($input);
	}
}