<?php 
//On empeche les utilisateurs non registrées d'avoir accèss directement au fichiers
defined('FLYCAR') or die('<h1 style="color:red">Acc&egrave;ss interdit!</h1>');
class ModeleVoitures{

	public function getVoitures() {
		$db = SingletonPDO::getInstance();
		$voitures = $db->prepare("
			SELECT `id_voiture` , `nom_marque` , `nom_modele`, `prenom_user`, `nom_user`, `annee`, `siege`, `porte`, `nom_carburant`, `nom_type`, `manuelle`, `info_voiture`, `prix`, `id`,`proprietaire`
			FROM `voitures`
			JOIN `marques` ON voitures.marque = marques.id_marque
			JOIN `modeles` ON voitures.modele = modeles.id_modele
			JOIN `carburants` ON voitures.carburante = carburants.id_carburant
			JOIN `types` ON voitures.type = types.id_type
			JOIN `utilisateurs` ON voitures.proprietaire = utilisateurs.login
		");
		$voitures->execute();
		$resultat = $voitures->fetchALl(PDO::FETCH_ASSOC);
		return $resultat;
	}	// end function getVoitures
	public function getVoituresMainSearch($query) {
		$db = SingletonPDO::getInstance();
		$info = $db->prepare($query);
		$info->execute();

		return $info->fetchAll(PDO::FETCH_ASSOC);
	}	// end function getVoituresMainSearch
	public function getVoituresFiltre($inputSearch = '') {
		$db = SingletonPDO::getInstance();
		if ($inputSearch == '') {
			$query = "
			SELECT `id_voiture`, `nom_marque`, `nom_modele`, `prenom_user`, `nom_user`, `annee`, `siege`, `porte`, `nom_carburant`, `nom_type`, `manuelle`, `info_voiture`, `prix`, `id`, `login`
			FROM `voitures`
			JOIN `marques` 		ON voitures.marque = marques.id_marque
			JOIN `modeles` 		ON voitures.modele = modeles.id_modele
			JOIN `carburants` 	ON voitures.carburante = carburants.id_carburant
			JOIN `types` 		ON voitures.type = types.id_type
			JOIN `utilisateurs` ON voitures.proprietaire = utilisateurs.login";
			$info = $db->prepare($query);
			$info->execute();
		} else {
			$query = "
			SELECT `id_voiture` , `nom_marque` , `nom_modele`, `prenom_user`, `nom_user`, `annee`, `siege`, `porte`, `nom_carburant`, `nom_type`, `manuelle`, `info_voiture`, `prix`, `id`, `login`
			FROM `voitures`
			JOIN `marques` 		ON voitures.marque = marques.id_marque
			JOIN `modeles` 		ON voitures.modele = modeles.id_modele
			JOIN `carburants` 	ON voitures.carburante = carburants.id_carburant
			JOIN `types` 		ON voitures.type = types.id_type
			JOIN `utilisateurs` ON voitures.proprietaire = utilisateurs.login
			WHERE (nom_marque LIKE '%$inputSearch%') 	OR 
				  (nom_modele LIKE '%$inputSearch%') 	OR 
				  (nom_user LIKE '%$inputSearch%') 		OR 
				  (prenom_user LIKE '%$inputSearch%') 	OR 
				  (annee LIKE '%$inputSearch%') 
			ORDER BY marque
		";
			$info = $db->prepare($query);
			$info->execute();
		}

		return $info->fetchAll(PDO::FETCH_ASSOC);
	}	// end function
	public function getVoituresMoinsCher() {
		$db = SingletonPDO::getInstance();
		$voitures = $db->prepare("
			SELECT `id_voiture` , `prix`, `login`, `plaque`, `nom_marque` , `nom_modele`, `annee`, note
			FROM `voitures`
			JOIN `marques` ON voitures.marque = marques.id_marque
			JOIN `modeles` ON voitures.modele = modeles.id_modele
			JOIN `utilisateurs` ON voitures.proprietaire = utilisateurs.login
			ORDER BY `prix` ASC LIMIT 12
		");
		$voitures->execute();
		$resultat = $voitures->fetchALl(PDO::FETCH_ASSOC);
		return $resultat;
	}	// end function
	public function getVoituresRecentes() {
		$db = SingletonPDO::getInstance();
		$voitures = $db->prepare("
			SELECT `id_voiture` , `prix`, `login`, `plaque`,  `note`, `nom_marque` , `nom_modele`,  `annee`
			FROM `voitures`
			JOIN `marques` ON voitures.marque = marques.id_marque
			JOIN `modeles` ON voitures.modele = modeles.id_modele
			JOIN `utilisateurs` ON voitures.proprietaire = utilisateurs.login
			ORDER BY `id_voiture` DESC LIMIT 12
		");
		$voitures->execute();
		$resultat = $voitures->fetchALl(PDO::FETCH_ASSOC);
		return $resultat;
	}	// end function
	public function getTypeVoiture() {
		$db = SingletonPDO::getInstance();
		$voitures = $db->prepare("SELECT * FROM `types`");
		$voitures->execute();
		$resultat = $voitures->fetchALl(PDO::FETCH_ASSOC);
		return $resultat;
	}	// end function
	public function inscrirevoiture($voiture_donnees) {
		$db = SingletonPDO::getInstance();
		

		$query = 'INSERT INTO voitures ( ';
		foreach ($voiture_donnees as $key => $value) {
			$query .= $key.', ';
		};
		$query = rtrim($query, ', ');
		$query .= ' ) VALUES ( ';
		foreach ($voiture_donnees as $value) {
			$query .= ' ?, ';
		};
		$query = rtrim($query, ', ');
		$query .= ' );';

		$voitureInscrire = $db->prepare($query);

		$inputs = [];

		foreach ($voiture_donnees as $value) {
			$inputs[] = $value;
		}
		
		return $voitureInscrire->execute($inputs);
	}   // end function
	public function modifierVoiture($voiture_donnees, $voiture_id) {
		$db = SingletonPDO::getInstance();
		
		//UPDATE `e1695549`.`voitures` SET `info_voiture` = 'Modifié pour etre de luxe!' WHERE `voitures`.`id_voiture` =33;

		$query = 'UPDATE `voitures` SET ';
		foreach ($voiture_donnees as $key => $value) {
			$query .= ' `' . $key.'` =  ?,';
		};
		$query = rtrim($query, ', ');
		$query .= ' WHERE `voitures`.`id_voiture` = ? ';
		
		
		$voitureUpdate = $db->prepare($query);

		$inputs = [];

		foreach ($voiture_donnees as $value) {
			$inputs[] = $value;
		}
		
		$inputs[] = $voiture_id;
		return $voitureUpdate->execute($inputs);
	}   // end function
	public function getMarques() {
		$db = SingletonPDO::getInstance();
		$marques = $db->prepare("
			SELECT *
			FROM `marques`
			ORDER BY `nom_marque` 
		");
		$marques->execute();
		$resultat = $marques->fetchALl(PDO::FETCH_ASSOC);
		return $resultat;
	}	// end function
	public function getModeles() {
		$db = SingletonPDO::getInstance();
		$modeles = $db->prepare("
			SELECT *
			FROM `modeles`
			ORDER BY `id_marque_mod` , `nom_modele` 
		");
		$modeles->execute();
		$resultat = $modeles->fetchALl(PDO::FETCH_ASSOC);
		return $resultat;
	}	// end function
	public function getCarburants() {
		$db = SingletonPDO::getInstance();
		$carburants = $db->prepare("
			SELECT *
			FROM `carburants`
		");
		$carburants->execute();
		$resultat = $carburants->fetchALl(PDO::FETCH_ASSOC);
		return $resultat;
	}	// end function
	public function getPlaque($plaque){
		$db = SingletonPDO::getInstance();
		$evaluation = $db->prepare("
			SELECT `plaque`
			FROM `voitures`
			WHERE `plaque` = ? 
		");
		$evaluation->execute([$plaque]);
		$resultat = $evaluation->fetchALl(PDO::FETCH_ASSOC);
		return $resultat;
	}	// end function
	public function getProprietaire($id_voiture){
		$db = SingletonPDO::getInstance();
		$proprietaire = $db->prepare("
			SELECT `proprietaire`
			FROM `voitures`
			WHERE `id_voiture` = ? 
		");
		$proprietaire->execute([$id_voiture]);
		$resultat = $proprietaire->fetchColumn();
		return $resultat;
	}	// end function
	public function getVoitureUser($login) {
		$db = SingletonPDO::getInstance();
		$voitures = $db->prepare("
			SELECT `id_voiture` , `nom_marque` , `plaque` , `nom_modele`, `prenom_user`, `nom_user`, `annee`, `siege`, `porte`, `nom_carburant`, `nom_type`, `manuelle`, `info_voiture`, `prix`, `login`,`proprietaire`
			FROM `voitures`
			JOIN `marques` ON voitures.marque = marques.id_marque
			JOIN `modeles` ON voitures.modele = modeles.id_modele
			JOIN `carburants` ON voitures.carburante = carburants.id_carburant
			JOIN `types` ON voitures.type = types.id_type
			JOIN `utilisateurs` ON voitures.proprietaire = utilisateurs.login
			WHERE login = ?
		");
		$voitures->execute([$login]);
		$resultat = $voitures->fetchALl(PDO::FETCH_ASSOC);
		
		return $resultat;
	}	// end function
	public function suppVoiture($id_voiture){
		$db = SingletonPDO::getInstance();
		$voitures = $db->prepare("
			DELETE FROM `voitures` WHERE `id_voiture` = ?
		");
		$voitures->execute([$id_voiture]);
		return $voitures;
	}	// end function
	public function getVoiture($id_voiture) {
		$db = SingletonPDO::getInstance();
		$voitures = $db->prepare("
			SELECT `id_voiture` , `login` , `id`, `valider` , `plaque` , `photos` , `suspendre` , `nom_marque` , `nom_modele`, `prenom_user`, `nom_user`, `annee`, `siege`, `porte`, `nom_carburant`, `nom_type`, `note`, `manuelle`, `info_voiture`, `prix`,`proprietaire`
			FROM `voitures`
			JOIN `marques` ON voitures.marque = marques.id_marque
			JOIN `modeles` ON voitures.modele = modeles.id_modele
			JOIN `carburants` ON voitures.carburante = carburants.id_carburant
			JOIN `types` ON voitures.type = types.id_type
			JOIN `utilisateurs` ON voitures.proprietaire = utilisateurs.login
			WHERE id_voiture = ?
		");
		$voitures->execute([$id_voiture]);
		$resultat = $voitures->fetch();
		return $resultat;
	}	// end function
	public function getDatesLocation($id) {
		$db = SingletonPDO::getInstance();
		$status=EnumStatus::REFUSER;

		$nb = $db->prepare("SELECT date_debut_louer, date_fin_louer 
			FROM location
			LEFT JOIN voitures ON location.id_voiture_louer = voitures.id_voiture
			WHERE id_voiture_louer = ? AND statut_louer <>?
			");
		$nb->execute([$id,$status]);


		return $nb->fetchAll(PDO::FETCH_ASSOC);
	}	// end function
	public function getVoituresProprietaire($proprietaire) {
		$db = SingletonPDO::getInstance();
		$voitures = $db->prepare("SELECT id_voiture, nom_marque, nom_modele, prix, proprietaire, plaque, annee, note
			FROM voitures
			JOIN marques ON marque = id_marque
			JOIN modeles ON modele = id_modele
			WHERE proprietaire = ?");
		$voitures->execute([$proprietaire]);

		return $voitures->fetchAll(PDO::FETCH_ASSOC);
	}	// end function getVoituresProprietaire
	public function getPhotos($id) {
		$db = SingletonPDO::getInstance();
		$voitures = $db->prepare("SELECT photos
			FROM voitures
			
			WHERE id_voiture = ?");
		$voitures->execute([$id]);

		return $voitures->fetchColumn();
	}	// end function getPhotos
	




	public function getVoituresCard() {
		$db = SingletonPDO::getInstance();
		$voitures = $db->prepare("
			SELECT `id_voiture` , `nom_marque` , `nom_modele`, `prenom_user`, `nom_user`, `annee`
			FROM `voitures`
			JOIN `marques` ON voitures.marque = marques.id_marque
			JOIN `modeles` ON voitures.modele = modeles.id_modele
			JOIN `utilisateurs` ON voitures.proprietaire = utilisateurs.login
		");
		$voitures->execute();
		$resultat = $voitures->fetchALl(PDO::FETCH_ASSOC);
		(empty($resultat)) ? $temp = false : $temp = true;
		return $temp;
	}	// end function
	
	public function getVoitureCard($id_voiture) {
		$db = SingletonPDO::getInstance();
		$voitures = $db->prepare("
			SELECT `id_voiture` , `nom_marque` , `nom_modele`, `prenom_user`, `nom_user`, `annee`
			FROM `voitures`
			JOIN `marques` ON voitures.marque = marques.id_marque
			JOIN `modeles` ON voitures.modele = modeles.id_modele
			JOIN `utilisateurs` ON voitures.proprietaire = utilisateurs.login
			WHERE id_voiture = ?
		");
		$voitures->execute([$id_voiture]);
		$resultat = $voitures->fetchALl(PDO::FETCH_ASSOC);
		(empty($resultat)) ? $temp = false : $temp = true;
		return $temp;
	}	// end function

	public function getModeleParMarque($id) {
		$db = SingletonPDO::getInstance();
		$modeles = $db->prepare("
			SELECT `id_modele`, `nom_modele` 
			FROM  `modeles` 
			WHERE id_marque_mod = ?
		");
		$modeles->execute([$id]);
		$resultat = $modeles->fetchALl(PDO::FETCH_ASSOC);
		return $resultat;
	}	// end function



	

} // end class