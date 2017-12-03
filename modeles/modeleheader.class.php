<?php 
/**
 * La classe qui traite des information pour header 
 * dans la base de données
 * @author Denis
 * @version 1.0
 */
class ModeleHeader {

	/**
	 * Extraire l'identifiant et nommer des pages statiques
	 * @return array - id des pages et les titres
	 */
	public function menuPage(){
		$db = SingletonPDO::getInstance();

		$page = $db->prepare("SELECT id_page, title FROM pages");
		$page->execute();

		return $page->fetchAll(PDO::FETCH_ASSOC);
	}

} // end class