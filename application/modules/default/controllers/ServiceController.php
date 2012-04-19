<?php

class ServiceController extends Zend_Controller_Action {
	public function init() {
		
	}
	public function indexAction() {
		$this->view->general_icon = 'ico color location';
		$this->view->title = 'Services';
	}
	public function addAction() {
		$this->view->general_icon = 'ico color add';
		$this->view->title = 'Ajouter un service';
	}
	public function modifyAction() { // brush
		$this->view->general_icon = 'ico color brush';
		$this->view->title = 'Modifier un service';
	}
	public function deleteAction() {
	
	}
	public function profilAction() {
		$this->view->title = 'Plus de details';
		$this->view->general_icon = 'ico color clipboard';
	}
}

