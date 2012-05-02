<?php

class CommandeController extends Zend_Controller_Action {
	private $config = NULL;
	private $db = NULL;
	public function init() {
		$this->ctrl = $this->_request->getControllerName ();
		$this->view->ctrl = $this->ctrl;
		
		$this->writer = new Zend_Log_Writer_Stream(APPLICATION_PATH.'/../tests/logs');
		$this->logger = new Zend_Log($this->writer);
		
		
		$this->config = new Zend_Config_Ini ( APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV );
		try {
			$this->db = Zend_Db::factory ( $this->config->database );
			$this->db->getConnection ();
			$this->db->getProfiler()->setEnabled(true);
		} catch ( Zend_Db_Adapter_Exception $e ) {
			echo $e->getMessage ();
		} catch ( Zend_Exception $e ) {
			echo $e->getMessage ();
		}
		$this->view->general_icon = 'ico color certificate';
	}
	public function indexAction() {
		$this->action = $this->_request->getActionName ();
		$this->view->action = $this->action;
		$this->view->title = 'Commande';
		
		$sql = 'SELECT * FROM commande';
		$this->view->list_commandes = $this->db->fetchAssoc ( $sql );
		
		$sql = 'SELECT * FROM client';
		$this->view->list_clients = $this->db->fetchAssoc ( $sql );
	}
	public function addAction() {
		$this->action = $this->_request->getActionName ();
		$this->view->action = $this->action;
		
		$this->view->general_icon = 'ico color add';
		$this->view->title = 'Ajouter une commande';
		$sql = 'SELECT * FROM type_projet';
		$this->view->list_types_projets = $this->db->fetchAssoc ( $sql );
		$sql = 'SELECT * FROM type_service';
		$this->view->list_types_services = $this->db->fetchAssoc ( $sql );
		$sql = 'SELECT * FROM employe';
		$this->view->list_employes = $this->db->fetchAssoc ( $sql );
		$sql = 'SELECT * FROM client';
		$this->view->list_clients = $this->db->fetchAssoc ( $sql );
	
	}
	public function submitAction() {
		$table_reponse = array ('message' => '' );
		
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		// recupperation des valeurs entrer par l'utilisateur
		$request_body = $this->getRequest ()->getRawBody ();
		$this->logger->info ( 'Request body : ' . $request_body );
		$data_from_user = Zend_Json::decode ( $request_body );
		//chercher id_type_service
		$type_service_string = $data_from_user ['type_service'];
		$nom_commande = $data_from_user ['nom_commande'];
		$sql = 'SELECT * FROM type_service';
		$list_types_services = $this->db->fetchAssoc ( $sql );
		$type_service_id = NULL;
		foreach ($list_types_services as $type_service)
		{
			if($type_service['libelle_type_service'] == $type_service_string)
			{
				$type_service_id = $type_service['id_type_service'];
				$this->logger->info('id type service trouvé = '.$type_service_id);
			}
		}
		$data_to_save = array ('libelle_commande' => $nom_commande, 'id_type_service' => $type_service_id);
		try {
			$this->db->insert ( 'commande', $data_to_save );
			$table_reponse ['message'] = 'Le commande a été bien ajouter ';
		} catch ( Zend_Db_Adapter_Exception $e ) {
			echo $e->getMessage ();
		}
		$json = Zend_Json::encode ( $table_reponse );
		echo $json;
	}
	public function modifyAction() { // brush
		$table_reponse = array ('message' => '' );
		
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		// recupperation des valeurs entrer par l'utilisateur
		$request_body = $this->getRequest ()->getRawBody ();
		$this->logger->info ( 'Request body : ' . $request_body );
		$data_from_user = Zend_Json::decode ( $request_body );
		//chercher id_type_service
		$nom_commande = $data_from_user ['nom_commande'];
		$id_commande = $data_from_user['id'];
		$type_service_string = $data_from_user ['type_service'];
		
		$sql = 'SELECT * FROM type_service';
		$list_types_services = $this->db->fetchAssoc ( $sql );
		$type_service_id = NULL;
		foreach ($list_types_services as $type_service)
		{
			if($type_service['libelle_type_service'] == $type_service_string)
			{
				$type_service_id = $type_service['id_type_service'];
				$this->logger->info('id type service trouvé = '.$type_service_id);
			}
		}
		$data_to_save = array ('libelle_commande' => $nom_commande, 'id_type_service' => $type_service_id);
		try {
			$condition = "id_commande = $id_commande";
			$this->db->update ( 'commande', $data_to_save, $condition );
			$table_reponse ['message'] = 'Le commande a été bien modifier ';
		} catch ( Zend_Db_Adapter_Exception $e ) {
			echo $e->getMessage ();
		}
		$json = Zend_Json::encode ( $table_reponse );
		echo $json;
	}
	public function modifyformAction() {
		$this->action = $this->_request->getActionName ();
		$this->view->action = $this->action;
		$this->view->general_icon = 'ico color brush';
		$this->view->title = 'Modifier une commande';
		
		$this->db->setFetchMode ( Zend_Db::FETCH_OBJ );
		$req_id = $this->getRequest ()->getParam ( 'id' );
		$id = $this->db->quote ( $req_id );
		$sql = "SELECT * FROM commande WHERE id_commande = $id";
		$this->view->commande = $this->db->fetchRow ( $sql );
		$sql = "SELECT * FROM type_service";
		$this->view->list_types_services = $this->db->fetchAssoc ( $sql );
	
	}
	
	public function deleteAction() {
		$n_lignes_supprime = NULL;
		$table_reponse = array ('message' => '' );
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		$data_from_user = $this->_getAllParams ();
		$condition = 'id_commande = ' . $data_from_user ['id'];
		try {
			$n_lignes_supprime = $this->db->delete ( 'commande', $condition );
			$table_reponse ['message'] = 'L\'commande a été supprimer';
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
				$condition = 'id_commande = ' . $data_from_user [$indice];
				$this->db->delete ( 'commande', $condition );
			}
			$table_reponse ['message'] = 'Les commandes ont été bien supprimés';
		
		} catch ( Zend_Db_Adapter_Exception $e ) {
			$table_reponse ['message'] = $e->getMessage ();
		}
		$json = Zend_Json::encode ( $table_reponse );
		echo $json;
	}

}



