<?php

class EmployeController extends Zend_Controller_Action {
	private $config = NULL;
	private $db = NULL;
	private $writer = NULL;
	private $logger = NULL;
	public function init() {
		$this->writer = new Zend_Log_Writer_Stream(APPLICATION_PATH.'/../tests/logs');
		$this->logger = new Zend_Log($this->writer);
		 
		$this->logger->info('Fonction init() executée');
		
		$this->config = new Zend_Config_Ini ( APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV );
		try {
			$this->db = Zend_Db::factory ( $this->config->database );
			$this->db->getConnection ();
		} catch ( Zend_Db_Adapter_Exception $e ) {
			echo $e->getMessage ();
		} catch ( Zend_Exception $e ) {
			echo $e->getMessage ();
		}
		$this->view->general_icon = 'ico color administrator';
	}
	public function indexAction() {
		$this->view->title = 'employe';
		
		$sql = 'SELECT * FROM employe';
		$this->view->list_employes = $this->db->fetchAssoc ( $sql );
		$sql = 'SELECT * FROM poste';
		$this->view->list_postes = $this->db->fetchAssoc ( $sql );
	}
	public function addAction() {
		$this->view->general_icon = 'ico color add';
		$this->view->title = 'Ajouter un employe';
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
		$id_employe_enregistrer = NULL;//on va l'utiliser pour se rappeller de l'id de l'employe enregistrer dans la BD
		
		$this->_helper->layout->disableLayout ();//on veut desactiver l'affichage par défault
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		//SOLUTION 1
		
		//recupperation des valeurs entrer par l'utilisateur
		$request_body = $this->getRequest()->getRawBody();
		$this->logger->info('Request body : '.$request_body);
		$data_from_user = Zend_Json::decode($request_body);
		//Activer cette ligne pour voir le resultat du decodage
		//$this->logger->info(Zend_Debug::dump($data_from_user));
		foreach ($data_from_user['occupations'] as $occupation)
		{
			foreach ($occupation as $nom_occupation)
			{
				$this->logger->info($nom_occupation);
			}
		}
		$nom = $data_from_user ['nom'];
		$prenom = $data_from_user ['prenom'];
		$gender = $data_from_user ['gender'];
		$email = $data_from_user ['email'];
		$adress = $data_from_user ['adresse'];
		$tel = $data_from_user ['tel'];
		$username = $data_from_user ['username'];
		$password = $data_from_user ['password'];
		$employe_poste_string = $data_from_user ['poste'];
		
		
		//PHASE D INSERTION DE L EMPLOYE DANS LA TABLE 'employe'
		//recupperation de id_poste equivalent au nom du poste de l'employe
		$this->logger->info('*********************PHASE D INSERTION DE L EMPLOYE************');
		$sql = 'SELECT * FROM poste';
		$list_postes = $this->db->fetchAssoc ( $sql );
		$poste_id = NULL;
		foreach ($list_postes as $poste)
		{
			if($poste['nom_poste'] == $employe_poste_string)
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
		//construire le tableau pour l'enregistrement de l'employe 
		$employe_to_save = array (
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
		$this->logger->info(html_entity_decode(Zend_Debug::dump($employe_to_save,$label = null,$echo = false), ENT_COMPAT, "utf-8"));
		try {
			$this->db->insert ( 'employe', $employe_to_save );
			$id_employe_enregistrer = $this->db->lastInsertId();
			$this->logger->info('last inserted ID = '.$id_employe_enregistrer);
			$reponse = 'success';
			$this->logger->info('insertion - EMPLOYE - OUI');
		} catch ( Zend_Db_Adapter_Exception $e ) {
			$reponse= 'Erreur';
			$this->logger->info('Requete erreur : '.$e->getMessage());			
		}
		
		//PHASE D INSERTION DES TUPLES id_employ | id_occupation DANS LA TABLE 'OCCUPER'
		$this->logger->info('*****************HASE D INSERTION DES TUPLES id_employ | id_occupation************');
		//recupperer la liste des occupation 
		$sql = 'SELECT * FROM occupation';
		$list_occupations = $this->db->fetchAssoc ( $sql );
		
		foreach($data_from_user ['occupations'] as $table_occupation)// !!!!!!!!!!!!!!!!!! $data_from_user ['occupations'] : Tableau des tableaux des occupations
		{//itterrer dans le champs des occupations de l'employe
			foreach ($table_occupation as $occupation){//$table_occupation : tableau des occupations
				//itterer dans tous les occupations de l'employe
					foreach ($list_occupations as $occupation_from_db)
					{//itterer dans les occupation de la BD
						if($occupation_from_db['nom_occup'] == $occupation)// !!!!!!!!!!!!!!!!!!
						{//l'employe a cette occupation, on cherche id_occup equivalent et on insert dans la BD
						$id_occup_courant = $occupation_from_db['id_occup'];
						//construire le tableau pour l'enregistrement du tuple id_employe | id_occup
						$tuple_employe_occup = array('id_employe' => $id_employe_enregistrer,
																				'id_occup' => $id_occup_courant);
						try {
							$this->logger->info(html_entity_decode(Zend_Debug::dump($tuple_employe_occup,$label = null,$echo = false), ENT_COMPAT, "utf-8"));
							$this->db->insert ( 'occuper', $tuple_employe_occup );
							$this->logger->info('insertion - OCCUPER - OUI');
							$reponse = 'success';
						} catch ( Zend_Db_Adapter_Exception $e ) {
							$this->logger->info($e->getMessage ());
						}
					}
				}
			}	
		}
		//$json = Zend_Json::encode($table_reponse);
		echo $reponse;
	}
	public function modifyAction() { // brush
		$table_reponse = array ('message' => '' );
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		$data_from_user = $this->_getAllParams ();
		
		if (! empty ( $data_from_user ['nom_employe'] )) {
			
			$new_data = array ('nom_employe' => $data_from_user ['nom_employe'] );
			$id_employe = $data_from_user ['id_employe'];
			$condition = "id_employe = $id_employe";
			try {
				$this->db->update ( 'employe', $new_data, $condition );
				$table_reponse ['message'] = 'Le employe a été bien modifier';
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
		$this->view->title = 'Modifier une employe';
		
		$this->db->setFetchMode ( Zend_Db::FETCH_OBJ );
		$req_id = $this->getRequest ()->getParam ( 'id' );
		$id = $this->db->quote ( $req_id );
		$sql = "SELECT id_employe, nom_employe FROM employe WHERE id_employe = $id";
		$this->view->employe = $this->db->fetchRow ( $sql );
	
	}
	public function deleteAction() {
		$n_lignes_supprime = NULL;
		$table_reponse = array ('message' => '' );
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( TRUE );
		
		$data_from_user = $this->_getAllParams ();
		$condition = 'id_employe = ' . $data_from_user ['id'];
		
		try {
			$n_lignes_supprime = $this->db->delete ( 'employe', $condition );
			$table_reponse ['message'] = 'L\'employe a été supprimer';
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
				$condition = 'id_employe = ' . $data_from_user [$indice];
				$this->db->delete ( 'employe', $condition );
			}
			$table_reponse ['message'] = 'Les employes ont été bien supprimés';
		
		} catch ( Zend_Db_Adapter_Exception $e ) {
			$table_reponse ['message'] = $e->getMessage ();
		}
		$json = Zend_Json::encode ( $table_reponse );
		echo $json;
	}

}



