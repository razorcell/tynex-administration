<?php

class IndexController extends Zend_Controller_Action {
	
	public function init() {
		$this->view->general_icon = 'ico color home';
		$this->view->title = 'Adminisatration de Tynex Media';
		/*
		 * //connect to the database try {$db =
		 * Zend_db::factory('Pdo_Mysql',array( 'host' => '127.0.0.1', 'username'
		 * => 'root', 'password' => '', 'dbname' => 'tynexADMIN' )); }catch
		 * (Zend_Db_Adapter_Exception $e) { echo $e->getMessage();
		 * }catch(Zend_Exception $e) { echo $e->getMessage(); } $sql = 'SELECT *
		 * FROM clients'; $this->view->list_clients = $db->fetchAssoc($sql);
		 */
	}
	
	public function indexAction() {
		// action body
		//$this->view->message = 'The service N° 12 is going to expire in 14 days';
	}

}

