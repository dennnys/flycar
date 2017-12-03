<?php 
/**
 * La classe qui traite des pages static 
 * dans la base de données
 * @author Denis
 * @version 1.0
 */
class ModelePage {

	/**
	 * Recherche des informations sur la base de données 
	 * pour la page avec la identification $id
	 * @param $id - id de la page
	 * @return array - information de la page
	 */
	public function getPage($id) {
		$db = SingletonPDO::getInstance();

		$page = $db->prepare("SELECT * FROM pages WHERE id_page = ?");
		$page->execute([$id]);

		return $page->fetchAll(PDO::FETCH_ASSOC);
	} // end function

	/**
	 * Recherche le id et le nom de toutes les pages statiques
	 * @return array
	 */
	public function getPageAllCourt() {
		
		$db = SingletonPDO::getInstance();

		$page = $db->prepare("SELECT id_page, title FROM pages");
		$page->execute();

		return $page->fetchAll(PDO::FETCH_ASSOC);
	} // end function

	/**
	 * Modification de une page statique
	 * @param $user_donne - toutes les données utilisateur
	 * @return boolean - la confirmation
	 */
	public function modificationPage($user_donne) {
		$db = SingletonPDO::getInstance();

		$query = 'UPDATE pages SET ';

		foreach ($user_donne as $key => $value) {
			if ($key != 'id_vie') $query .= $key.' = ?, '; 
		}
		$query = rtrim($query, ', ');
		$query .= ' WHERE id_page = ?;';

		$inscrire = $db->prepare($query);

		//var_dump($query);

		$inputs = [];

		foreach ($user_donne as $value) {
			$inputs[] = $value;
		}

		return $inscrire->execute($inputs);
	} // end function

	/**
	 * Creation de une page statique
	 * @param $user_donne - toutes les données utilisateur
	 * @return boolean - la confirmation
	 */
	public function creePage($user_donne) {
		$db = SingletonPDO::getInstance();

		$query = "INSERT INTO pages (";
		foreach ($user_donne as $key => $value) {
			$query .= $key.', ';
		};
		$query = rtrim($query, ', ');
		$query .= ") VALUES ( ";
		foreach ($user_donne as $value) {
			$query .= ' ?, ';
		};
		$query = rtrim($query, ", ");
		$query .= ");";

		$inscrire = $db->prepare($query);

		$inputs = [];

		foreach ($user_donne as $value) {
			$inputs[] = $value;
		}
		return $inscrire->execute($inputs);

	}// end function

	/**
	 * Effacement de une page statique
	 * @param $id - id de la page
	 * @return boolean - la confirmation
	 */
	public function souprimePage($id) {
		$db = SingletonPDO::getInstance();

		$query = "DELETE FROM pages WHERE id_page = ?";

		$souprime = $db->prepare($query);

		return $souprime->execute([$id]);

	} // end function

	/**
	 * Vérifier s'il existe déjà une telle id
	 * @param $id 
	 * @return si OUI - le array avec id, si NON - le array vide
	 */
	public function existeIdPage($id) {
		$db = SingletonPDO::getInstance();

		$utilisateur = $db->prepare("SELECT title FROM pages WHERE id_page = ?;");
		$utilisateur->execute([$id]);

		return $utilisateur->fetchAll(PDO::FETCH_ASSOC);
	} // end function


} // end class