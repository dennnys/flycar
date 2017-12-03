<?php 
/**
 * La classe qui crée la vue
 * @author Denis
 * @version 1.0
 */
class ControleurVue {

	private $_headerData;
	private $_footerData;

	private $_fichier;

	/**
	 * Fonctions d'appel pour création d'informations pour header et footer
	 */
	public function __construct() {
		$this->_headerData = $this->headerData();
		$this->_footerData = $this->footerData();
	} // end function constructeur

	/**
	 * Création d'informations pour le contenu de la page 
	 * et l'appel de la Vue
	 * @param $fichier string - le nome de la vue
	 * @param $donnees array - les donness
	 */
	public function create($fichier, $donnees) {
		$donnees['header'] = $this->_headerData;
		$donnees['footer'] = $this->_footerData;
		$_fichier = 'vues/'.THEME.'/'.$fichier.'.php';
		//var_dump($donnees);
		extract($donnees);
		// eccesible variable $header, $data, $footer
		//var_dump($header);
		require_once $_fichier;
	}

	/**
	 * Appeler le modèle d'information de header
	 * @return array
	 */
	private function headerData() {
		$header = new ControleurHeader();
		$data = $header->execute();
		//$data = ['menu'=>$modeleHeader->menuPage()];
		return $data;
	}

	/**
	 * Appeler le modèle d'information de footer
	 */
	private function footerData() {

	}

} // end class