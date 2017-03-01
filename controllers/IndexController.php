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
    	$tab_animal= new Application_Model_DbTable_Alexa();
    	$this->view->contactos = $tab_animal->fetchAll();
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
        $tab_contacto = new Application_Model_DbTable_Alexa();
        $contacto = $tab_contacto->find($id)->current();
        $contacto->delete();
        
        return $this->_helper->redirector('index');
        
    }


}













