<?php
namespace Mp3\Model;
// Add these import statements
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
class Mp3 implements InputFilterAwareInterface
{
	public $id;
	public $area;
	public $title;
	// public $location;
	public $audiofile;

	protected $inputFilter;
// <-- Add this variable
	public function exchangeArray($data)
	{
		$this->id
		= (isset($data['id']))
		? $data['id']
		: null;
		$this->area = (isset($data['area'])) ? $data['area'] : null;
		$this->title = (isset($data['title'])) ? $data['title'] : null;
		// $this->location = (isset($data['location'])) ? $data['location'] : null;
		$this->audiofilepath = (isset($data['audiofile'])) ? $data['audiofile'] : null;
		$this->audiofile = (isset($data['audiofile']['tmp_name'])) ? $data['audiofile']['tmp_name'] : $data['audiofile'];
	}
// Add content to these methods:
// Add the following method:
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}


	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory
			= new InputFactory();
			$inputFilter->add($factory->createInput(array(
				'name'
				=> 'id',
				'required' => true,
				'filters' => array(
					array('name' => 'Int'),
					),
				)));
			$inputFilter->add($factory->createInput(array(
				'name'
				=> 'area',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
					),
				'validators' => array(
					array(
						'name'
						=> 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'
							=> 1,
							'max'
							=> 100,
							),
						),
					),
				)));
			$inputFilter->add($factory->createInput(array(
				'name'
				=> 'title',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
					),
				'validators' => array(
					array(
						'name'
						=> 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'
							=> 1,
							'max'
							=> 100,
							),
						),
					),
				)));
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}
