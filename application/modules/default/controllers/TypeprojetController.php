<?php

class TypeprojetController extends Zend_Controller_Action
{
    public function init()
    {
    	$this->view->general_icon = 'ico color stop';
    }
    public function indexAction()
    {
        $this->view->title = 'Types de projet';
    }
    public function addAction()
    {
    	$this->view->general_icon = 'ico color add';
    	$this->view->title = 'Ajouter un type de projet';
    }
    public function modifyAction()
    {//brush
    	$this->view->general_icon = 'ico color brush';
    	$this->view->title = 'Modifier un type de projet';
    }
    public function deleteAction()
    {
    	
    }

}

