<?php 

class ControleurAccueil {

	public function execute() {

		$this->show();

	} // end function

	private function show() {

		
		$data = [];
		$modele = new ModeleVoitures();
		$data['cheap']= $modele->getVoituresMoinsCher();
		$data['new']= $modele->getVoituresRecentes();

		$vue = new ControleurVue();
		$vue->create('accueil', ['data'=>$data] );

	} // end function

} // end class