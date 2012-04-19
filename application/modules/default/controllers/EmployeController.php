<?php

class EmployeController extends Zend_Controller_Action {
	public function init() {
		$this->view->general_icon = 'ico color administrator';
	}
	public function indexAction() {
		$this->view->title = 'Employés';
	}
	public function addAction() {
		$this->view->general_icon = 'ico color add';
		$this->view->title = 'Ajouter un employé';
	}
	public function modifyAction() { // brush
		$this->view->general_icon = 'ico color brush';
		$this->view->title = 'Modifier un employé';
	}
	public function deleteAction() {
	
	}
	public function profilAction() {
		$this->view->title = 'Profil';
		$this->view->general_icon = 'ico color clipboard';
	}
}

