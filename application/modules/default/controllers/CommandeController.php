<?php

class CommandeController extends Zend_Controller_Action {
	private $ctrl = null;
	private $action = null;
	
	public function init() {
		$this->view->general_icon = 'ico color administrator';
		$this->ctrl = $this->_request->getControllerName ();
		$this->view->ctrl = $this->ctrl;
	}
	public function indexAction() {
		// $this->view->title = 'Commande';
		
		$this->action = $this->_request->getActionName ();
		$this->view->action = $this->action;
	}
	public function addAction() {
		$this->view->general_icon = 'ico color add';
		$this->view->title = 'Ajouter une commande';
		
		$this->action = $this->_request->getActionName ();
		$this->view->action = $this->action;
	
	}
	public function modifyAction() { // brush
		$this->view->general_icon = 'ico color brush';
		$this->view->title = 'Modifier un employé';
		
		$this->action = $this->_request->getActionName ();
		$this->view->action = $this->action;
	}
	public function deleteAction() {
	
	}
	public function factureAction() {
		$this->_helper->layout()->disableLayout();
		$this->view->title = 'Profil';
		$this->view->general_icon = 'ico color clipboard';
		
		$this->action = $this->_request->getActionName ();
		$this->view->action = $this->action;
	}
}

