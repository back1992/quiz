<?php
namespace Album\Form;
use Zend\Form\Element;
// use Zend\Form\Element\Url;
use Zend\Form\Form;
use Zend\InputFilter;
class CommentForm extends Form
{
	public function __construct($name = null)
	{
// we want to ignore the name passed
		parent::__construct('comment');
		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
			));
		$this->add(array(
			'name' => 'commenter_name',
			'type' => 'Text',
			'options' => array(
				'label' => 'Name: ',
				),
			));
		
		$this->add(array(
			'name' => 'commenter_email',
			'type' => 'Email',
			'options' => array(
				'label' => 'Email: ',
				),
			));
		
		$this->add(array(
			'name' => 'comment',
			'type' => 'Text',
			'options' => array(
				'label' => 'Comment: ',
				),
			));
		$this->add(array(
			'name' => 'artist',
			'type' => 'Textarea',
			'options' => array(
				'label' => 'Artist',
				),
			));
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'Go',
				'id' => 'submitbutton',
				),
			));
	}
}
