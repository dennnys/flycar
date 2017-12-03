<?php 
/**
 * controleurvoiture.class
 * Definition de la classe controleurvoiture qui gère l'accès et les modifications de la table voitures et de ses tabbles connexes dans la base de données Flycar.
 *
 * @package Flycar
 * @subpackage Controleurs
 * @category classes
 * @author Birnaz, Bourrier, Brûlé et Gutiérrez.
 * @version 1.0
 */ 
//On empeche les utilisateurs non registrées d'avoir accèss directement au fichiers
defined('FLYCAR') or die('<h1 style="color:red">Acc&egrave;ss interdit!</h1>');

class ControleurVoiture {
	/**
	 * Execute() 
	 * Function qui est exécutée par défaut lors de l'appel du contrôleur voitures
	 * @access public
	 * @author Jose Gutiérrez
	 */
	public function  execute() {

		if (!Utils::getGet('action')) {
			header("Location: ".PATH);
		}
		if ($_GET['action'] == 'all') {
			$this->showAll();
		} 
		if ($_GET['action'] == 'alladmin') {
			if(Utils::isConnecter()){
				
				if (Utils::getStatut()<3) {
						$this->showAllFiltre();
				}else {
					$this->showMesVoitures();
				}
			}else{
				header("Location: ".PATH);
			}
		}
		if ($_GET['action'] == 'ajouter') {
			$this->inscrireVoiture();	
		}
		if ($_GET['action'] == 'modifier') {
			if(Utils::isConnecter()){
				$id_voiture = Utils::getGet('id');
				$this->modifier($id_voiture);
			}else{
				header("Location: ".PATH);
			}
		}
		if ($_GET['action'] == 'confirmsupprimer'){
			if(Utils::isConnecter()){
				$id_voiture = Utils::getGet('id');
				$this->confirmSupprimer($id_voiture);
			}else{
				header("Location: ".PATH);
			}
		}
		if ($_GET['action'] == 'supprimer'){
			if(Utils::isConnecter()){
				
				$id_voiture = Utils::getGet('id');
				
				//if (Utils::isSuperAdmin() || Utils::isAdmin()) {
					$this->supprimerVoiture($id_voiture);
				//}else {
					//$this->supprimerMaVoiture($id_voiture);
				//}
			}else{
				header("Location: ".PATH);
			}
		}
		if ($_GET['action'] == 'show') {
			if(Utils::getGet('id')) {
				$id = Utils::getGet('id');
				$this->show($id);
			} else {
				header("Location: ".PATH.'/voitures/all');
			}
		}
		if ($_GET['action'] == 'showAllCard') {
			if(Utils::getGet('id')) {
				$id = $_GET['id'];
				$this->showAllCard();
			} else {
				header("Location: ".PATH);
			}
		}
		if ($_GET['action'] == 'showCard') {
			if(Utils::getGet('id')) {
				$id = $_GET['id'];
				$this->showCard($id);
			} else {
				header("Location: ".PATH);
			}
		}
		if ($_GET['action'] == 'modelesparmarque'){
			if(Utils::isConnecter()){
				$id_marque = Utils::getGet('id');
				$this->getModelesParMarque($id_marque);
			}else{
				header("Location: ".PATH);
			}
		}
	} // end function execute
	/**
	 * showAll() 
	 * Function qui affiche toutes les voitures registrées dans le système.
	 * @access private
	 * @author Jonathan Brûlé / Jose Gutiérrez
	 */
	private function showAll() {
		//On récuppère les paramètres du filtre
		$dateDebut = Utils::getGet('dateDebut');
		$dateFin = Utils::getGet('dateFin');
		$prixMin = Utils::getGet('prixMin');
		$prixMax = Utils::getGet('prixMax');
		$transmission = Utils::getGet('transmission');
		$typeVoiture = Utils::getGet('typeVoiture');
		$nbPlace = Utils::getGet('nbPlace');
		$trier = Utils::getGet('trier');
		if($dateDebut && $dateFin){
			$_SESSION['dateDebut']= $dateDebut;
			$_SESSION['dateFin']=$dateFin;
		}

		//On construit la requête 
		$query='SELECT `id_voiture`, `login`, `plaque`, `nom_marque`, `nom_modele`, `prenom_user`, `nom_user`, `annee`, `siege`, `porte`, `nom_carburant`, `nom_type`, `manuelle`, `info_voiture`, `prix`, `id`
		FROM `voitures`
		JOIN `marques` 		ON voitures.marque = marques.id_marque
		LEFT JOIN `location` 	ON voitures.id_voiture = location.id_voiture_louer
		JOIN `modeles` 		ON voitures.modele = modeles.id_modele
		JOIN `carburants` 	ON voitures.carburante = carburants.id_carburant
		JOIN `types` 		ON voitures.type = types.id_type
		JOIN `utilisateurs` ON voitures.proprietaire = utilisateurs.login
		WHERE 1=1';
		if($dateDebut && $dateFin){
			$query.= ' AND id_voiture NOT IN (SELECT id_voiture_louer FROM location WHERE date_debut_louer BETWEEN "'.$dateDebut.'" and "'.$dateFin.'" OR date_fin_louer  BETWEEN "'.$dateDebut.'"  and "'.$dateFin.'")';
		}
		
		if($prixMin){
			$query.=' AND prix >='. $prixMin;
		}
		if($prixMax){
			$query.=' AND prix <='. $prixMax;
		}
		if($transmission){
			$query.=' AND manuelle ='. $transmission;
		}
		if($typeVoiture){
			$query.=' AND type ='. $typeVoiture;
		}
		if($nbPlace){
			$query.=' AND siege >='. $nbPlace;
		}
		$query.=' GROUP BY `id_voiture`';


		if($trier){
			$query.=' ORDER BY prix '. $trier;
		}
		//On appelle le model et l'envoie la requête
		$modele = new ModeleVoitures();
		$data['search']= $modele->getVoituresMainSearch($query);
		$data['type']=$modele->getTypeVoiture();
		
		$vue = new ControleurVue();
		$vue->create('voituresAll', ['data'=>$data] );
	} // end function
	/**
	 * showAllFiltre() 
	 * Function qui affiche toutes les voitures registrées dans le système.
	 * @access private
	 * @author Jonathan Brûlé / Jose Gutiérrez
	 */
	private function showAllFiltre() {
		$modele = new ModeleVoitures();
		$inputSearch = Utils::getPost('input-voiture-search');
		if(isset($_POST['voiture-search']) && $inputSearch) {
			$data = $modele->getVoituresFiltre($inputSearch);
		}else{
			$data = $modele->getVoituresFiltre();
		}
		$vue = new ControleurVue();
		$vue->create('voituresAllAdmin', ['data'=>$data] );
	} // end function
	private function getModelesParMarque($id) {
		$modele = new ModeleVoitures();
		
		$data = $modele->getModeleParMarque($id);
		
		$json = json_encode($data);
        echo $json;
	} // end function
	
	private function showMesVoitures() {
		$modele = new ModeleVoitures();
		$login = Utils::getSession("login");
		$login = $_SESSION['flyUser']['login'];
		$data = $modele->getVoitureUser($login);
		$vue = new ControleurVue();
		$vue->create('voituresAllCard', ['data'=>$data] );
	} // end function

	private function inscrireVoiture(){
		$modeleVoitures = new ModeleVoitures();
		$marques = $modeleVoitures->getMarques();
		$modeles = $modeleVoitures->getModeles();
		$carburants = $modeleVoitures->getCarburants();
		$types = $modeleVoitures->getTypeVoiture();
		$data=[
			'marques' => $marques,
			'modeles' => $modeles,
			'carburants' => $carburants,
			'types' => $types
		];
		if(isset($_POST['ajouterVoiture'])){
			//On récupère les informations de la voiture envoyes dans le formulaire.		
			$marque = Utils::getPost('marque');
			$modele = Utils::getPost('modele');
			$annee = Utils::getPost('annee');
			$siege = Utils::getPost('siege');
			$porte = Utils::getPost('porte');
			$carburante = Utils::getPost('carburante');
			$type = Utils::getPost('type');
			$manuelle = Utils::getPost('manuelle');
			$info_voiture = Utils::getPost('info_voiture');
			$prix = Utils::getPost('prix');
			$proprietaire =$_SESSION['flyUser']['login'];
			$plaque = Utils::getPost('plaque');
			//On vérifie que les données ne sont pas vides.
			if (($marque !== false)&&($modele !== false)&&($annee !== false)
				&&($siege !== false)&&($porte !== false)&&($carburante !== false)
				&&($type !== false)&&($manuelle !== false)&&($manuelle !== false)
				&&($info_voiture !== false)&&($prix !== false)&&($proprietaire !== false)
				&&($plaque !== false)){
					//On flitre les données
					$marque = Utils::filtreFort($marque);
					$modele = Utils::filtreFort($modele);
					$annee = Utils::filtreFort($annee);
					$siege = Utils::filtreFort($siege);
					$porte = Utils::filtreFort($porte);
					$carburante = Utils::filtreFort($carburante); 
					$type = Utils::filtreFort($type);
					$manuelle = Utils::filtreFort($manuelle);
					$info_voiture = Utils::filtreFort($info_voiture);
					$prix = Utils::filtreFort($prix);
					$proprietaire = Utils::filtreFort($proprietaire);
					$plaque = Utils::filtreFort($plaque);

					$erreur = false;
					//On empeche de ajouter une voiture qui a été déjà ajouté
					if($modeleVoitures->getPlaque($plaque) != false) {
						$_SESSION['erreur'] = 'ERREUR: La plaque du vehicule &agrave; inscrire existe d&eacute;j&agrave;!';
						$vue = new ControleurVue();
						$vue->create('voituresAjouter', ['data'=>$data] );
					} else {
						// upload file
						// On verifie l'extension du fichier
						$total = count($_FILES['img_voiture']['name']);
						$resultatType=true;
						$resultatSize=true;
						for ($i=0; $i <$total ; $i++) { 

							if(strtolower(pathinfo($_FILES["img_voiture"]["name"][$i], PATHINFO_EXTENSION)) !='jpg' ){
								$resultatType=false;

							}
							if($_FILES["img_voiture"]["size"][$i]> 100000){
								$resultatSize=false;
							}	
						}
					
						if ($resultatType && $resultatSize) {
							for ($i=0; $i < $total; $i++) { 
								$index=0;
								$index=$i+1;
								// permet d'overwrite le fichier
								if(file_exists('upload/voitures/'.$proprietaire.'_v'.$plaque.'_'.$index.'.jpg')){
									unlink('upload/voitures/'.$proprietaire.'_v'.$plaque.'_'.$index.'.jpg');
								} 
								if(move_uploaded_file($_FILES['img_voiture']['tmp_name'][$i], 'upload/voitures/'.$proprietaire.'_v'.$plaque.'_'.$index.'.jpg')){
								}else{
									$_SESSION['erreur'] = 'ERREUR: Il y a un probléme avec le téléchargement de vos photos!'; 
									$erreur=true;
								}
							}
						} else {
							if(!$resultatType && !$resultatSize){
								$_SESSION['erreur'] = 'ERREUR: L\'extension du fichier doit être<b>.jpg</b> et la grosseur maximale du fichier est de 100<b>Ko</b>!';
								$vue = new ControleurVue();
								$vue->create('voituresAjouter', ['data'=>$data] );
								$erreur = true;
							}else if(!$resultatType){
								$_SESSION['erreur'] = 'ERREUR: L\'extension du fichier doit être<b>.jpg</b>!';
								$vue = new ControleurVue();
								$vue->create('voituresAjouter', ['data'=>$data] );
								$erreur = true;
							}else if(!$resultatSize){
								$_SESSION['erreur'] = 'ERREUR: La grosseur maximale du fichier est de 100<b>Ko</b>!';
								$vue = new ControleurVue();
								$vue->create('voituresAjouter', ['data'=>$data] );
								$erreur = true;
							}
							

						}
							

						// inscrire la voiture dans la base de donnéss
						
						if(!$erreur){

							if ($id_voiture = Utils::filtreFort(Utils::getPost('id_voiture')) != false) { 
								$voiture_donnees = [
												'id_voiture' => $id_voiture
												];
							}
							$voiture_donnees = [
												'marque' => $marque,
												'modele' => $modele,
												'annee' => $annee,
												'siege' => $siege,
												'porte' => $porte,
												'carburante' => $carburante,
												'type' => $type,
												'manuelle' => $manuelle,
												'info_voiture' => $info_voiture,
												'prix' => $prix,
												'proprietaire' => $proprietaire,
												'plaque' => $plaque,
												'photos' => $total
											];

							$vehicule = $modeleVoitures->inscrirevoiture($voiture_donnees);
							// echo $vehicule;
							//die();
							if($vehicule) { 
								$_SESSION['succes'] = 'SUCCES: Le vehicule a &eacute;t&eacute ajout&eacute'; 
								$this->showMesVoitures();
							}else { 
								$_SESSION['erreur'] = 'ERREUR: Il y a un probléme! Le vehicule n\'a pas été ajouté. Veuillez resayer plus tard!'; 
								$vue = new ControleurVue();
								$vue->create('voituresAjouter', ['data'=>$data] );
							}
						}	
					}
			}else {
				$_SESSION['erreur'] = 'ERREUR: Toutes le champs sont obligatoires!';
				$vue = new ControleurVue();
				$vue->create('voituresAjouter', ['data'=>$data] );
			 }
		}else {
			$vue = new ControleurVue();
			$vue->create('voituresAjouter', ['data'=>$data] );
		}
	} // end function
	private function modifier($id_voiture){
		$modeleVoitures = new ModeleVoitures();
		$data['info_voiture'] = $modeleVoitures->getVoiture($id_voiture);
		$data['liste_marque'] = $modeleVoitures->getMarques();
		$data['liste_modele'] = $modeleVoitures->getModeles();
		$data['liste_carburant'] = $modeleVoitures->getCarburants();
		$data['liste_type'] = $modeleVoitures->getTypeVoiture();
		if(isset($_POST['modifierVoiture'])){
			$proprietaire = $modeleVoitures->getProprietaire($id_voiture);
			$login = $_SESSION['flyUser']['login'];
			if($proprietaire == $login){
				//On récupère les informations de la voiture envoyes dans le formulaire.		
				$marque = Utils::getPost('marque');
				$modele = Utils::getPost('modele');
				$annee = Utils::getPost('annee');
				$siege = Utils::getPost('siege');
				$porte = Utils::getPost('porte');
				$carburante = Utils::getPost('carburante');
				$type = Utils::getPost('type');
				$manuelle = Utils::getPost('manuelle');
				$info_voiture = Utils::getPost('info_voiture');
				$prix = Utils::getPost('prix');
				$proprietaire =$_SESSION['flyUser']['login'];
				$plaque = Utils::getPost('plaque');
				$id_voiture = Utils::getPost('id_voiture');
				//On vérifie que les données ne sont pas vides.
				if (($marque !== false)&&($modele !== false)&&($annee !== false)&&($siege !== false)&&($porte !== false)&&($carburante !== false)&&($type !== false)&&($manuelle !== false)&&($manuelle !== false)&&($info_voiture !== false)&&($prix !== false)&&($proprietaire !== false)&&($plaque !== false)){
					//On flitre les données
					$marque = Utils::filtreFort($marque);
					$modele = Utils::filtreFort($modele);
					$annee = Utils::filtreFort($annee);
					$siege = Utils::filtreFort($siege);
					$porte = Utils::filtreFort($porte);
					$carburante = Utils::filtreFort($carburante); 
					$type = Utils::filtreFort($type);
					$manuelle = Utils::filtreFort($manuelle);
					$info_voiture = Utils::filtreFort($info_voiture);
					$prix = Utils::filtreFort($prix);
					$proprietaire = Utils::filtreFort($proprietaire);
					$plaque = Utils::filtreFort($plaque);
					$id_voiture = Utils::filtreFort($id_voiture);

					$erreur = false;

					$inputVide = false;
					foreach ($_FILES['img_voiture']['error'] as $ferror) {
					    if ($ferror != UPLOAD_ERR_NO_FILE) {
					      $inputVide= true;
					    }
					}

					$total = $modeleVoitures->getPhotos($id_voiture);

					if($inputVide != false){
						$total = count($_FILES['img_voiture']['name']);
						
						$resultatType=true;
						$resultatSize=true;
						for ($i=0; $i <$total ; $i++) { 
							if(strtolower(pathinfo($_FILES["img_voiture"]["name"][$i], PATHINFO_EXTENSION)) !='jpg' ){
								$resultatType=false;
							}
							if($_FILES["img_voiture"]["size"][$i]> 100000){
								$resultatSize=false;
							}
						}
						
					
						if ($resultatType && $resultatSize) {
							for ($i=0; $i < $total; $i++) { 
								$index=0;
								$index=$i+1;
								// permet d'overwrite le fichier
								if(file_exists('upload/voitures/'.$proprietaire.'_v'.$plaque.'_'.$index.'.jpg')){
									unlink('upload/voitures/'.$proprietaire.'_v'.$plaque.'_'.$index.'.jpg');
								} 
								if(move_uploaded_file($_FILES['img_voiture']['tmp_name'][$i], 'upload/voitures/'.$proprietaire.'_v'.$plaque.'_'.$index.'.jpg')){
								}else{
									$_SESSION['erreur'] = 'ERREUR: Il y a un probléme avec le téléchargement de vos photos!'; 
									$erreur=true;
								}
							}
						}else{
							if(!$resultatType && !$resultatSize){
								$_SESSION['erreur'] = 'ERREUR: L\'extension du fichier doit être<b>.jpg</b> et la grosseur maximale du fichier est de 100<b>Ko</b>!';
								$vue = new ControleurVue();
								$vue->create('voituresModifier', ['data'=>$data] );
								$erreur = true;
							}else if(!$resultatType){
								$_SESSION['erreur'] = 'ERREUR: L\'extension du fichier doit être<b>.jpg</b>!';
								$vue = new ControleurVue();
								$vue->create('voituresModifier', ['data'=>$data] );
								$erreur = true;
							}else if(!$resultatSize){
								$_SESSION['erreur'] = 'ERREUR: La grosseur maximale du fichier est de 100<b>Ko</b>!';
								$vue = new ControleurVue();
								$vue->create('voituresModifier', ['data'=>$data] );
								$erreur = true;
							}
						 }
					}
					if(!$erreur){
						
						$ancienNbVoiture = $modeleVoitures->getPhotos($id_voiture);
						// delete les photos précédente d'extras
						if($total< $ancienNbVoiture){
							for ($i=$total+1; $i <= $ancienNbVoiture; $i++) { 
								$resultUnlink[] = unlink('upload/voitures/'.$proprietaire.'_v'.$plaque.'_'.$i.'.jpg');
							}
						}
						// inscrire la voiture dans la base de donnéss
						$voiture_donnees = [
											'marque' => $marque,
											'modele' => $modele,
											'annee' => $annee,
											'siege' => $siege,
											'porte' => $porte,
											'carburante' => $carburante,
											'type' => $type,
											'manuelle' => $manuelle,
											'info_voiture' => $info_voiture,
											'prix' => $prix,
											'proprietaire' => $proprietaire,
											'plaque' => $plaque,
											'photos' => $total
										];
						$vehicule = $modeleVoitures->modifierVoiture($voiture_donnees, $id_voiture);
						if($vehicule) { 

							$_SESSION['succes'] = 'SUCCES: Le vehicule a &eacute;t&eacute modifi&eacute'; 
							$this->showMesVoitures();
						}else { 
							$_SESSION['erreur'] = 'ERREUR: Il y a un probléme! Le vehicule n\'a pas &eacute;t&eacute modifi&eacute. Veuillez resayer plus tard!'; 
							$vue = new ControleurVue();
							$vue->create('voituresModifier', ['data'=>$data] );
						}
					}			
				}else {
					$_SESSION['erreur'] = 'ERREUR: Toutes le champs sont obligatoires!';
					$vue = new ControleurVue();
					$vue->create('voituresModifier', ['data'=>$data] );
				}
			}else{
				$_SESSION['erreur']= "Vous ne disposez pas suffisamment d'autorisations pour modifier ce v&eacute;hicule";
				$this->showMesVoitures();
			}	 
		}else {
			$vue = new ControleurVue();
			$vue->create('voituresModifier', ['data'=>$data] );
		}	
	} // end function
	private function confirmSupprimer($id_voiture){
		$modele = new ModeleVoitures();
		$data = $modele->getVoiture($id_voiture);
		$vue = new ControleurVue();
		$vue->create('voituresSupp', ['data'=>$data] );
	} // end function
	private function supprimerVoiture($id_voiture){
		$modele = new ModeleVoitures();
		$modeleLocation = new modeleLocation();
		$infoLocation = $modeleLocation->getLocationVoiture($id_voiture);
		
		if ($infoLocation['COUNT(`id_louer`)'] == 0) {
			if (Utils::isSuperAdmin() || Utils::isAdmin()) {
		
				$result = $modele->suppVoiture($id_voiture);
	
				if ($result == true){

					$_SESSION['succes']= "La voiture a &eacute;t&eacute; supprim&eacute;.";

				}else{

					$_SESSION['erreur']= "La voiture n'a pas pu &ecirc;tre supprim&eacute;";
				 } 
			}else{
				$proprietaire = $modele->getProprietaire($id_voiture);
				$login = $_SESSION['flyUser']['login'];
				if($proprietaire == $login){
					$result = $modele->suppVoiture($id_voiture);
					if ($result == true){
						$_SESSION['succes']= "La voiture a &eacute;t&eacute; supprim&eacute;.";
					}else{
						$_SESSION['erreur']= "La voiture n'a pas pu &ecirc;tre supprim&eacute;";
					 }
				}else{
					$_SESSION['erreur']= "Vous ne disposez pas suffisamment d'autorisations pour supprimer ce v&eacute;hicule donc il n'a pas pu &ecirc;tre supprim&eacute;";
				 }
			 }	 
		}else{
			$_SESSION['erreur'] = "La voiture n'a pas pu &ecirc;tre supprim&eacute;! Il y a  des locations enregistrées pour cette voiture";
		 }	
			

		if (Utils::isSuperAdmin() || Utils::isAdmin()) {
			$this->showAllFiltre();
		}else{
			$this->showMesVoitures();
		 }
	} // end function
	private function showAllCard() {
		$modele = new ModeleVoitures();
		$data = $modele->getVoituresCard();

		$vue = new ControleurVue();
		$vue->create('voituresAllCard', ['data'=>$data] );
	} // end function
	private function show($id) {
		$modele_avis = new ModeleAvis();
		// souprime le avis
		if(isset($_POST['souprime_avis'])) {
			$id_avis = Utils::getPost('id_avis');
			$id_voiture = Utils::getPost('id_voiture');
			if ($id_avis) {
				$souprime = $modele_avis->souprimeAvis($id_avis, $id_voiture);
				if ($souprime) {
					$_SESSION['succes']= "SUCCES: Le avis a eté souprime!";
				} else {
					$_SESSION['erreur']= "Erreur: Le avis n'a pas eté souprime!";
				}
			}
		}
		// FIN souprime le avis

		if (isset($_POST["ajouter"])&&isset($_POST["dateDebut"])&&isset($_POST["dateFin"]) )
		{

			$_SESSION['dateDebut'] =$_POST["dateDebut"];
			$_SESSION['dateFin'] =$_POST["dateFin"];
			$_GET['action'] = "louer";
			$locationCtrl = new ControleurLocation();
			$result =$locationCtrl->execute();
			
			if ($result == true){

				$_SESSION['succes']= "Votre réservation est enregistrée.";
			}else{

				$_SESSION['erreur']= "La réservation n'a pas pu être enregistrée";
			}

		}else if (isset($_POST["bloquer"])&&isset($_POST["dateDebut"])&&isset($_POST["dateFin"]) ){
			$_SESSION['dateDebut'] =$_POST["dateDebut"];
			$_SESSION['dateFin'] =$_POST["dateFin"];
			$_GET['action'] = "bloquer";
			$locationCtrl = new ControleurLocation();
			$result =$locationCtrl->execute();
			

			if ($result == true){

				$_SESSION['succes']= "Les dates ont bien été bloquées.";
			}else{

				$_SESSION['erreur']= "Erreur: Les dates n'ont pas pu être bloquées.";
			}

		}

		$modele = new ModeleVoitures();

		$arrayDates=$modele->getDatesLocation($id);

		// $arrayDates= $this->getListDates($arrayDates);

		$data = $modele->getVoiture($id);
		
		$avis = $modele_avis->getAvisVoiture($data['id_voiture']);

		$vue = new ControleurVue();
		$vue->create('voitureShow', ['data'=>$data, 'dates'=>$arrayDates, 'avis'=>$avis] );
	} // end function
	private function getListDates($dates){
		$arrayDates= array();

		foreach ($dates as $date) {
			//echo  'Debut: '.$date['date_debut_louer'];
			//echo 'Fin: '.$date['date_fin_louer'];
			$date1=date_create($date["date_debut_louer"]);
			$date2=date_create($date["date_fin_louer"]);
			//$diff=date_diff($date1,$date2);
			$listeDate = new DatePeriod(
				$date1, new DateInterval('P1D'),$date2


				);
			

			foreach ($listeDate as $d) {
				$arrayDates[]=$d->format('Y-m-d');
			}
			$arrayDates[]=$date2->format('Y-m-d');
			
		}
		return $arrayDates;
	} // end function





	private function showCard($id) {
		$modele = new ModeleVoitures();
		$data = $modele->getVoitureCard($id);

		$vue = new ControleurVue();
		$vue->create('voituresAllCard', ['data'=>$data] );
	}
	private function supprimerMaVoiture($id_voiture){
		$modele = new ModeleVoitures();
		$proprietaire = $modele->getProprietaire($id_voiture);
		$login = $_SESSION['flyUser']['login'];
		// die();
		if($proprietaire == $login){

			$result = $modele->suppVoiture($id_voiture);
			if ($result == true){
				$_SESSION['succes']= "La voiture a &eacute;t&eacute; supprim&eacute;.";

			}else{
				$_SESSION['erreur']= "La voiture n'a pas pu &ecirc;tre supprim&eacute";
			}
		}else{
			$_SESSION['erreur']= "La voiture n'a pas pu &ecirc;tre supprim&eacute;";
			}
		$this->showMesVoitures();
	} // end function

} // end class