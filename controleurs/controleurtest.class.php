<?php 

class ControleurTest {

	public function execute() {

		$this->show();

	} // end function

	private function show() {
		// $modele=new ModeleVoitures();
		// $data = $modele->getDatesLocation(1);
		$data=[];
		$vue = new ControleurVue();
		$vue->create('test', ['data'=>$data] );

	} // end function

} // end class