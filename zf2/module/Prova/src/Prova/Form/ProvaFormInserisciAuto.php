<?php
namespace Prova\Form;

use Zend\Form\Element\Select;

use Zend\Form\Element\Password;

use Zend\Form\Element\Submit;


use Zend\Form\Element\Text;

use Zend\Form\Element;

use Zend\Form\Form;

class ProvaFormInserisciAuto extends Form
{
	public function __construct($name = null){
		// we want to ignore the name passed
		parent::__construct('prova');
		
		$this->setAttribute('method', 'post');
		$textMarca = new Text('Marca');
		$textMarca->setLabel("Marca");
		
		$this->add($textMarca);
		
		$textModello = new Text('Modello');
		$textModello->setLabel("Modello");
		
		$this->add($textModello);
		
		$textColore = new Text("Colore");
		$textColore->setLabel("Colore");
		$this->add($textColore);
		
		$textPrezzo = new Text("Prezzo");
		$textPrezzo->setLabel("Prezzo");
		$this->add($textPrezzo);
		
		$selectAnno = new Select("Anno");
		//$anni = array();
		$selectAnno->setValueOptions(array_combine(range(1999, 2012),
										range(1999, 2012)));
	
		$this->add($selectAnno);
		
		$input = new Submit("submit");
		//$input->setLabel("Iscriviti");
		$input->setValue("Inserisci");
		$this->add($input);
		
	}
}