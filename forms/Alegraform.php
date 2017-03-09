<?php

class Application_Form_Alegraform extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setMethod('post');
    	//la etiqueda ese "nombre contacto" y se pasa la variable "name"
    	$t_contacto = new Zend_Form_Element_Text('name',array('required'=>true,'label'=>'Nombre contacto:'));
    	$t_identification = new Zend_Form_Element_Text('identification',array('label'=>'Identificacion:'));
    	$t_phonePrimary = new Zend_Form_Element_Text('phonePrimary',array('label'=>'Telefono 1:'));
    	$t_phoneSecondary = new Zend_Form_Element_Text('phoneSecondary',array('label'=>'Telefono 2:'));
    	$t_fax = new Zend_Form_Element_Text('fax',array('label'=>'Fax:'));
    	$t_mobile = new Zend_Form_Element_Text('mobile',array('label'=>'Celular:'));
    	$t_observations = new Zend_Form_Element_Text('observations',array('label'=>'Observaciones:'));
    	$t_email = new Zend_Form_Element_Text('email',array('label'=>'Correo Electronico:'));
    	$t_city = new Zend_Form_Element_Text('city',array('label'=>'Ciudad:'));
    	$t_address= new Zend_Form_Element_Text('address',array('label'=>'Direccion:'));
    	$type = new Zend_Form_Element_MultiCheckbox('type', array(
    			'multiOptions' => array(
    					'client' => 'Cliente',
    					'provider' => 'Proveedor',
    			)
    	));
    	$t_priceList = new Zend_Form_Element_Select('priceList',
    			array(
    					'label' => 'Lista de Precios:',
    					'value' => '0',
    					'multiOptions' => array(
    							'0' => 'Ninguno',
    							'1' => 'General',
    					),   					 
    			));
    	$t_seller = new Zend_Form_Element_Select('seller',
    			array(
    					'label' => 'Vendedor:',
    					'value' => '0',
    					'multiOptions' => array(
    							'0' => 'Ninguno',
    					),   	
    			));
    	$t_term = new Zend_Form_Element_Select('term',
    			array(
    					'label' => 'Termino de Pago:',
    					'value' => '1',
    					'multiOptions' => array(
    							'0'    => 'Vencimiento manual',
    							'1'    => 'De contado',
    							'2'    => '8 dias',
    							'3'    => '15 dias',
    							'4'    => '30 dias',
    							'5'    => '60 dias',
    					),
    			));
    	
    	$a_contacto = new Zend_Form_Element_Text('a_name',array('required'=>true,'label'=>'Nombre:'));
    	$a_lastName = new Zend_Form_Element_Text('a_lastName',array('label'=>'Apellido:'));
    	$a_email = new Zend_Form_Element_Text('a_email',array('label'=>'Correo electronico:'));
    	$a_phone = new Zend_Form_Element_Text('a_phone',array('label'=>'Telefono:'));
    	$a_mobile = new Zend_Form_Element_Text('a_mobile',array('label'=>'Celular:'));
    	$a_sendNotifications = new Zend_Form_Element_Checkbox('a_sendNotifications',array(
    			'label'=>'Enviar Notificacion:',
    			'checkedValue' => true,
                'uncheckedValue' => false
    	)); 	
    	 
    	$this->addElement($t_contacto);
    	$this->addElement($t_identification);
    	$this->addElement($t_address);
    	$this->addElement($t_city);
    	$this->addElement($t_phonePrimary);
    	$this->addElement($t_phoneSecondary);
    	$this->addElement($t_fax);
    	$this->addElement($t_mobile);
    	$this->addElement($t_email);
    	$this->addElement($t_priceList);
    	$this->addElement($t_seller);    	    	
    	$this->addElement($t_term);
		$this->addElement($type);
    	$this->addElement($t_observations);
    	
    	$this->addElement($a_contacto);
    	$this->addElement($a_lastName);
    	$this->addElement($a_email);
    	$this->addElement($a_phone);
    	$this->addElement($a_mobile);
    	$this->addElement($a_sendNotifications);
    	
    	/*$address[] = new Zend_Form_Element_Text('address',array(
    			new Zend_Form_Element_Text('a_name',array('required'=>true,'label'=>'Nombre:')),
    			 new Zend_Form_Element_Text('a_lastName',array('label'=>'Apellido:')),
    			new Zend_Form_Element_Text('a_email',array('label'=>'Correo electronico:')),
    			new Zend_Form_Element_Text('a_phone',array('label'=>'Telefono:')),
    			new Zend_Form_Element_Text('a_mobile',array('label'=>'Celular:')),
    			 new Zend_Form_Element_Checkbox('a_sendNotifications',array(
    					'label'=>'Enviar Notificacion:',
    					'checkedValue' => true,
    					'uncheckedValue' => false
    			))
    			
    			
    	));*/
    	
    	$submit_contacto = new Zend_Form_Element_Submit('contacto_submit',array('label'=>'Guarda contacto'));
    	$this->addElement($submit_contacto);
    }


}

