<?php 

namespace modeles;
use \PDO;

/**
 * La classe qui traite les utilisateurs
 * dans la base de données
 * @author Denis
 * @version 1.0
 */
class ModeleUtilisateurs {

	/**
	 * Vérifier s'il y a déjà un tel login
	 * @param $login
	 * @return boolean
	 */
public function existeLogin($login) {

		$db = new PDO('mysql:host=localhost;dbname=flycar', 'root', '');

		$utilisateur = $db->prepare("SELECT login FROM utilisateurs WHERE login = ? ");
		$utilisateur->execute([$login]);

		$resultat = $utilisateur->fetchAll(PDO::FETCH_ASSOC);

		(empty($resultat)) ? $temp = false : $temp = true;
		return $temp;
	} // end function

	/**
	 * Vérifier s'il y a déjà un tel numero de permis de conduit
	 * @param $id_user - numero de permis de conduit
	 * @return boolean
	 */
	public function existePermis($id_user) {

		$db = new PDO('mysql:host=localhost;dbname=flycar', 'root', '');

		$utilisateur = $db->prepare("SELECT login FROM utilisateurs WHERE id_user = ? ");
		$utilisateur->execute([$id_user]);

		$resultat = $utilisateur->fetchAll(PDO::FETCH_ASSOC);

		(empty($resultat)) ? $temp = false : $temp = true;
		return $temp;
	} // end function

	/**
	 * Vérifier s'il existe une telle login avec ce mot de passe
	 * @param $login
	 * @param $pass
	 * @return array - si OUI avec donnees, si NON array vide 
	 */
	public function existeUtilisateur($login, $pass) {

		//hache le mot de pass avec le SEL
		$pass = md5($pass.'ab1s2d3_%_q4w5e6');

		$db = new PDO('mysql:host=localhost;dbname=flycar', 'root', '');

		$utilisateur = $db->prepare("SELECT id, login, id_user, nom_user, prenom_user, email, nom_statut, telephone, suspendre, valider, statut FROM utilisateurs JOIN statuts ON statut = id_statut WHERE login = ? AND password = ?");
		$utilisateur->execute([$login, $pass]);

		return $utilisateur->fetchAll(PDO::FETCH_ASSOC);
	} // end function

	/**
	 * Enregistrement d'un nouvel utilisateur
	 * @param $user_donne array - toutes les données nécessaires
	 * @return boolean - la confirmation
	 */
	public function inscrireUtilisateur($user_donne) {
		$db = SingletonPDO::getInstance();

		$query = 'INSERT INTO utilisateurs ( ';
		foreach ($user_donne as $key => $value) {
			$query .= $key.', ';
		};
		$query = rtrim($query, ', ');
		$query .= ' ) VALUES ( ';
		foreach ($user_donne as $value) {
			$query .= ' ?, ';
		};
		$query = rtrim($query, ', ');
		$query .= ' );';

		$inscrire = $db->prepare($query);

		$inputs = [];

		foreach ($user_donne as $value) {
			$inputs[] = $value;
		}
		return $inscrire->execute($inputs);

	} // end function

	/**
	 * Modification d'un utilisateur
	 * @param $user_donne array - toutes les données nécessaires
	 * @param $id - le id de utilisateur
	 * @return boolean - la confirmation
	 */
	public function modifierUtilisateur($user_donne, $id) {
		$db = SingletonPDO::getInstance();

		$query = 'UPDATE utilisateurs SET ';
		foreach ($user_donne as $key => $value) {
			$query .= $key.' = ?, ';
		};
		$query = rtrim($query, ', ');
		$query .= ' WHERE id = ?;';

		$inscrire = $db->prepare($query);

		$inputs = [];

		foreach ($user_donne as $value) {
			$inputs[] = $value;
		}
		$inputs[] = $id;
		return $inscrire->execute($inputs);

	} // end function

	/**
	 * Renvoie la liste des utilisateurs selon le search entré
	 * @param $inputSearch - input de recherche (login, nom, prenom)
	 * @return array - information sur utilisateur
	 */
	public function getUtilisateursAllCourt($inputSearch = '') {
		$db = SingletonPDO::getInstance();

		if ($inputSearch == '') {
			$query = "SELECT id, login, nom_user, prenom_user, nom_statut, suspendre, valider FROM utilisateurs JOIN statuts ON statut = id_statut ORDER BY valider";
			$info = $db->prepare($query);
			$info->execute();
		} else {
			$query = "SELECT id, login, nom_user, prenom_user, nom_statut, suspendre, valider FROM utilisateurs JOIN statuts ON statut = id_statut WHERE (login LIKE '%$inputSearch%') OR (nom_user LIKE '%$inputSearch%') OR (prenom_user LIKE '%$inputSearch%') ORDER BY valider";
			$info = $db->prepare($query);
			$info->execute();
		}

		return $info->fetchAll(PDO::FETCH_ASSOC);
	}
	/**
	 * Renvoie la liste des administrateurs
	 * @return array - information sur admins
	 */

	public function getAllAdmins(){
		$db = SingletonPDO::getInstance();

		$admins = $db->prepare("SELECT id, login, nom_user, prenom_user FROM utilisateurs  WHERE statut < 3 ");
		$admins->execute();

		return $admins->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Renvoie les données de l'utilisateur 
	 * @param $id - id de utilisateur
	 * @return array - les donnees de l'utilisateur 
	 */
	public function getUtilisateur($id) {
		$db = new PDO('mysql:host=localhost;dbname=flycar', 'root', '');

		$utilisateur = $db->prepare("SELECT id, login, nom_user, prenom_user, nom_statut, id_user, email, telephone, statut, suspendre, valider, adresse, cod_post FROM utilisateurs JOIN statuts ON statut = id_statut WHERE id = ? ");
		$utilisateur->execute([$id]);

		return $utilisateur->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Calcule le nombre de nouveaux utilisateurs enregistrés
	 * @return nombre de l'utilisateur 
	 */
	public function getCountUserNouveau() {
		$db = SingletonPDO::getInstance();

		$nb = $db->prepare("SELECT COUNT(id) FROM utilisateurs WHERE valider IS NULL");
		$nb->execute();

		return $nb->fetchColumn();
	}

	/**
	 * Change la statut de utilisateur
	 * @param $idchange - le nouveau statut
	 * @param $id - l'utilisateur
	 * @return boolean - la confirmation
	 */
	public function changeStatut($idchange, $id) {
		$db = SingletonPDO::getInstance();

		$query = 'UPDATE utilisateurs SET statut = ? WHERE id = ?;';

		$modifie = $db->prepare($query);

		return $modifie->execute([$idchange, $id]);

	}

	/**
	 * Bloque l'utilisateur
	 * @param $idqui - par qui il a été bloqué 
	 * @param $id - l'utilisateur
	 * @return boolean - la confirmation
	 */
	public function bloqueUser($idqui, $id) {
		$db = SingletonPDO::getInstance();

		$query = 'UPDATE utilisateurs SET suspendre = ? WHERE id = ?;';

		$modifie = $db->prepare($query);

		return $modifie->execute([$idqui, $id]);

	}

	/**
	 * Debloque l'utilisateur
	 * @param $id - l'utilisateur
	 * @return boolean - la confirmation
	 */
	public function debloqueUser($id) {
		$db = SingletonPDO::getInstance();

		$query = 'UPDATE utilisateurs SET suspendre = NULL WHERE id = ?;';

		$modifie = $db->prepare($query);

		return $modifie->execute([$id]);

	}

	/**
	 * Active l'utilisateur avec la date actuelle
	 * @param $id - l'utilisateur
	 * @return boolean - la confirmation
	 */
	public function activeUser($id) {
		$db = SingletonPDO::getInstance();

		$query = 'UPDATE utilisateurs SET valider = NOW() WHERE id = ?;';

		$modifie = $db->prepare($query);

		return $modifie->execute([$id]);

	}

	/**
	 * Souprime l'utilisateur
	 * @param $id - l'utilisateur
	 * @return boolean - la confirmation
	 */
	public function supprimerUser($id) {
		$db = SingletonPDO::getInstance();

		$query = 'DELETE FROM utilisateurs WHERE id = ?;';

		$modifie = $db->prepare($query);

		return $modifie->execute([$id]);

	}





} // end class