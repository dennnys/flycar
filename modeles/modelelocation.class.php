<?php 

class ModeleLocation {

	public function getCountReservationsAdmin() {
		$db = SingletonPDO::getInstance();

		$nb = $db->prepare("SELECT COUNT(id_louer) FROM location WHERE statut_louer = '1' ");
		$nb->execute();

		return $nb->fetchColumn();
	}

	public function getCountReservationsPaidAdmin(){
		$db = SingletonPDO::getInstance();

		$nb = $db->prepare("SELECT COUNT(id_louer) FROM location WHERE statut_louer = '4' ");
		$nb->execute();

		return $nb->fetchColumn();
	}

	public function getCountReservationsUser($login) {
		$db = SingletonPDO::getInstance();

		$nb = $db->prepare("SELECT COUNT(id) FROM location 
			LEFT JOIN utilisateurs 
			ON location.id_user_louer = utilisateurs.id_user
			INNER JOIN statutlouer
			ON location.statut_louer = statutlouer.id_statut_louer
			WHERE location.statut_louer = '1' AND login = ?");
		$nb->execute([$login]);


		return $nb->fetchColumn();
	}

	public function getCountRequetesOwner($login) {
		$db = SingletonPDO::getInstance();

		$nb = $db->prepare("SELECT COUNT(id_louer) 
			FROM location
			LEFT JOIN voitures ON location.id_voiture_louer = voitures.id_voiture
			LEFT JOIN utilisateurs ON voitures.proprietaire = utilisateurs.id_user
			INNER JOIN statutlouer ON location.statut_louer = statutlouer.id_statut_louer
			WHERE location.statut_louer =  '1'
			AND proprietaire =  ?");
		$nb->execute([$login]);


		return $nb->fetchColumn();
	}

public function getCountReservationsToPayUser($login) {
		$db = SingletonPDO::getInstance();

		$nb = $db->prepare("SELECT COUNT(id) FROM location 
			LEFT JOIN utilisateurs 
			ON location.id_user_louer = utilisateurs.id_user
			INNER JOIN statutlouer
			ON location.statut_louer = statutlouer.id_statut_louer
			WHERE location.statut_louer = '2' AND login = ?");
		$nb->execute([$login]);

		return $nb->fetchColumn();
	}
	


	public function getLocations($inputSearch = '') {
		$db = SingletonPDO::getInstance();

		if ($inputSearch == '') {
			$query = "SELECT id_louer, login, date_debut_louer, date_fin_louer, prix_louer, statut_louer, prenom_user, nom_user, proprietaire, nom_statut_louer FROM location
			LEFT JOIN utilisateurs 
			 ON location.id_user_louer = utilisateurs.id_user
			 INNER JOIN voitures 
			 ON location.id_voiture_louer = voitures.id_voiture
			 INNER JOIN statutlouer
			 ON location.statut_louer = statutlouer.id_statut_louer
			 ORDER BY statut_louer ASC
			-- INNER JOIN marques 
			-- ON voitures.marque = marques.id_marque
			-- INNER JOIN modeles
			-- ON voitures.modele = modeles.id_modele
			";

			$info = $db->prepare($query);
			$info->execute();

		} else 
		{
			$query = "SELECT * FROM location
			LEFT JOIN utilisateurs 
			ON location.id_user_louer = utilisateurs.id_user
			INNER JOIN voitures 
			ON location.id_voiture_louer = voitures.id_voiture
			INNER JOIN marques 
			ON voitures.marque = marques.id_marque
			INNER JOIN modeles
			ON voitures.modele = modeles.id_modele
			INNER JOIN statutlouer
			 ON location.statut_louer = statutlouer.id_statut_louer
			WHERE (id_louer LIKE '%$inputSearch%') 
			OR (date_debut_louer LIKE '%$inputSearch%') 
			OR (date_fin_louer LIKE '%$inputSearch%')
			OR (nom_marque LIKE '%$inputSearch%')
			OR (nom_modele LIKE '%$inputSearch%')";
			
			$info = $db->prepare($query);
			$info->execute();
		}
		

		return $info->fetchAll(PDO::FETCH_ASSOC);
	}//fin getLocations




	public function getLocationsUser($login, $inputSearch = '') {
		$db = SingletonPDO::getInstance();
		//var_dump($login);die;
		if ($inputSearch == '') {
			$query = $db->prepare("SELECT id, id_louer, login, date_debut_louer, date_fin_louer, prix_louer, statut_louer, prenom_user, nom_user, proprietaire, nom_statut_louer FROM location
			LEFT JOIN utilisateurs 
			 ON location.id_user_louer = utilisateurs.id_user
			 INNER JOIN voitures 
			 ON location.id_voiture_louer = voitures.id_voiture
			 INNER JOIN statutlouer
			 ON location.statut_louer = statutlouer.id_statut_louer
			 WHERE login = ? ORDER BY statut_louer, id_louer DESC
			");

			//$query = $db->prepare($query);
			$query->execute([$login]);
			$info = $query->fetchALl(PDO::FETCH_ASSOC);
			return $info;
			//var_dump($query);die;
			//$resultat->closeCursor()
			//return $info->fetchAll(PDO::FETCH_ASSOC);

		} else 
		{
		// 	$query = "SELECT * FROM location
		// 	LEFT JOIN utilisateurs 
		// 	ON location.id_user_louer = utilisateurs.id_user
		// 	INNER JOIN voitures 
		// 	ON location.id_voiture_louer = voitures.id_voiture
		// 	INNER JOIN marques 
		// 	ON voitures.marque = marques.id_marque
		// 	INNER JOIN modeles
		// 	ON voitures.modele = modeles.id_modele
		// 	WHERE (id_louer LIKE '%$inputSearch%') 
		// 	OR (date_debut_louer LIKE '%$inputSearch%') 
		// 	OR (date_fin_louer LIKE '%$inputSearch%')
		// 	OR (nom_marque LIKE '%$inputSearch%')
		// 	OR (nom_modele LIKE '%$inputSearch%')";
			
		// 	$info = $db->prepare($query);
		// 	$info->execute();
		}
		

		//return $info->fetchAll(PDO::FETCH_ASSOC);
	}//getLocationsUser

	public function getProprietaire($proprietaire) {
		$db = SingletonPDO::getInstance();

		$array = $db->prepare("SELECT login, nom_user, prenom_user, id
			FROM utilisateurs
			WHERE login =?
			");

		$array->execute([$proprietaire]);
		return $array->fetchAll(PDO::FETCH_ASSOC);

	}//fin getProprietaire

	public function getLocataire($id_louer) {
		$db = SingletonPDO::getInstance();

		$array = $db->prepare("SELECT login, nom_user, prenom_user, id
			FROM utilisateurs
			INNER JOIN location
			ON utilisateurs.id_user = location.id_user_louer
			WHERE id_louer =?
			");

		$array->execute([$id_louer]);
		return $array->fetchAll(PDO::FETCH_ASSOC);

	}//fin getLocataire


	public function getLocation($id) {
		$db = SingletonPDO::getInstance();

		$info = $db->prepare("SELECT id, id_louer,login, plaque, id_user_louer, id_voiture, nom_marque, nom_modele, annee, date_debut_louer, date_fin_louer, prix, prix_louer, nom_statut_louer, statut_louer, prenom_user, id, nom_user, proprietaire 
			FROM location
			LEFT JOIN utilisateurs 
			ON location.id_user_louer = utilisateurs.id_user
			INNER JOIN voitures 
			ON location.id_voiture_louer = voitures.id_voiture
			INNER JOIN marques 
			ON voitures.marque = marques.id_marque
			INNER JOIN modeles
			ON voitures.modele = modeles.id_modele
			INNER JOIN statutlouer
			 ON location.statut_louer = statutlouer.id_statut_louer
			WHERE id_louer =?
			");

		$info->execute([$id]);
		return $info->fetchAll(PDO::FETCH_ASSOC);
	}//fin getLocation


	public function getLocationsOwner($login) {
		$db = SingletonPDO::getInstance();

		$page = $db->prepare("SELECT *
			FROM utilisateurs
			INNER JOIN voitures 
			ON utilisateurs.id_user = voitures.proprietaire 
			AND INNER JOIN locations 
			ON voitures.id_voiture = location.id_voiture_louer 
			WHERE utilisateurs.login= ?");
		$page->execute([$id_user]);

		return $page->fetchAll(PDO::FETCH_ASSOC);
	} // end function

	public function getLocationsOwnerHold($login) {
		$db = SingletonPDO::getInstance();

		// $page = $db->prepare("SELECT * FROM messagerie JOIN utilisateurs on utilisateurs.login = messages.auteur WHERE destinataire = ? ORDER BY messages.ecrire DESC");
		//$status=EnumStatus::EN_ATTENTE;
		//AND statut_louer =?

		$page = $db->prepare("SELECT id, id_louer, prenom_user, nom_user, date_debut_louer, date_fin_louer, prix_louer, statut_louer, nom_statut_louer 
				FROM location
				INNER JOIN voitures 
				ON location.id_voiture_louer = voitures.id_voiture
				LEFT JOIN utilisateurs 
				ON voitures.proprietaire = utilisateurs.login
				INNER JOIN statutlouer
			ON location.statut_louer = statutlouer.id_statut_louer
				WHERE login =  ? ORDER BY statut_louer ASC
				");

		$page->execute([$login]);

		return $page->fetchAll(PDO::FETCH_ASSOC);
	} // end function

	public function getLocationsClient($id_user) {
		$db = SingletonPDO::getInstance();

		// $page = $db->prepare("SELECT * FROM location JOIN utilisateurs on utilisateurs.login = messages.auteur WHERE destinataire = ? ORDER BY messages.ecrire DESC");

		$page = $db->prepare("SELECT *
			FROM location INNERJOIN voitures 
			ON id_voiture_louer = id_voiture 
			AND INNERJOIN utilisateurs 
			ON proprietaire = id_user 
			WHERE Utilisateurs.id_user_= ?");
		$page->execute([$id_user]);

		return $page->fetchAll(PDO::FETCH_ASSOC);
	} // end function

	public function getLocationsClientHold($id_user) {
		$db = SingletonPDO::getInstance();

		// $page = $db->prepare("SELECT * FROM location JOIN utilisateurs on utilisateurs.login = messages.auteur WHERE destinataire = ? ORDER BY messages.ecrire DESC");
		$status=EnumStatus::EN_ATTENTE;

		$page = $db->prepare("SELECT *
			FROM location INNERJOIN voitures 
			ON id_voiture_louer = id_voiture 
			AND INNERJOIN utilisateurs 
			ON proprietaire = id_user 
			WHERE Utilisateurs.id_user_= ?
			AND location.statut= ?");
		$page->execute([$id_user,$status]);

		return $page->fetchAll(PDO::FETCH_ASSOC);
	} // end function

	
public function ajoutLocation($location_data) 
	{
		$db = SingletonPDO::getInstance();

		$id_user=$_SESSION['flyUser']['id_user'];
		$id_voiture=$_SERVER["REQUEST_URI"];
		// var_dump($_POST);
		// die();
		// $id_voiture_louer=preg_split('/', $id_voiture)[count($id_voiture)-1];
		if($this->valideDate($location_data["dateDebut"]) && $this->valideDate($location_data["dateFin"])){
		//var_dump('whattttttttttttttt');die();
		$date1=date_create($location_data["dateDebut"]);
		$date2=date_create($location_data["dateFin"]);
		$diff=date_diff($date1,$date2);
		//var_dump($diff);
		$prix_voiture=$location_data["prix"];
		//prix de locaation: durée * prix voiture
		$prix_louer=$diff->days*$location_data["prix"];
		$statut=EnumStatus::EN_ATTENTE;

		//var_dump($location_data, $id_user, $statut, $prix_louer);die;
		try{
		$query = "INSERT INTO location (
			id_user_louer, 
			id_voiture_louer, 
			date_debut_louer, 
			date_fin_louer,  
			statut_louer, 
			prix_louer)
		VALUES (:id_user_louer, :id_voiture_louer, :date_debut_louer, :date_fin_louer, :statut_louer, :prix_louer)";

		// prepare sql and bind parameters
    	$stmt = $db->prepare($query);
    	$stmt->bindParam(':id_user_louer', $id_user);
    	$stmt->bindParam(':id_voiture_louer', $location_data["id"]);
    	$stmt->bindParam(':date_debut_louer', $location_data["dateDebut"]);
    	$stmt->bindParam(':date_fin_louer', $location_data["dateFin"]);
    	$stmt->bindParam(':statut_louer', $statut);
    	$stmt->bindParam(':prix_louer', $prix_louer);
    	//$stmt->bindParam(':mode_paiement', $email);
		$result = $stmt->execute();
		
	}catch(PDOException $pdoE)
	{
    	echo $pdoE->getMessage().'<br/>';
    	//var_dump($pdoE);
	}
		// var_dump($result);
		return $result;
	}$_SESSION['erreur'] = "La réservation n'a pas pu être enregistrée: les dates sont invalides";
	//var_dump('no valid');die();
	return false;

	}// fin function ajoutLocation

	public function bloquerDates($location_data) 
	{

		$db = SingletonPDO::getInstance();

		$id_user=$_SESSION['flyUser']['id_user'];
		$id_voiture=$_SERVER["REQUEST_URI"];
		// var_dump($_POST);
		// die();
		// $id_voiture_louer=preg_split('/', $id_voiture)[count($id_voiture)-1];
		if($this->valideDate($location_data["dateDebut"]) && $this->valideDate($location_data["dateFin"])){
		//var_dump('whattttttttttttttt');die();
		$date1=date_create($location_data["dateDebut"]);
		$date2=date_create($location_data["dateFin"]);
		//$diff=date_diff($date1,$date2);
		//var_dump($diff);
		//$prix_voiture=$location_data["prix"];
		//prix de locaation: durée * prix voiture
		$prix_louer='1';
		$statut='5';

		//var_dump($location_data, $id_user, $statut, $prix_louer);die;
		try{
		$query = "INSERT INTO location (
			id_user_louer, 
			id_voiture_louer, 
			date_debut_louer, 
			date_fin_louer,  
			statut_louer, 
			prix_louer)
		VALUES (:id_user_louer, :id_voiture_louer, :date_debut_louer, :date_fin_louer, :statut_louer, :prix_louer)";

		// prepare sql and bind parameters
    	$stmt = $db->prepare($query);
    	$stmt->bindParam(':id_user_louer', $id_user);
    	$stmt->bindParam(':id_voiture_louer', $location_data["id"]);
    	$stmt->bindParam(':date_debut_louer', $location_data["dateDebut"]);
    	$stmt->bindParam(':date_fin_louer', $location_data["dateFin"]);
    	$stmt->bindParam(':statut_louer', $statut);
    	$stmt->bindParam(':prix_louer', $prix_louer);
    	//$stmt->bindParam(':mode_paiement', $email);
		$result = $stmt->execute();
		
	}catch(PDOException $pdoE)
	{
    	echo $pdoE->getMessage().'<br/>';
    	//var_dump($pdoE);
	}
		// var_dump($result);
		return $result;
	}$_SESSION['erreur'] = "Les dates n'ont pas pu être enregistrées: les dates sont invalides";
	//var_dump('no valid');die();
	return false;

	}// fin function creerLocation

	public function paiementCC($idLocation) {
		$db = SingletonPDO::getInstance();
		//var_dump($idLocation);die;
		$id_louer=$idLocation['id_louer'];
		$query = "UPDATE location
	 	SET statut_louer = '4', mode_paiement = '1'
		WHERE id_louer=?";

		$modifie = $db->prepare($query);

		return $modifie->execute([$id_louer]);

	}

	public function validerLocation($idLocation) {
		$db = SingletonPDO::getInstance();

		$query = "UPDATE location
	 	SET statut_louer = '2'
		WHERE id_louer=?";

		$modifie = $db->prepare($query);

		return $modifie->execute([$idLocation]);

	}

	public function refuserLocation($idLocation) {
		$db = SingletonPDO::getInstance();

		$query = "UPDATE location
	 	SET statut_louer = '3'
		WHERE id_louer=?";

		$modifie = $db->prepare($query);

		return $modifie->execute([$idLocation]);

	}

	// public function refuserLocation($data) {
	// 	$db = SingletonPDO::getInstance();

	// 	$refuser=3;
	// 	//appel constante
	// 	$accepter=EnumStatus::REFUSER;
	// 	$id_location=$data;

	// 	$query = "UPDATE location
	// 	SET statut_louer = $refuser
	// 	WHERE id_louer=$id_location"; //id de la location

	// 	// prepare sql and bind parameters
 //    	$stmt = $conn->prepare($query);
 //    	$stmt->bindParam(':statut_louer', $refuser);
 //    	//$stmt->bindParam(':mode_paiement', $email);

	// 	return $refuser->execute($inputs);

	// }// fin function refuserLocation

	private function valideDate($dateString){
		//var_dump($dateString);
		return (preg_match("/201[7-8]-(0[1-9]|1[0-2])-((0[1-9])|([1-2][0-9])|3[0-1])/i", $dateString)) ;

	}// fin function validerDate

	public function getCountCars($login){
		$db = SingletonPDO::getInstance();

		$nb = $db->prepare("SELECT COUNT(id_voiture) 
			FROM voitures
			LEFT JOIN utilisateurs
			ON utilisateurs.id_user = voitures.proprietaire 
			WHERE login = ? ");
		$nb->execute([$login]);

		return $nb->fetchColumn();
	}// fin function getCountReservationsPaidAdmin


	public function getCarsId($login){
		$db = SingletonPDO::getInstance();

		$nb = $db->prepare("SELECT id_voiture
		FROM voitures
		LEFT JOIN utilisateurs ON utilisateurs.id_user = voitures.proprietaire
		WHERE proprietaire =  ? ");
		$nb->execute([$login]);

		return $nb->fetchAll(PDO::FETCH_ASSOC);

		}// fin function getCountReservationsPaidAdmin

	public function getLocationVoiture($id_voiture) {	
		$db = SingletonPDO::getInstance();
		$nb = $db->prepare( "SELECT `id_louer`, `id_voiture_louer`, `date_debut_louer`, `date_fin_louer`, `statut_louer`,
		COUNT(`id_louer`) 
		FROM `location`
		WHERE location.id_voiture_louer = ? AND `statut_louer` < 3
		");
		$nb->execute([$id_voiture]);
		return $nb->fetch(PDO::FETCH_ASSOC);
}	// end function	

} // end class