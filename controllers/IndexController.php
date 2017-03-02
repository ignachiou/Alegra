<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        //$client = new Zend_Rest_Client('https://app.alegra.com/api/v1/contacts/');
        
    	$tab_contacto= new Application_Model_DbTable_Alexa();
    	
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
    	$this->view->contactos = $tab_contacto->fetchAll();
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
    			$data = array('nombre'=>$form_contac->getValue('nombre_contacto') );
    			$tab_contacto= new Application_Model_DbTable_Alexa();
    			$tab_contacto->insert($data);
    			$form_contac->reset();
    		}
    	}
    	$this->_helper->redirector('index');
    }

    public function editAction()
    {
        // action body
        $id = $this->getRequest()->getParam('id');
        $tab_contacto = new Application_Model_DbTable_Alexa();
        $contacto = $tab_contacto->find($id)->current();
        $this->view->form = new Application_Form_Alegraform();
        $this->view->form->populate($contacto->toArray());
        $this->view->form->setAction($this->view->
          url(array('controller'=>'index','action'=>'update','id'=>$id,'nombre'=>$contacto['nombre'])));
    }

    public function updateAction()
    {
        // action body
        $id = $this->getRequest()->getParam('id');
        $nombre = $this->getRequest()->getParam('nombre_contacto');
        $tab_contacto = new Application_Model_DbTable_Alexa();
        $contacto = $tab_contacto->find($id)->current();
        $request = $this->getRequest();
        if ($request->isPost())
        {
        	//se guarda en data el array que modificara la info en la BD
        	$data = array('id'=>$id, 'nombre'=>$nombre);
        	$contacto->setFromArray($data);
        	$contacto->save();
        	
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
    	
    	
       /* $id = $this->getRequest()->getParam('id');
        $tab_contacto = new Application_Model_DbTable_Alexa();
        $contacto = $tab_contacto->find($id)->current();
        $contacto->delete();*/
        
        return $this->_helper->redirector('index');
        
    }


}













