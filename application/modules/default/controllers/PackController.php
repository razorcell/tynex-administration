<?php

class PackController extends Zend_Controller_Action {
	private $config = NULL;
	private $db = NULL;
	public function init() {
		
		$this->config = new Zend_Config_Ini ( APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV );
		
		try {
			$this->db = Zend_Db::factory ( $this->config->database );
			$this->db->getConnection ();
		} catch ( Zend_Db_Adapter_Exception $e ) {
			echo $e->getMessage ();
		} catch ( Zend_Exception $e ) {
			echo $e->getMessage ();
		}
		$this->view->general_icon = 'ico color certificate';
	}
	public function indexAction() {
		$this->view->title = 'pack';
		
		$sql = 'SELECT * FROM pack_service';
		$this->view->list_packs = $this->db->fetchAssoc ( $sql );
	}
	public function addAction() {
		
		$this->view->general_icon = 'ico color add';
		$this->view->title = 'Ajouter un pack';
	
	}
	public function submitAction() {
		$table_reponse = array ('message' => '' );
		
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		$data_from_user = $this->_getAllParams ();
		
		if (! empty ( $data_from_user ['nom_pack'] )) {
			$data_to_save = array ('nom_pack' => $data_from_user ['nom_pack'] );
			try {
				$this->db->insert ( 'pack', $data_to_save );
				$table_reponse ['message'] = 'Le pack a été bien ajouter ';
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
		
		if (! empty ( $data_from_user ['nom_pack'] )) {
			$new_data = array ('nom_pack' => $data_from_user ['nom_pack'] );
			$id_pack = $data_from_user ['id_pack'];
			$condition = "id_pack = $id_pack";
			try {
				$this->db->update ( 'pack', $new_data, $condition );
				$table_reponse ['message'] = 'Le pack a été bien modifier';
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
		$this->view->title = 'Modifier une pack';
		
		$this->db->setFetchMode ( Zend_Db::FETCH_OBJ );
		$req_id = $this->getRequest ()->getParam ( 'id' );
		$id = $this->db->quote ( $req_id );
		$sql = "SELECT id_pack, nom_pack FROM pack WHERE id_pack = $id";
		$this->view->pack = $this->db->fetchRow ( $sql );
	
	}
	
	public function deleteAction() {
		$n_lignes_supprime = NULL;
		$table_reponse = array ('message' => '' );
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		$data_from_user = $this->_getAllParams ();
		$condition = 'id_pack = ' . $data_from_user ['id'];
		try {
			$n_lignes_supprime = $this->db->delete ( 'pack', $condition );
			$table_reponse ['message'] = 'L\'pack a été supprimer';
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
				$condition = 'id_pack = ' . $data_from_user [$indice];
				$this->db->delete ( 'pack', $condition );
			}
			$table_reponse ['message'] = 'Les packs ont été bien supprimés';
		
		} catch ( Zend_Db_Adapter_Exception $e ) {
			$table_reponse ['message'] = $e->getMessage ();
		}
		$json = Zend_Json::encode ( $table_reponse );
		echo $json;
	}

}



