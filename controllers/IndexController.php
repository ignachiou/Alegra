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
    	$client->setAuth('xxxxxxx', 'xxxxxxxx');
    	 
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
    					'address'=>array(
    							'address'=>$form_contac->getValue('address'),
    							'city'=>$form_contac->getValue('city'),
    					),
    					'observations'=>$form_contac->getValue('observations'),
    					'term'=>$form_contac->getValue('term'),
    					//'seller'=>$form_contac->getValue('seller'),    					
    					
    					 'type'=>$form_contac->getValue('type'),
    					'priceList'=>$form_contac->getValue('priceList'),
    					
    					
    					
    					'internalContacts'=>$internalContact,
    							
    					  							
    					   		
    			);
    			$json_alegra = Zend_Json::encode($data);
    			$client = new Zend_Http_Client('https://app.alegra.com/api/v1/contacts/'); 
    			$client->setAuth('xxxxxxx', 'xxxxxxx');
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
        $client->setAuth('xxxxxxx', 'xxxxxx');
         
        //se solicita un request con los parametros que se estan pasando en client
        $a = $client->request('GET');
        $b = strstr($a, '{');
        $json_alegra = substr($b,0, -5);
         
        //Se pasa de json a array
        $phpNative = Zend_Json::decode($json_alegra); //$phpNative = json_decode($json_alegra, true);
        $address = $phpNative["address"];
        //en esta seccion se toma en cuenta el primer array, si fueran varios
        //el valor 0 no existiria y estaria posiblemente dentro de un for
        $name_i = $phpNative["internalContacts"][0]["name"];
        $lastName_i = $phpNative["internalContacts"][0]["lastName"];
        $email_i = $phpNative["internalContacts"][0]["email"];
        $phone_i = $phpNative["internalContacts"][0]["phone"];
        $mobile_i = $phpNative["internalContacts"][0]["mobile"];
        $sendNotifications_i = $phpNative["internalContacts"][0]["sendNotifications"];
        
        
        //$this->view->response = $a;
                
        $this->view->form = new Application_Form_Alegraform();
        //usamos populate para llenar el formulario con el array $phpNative
        //las variables del array deben cooncordar con las del form
        $this->view->form->populate($phpNative);
        $this->view->form->populate($address);
        $this->view->form->setDefault('a_name',$name_i);
        $this->view->form->setDefault('a_lastName',$lastName_i);
        $this->view->form->setDefault('a_email',$email_i);
        $this->view->form->setDefault('a_phone',$phone_i);
        $this->view->form->setDefault('a_mobile',$mobile_i);
        $this->view->form->setDefault('a_sendNotifications',$sendNotifications_i);
        $this->view->form->setAction($this->view->
          url(array('controller'=>'index','action'=>'update','id'=>$id)));
        //$this->view->response = $address;
    
    }

    public function updateAction()
    {
        // action body
        //los parametros que envia el formulario los almaceno en vars
        $id = $this->getRequest()->getParam('id');
        $nombre = $this->getRequest()->getParam('name'); 
        $identification = $this->getRequest()->getParam('identification');
        $phonePrimary = $this->getRequest()->getParam('phonePrimary');
        $phoneSecondary = $this->getRequest()->getParam('phoneSecondary');
        $fax = $this->getRequest()->getParam('fax');
        $mobile = $this->getRequest()->getParam('mobile');
        $observations = $this->getRequest()->getParam('observations');
        $email = $this->getRequest()->getParam('email');
        $city = $this->getRequest()->getParam('city');
        $address = $this->getRequest()->getParam('address');
        $type = $this->getRequest()->getParam('type');
        $priceList = $this->getRequest()->getParam('priceList');
        $seller = $this->getRequest()->getParam('seller');
        $term = $this->getRequest()->getParam('term');
        $nombre_i = $this->getRequest()->getParam('a_name');
        $lastName_i = $this->getRequest()->getParam('a_lastName');
        $email_i = $this->getRequest()->getParam('a_email');
        $phone_i = $this->getRequest()->getParam('a_phone');
        $mobile_i = $this->getRequest()->getParam('a_mobile');
        $sendNotifications_i = $this->getRequest()->getParam('a_sendNotifications');
        
        $internalContact[] = array(
        		'name'=>$nombre_i,
        		'lastName'=>$lastName_i,
        		'email'=>$email_i,
        		'phone'=>$phone_i,
        		'mobile'=>$mobile_i,
        		'sendNotifications'=>$sendNotifications_i,
        );
        
        $request = $this->getRequest();
        
        if ($request->isPost())
        {
        	//se guarda en data el array que modificara la info de el servidor
        	$data = array(
        			'id'=>$id, 
        			'name'=>$nombre,
        			'identification'=>$identification,
    				'email'=>$email,
    				'phonePrimary'=>$phonePrimary,
    				'phoneSecondary'=>$phoneSecondary,
    				'fax'=>$fax,
    				'mobile'=>$mobile,
    				'address'=>array(
    						'address'=>$address,
    						'city'=>$city,
    					),
        			//'term'=>$term,
    				'observations'=>$observations,    				
    				//'seller'=>$seller,    					
    					
    				'type'=>$type,
    				'priceList'=>$priceList,   					
    				'internalContacts'=>$internalContact,
        	);
        	$json_alegra = Zend_Json::encode($data);
        	$client = new Zend_Http_Client('https://app.alegra.com/api/v1/contacts/'.$id);
        	$client->setAuth('xxxxxxxxx', 'xxxxxx');
        	$client->setRawData($json_alegra, 'application/json');
        	$client->request('PUT');
        	//$this->view->response = $json_alegra; 
        	        	return $this->_helper->redirector('index'); 
        }
        
    }

    public function deleteAction()
    {
        // action body
        
    	$id = $this->getRequest()->getParam('id');
    	$client = new Zend_Http_Client('https://app.alegra.com/api/v1/contacts/'.$id);
    	$client->setAuth('xxxxx', 'xxxxxxxx');
    	$client->request('DELETE'); 
    	       
        return $this->_helper->redirector('index');
        
    }


}
