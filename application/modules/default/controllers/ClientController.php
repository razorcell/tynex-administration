<?php

class ClientController extends Zend_Controller_Action {
	private $config = NULL;
	private $db = NULL;
	private $writer = NULL;
	private $logger = NULL;
	public function init() {
		$this->ctrl = $this->_request->getControllerName ();
		$this->view->ctrl = $this->ctrl;
		
		$this->writer = new Zend_Log_Writer_Stream(APPLICATION_PATH.'/../tests/logs');
		$this->logger = new Zend_Log($this->writer);
		 
		$this->logger->info('Fonction init() executée');
		
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
		$this->view->general_icon = 'ico color administrator';
	}
	public function indexAction() {
		$this->action = $this->_request->getActionName ();
		$this->view->action = $this->action;
		$this->view->title = 'client';
		
		$sql = 'SELECT * FROM client';
		$this->view->list_clients = $this->db->fetchAssoc ( $sql );
	}
	public function addAction() {
		$this->action = $this->_request->getActionName ();
		$this->view->action = $this->action;
		
		$this->view->general_icon = 'ico color add';
		$this->view->title = 'Ajouter un client';
		$sql = 'SELECT * FROM poste';
		$this->view->list_postes = $this->db->fetchAssoc ( $sql );
		$sql = 'SELECT * FROM occupation';
		$this->view->list_occupations = $this->db->fetchAssoc ( $sql );
	
	}
	public function submitAction() {
		$this->logger->info('submitAction()');
		//stocker les messages d'erreur/succe pour les retourner à l'utilisateur
		//$table_reponse = array ('message' => '');
		$reponse = '';
		$id_client_enregistrer = NULL;//on va l'utiliser pour se rappeller de l'id de l'client enregistrer dans la BD
		
		$this->_helper->layout->disableLayout ();//on veut desactiver l'affichage par défault
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		//SOLUTION 1
		
		//recupperation des valeurs entrer par l'utilisateur
		$request_body = $this->getRequest()->getRawBody();
		$this->logger->info('Request body : '.$request_body);
		$data_from_user = Zend_Json::decode($request_body);
		//Activer cette ligne pour voir le resultat du decodage
		
		$this->logger->info(html_entity_decode(Zend_Debug::dump($data_from_user,$label = null,$echo = false), ENT_COMPAT, "utf-8"));
		$nom;
		$prenom;
		$tel;
		$tel_societe;
		$fax;
		$email;
		$adresse;
		$gender;
		$societe;
		$email_societe;
		
		
		if($data_from_user['type'] == 'particulier'){
			$nom = $data_from_user ['nom_p'];
			$prenom = $data_from_user ['prenom_p'];
			$gender = $data_from_user ['gender_p'];
			$email = $data_from_user ['email_p'];
			$tel = $data_from_user ['tel_p'];
			
			//PHASE D INSERTION DE L client DANS LA TABLE 'client'
			
			$this->logger->info('*********************PHASE D INSERTION Du client************');
			
			//recupperation de la chaine de caractéres representant le gender
			$gender_string = NULL;
			if($data_from_user ['gender'] == 0)
			{
				$gender_string = 'Homme';
			}
			else{
				$gender_string = 'Femme';
			}
			//construire le tableau pour l'enregistrement de l'client
			$client_to_save = array (
					'nom' => $nom,
					'prenom' => $prenom,
					'gender' => $gender_string,
					'tel' => $tel,
					'tel_societe' => '',
					'fax' => '',
					'email' => $email,
					'adresse' => '',
					'societe' => '',
					'email_societe' => '',		
					'type' => 'Particulier',
			);
			$this->logger->info(html_entity_decode(Zend_Debug::dump($client_to_save,$label = null,$echo = false), ENT_COMPAT, "utf-8"));
			try {
				$this->db->insert ( 'client', $client_to_save );
				$this->logger->info('update query : '.$this->db->getProfiler()->getLastQueryProfile()->getQuery());
				$id_client_enregistrer = $this->db->lastInsertId();
				$this->logger->info('last inserted ID = '.$id_client_enregistrer);
				$reponse = 'success';
				$this->logger->info('insertion - particulier - OUI');
			} catch ( Zend_Db_Adapter_Exception $e ) {
				$reponse= 'Erreur';
				$this->logger->info('Requete erreur : '.$e->getMessage());
			}
			
		}
		
		
		
		
		//$json = Zend_Json::encode($table_reponse);
		echo $reponse;
		$this->db->getProfiler()->setEnabled(false);
	}
	public function modifyAction() { // brush
		$this->logger->info('modifyAction()');
		//stocker les messages d'erreur/succe pour les retourner à l'utilisateur
		//$table_reponse = array ('message' => '');
		$reponse = '';
		$id_client_enregistrer = NULL;//on va l'utiliser pour se rappeller de l'id de l'client enregistrer dans la BD
		
		$this->_helper->layout->disableLayout ();//on veut desactiver l'affichage par défault
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		//SOLUTION 1
		
		//recupperation des valeurs entrer par l'utilisateur
		$request_body = $this->getRequest()->getRawBody();
		$this->logger->info('Request body : '.$request_body);
		$data_from_user = Zend_Json::decode($request_body);
		//Activer cette ligne pour voir le resultat du decodage
		//$this->logger->info(Zend_Debug::dump($data_from_user));
		
		$id = $data_from_user ['id'];
		$nom = $data_from_user ['nom'];
		$prenom = $data_from_user ['prenom'];
		$gender = $data_from_user ['gender'];
		$email = $data_from_user ['email'];
		$adress = $data_from_user ['adresse'];
		$tel = $data_from_user ['tel'];
		$username = $data_from_user ['username'];
		$password = $data_from_user ['password'];
		$client_poste_string = $data_from_user ['poste'];
		
		
		//PHASE DE MISE A JOUR DE L client DANS LA TABLE 'client'
		$this->logger->info('*********************PHASE DE MISE A JOUR DE L client************');
		//recupperation de id_poste equivalent au nom du poste de l'client
		
		$sql = 'SELECT * FROM poste';
		$list_postes = $this->db->fetchAssoc ( $sql );
		$poste_id = NULL;
		foreach ($list_postes as $poste)
		{
			if($poste['nom_poste'] == $client_poste_string)
			{
				$poste_id = $poste['id_poste'];
				$this->logger->info('id poste trouvé = '.$poste_id);
			}
		}
		//recupperation de la chaine de caractéres representant le gender
		$gender_string = NULL;
		if($data_from_user ['gender'] == 0)
		{
			$gender_string = 'Homme';
		}
		else{
			$gender_string = 'Femme';
		}
		//construire le tableau pour la mise a jour enregistrement de l'client 
		$client_to_save = array (
				'nom' => $nom,
				'prenom' => $prenom,
				'genre' => $gender_string,
				'username' => $username,
				'password' => $password,
				'tel' => $tel,
				'email' => $email,
				'adresse' => $adress,
				'id_poste' => $poste_id
		);
		$this->logger->info(html_entity_decode(Zend_Debug::dump($client_to_save,$label = null,$echo = false), ENT_COMPAT, "utf-8"));
		try {
			$condition = "id_client = $id";
			$this->logger->info('client update condition : '.$condition);
			$n = $this->db->update ( 'client', $client_to_save, $condition);
			
			$this->logger->info('update query : '.$this->db->getProfiler()->getLastQueryProfile()->getQuery());
			
			
			//$id_client_enregistrer = $this->db->lastInsertId();
			$this->logger->info('nbr de lignes  = '.$n);
			$reponse = 'success';
			$this->logger->info('MISE A JOUR - client - OUI');
		} catch ( Zend_Db_Adapter_Exception $e ) {
			$reponse= 'Erreur';
			$this->logger->info('Requete erreur : '.$e->getMessage());			
		}
		
		//PHASE D INSERTION DES TUPLES id_employ | id_occupation DANS LA TABLE 'OCCUPER'
		if(isset($data_from_user ['occupations'])){
				$this->logger->info('*****************PHASE DE SUPPRESSION DES TUPLES id_employ | id_occupation existant************');
				$condition = "id_client = $id";
				$this->logger->info('Occuper delete condition : '.$condition);
				$this->db->delete('occuper', $condition);
				$this->logger->info('update query : '.$this->db->getProfiler()->getLastQueryProfile()->getQuery());
				
				$this->logger->info('*****************PHASE D INSERTION DES TUPLES id_employ | id_occupation************');
				//recupperer la liste des occupation
				$sql = 'SELECT * FROM occupation';
				$list_occupations = $this->db->fetchAssoc ( $sql );
				
				foreach($data_from_user ['occupations'] as $table_occupation)// !!!!!!!!!!!!!!!!!! $data_from_user ['occupations'] : Tableau des tableaux des occupations
				{//itterrer dans le champs des occupations de l'client
				foreach ($table_occupation as $occupation){//$table_occupation : tableau des occupations
					//itterer dans tous les occupations de l'client
					foreach ($list_occupations as $occupation_from_db)
					{//itterer dans les occupation de la BD
						if($occupation_from_db['nom_occup'] == $occupation)// !!!!!!!!!!!!!!!!!!
						{//l'client a cette occupation, on cherche id_occup equivalent et on insert dans la BD
							$id_occup_courant = $occupation_from_db['id_occup'];
							//construire le tableau pour l'enregistrement du tuple id_client | id_occup
							$tuple_client_occup = array('id_client' => $id,
									'id_occup' => $id_occup_courant);
							try {
								$this->logger->info(html_entity_decode(Zend_Debug::dump($tuple_client_occup,$label = null,$echo = false), ENT_COMPAT, "utf-8"));
								$this->db->insert ( 'occuper', $tuple_client_occup );
								$this->logger->info('MISE A JOUR - OCCUPER - OUI');
								$reponse = 'success';
							} catch ( Zend_Db_Adapter_Exception $e ) {
								$this->logger->info($e->getMessage ());
							}
						}
					}
				}
			}
			
			
		}
		$this->db->getProfiler()->setEnabled(false);
		//$json = Zend_Json::encode($table_reponse);
		echo $reponse;
	}
	public function modifyformAction() {
		$this->view->general_icon = 'ico color brush';
		$this->view->title = 'Modifier un client';
		
		$this->db->setFetchMode ( Zend_Db::FETCH_OBJ );
		$req_id = $this->getRequest ()->getParam ( 'id' );
		$id = $this->db->quote ( $req_id );
		
		//recupperation des infos de l'client stocker dans la table client
		
		$sql = "SELECT * FROM client WHERE id_client = $id";
		$this->view->client = $this->db->fetchRow ( $sql );
		//recupperation de la liste des poste pour la convertion id_poste => nom_poste
		$this->db->setFetchMode ( Zend_Db::FETCH_ASSOC );
		$sql = 'SELECT * FROM poste';
		$this->view->list_postes = $this->db->fetchAssoc ( $sql );
		//$this->logger->info(html_entity_decode(Zend_Debug::dump($this->db->fetchAssoc ( $sql ),$label = null,$echo = false), ENT_COMPAT, "utf-8"));
		
		//recupperation de la liste des occupations
		$sql = 'SELECT * FROM occupation';
		$this->view->list_occupations = $this->db->fetchAssoc ( $sql );
		//recupperation des occupations de cette client
		$sql = "SELECT * FROM occuper WHERE id_client = $id";
		$this->view->client_occupations = $this->db->fetchAll ( $sql );
		$this->logger->info(html_entity_decode(Zend_Debug::dump($this->db->fetchAll ( $sql ),$label = null,$echo = false), ENT_COMPAT, "utf-8"));
	}
	public function deleteAction() {
		$n_lignes_supprime = NULL;
		$table_reponse = array ('message' => '' );
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		$data_from_user = $this->_getAllParams ();
		$condition = 'id_client = ' . $data_from_user ['id'];
	
		try {
			$n_lignes_supprime = $this->db->delete ( 'client', $condition );
			$table_reponse ['message'] = 'Le client a été supprimer';
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
				$condition = 'id_client = ' . $data_from_user [$indice];
				$this->db->delete ( 'client', $condition );
			}
			$table_reponse ['message'] = 'Les clients ont été bien supprimés';
		
		} catch ( Zend_Db_Adapter_Exception $e ) {
			$table_reponse ['message'] = $e->getMessage ();
		}
		$json = Zend_Json::encode ( $table_reponse );
		echo $json;
	}

}



