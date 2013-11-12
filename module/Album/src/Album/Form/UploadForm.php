<?php
namespace Album\Form;
use Zend\Form\Element;
use Zend\Form\Form;

class UploadForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->addElements();
        $this->add(array(
            'name' => 'caption',
            'type' => 'Text',
            'options' => array(
                'label' => 'Caption ',
                ),
            ));
    }

    public function addElements()
    {
        // File Input
        $file = new Element\File('audio-file');
        $file->setLabel('Upload Audio File')
             ->setAttribute('id', 'audio-file');
        $this->add($file);
    }
}