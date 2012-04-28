<?php

class ServiceController extends Zend_Controller_Action {
	private $config = NULL;
	private $db = NULL;
	private $writer = NULL;
	private $logger = NULL;
	public function init() {
		$this->ctrl = $this->_request->getControllerName ();
		$this->view->ctrl = $this->ctrl;
		
		$this->writer = new Zend_Log_Writer_Stream ( APPLICATION_PATH . '/../tests/logs' );
		$this->logger = new Zend_Log ( $this->writer );
		
		$this->logger->info ( 'Fonction init() executée' );
		
		$this->config = new Zend_Config_Ini ( APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV );
		try {
			$this->db = Zend_Db::factory ( $this->config->database );
			$this->db->getConnection ();
			$this->db->getProfiler ()->setEnabled ( true );
		
		} catch ( Zend_Db_Adapter_Exception $e ) {
			echo $e->getMessage ();
		} catch ( Zend_Exception $e ) {
			echo $e->getMessage ();
		}
		$this->view->general_icon = 'ico color stats_lines';
	}
	public function indexAction() {
		$this->action = $this->_request->getActionName ();
		$this->view->action = $this->action;
		$this->view->title = 'service';
		
		$sql = 'SELECT * FROM service';
		$this->view->list_services = $this->db->fetchAssoc ( $sql );
		$this->logger->info ( 'get all services : ' . $this->db->getProfiler ()->getLastQueryProfile ()->getQuery () );
		$this->db->getProfiler ()->setEnabled ( false );
	}
	public function addAction() {
		$this->logger->info ( ' service addAction() ' );
		$this->action = $this->_request->getActionName ();
		$this->view->action = $this->action;
		
		$this->view->general_icon = 'ico color add';
		$this->view->title = 'Ajouter un service';
		$sql = 'SELECT * FROM commande';
		$this->view->list_commandes = $this->db->fetchAssoc ( $sql );
		$sql = 'SELECT * FROM type_service';
		$this->view->list_types_services = $this->db->fetchAssoc ( $sql );
		$sql = 'SELECT * FROM pack';
		$this->view->list_packs = $this->db->fetchAssoc ( $sql );
		$sql = 'SELECT * FROM employe';
		$this->view->list_employes = $this->db->fetchAssoc ( $sql );
		$this->logger->info ( 'get all clients : ' . $this->db->getProfiler ()->getLastQueryProfile ()->getQuery () );
		$this->db->getProfiler ()->setEnabled ( false );
	
	}
	public function updatepackAction(){
		$this->_helper->layout->disableLayout (); 
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		$request_body = $this->getRequest ()->getRawBody ();
		$this->logger->info ( 'Request body : ' . $request_body );
		$data_from_user = Zend_Json::decode ( $request_body );
		$type_service_string = $data_from_user['type_service'];
		//get id_type_service
		if(!empty($type_service_string)){
			$sql = 'SELECT * FROM type_service';
			$list_types_services = $this->db->fetchAssoc ( $sql );
			$type_service_id = NULL;
			foreach($list_types_services as $type_service){
				if($type_service['libelle_type_service'] == $type_service_string){
					$type_service_id = $type_service['id_type_service'];
				}
			}
			$sql = "SELECT * FROM pack WHERE id_type_service = $type_service_id";
			$packs = $this->db->fetchAssoc ( $sql );
			$this->logger->info ( 'packs Assoc ' . html_entity_decode ( Zend_Debug::dump ( $packs, $label = null, $echo = false ), ENT_COMPAT, "utf-8" ) );
			
			$json = Zend_Json::encode($packs);
			$this->logger->info ($json);
			$this->db->getProfiler ()->setEnabled ( false );
			echo $json;
		}
		
	}
	public function submitAction() {
		$this->logger->info ( 'service submitAction()' );
		// stocker les messages d'erreur/succe pour les retourner à
		// l'utilisateur
		// $table_reponse = array ('message' => '');
		$reponse = '';
		
		$this->_helper->layout->disableLayout (); // on veut desactiver
		                                          // l'affichage par défault
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		// SOLUTION 1
		
		// recupperation des valeurs entrer par l'utilisateur
		$request_body = $this->getRequest ()->getRawBody ();
		$this->logger->info ( 'Request body : ' . $request_body );
		$data_from_user = Zend_Json::decode ( $request_body );
		// Activer cette ligne pour voir le resultat du decodage
		
		$this->logger->info ( 'Decoded data from user : ' . html_entity_decode ( Zend_Debug::dump ( $data_from_user, $label = null, $echo = false ), ENT_COMPAT, "utf-8" ) );
		$commande = $data_from_user ['commande'];
		$description = $data_from_user ['description'];
		$prix = $data_from_user ['prix'];
		$date_debut = $data_from_user ['date_debut'];
		$date_fin = $data_from_user ['date_fin'];
		$status = $data_from_user ['status'];
		
		// PHASE D INSERTION DE L service DANS LA TABLE 'service'
		
		$this->logger->info ( '*********************PHASE D INSERTION D UNE ENTREPRISE************' );
		
		// recupperation de la chaine de caractéres representant le gender
		$gender_string = NULL;
		if ($gender == 0) {
			$gender_string = 'Homme';
		} else {
			$gender_string = 'Femme';
		}
		// construire le tableau pour l'enregistrement de l'service
		$service_to_save = array ('nom' => $nom, 'prenom' => $prenom, 'tel' => $tel, 'tel_societe' => $tel_societe, 'fax' => $fax, 'email' => $email, 'adresse' => $adresse, 'type' => 'Entreprise', 'gender' => $gender_string, 'societe' => $societe, 'email_societe' => $email_societe );
		$this->logger->info ( 'service to save ' . html_entity_decode ( Zend_Debug::dump ( $service_to_save, $label = null, $echo = false ), ENT_COMPAT, "utf-8" ) );
		try {
			$this->db->insert ( 'service', $service_to_save );
			$this->logger->info ( 'inserer entreprise : ' . $this->db->getProfiler ()->getLastQueryProfile ()->getQuery () );
			$id_service_enregistrer = $this->db->lastInsertId ();
			$this->logger->info ( 'last inserted ID = ' . $id_service_enregistrer );
			$reponse = 'success';
			$this->logger->info ( 'insertion - entreprise - OUI' );
		} catch ( Zend_Db_Adapter_Exception $e ) {
			$reponse = 'Erreur';
			$this->logger->info ( 'Requete erreur : ' . $e->getMessage () );
		}
		// $json = Zend_Json::encode($table_reponse);
		$this->db->getProfiler ()->setEnabled ( false );
		echo $reponse;
	
	}
	public function modifyformAction() {
		$this->logger->info ( 'service modifyform()' );
		$this->view->general_icon = 'ico color brush';
		$this->view->title = 'Modifier un service';
		
		// $this->db->setFetchMode ( Zend_Db::FETCH_OBJ );
		$req_id = $this->getRequest ()->getParam ( 'id' );
		$id = $this->db->quote ( $req_id );
		
		// recupperation des infos de l'service stocker dans la table service
		
		$sql = "SELECT * FROM service WHERE id_service = $id";
		$service = $this->db->fetchRow ( $sql );
		$this->logger->info ( html_entity_decode ( Zend_Debug::dump ( $service, $label = null, $echo = false ), ENT_COMPAT, "utf-8" ) );
		// recupperation de la liste des poste pour la convertion id_poste =>
		// nom_poste
		$this->db->setFetchMode ( Zend_Db::FETCH_ASSOC );
		$this->view->service = $service;
		// si c'est une entreprise
		if ($service ['type'] == 'Entreprise') {
			
			$this->logger->info ( 'service = entreprise' );
			$this->render ( 'modifyformentreprise' );
		}
		if ($service ['type'] == 'Particulier') {
			
			$this->logger->info ( 'service = particulier' );
			$this->render ( 'modifyformparticulier' );
		}
		
		// $this->logger->info(html_entity_decode(Zend_Debug::dump($this->db->fetchAssoc
	// ( $sql ),$label = null,$echo = false), ENT_COMPAT, "utf-8"));
		
		// recupperation de la liste des occupations
		
		// recupperation des occupations de cette service
	
	}
	public function modifyAction() { // brush
		$this->logger->info ( 'service modifyAction()' );
		// stocker les messages d'erreur/succe pour les retourner à
		// l'utilisateur
		// $table_reponse = array ('message' => '');
		$reponse = '';
		
		$this->_helper->layout->disableLayout (); // on veut desactiver
		                                          // l'affichage par défault
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		// SOLUTION 1
		
		// recupperation des valeurs entrer par l'utilisateur
		$request_body = $this->getRequest ()->getRawBody ();
		$this->logger->info ( 'Request body : ' . $request_body );
		$data_from_user = Zend_Json::decode ( $request_body );
		// Activer cette ligne pour voir le resultat du decodage
		
		$this->logger->info ( 'Decoded data from user : ' . html_entity_decode ( Zend_Debug::dump ( $data_from_user, $label = null, $echo = false ), ENT_COMPAT, "utf-8" ) );
		$id = NULL;
		$nom = NULL;
		$prenom = NULL;
		$tel = NULL;
		$tel_societe = NULL;
		$fax = NULL;
		$email = NULL;
		$adresse = NULL;
		$gender = NULL;
		$societe = NULL;
		$email_societe = NULL;
		// si entreprise
		if ($data_from_user ['type'] == 'entreprise') {
			$id = $data_from_user ['id'];
			$nom = $data_from_user ['nom_r'];
			$prenom = $data_from_user ['prenom_r'];
			$gender = $data_from_user ['gender_r']; // !!!!!!!!!!!!!!!!!!!
			$email = $data_from_user ['email_r'];
			$tel = $data_from_user ['tel_r'];
			$societe = $data_from_user ['nom_e'];
			$email_societe = $data_from_user ['email_e'];
			$tel_societe = $data_from_user ['tel_e'];
			$fax = $data_from_user ['fax_e'];
			$adresse = $data_from_user ['adresse_e'];
			
			// PHASE D INSERTION DE L service DANS LA TABLE 'service'
			
			$this->logger->info ( '*********************PHASE DE MODIFICATION D UNE ENTREPRISE************' );
			
			// recupperation de la chaine de caractéres representant le gender
			$gender_string = NULL;
			if ($gender == 0) {
				$gender_string = 'Homme';
			} else {
				$gender_string = 'Femme';
			}
			// construire le tableau pour l'enregistrement de l'service
			$service_to_save = array ('nom' => $nom, 'prenom' => $prenom, 'tel' => $tel, 'tel_societe' => $tel_societe, 'fax' => $fax, 'email' => $email, 'adresse' => $adresse, 'type' => 'Entreprise', 'gender' => $gender_string, 'societe' => $societe, 'email_societe' => $email_societe );
			$this->logger->info ( 'New service data ' . html_entity_decode ( Zend_Debug::dump ( $service_to_save, $label = null, $echo = false ), ENT_COMPAT, "utf-8" ) );
			try {
				$condition = "id_service = $id";
				$this->logger->info ( 'service entreprise update condition : ' . $condition );
				$this->db->update ( 'service', $service_to_save, $condition );
				$this->logger->info ( 'mise à jour entreprise : ' . $this->db->getProfiler ()->getLastQueryProfile ()->getQuery () );
				
				$reponse = 'success';
				$this->logger->info ( 'mise à jour  - entreprise - OUI' );
			} catch ( Zend_Db_Adapter_Exception $e ) {
				$reponse = 'Erreur';
				$this->logger->info ( 'Requete erreur : ' . $e->getMessage () );
			}
		
		}
		// si particulier
		if ($data_from_user ['type'] == 'particulier') {
			$id = $data_from_user ['id'];
			$nom = $data_from_user ['nom_p'];
			$prenom = $data_from_user ['prenom_p'];
			$gender = $data_from_user ['gender_p'];
			$email = $data_from_user ['email_p'];
			$tel = $data_from_user ['tel_p'];
			
			// PHASE D INSERTION DE L service DANS LA TABLE 'service'
			
			$this->logger->info ( '*********************PHASE DE MODIFICATION D UN PARTICULIER************' );
			
			// recupperation de la chaine de caractéres representant le gender
			$gender_string = NULL;
			if ($gender == 0) {
				$gender_string = 'Homme';
			} else {
				$gender_string = 'Femme';
			}
			// construire le tableau pour l'enregistrement de l'service
			$service_to_save = array ('nom' => $nom, 'prenom' => $prenom, 'tel' => $tel, 'tel_societe' => '', 'fax' => '', 'email' => $email, 'adresse' => '', 'type' => 'Particulier', 'gender' => $gender_string, 'societe' => '', 'email_societe' => '' );
			$this->logger->info ( 'service to save ' . html_entity_decode ( Zend_Debug::dump ( $service_to_save, $label = null, $echo = false ), ENT_COMPAT, "utf-8" ) );
			try {
				
				$condition = "id_service = $id";
				$this->logger->info ( 'service particulier update condition : ' . $condition );
				$this->db->update ( 'service', $service_to_save, $condition );
				$this->logger->info ( 'mise à jour entreprise : ' . $this->db->getProfiler ()->getLastQueryProfile ()->getQuery () );
				
				$reponse = 'success';
				$this->logger->info ( 'mise à jour  - particulier - OUI' );
			} catch ( Zend_Db_Adapter_Exception $e ) {
				$reponse = 'Erreur';
				$this->logger->info ( 'Requete erreur : ' . $e->getMessage () );
			}
		
		}
		// $json = Zend_Json::encode($table_reponse);
		$this->db->getProfiler ()->setEnabled ( false );
		echo $reponse;
	}
	
	public function deleteAction() {
		$n_lignes_supprime = NULL;
		$table_reponse = array ('message' => '' );
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		$data_from_user = $this->_getAllParams ();
		$condition = 'id_service = ' . $data_from_user ['id'];
		
		try {
			$n_lignes_supprime = $this->db->delete ( 'service', $condition );
			$table_reponse ['message'] = 'Le service a été supprimer';
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
				$condition = 'id_service = ' . $data_from_user [$indice];
				$this->db->delete ( 'service', $condition );
			}
			$table_reponse ['message'] = 'Les services ont été bien supprimés';
		
		} catch ( Zend_Db_Adapter_Exception $e ) {
			$table_reponse ['message'] = $e->getMessage ();
		}
		$json = Zend_Json::encode ( $table_reponse );
		echo $json;
	}

}





