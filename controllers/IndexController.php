<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	$this->view->title = "Alegra. Software Contable y de Facturacion para Pymes";
    }

    public function showcontactAction()
    {
    	// action body
    	$this->view->title = "Contactos";
    }

    public function showformAction()
    {
    	$this->view->title = "Crear Contacto";
    }

    public function createformAction()
    {
    	// action body
    	    	
    	$request=$this->getRequest();
    	if ($request->isPost())
    	{
    		if ($request->getPost() )
    		{ 
    			
    			$data= $request->getPost();
    			
    			$city = $data["city"];
    			$address1 = $data["address"];
    			$address2 = array(
    						'address' => $address1,
    						'city' => $city,    					
    			);
    			
    			$data['address'] = $address2;     			
    			$json_alegra = Zend_Json::encode($data);
    			$client = new Zend_Http_Client('https://app.alegra.com/api/v1/contacts/'); 
    			$client->setAuth('ignacio_salvatierra@hotmail.com', '4e974924c2a0c3f545c0');
    			//Se le dice al header que es una app/json y se le pasa el parametro
    			$client->setRawData($json_alegra, 'application/json');
    			$client->request('POST'); 
    			//$this->view->response = $json_alegra;  		
    		}
    	}
    	$this->_helper->redirector('showcontact');
    }

    public function editAction()
    {
    	
    	$this->view->title = "Editar Contacto";
    
    }

    public function updateAction()
    {
        
    	$id = $this->getRequest()->getParam('id');
        $request=$this->getRequest();
        if ($request->isPost())
        {
        	//$form_contac = new Application_Form_Alegraform();
        	if ($request->getPost() )
        	{
        		 
        		$data= $request->getPost();
        		 
        		$city = $data["city"];
        		$address1 = $data["addresss"];
        		$address2 = array(
        				'address' => $address1,
        				'city' => $city,
        		);
        		 
        		$data['address'] = $address2;
        		
        		$json_alegra = Zend_Json::encode($data);
        		$client = new Zend_Http_Client('https://app.alegra.com/api/v1/contacts/'.$id);
        		$client->setAuth('ignacio_salvatierra@hotmail.com', '4e974924c2a0c3f545c0');
        		//Se le dice al header que es una app/json y se le pasa el parametro
        		$client->setRawData($json_alegra, 'application/json');
        		$client->request('PUT');
        		//$this->view->response = $data;
        	}
        }
        $this->_helper->redirector('showcontact');
        
    }

    public function deleteAction()
    {
        // action body
        
    	$id = $this->getRequest()->getParam('id');
    	$client = new Zend_Http_Client('https://app.alegra.com/api/v1/contacts/'.$id);
    	$client->setAuth('ignacio_salvatierra@hotmail.com', '4e974924c2a0c3f545c0');
    	$client->request('DELETE'); 
    	       
        return $this->_helper->redirector('showcontact');
        
    }

    public function viewAction()
    {
        // action body
        
    	$id = $this->getRequest()->getParam('id');
    	$client = new Zend_Http_Client('https://app.alegra.com/api/v1/contacts/'.$id);
    	$client->setAuth('ignacio_salvatierra@hotmail.com', '4e974924c2a0c3f545c0');
    	//se solicita un request con los parametros que se estan pasando en client
    	$a = $client->request('GET');
    	$b = strstr($a, '{"id');
    	$json_alegra = substr($b,0, -5);
    	//Se pasa pasa de json a array
    	$phpNative = Zend_Json::decode($json_alegra); //$phpNative = json_decode($json_alegra, true);
    	$name = $phpNative['name'];
    	
    	//se envia a la vista
    	$this->view->response = $phpNative;
    	$this->view->title = $name;
    	
    }

    public function infoAction()
    {
        $this->view->title = "Nosotros Alegra";
    }

    public function facturaAction()
    {
        $this->view->title = "Info facturas";
    }

    public function bancoAction()
    {
        $this->view->title = "Info crear banco";
    }

    public function importarAction()
    {
        $this->view->title = "Importar contactos";
    }

    public function remodelacionAction()
    {
        $this->view->title = "En construccion";
    }


}














