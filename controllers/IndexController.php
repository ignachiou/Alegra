<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body//$client = new Zend_Rest_Client('https://app.alegra.com/api/v1/contacts/');
            	
    	$client = new Zend_Http_Client('https://app.alegra.com/api/v1/contacts/');
    	$client->setAuth('salvador.ignacio.salvatierra@gmail.com', 'c057687f5260aac9c56c');
    	
    	//se solicita un request con los parametros que se estan pasando en client
    	$a = $client->request('GET');    	 
    	$b = strstr($a, '[');
    	$json_alegra = substr($b,0, -5);    	
    	//Se pasa pasa de json a array
    	$phpNative = Zend_Json::decode($json_alegra); //$phpNative = json_decode($json_alegra, true);
    	
    	//se envia a la vista
    	$this->view->response = $phpNative;
    }

    public function showformAction()
    {
        // action body
    	$this->view->form = new Application_Form_Alegraform();
    	//'create esta referida en el archivo .ini
    	$this->view->form->setAction($this->view->
           url(array('controller'=>'index','action'=>'createform'),'create'));
    }

    public function createformAction()
    {
    	// action body
    	
    	$request=$this->getRequest();
    	if ($request->isPost())
    	{
    		$form_contac = new Application_Form_Alegraform();
    		if ($form_contac->isValid( $request->getPost()) )
    		{
    			//obtiene el valor "name" pasada por parametro y se introduce en un array
    			$internalContact[] = array(
    					'name'=>$a_contacto = $form_contac->getValue('a_name'),
    					'lastName'=>$a_lastName = $form_contac->getValue('a_lastName'),
    					'email'=>$a_lastName = $form_contac->getValue('a_email'),
    					'phone'=>$a_lastName = $form_contac->getValue('a_phone'),
    					'mobile'=>$a_lastName = $form_contac->getValue('a_mobile'),
    					'sendNotifications'=>$a_sendNotifications = $form_contac->getValue('a_sendNotifications'),
    			);
    			$data = array(
    					'name'=>$form_contac->getValue('name'), 
    					'identification'=>$form_contac->getValue('identification'),
    					'email'=>$form_contac->getValue('email'),
    					'phonePrimary'=>$form_contac->getValue('phonePrimary'),
    					'phoneSecondary'=>$form_contac->getValue('phoneSecondary'),
    					'fax'=>$form_contac->getValue('fax'),
    					'mobile'=>$form_contac->getValue('mobile'),
    					'observations'=>$form_contac->getValue('observations'),    					
    					'type'=>$form_contac->getValue('type'),
    					'address'=>array(
    							'address'=>$form_contac->getValue('address'),
    							'city'=>$form_contac->getValue('city'),
    					),
    					//'seller'=>$form_contac->getValue('seller'),
    					'term'=>$form_contac->getValue('term'),
    					'priceList'=>$form_contac->getValue('priceList'),
    					
    					
    					
    					'internalContacts'=>$internalContact,
    							
    					  							
    					   		
    			);
    			$json_alegra = Zend_Json::encode($data);
    			$client = new Zend_Http_Client('https://app.alegra.com/api/v1/contacts/'); 
    			$client->setAuth('salvador.ignacio.salvatierra@gmail.com', 'c057687f5260aac9c56c');
    			//Se le dice al header que es una app/json y se le pasa el parametro
    			$client->setRawData($json_alegra, 'application/json');
    			$client->request('POST'); 
    			//$this->view->response = $json_alegra; 			
    		}
    	}
    	$this->_helper->redirector('index');
    }

    public function editAction()
    {
    	
        // action body
        $id = $this->getRequest()->getParam('id');        
        $client = new Zend_Http_Client('https://app.alegra.com/api/v1/contacts/'.$id);
        $client->setAuth('salvador.ignacio.salvatierra@gmail.com', 'c057687f5260aac9c56c');
         
        //se solicita un request con los parametros que se estan pasando en client
        $a = $client->request('GET');
        $b = strstr($a, '{');
        $json_alegra = substr($b,0, -5);
         
        //Se pasa de json a array
        $phpNative = Zend_Json::decode($json_alegra); //$phpNative = json_decode($json_alegra, true);
        
        //$this->view->response = $a;
                
        $this->view->form = new Application_Form_Alegraform();
        //usamos populate para llenar el formulario con el array $phpNative
        //las variables del array deben cooncordar con las del form
        $this->view->form->populate($phpNative);
        $this->view->form->setAction($this->view->
          url(array('controller'=>'index','action'=>'update','id'=>$id)));
    
    }

    public function updateAction()
    {
        // action body
        //los parametros que envia el formulario los almaceno en vars
        $id = $this->getRequest()->getParam('id');
        $nombre = $this->getRequest()->getParam('name'); 
        $request = $this->getRequest();
        
        if ($request->isPost())
        {
        	//se guarda en data el array que modificara la info en la BD
        	$data = array('id'=>$id, 'name'=>$nombre);
        	$json_alegra = Zend_Json::encode($data);
        	$client = new Zend_Http_Client('https://app.alegra.com/api/v1/contacts/'.$id);
        	$client->setAuth('salvador.ignacio.salvatierra@gmail.com', 'c057687f5260aac9c56c');
        	$client->setRawData($json_alegra, 'application/json');
        	$client->request('PUT');
        	
        	return $this->_helper->redirector('index'); 
        }
        
    }

    public function deleteAction()
    {
        // action body
        
    	$id = $this->getRequest()->getParam('id');
    	$client = new Zend_Http_Client('https://app.alegra.com/api/v1/contacts/'.$id);
    	$client->setAuth('salvador.ignacio.salvatierra@gmail.com', 'c057687f5260aac9c56c');
    	$client->request('DELETE'); 
    	       
        return $this->_helper->redirector('index');
        
    }


}













