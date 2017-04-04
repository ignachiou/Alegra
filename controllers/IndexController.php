<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
    }

    public function showformAction()
    {
        
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
    	$this->_helper->redirector('index');
    }

    public function editAction()
    {
    	
        
    
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
        		//$this->view->response = $json_alegra;
        	}
        }
        $this->_helper->redirector('index');
        
    }

    public function deleteAction()
    {
        // action body
        
    	$id = $this->getRequest()->getParam('id');
    	$client = new Zend_Http_Client('https://app.alegra.com/api/v1/contacts/'.$id);
    	$client->setAuth('ignacio_salvatierra@hotmail.com', '4e974924c2a0c3f545c0');
    	$client->request('DELETE'); 
    	       
        return $this->_helper->redirector('index');
        
    }


}
