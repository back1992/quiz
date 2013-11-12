<?php
namespace Ffmpeg\Form;
use Zend\Form\Element;
// use Zend\Form\Element\Url;
use Zend\Form\Form;
// use Zend\InputFilter;
class dirForm extends Form
{
	public function __construct($name = null)
	{
// we want to ignore the name passed
		parent::__construct('dir');

		$this->setAttribute('method', 'post');
		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
			));
		$this->add(array(
			'type' => 'Zend\Form\Element\Checkbox',
			'name' => 'check',
			'options' => array(
				'label' => 'A checkbox',
				'use_hidden_element' => true,
				'checked' => 'checked',
				'checked_value' => '1',
				'unchecked_value' => '0'

				)
			));
		$this->add(array(
			'name' => 'title',
			// 'type' => 'text',
			'options' => array(
				'label' => 'Title ',
				),
			));
		$this->add(array(
			'name' => 'process',
			'type' => 'Zend\Form\Element\Button',
			'type' => 'Submit',
			'options' => array(
				'value' => 'Process',
				'label' => 'Process'
				)
			));
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'Submit',
				'id' => 'submitbutton',
				),
			));
	}
}
