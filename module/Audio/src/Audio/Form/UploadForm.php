<?php
namespace Audio\Form;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Date;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
class UploadForm extends Form
{
    public function __construct
    ($name = null, $options = array())
    {
            parent::__construct('upload-form');
        $this->
setAttribute('method', 'post')
        ->setHydrator(new ClassMethodsHydrator(false))
        ->setInputFilter(new InputFilter());
        $this->setAttribute('role', 'form');
        $this->addElements();
        $this->add(array(
            'name' => 'title',
            'type' => 'Text',
            'options' => array(
                'label' => 'Quiz Title ',
                ),
            'attributes' => array(
                'class' => 'form-control form-group',
                 'id'=>"quiz-title" ,
                 'style'=>"width: 500px" ,
                 'placeholder'=> 'Quiz Title '
                ),
            ));
        $this->add(array(
            'name' => 'city',
            'type' => 'Text',
            'options' => array(
                'label' => 'City ',
                ),
            'attributes' => array(
                'class' => 'form-control form-group',
                 'id'=>"city" ,
                 'style'=>"width: 500px" ,
                 'placeholder'=> 'City '
                ),
            ));
$this->add(array(
             'type' => 'Zend\Form\Element\Select',
             'name' => 'state',
             'options' => array(
                     'label' => 'State: ',
                     'empty_option' => 'state',
                     'value_options' => array(
                     ),
             ),
                           'attributes' => array(
                'class' => 'form-control form-group prov',
                 'id'=>"prov" ,
                 'style'=>"width: 130px" ,
                ),
     ));
$this->add(array(
             'type' => 'Zend\Form\Element\Select',
             'name' => 'city',
             'options' => array(
                     'label' => 'City',
                     'empty_option' => 'City',
                     'value_options' => array(
                     ),
             ),
              'attributes' => array(
                'class' => 'form-control form-group city',
                 'id'=>"city" ,
                 'style'=>"width: 130px" ,
                ),
     ));
        $this->add(array(
            'name' => 'caption',
            'type' => 'Text',
            'options' => array(
                'label' => 'Caption ',
                ),
            'attributes' => array(
                'class' => 'form-control form-group',
                 'id'=>"exampleInputPassword1" ,
                 'style'=>"width: 500px" ,
                 'placeholder'=> 'Caption '
                ),
            ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Submit',
                'class' => 'btn btn-primary form-group',
                ),
            ));
/*        $this->add(array(
    'type' => 'Zend\Form\Element\Date',
    'name' => 'date',
    'option' => array(
        'label' => 'Date',
        'format' => 'Y-m'
    ),
        'attributes' => array(
                'class' => 'form-control form-group',
                 'id'=>"exampleInputPassword1" ,
                 'style'=>"display: block;
  cursor: pointer;
  width: 180px;
  height: 36px;
  align: right;
  "),
));*/
$this->add(array(
    'type' => 'Zend\Form\Element\MonthSelect',
    'name' => 'monthyear',
    'options' => array(
        'label' => 'Select a month and a year',
        'min_year' => 1986,
    ),
));
}
    public function addElements()
    {
        // File Input
        $file = new Element\File('audio-file');
        $file->setLabel('Upload Audio File')->setAttribute('id', 'audio-file')->setAttribute('style', 'width: 280px')->setAttribute('class', 'form-group')->setAttribute('placeholder', 'audio-file');
        $this->add($file);
    }
}