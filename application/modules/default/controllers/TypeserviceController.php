<?php

class TypeserviceController extends Zend_Controller_Action {
	private $config = NULL;
	private $db = NULL;
	private $writer = NULL;
	private $logger = NULL;
	public function init() {
		$this->writer = new Zend_Log_Writer_Stream(APPLICATION_PATH.'/../tests/logs');
		$this->logger = new Zend_Log($this->writer);
		
		$this->config = new Zend_Config_Ini ( APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV );
		
		try {
			$this->db = Zend_Db::factory ( $this->config->database );
			$this->db->getConnection ();
		} catch ( Zend_Db_Adapter_Exception $e ) {
			echo $e->getMessage ();
		} catch ( Zend_Exception $e ) {
			echo $e->getMessage ();
		}
		$this->view->general_icon = 'ico color coin';
	}
	public function indexAction() {
		$this->view->title = 'typeservice';
		
		$sql = 'SELECT * FROM type_service';
		$this->view->list_typeservices = $this->db->fetchAssoc ( $sql );
	}
	public function addAction() {
		
		$this->view->general_icon = 'ico color add';
		$this->view->title = 'Ajouter un typeservice';
	
	}
	public function submitAction() {
		$this->logger->info('typeservice : submitAction()');
		$table_reponse = array ('message' => '' );
		
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		$data_from_user = $this->_getAllParams ();
		
		
		if (! empty ( $data_from_user ['libelle_typeservice'] )) {
			$data_to_save = array ('libelle_type_service' => $data_from_user ['libelle_typeservice'] );
			$this->logger->info(html_entity_decode(Zend_Debug::dump($data_to_save,$label = null,$echo = false), ENT_COMPAT, "utf-8"));
			try {
				$this->db->insert ( 'type_service', $data_to_save );
				$this->logger->info('update query : '.$this->db->getProfiler()->getLastQueryProfile()->getQuery());
				$this->logger->info('type de service ajouter : OUI');
				$table_reponse ['message'] = 'Le type de service a été bien ajouter ';
			} catch ( Zend_Db_Adapter_Exception $e ) {
				echo $e->getMessage ();
			}
		} else {
			$table_reponse ['message'] = 'erreur';
		}
		$json = Zend_Json::encode ( $table_reponse );
		echo $json;
	}
	public function modifyAction() { // brush
		$table_reponse = array ('message' => '' );
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		$data_from_user = $this->_getAllParams ();
		
		if (! empty ( $data_from_user ['nom_typeservice'] )) {
			$new_data = array ('nom_typeservice' => $data_from_user ['nom_typeservice'] );
			$id_typeservice = $data_from_user ['id_typeservice'];
			$condition = "id_typeservice = $id_typeservice";
			try {
				$this->db->update ( 'typeservice', $new_data, $condition );
				$table_reponse ['message'] = 'Le typeservice a été bien modifier';
			} catch ( Zend_Db_Adapter_Exception $e ) {
				echo $e->getMessage ();
			}
		} else {
			$table_reponse ['message'] = 'erreur';
		}
		$json = Zend_Json::encode ( $table_reponse );
		echo $json;
	}
	public function modifyformAction() {
		$this->view->general_icon = 'ico color brush';
		$this->view->title = 'Modifier une typeservice';
		
		$this->db->setFetchMode ( Zend_Db::FETCH_OBJ );
		$req_id = $this->getRequest ()->getParam ( 'id' );
		$id = $this->db->quote ( $req_id );
		$sql = "SELECT id_typeservice, nom_typeservice FROM typeservice WHERE id_typeservice = $id";
		$this->view->typeservice = $this->db->fetchRow ( $sql );
	
	}
	
	public function deleteAction() {
		$n_lignes_supprime = NULL;
		$table_reponse = array ('message' => '' );
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		$data_from_user = $this->_getAllParams ();
		$condition = 'id_typeservice = ' . $data_from_user ['id'];
		try {
			$n_lignes_supprime = $this->db->delete ( 'typeservice', $condition );
			$table_reponse ['message'] = 'L\'typeservice a été supprimer';
			$table_reponse ['n_lignes_supprime'] = $n_lignes_supprime;
		} catch ( Zend_Db_Adapter_Exception $e ) {
			$table_reponse ['message'] = $e->getMessage ();
		}
		$json = Zend_Json::encode ( $table_reponse );
		echo $json;
	}
	public function deleteallAction() {
		$n_lignes_supprime = NULL;
		$table_reponse = array ('message' => '' );
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		$data_from_user = $this->_getAllParams ();
		$taille = $data_from_user ['taille'];
		try {
			for($i = 0; $i < $taille; $i ++) {
				$indice = 'id' . $i;
				$condition = 'id_typeservice = ' . $data_from_user [$indice];
				$this->db->delete ( 'typeservice', $condition );
			}
			$table_reponse ['message'] = 'Les typeservices ont été bien supprimés';
		
		} catch ( Zend_Db_Adapter_Exception $e ) {
			$table_reponse ['message'] = $e->getMessage ();
		}
		$json = Zend_Json::encode ( $table_reponse );
		echo $json;
	}

}



