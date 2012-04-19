<?php

class TypeserviceController extends Zend_Controller_Action
{
    public function init()
    {
    	$this->view->general_icon = 'ico color coin';
    }
    public function indexAction()
    {
        $this->view->title = 'Types des Services';
    }
    public function addAction()
    {
    	$this->view->general_icon = 'ico color add';
    	$this->view->title = 'Ajouter un nouveau type de service';
    }
    public function modifyAction()
    {//brush
    	$this->view->general_icon = 'ico color brush';
    	$this->view->title = 'Modifier un type de service';
    }
    public function deleteAction()
    {
    	
    }

}

