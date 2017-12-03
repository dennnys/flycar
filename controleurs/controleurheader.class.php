<?php 
/**
 * La classe qui traite de la création d'informations pour header
 * @author Denis
 * @version 1.0
 */
class ControleurHeader {

	private $_data = [];

	/**
	 * Modèles d'appel pour créer des informations de header
	 * @return array - les informations dans la base de données pour header
	 */
	public function execute() {
		$modeleHeader = new ModeleHeader();
		$data_menu = $modeleHeader->menuPage();
		$modeleVoiture = new ModeleVoitures();
		$data_type=$modeleVoiture->getTypeVoiture();

		$this->_data['menu'] = $data_menu;
		$this->_data['type'] = $data_type;

	if (Utils::isConnecter()) {
		$controleurUser = new ControleurAccueilUser();
		$donneesNouveau = $controleurUser->donneesNouveau();
		$this->_data['notifications'] = $donneesNouveau;
	}
		return $this->_data;
	}

} // end class