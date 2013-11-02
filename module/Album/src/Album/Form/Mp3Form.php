<?php
namespace Album\Form;
use Zend\Form\Element;
// use Zend\Form\Element\Url;
use Zend\Form\Form;
use Zend\InputFilter;
class Mp3Form extends Form
{
	public function __construct($name = null)
	{
// we want to ignore the name passed
		parent::__construct('mp3');
		$this->addElements();
		$this->addButton();
		$this->addInputFilter();

		$this->setAttribute('method', 'post');
		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
			));
		$this->add(array(
			'name' => 'title',
			'type' => 'Text',
			'options' => array(
				'label' => 'Title ',
				),
			));
		$this->add(array(
			'name' => 'area',
			'type' => 'Text',
			'options' => array(
				'label' => 'Area ',
				),
			));
		$this->add(array(
			'name' => 'caption',
			'type' => 'Text',
			'options' => array(
				'label' => 'Caption ',
				),
			));
		$this->add(array(
			'name' => 'filetype',
			'type' => 'Text',
			'options' => array(
				'label' => 'Filetype ',
				),
			));
		$this->add(array(
			'name' => 'audiofilepath',
			'type' => 'Text',
			'options' => array(
				'label' => 'Audiofilepath ',
				),
			));
		$this->add(array(
			'name' => 'audiofiledir',
			'type' => 'Text',
			'options' => array(
				'label' => 'Audiofiledir ',
				),
			));
		$this->add(array(
			'name' => 'filename',
			'type' => 'Text',
			'options' => array(
				'label' => 'Filename ',
				),
			));
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'Go ',
				'id' => 'submitbutton',
				),
			));
	}
	public function addElements()
	{
// File Input
		$file = new Element\File('audiofile');
		$file->setLabel('Audio File Upload ')
		->setAttribute('id', 'audiofile');
		$this->add($file);
	}
	public function addButton()
	{
// File Input
		$mybutton = new Element\Button('mybutton');
		$mybutton->setLabel("Splt  Mp3");
		// ->setAttribute('onclick','window.location =\''.$this->url(array('controller'=>'users','action'=>'join')).'\' ');
		// ->setAttribute('onclick','window.location =\'http://zf2-test/mp3/delete'.'\' ');
		// ->setAttribute('onclick','window.location =\'http://www.baidu.com'.'\' ');
		// ->setAttribute('action', $this->url('home'));


		$this->add($mybutton);
	}

	public function addInputFilter()
	{
		$inputFilter = new InputFilter\InputFilter();

        // File Input
		$fileInput = new InputFilter\FileInput('audiofile');
		$fileInput->setRequired(true);
		$fileInput->getFilterChain()->attachByName(
			'filerenameupload',
			array(
				'target'    => './data/tmpuploads/audiofile',
				'randomize' => true,
				)
			);
		$inputFilter->add($fileInput);

		$this->setInputFilter($inputFilter);
	}
}
