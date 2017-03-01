<?php

class Application_Form_Alegraform extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setMethod('post');
    	$t_contacto=new Zend_Form_Element_Text('nombre_contacto',array('label'=>'Nombre contacto:'));
    	$this->addElement($t_contacto);
    	$submit_contacto=new Zend_Form_Element_Submit('contacto_submit',array('label'=>'Guarda contacto'));
    	$this->addElement($submit_contacto);
    }


}

