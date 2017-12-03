<?php 

class ControleurLocation {

	public function execute() {
		if(!$_SESSION['flyUser']){
			header('Location:' .PATH);
		}
		if (!Utils::getGet('action')) {
			$_GET['action'] = 'all';
		}

		if ($_GET['action'] == 'all')
		{
			if(Utils::isConnecter())
			{

				if (Utils::getStatut()<3)
				{
					$this->showAll();
					
				}else
				{

					$this->showAllUser();
				}
			}else{
				header("Location: ".PATH);
			}
		}//fin if 

		if ($_GET['action'] == 'show') {
			if(Utils::getGet('id')) {
				$id = $_GET['id'];
				$this->show($id);
			} else {
				header("Location: ".PATH);
			}
		}

		if ($_GET['action'] == 'valider') {
			if(Utils::getGet('id')) {
				$id = $_GET['id'];
				$this->valider($id);
			} else {
				header("Location: ".PATH);
			}
		}

		if ($_GET['action'] == 'louer') {

			return $this->ajoutLocation($_POST);
		}

		if ($_GET['action'] == 'bloquer') {

			return $this->bloquerDates($_POST);
		}


		if ($_GET['action'] == 'payercc') {

			return $this->paiementCC($_POST);
		}


	} //end function

	private function showAll() {
		$modele = new ModeleLocation();
		$inputSearch = Utils::getPost('input-location-search');

		if(isset($_POST['location-search']) && $inputSearch) {
			$data = $modele->getLocations($inputSearch);
		} else {
			$data = $modele->getLocations();
		}

		$vue = new ControleurVue();
		$vue->create('locationsAll', ['data'=>$data] );

	} // fin function showAll

	private function showAllUser() {
		$modele = new ModeleLocation();
		$modeleAvis = new ModeleAvis();
		$login = Utils::getSession("login");
		$login = $_SESSION['flyUser']['login'];
		//$inputSearch = Utils::getPost('input-location-search');

		// if(isset($_POST['location-search']) && $inputSearch) {
		// 	$data = $modele->getLocationsUser($inputSearch);
		// } else {
			$data = $modele->getLocationsUser($login);
			$requetes = $modele->getCarsId($login);
			//$array	= $modele->getLocataire($data[0]["id_louer"]);
		// }
			if (!empty($requetes))
			{


				$dataOwner = $modele->getLocationsOwnerHold($login);

			} else {

				 $dataOwner = [];
			}

		$vue = new ControleurVue();
		$vue->create('locationsAllUser', ['data'=>$data, 'dataOwner'=>$dataOwner] );

	} // fin function showAllUser


	private function show($id) {
		$modele = new ModeleLocation();
		$modeleAvis = new ModeleAvis();
		$data = $modele->getLocation($id);
		$array	= $modele->getProprietaire($data[0]["proprietaire"]);

		if (isset($_POST["prenom"])&&isset($_POST["nom"])
		&&isset($_POST["number"]) &&isset($_POST["ccv"]) ){

			//$_SESSION['dateDebut'] =$_POST["dateDebut"];
			//$_SESSION['dateFin'] =$_POST["dateFin"];
			$idLocation =$_POST["id_louer"];
			$_GET['action'] = "payercc";
			$locationCtrl = new ControleurLocation();
			$modifie =$locationCtrl->execute();
			

			if ($modifie == true){

				$_SESSION['succes']= "Votre réservation est payée.";
			}else{

				$_SESSION['erreur']= "La réservation n'a pas pu être payée";
			}
		}

		// verifie le inscription de avis
		if(isset($_POST['ecrire-avis'])) {
			$commentaire = Utils::getPost('commentaire');
			$note = Utils::getPost('note');
			if (strlen($commentaire) > 5) {
				$commentaire = Utils::filtreFort($commentaire);
				$note = intval($note);

				$user_donne = [
					'id_louer_avis' => $data[0]["id_louer"],
					'id_voiture_avis' => $data[0]["id_voiture"],
					'id_user_avis' => $_SESSION['flyUser']['id'],
					'date_avis' => date('Y-m-d'),
					'text_avis' => $commentaire,
					'note_avis' => $note
				];
				$enregistreAvis = $modeleAvis->enregistreAvis($user_donne);
				if($enregistreAvis) {
					
					$_SESSION['succes']= "Votre commentaire a etai enregistre avec succes.";
				} else {
					$_SESSION['erreur'] = 'ERREUR: Le commentaire na pas enregistre!';
				}

			} else {
				$_SESSION['erreur'] = 'ERREUR: Minimum 6 caracteres!';
			}
			//var_dump($commentaire, $note); die();
		}
		// Fin verifie le inscription de avis

		$existeAvis = $modeleAvis->existeAvis($data[0]['id_louer'], $data[0]["id_voiture"], $_SESSION['flyUser']["id"]);

		$vue = new ControleurVue();
		$vue->create('locationShow', ['data'=>$data, 'array'=>$array, 'existeAvis' => $existeAvis] );

	}//fin fonction show

	private function valider($id) {
		$modele = new ModeleLocation();
		$data = $modele->getLocation($id);
		//var_dump($data[0]["proprietaire"]); die();
			$array	= $modele->getProprietaire($data[0]["proprietaire"]);
			//var_dump($data); var_dump($array); die();

		if (isset($_POST['accepter-location'])) {
			$idLocation = Utils::getPost('accepter-location-id');
			if ($idLocation) {
				$accepterLocation = $modele->validerLocation($idLocation);
				if ($accepterLocation) {
					$_SESSION['succes'] = 'Vous avez accepté la réservation!';
					header('Location: '.$_SERVER["HTTP_REFERER"]);

				} else {
					$_SESSION['erreur'] = "ERREUR: Vous n'avez pas pu accepter la réservation";
				}
			}
		}

		if (isset($_POST['refuser-location'])) {
			$idLocation = Utils::getPost('refuser-location-id');
				if ($idLocation) {
					$refuserLocation = $modele->refuserLocation($idLocation);
					if ($refuserLocation) {
						$_SESSION['succes'] = 'Vous avez refusé la réservation';
						header('Location: '.$_SERVER["HTTP_REFERER"]);

					} else {
						$_SESSION['erreur'] = "ERREUR: Vous n'avez pas pu refuser la réservation";
					}
				}
		}

		$vue = new ControleurVue();
		$vue->create('locationValider', ['data'=>$data, 'array'=>$array] );

	}//fin fonction valider

	private function ajoutLocation($location_data) {
		
		$modele = new ModeleLocation();
		
		return $data = $modele->ajoutLocation($location_data);
		//header('Location: '.$_SERVER["HTTP_REFERER"]);

	}//fin fonction ajoutLocation

	private function bloquerDates($location_data) {
		
		$modele = new ModeleLocation();
		
		return $data = $modele->bloquerDates($location_data);
		//header('Location: '.$_SERVER["HTTP_REFERER"]);

	}//fin fonction bloquerDates

	private function paiementCC($id) {
		
		$modele = new ModeleLocation();
		
		return $data = $modele->paiementCC($id);
		//header('Location: '.$_SERVER["HTTP_REFERER"]);

	}




} // end class