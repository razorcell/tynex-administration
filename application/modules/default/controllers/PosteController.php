<?php

class PosteController extends Zend_Controller_Action
{
    public function init()
    {
    	$this->view->general_icon = 'ico color certificate';
    }
    public function indexAction()
    {
        $this->view->title = 'Poste';
    }
    public function addAction()
    {
    	$this->view->general_icon = 'ico color add';
    	$this->view->title = 'Ajouter un poste';
    }
    public function modifyAction()
    {//brush
    	$this->view->general_icon = 'ico color brush';
    	$this->view->title = 'Modifier un poste';
    }
    public function deleteAction()
    {
    	
    }
}

