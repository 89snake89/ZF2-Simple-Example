<?php
// module/Album/src/Album/Form/AlbumForm.php:
namespace Album\Form;

use Zend\Form\Element;

use Zend\Form\Form;

class AlbumForm extends Form
{
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('album');
		$this->setAttribute('method', 'post');
		$this->add(array(
				'name' => 'id',
				'attributes' => array(
						'type'  => 'hidden',
				),
		));
		$this->add(array(
					'name' => 'year',
					'attributes' => array(
								'type' => 'text',
							),
					'options' => array(
								'label' => 'Year',
							)
				));
		$this->add(array(
				'name' => 'artist',
				'attributes' => array(
						'type'  => 'text',
				),
				'options' => array(
						'label' => 'Artist',
				),
		));
		$this->add(array(
				'name' => 'title',
				'attributes' => array(
						'type'  => 'text',
				),
				'options' => array(
						'label' => 'Title',
				),
		));
		
		$textYear = new Element\Text('year');
		$textYear->setLabel("Year");
		$textYear->setAttributes(array('size' => 4));
		$this->add($textYear);
		
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Go',
						'id' => 'submitbutton',
				),
		));
		
		
	}
}