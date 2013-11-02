<?php
namespace Album\Form;
// use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;

class ContractForm extends Form
{
	// protected $captcha;

	public function __construct()
	// public function __construct(CaptchaAdapter $captcha)
	{
		// $this->captcha = $captcha;

        // add() can take either an Element/Fieldset instance,
        // or a specification, from which the appropriate object
        // will be built.

		$this->add(array(
			'name' => 'name',
			'options' => array(
				'label' => 'Your name',
				),
			'type'  => 'Text',
			));
		$this->add(array(
			'type' => 'Zend\Form\Element\Email',
			'name' => 'email',
			'options' => array(
				'label' => 'Your email address',
				),
			));
		$this->add(array(
			'name' => 'subject',
			'options' => array(
				'label' => 'Subject',
				),
			'type'  => 'Text',
			));
		$this->add(array(
			'type' => 'Zend\Form\Element\Textarea',
			'name' => 'message',
			'options' => array(
				'label' => 'Message',
				),
			));
		$this->add(array(
			'type' => 'Zend\Form\Element\Captcha',
			'name' => 'captcha',
			'options' => array(
				'label' => 'Please verify you are human.',
				'captcha' => $this->captcha,
				),
			));
		$this->add(new Element\Csrf('security'));
		$this->add(array(
			'name' => 'send',
			'type'  => 'Submit',
			'attributes' => array(
				'value' => 'Submit',
				),
			));

        // We could also define the input filter here, or
        // lazy-create it in the getInputFilter() method.
	}
}