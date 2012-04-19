<?php

class ProjectController extends Zend_Controller_Action {
	public function init() {
		
	}
	public function indexAction() {
		$this->view->general_icon = 'ico color stats_lines';
		$this->view->title = 'Employés';
	}
	public function addAction() {
		$this->view->general_icon = 'ico color add';
		$this->view->title = 'Ajouter un projet';
	}
	public function modifyAction() { // brush
		$this->view->general_icon = 'ico color brush';
		$this->view->title = 'Modifier un employé';
	}
	public function deleteAction() {
	
	}
	public function profilAction() {
		$this->view->title = 'Plus de details';
		$this->view->general_icon = 'ico color clipboard';
	}
}

