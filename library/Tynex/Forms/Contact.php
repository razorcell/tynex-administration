<?php
class Square_Form_Contact extends Zend_Form
{
  public function init()
  {
    // initialize form
    $this->setAction('/contact/index')
         ->setMethod('post');
         
    // create text input for name 
    $name = new Zend_Form_Element_Text('name');
    $name->setLabel('Name:')
         ->setOptions(array('size' => '35'))
         ->setRequired(true)
         ->addValidator('NotEmpty', true)
         ->addValidator('Alpha', true)            
         ->addFilter('HTMLEntities')            
         ->addFilter('StringTrim');            
    
    // create text input for email address
    $email = new Zend_Form_Element_Text('email');
    $email->setLabel('Email address:');
    $email->setOptions(array('size' => '50'))
          ->setRequired(true)
          ->addValidator('NotEmpty', true)
          ->addValidator('EmailAddress', true)            
          ->addFilter('HTMLEntities')            
          ->addFilter('StringToLower')        
          ->addFilter('StringTrim');            
    
    // create text input for message body
    $message = new Zend_Form_Element_TextArea('message');
    $message->setLabel('Message:')
            ->setOptions(array('rows' => '8','cols' => '40'))
            ->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addFilter('HTMLEntities')            
            ->addFilter('StringTrim');            
    
    // create captcha
    $captcha = new Zend_Form_Element_Captcha('captcha', array(
      'captcha' => array(
        'captcha' => 'Dumb',
        //'wordLen' => 6,//number of caracters in the captcha
        //'timeout' => 300,
        //'width'   => 50,
        //'height'  => 100,
       /* 'imgUrl'  => '/captcha',
        'imgDir'  => APPLICATION_PATH . '/../public/captcha',
        'font'    => APPLICATION_PATH . '/../public/fonts/LiberationSansRegular.ttf',*/
        )
    ));
    $captcha->setLabel('Verification code:');    
            
    // create submit button
    $submit = new Zend_Form_Element_Submit('submit');
    $submit->setLabel('Send Message')
           ->setOptions(array('class' => 'submit'));
                
    // attach elements to form
    $this->addElement($name)
         ->addElement($email);
		 //add display group
	$this->addDisplayGroup(array('name','email'),'personnal_information');
	$this->getDisplayGroup('personnal_information')->setLegend('The pesonnal informations');
    
	$this->addElement($message)
         ->addElement($captcha)
         ->addElement($submit);
  }
}

