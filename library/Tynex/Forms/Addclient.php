<?php
class Tynex_Forms_Addclient extends Zend_Form
{

	public function init()
  	{
  		
		 	$name = new Zend_Form_Element_Text('name');
		  	$name->setLabel('Nom');
		  	
		  	$prenam = new Zend_Form_Element_Text('prenam');
		  	$prenam->setLabel('Prenom	');
		  	
		  	$gender = new Zend_Form_Element_Radio('gender');
		  	$gender->addMultiOptions(array('Male','femelle'));
		  	
		  	$adresse = new Zend_Form_Element_Text('adresse');
		  	$adresse->setLabel('Adresse');
		  	
		  	$tel = new Zend_Form_Element_Text('tel');
		  	$tel->setLabel('Tel');
		    
		  	$tel2 = new Zend_Form_Element_Text('tel2');
		  	$tel2->setLabel('Tel2');
		  	
		  	$fax = new Zend_Form_Element_Text('fax');
		  	$fax->setLabel('Fax');
		  	
		  	$submit = new Zend_Form_Element_Submit('submit');
		  	$submit->setValue('Submit');
		  	
		  	$this->addElements(array($name,$prenam,$gender,$adresse,$tel,$fax,$tel2,$submit));
		  
					  
		  	$this->setElementDecorators(array(
		  		'ViewHelper',
		  		array(array('data' => 'HtmlTag'),  array('tag' =>'div')),
		  		array('Label'),
		  		array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'section'))
		  ));
		  	
		  	//$gender->setDecorators($decorators)
		  	
		  	
		  	$submit->setDecorators(array('ViewHelper',
		  			array(array('data' => 'HtmlTag'),  array('tag' =>'td', 'class'=> 'element')),
		  			array(array('emptyrow' => 'HtmlTag'),  array('tag' =>'td', 'class'=> 'element', 'placement' => 'PREPEND')),
		  			array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		  	));
		  	
		  	$this->setDecorators(array(
		  			'FormElements',
		  			array('HtmlTag', array('tag' => 'table')),
		  			'Form'
		  	));
  	}
}

