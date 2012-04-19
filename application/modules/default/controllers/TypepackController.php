<?php

class TypepackController extends Zend_Controller_Action
{
    public function init()
    {
    	$this->view->general_icon = 'ico color point';
    }
    public function indexAction()
    {
        $this->view->title = 'Types des Packs';
    }
    public function addAction()
    {
    	$this->view->general_icon = 'ico color add';
    	$this->view->title = 'Ajouter un nouveau type de pack';
    }
    public function modifyAction()
    {//brush
    	$this->view->general_icon = 'ico color brush';
    	$this->view->title = 'Modifier un type de pack';
    }
    public function deleteAction()
    {
    	
    }

}

