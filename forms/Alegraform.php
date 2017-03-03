<?php

class Application_Form_Alegraform extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setMethod('post');
    	//la etiqueda ese "nombre contacto" y se pasa la variable "name"
    	$t_contacto = new Zend_Form_Element_Text('name',array('label'=>'Nombre contacto:'));
    	$t_identification = new Zend_Form_Element_Text('identification',array('label'=>'Identificacion:'));
    	$t_phonePrimary = new Zend_Form_Element_Text('phonePrimary',array('label'=>'Telefono 1:'));
    	$t_phoneSecondary = new Zend_Form_Element_Text('phoneSecondary',array('label'=>'Telefono 2:'));
    	$t_fax = new Zend_Form_Element_Text('fax',array('label'=>'Fax:'));
    	$t_mobile = new Zend_Form_Element_Text('mobile',array('label'=>'Celular:'));
    	$t_observations = new Zend_Form_Element_Text('observations',array('label'=>'Observaciones:'));
    	$t_email = new Zend_Form_Element_Text('email',array('label'=>'Correo Electronico:'));
    	$type = new Zend_Form_Element_MultiCheckbox('type', array(
    			'multiOptions' => array(
    					'client' => 'Cliente',
    					'provider' => 'Proveedor',
    			)
    	));
    	 
    	$this->addElement($t_contacto);
    	$this->addElement($t_identification);
    	$this->addElement($t_phonePrimary);
    	$this->addElement($t_phoneSecondary);
    	$this->addElement($t_fax);
    	$this->addElement($t_mobile);
    	$this->addElement($t_email);
    	
    	$this->addElement('select','priceList',
    			array(
    					'label'        => 'Lista de Precios:',
    					'value'        => 'null',
    					'multiOptions' => array(
    							'null'    => 'Niguno',
    							'general'   => 'General',
    					),
    			)
    	);
    	
    	$this->addElement('select','seller',
    			array(
    					'label'        => 'Vendedor:',
    					'value'        => 'null',
    					'multiOptions' => array(
    							'null'    => 'Niguno',
    					),
    			)
    	);
    	
    	$this->addElement('select','term',
    			array(
    					'label'        => 'Termino de Pago:',
    					'value'        => '1',
    					'multiOptions' => array(
    							'1'    => 'Vencimiento manual',
    							'2'    => 'De contado',
    							'3'    => '8 dias',
    							'4'    => '15 dias',
    							'5'    => '30 dias',
    							'6'    => '60 dias',
    					),
    			)
    	);
		$this->addElement($type);
    	$this->addElement($t_observations);
    	
    	$submit_contacto = new Zend_Form_Element_Submit('contacto_submit',array('label'=>'Guarda contacto'));
    	$this->addElement($submit_contacto);
    }


}

