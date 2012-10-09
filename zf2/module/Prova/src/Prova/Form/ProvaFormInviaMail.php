<?php
namespace Prova\Form;

use Prova\Controller\ProvaController;

use Prova\Model\User;

use Zend\Form\Element\Select;

use Zend\Form\Element\Color;

use Zend\Form\Element\Email;

use Zend\Form\Element\Textarea;


use Zend\Form\Element\Submit;


use Zend\Form\Element\Text;

use Zend\Form\Element;

use Zend\Form\Form;

class ProvaFormInviaMail extends Form
{
	public function __construct($name = null){
		// we want to ignore the name passed
		parent::__construct('prova');
		$this->setAttribute('method', 'post');
		
		
		$select = new Select("Receiver");
		$select->setValueOptions(array('1' => 'fabio'));
		
		//$select->setValue($value);
		//$select->setValue('Id_User');
		$this->add($select);
		
		
		$textMessage = new Textarea('Message');
		$textMessage->setLabel("Messaggio");
		//$textMessage->setAttributes(array('cols' => '600'));
		$this->add($textMessage);
		
		$input = new Submit("submit");
		//$input->setLabel("Iscriviti");
		$input->setValue("Invia");
		$this->add($input);
	}
}