<?php 

class ControleurAccueilUser {

	public function execute() 
	{

		if (!Utils::getGet('action')) 
		{
			header("Location: ".PATH);
		}
			//var_dump($_GET);
			if ($_GET['action'] == 'show')
			{
						$this->show(); 
			}

			if ($_GET['action'] == 'ajax')
			{
				//$json = json_encode($this->getLocationsAccueil())
						echo $this->getLocationsAccueil(); //$this->getLocationsAccueil(); 
			}
			if ($_GET['action'] == 'ajaxpayees')
			{
				//$json = json_encode($this->getLocationsAccueil())
						echo $this->getPaidAccueil(); //$this->getLocationsAccueil(); 
			}
			if ($_GET['action'] == 'ajaxreservations')
			{
				//$json = json_encode($this->getLocationsAccueil())
						echo $this->getRes(); //$this->getLocationsAccueil(); 
			}
			if ($_GET['action'] == 'ajaxtopay')
			{
				//$json = json_encode($this->getLocationsAccueil())
						echo $this->getToPay(); //$this->getLocationsAccueil(); 
			}
			if ($_GET['action'] == 'ajaxrequetes')
			{
				//$json = json_encode($this->getLocationsAccueil())
						echo $this->getRequetes(); //$this->getLocationsAccueil(); 
			}

	} // end function

	public function getLocationsAccueil(){

		//Toutes les réservations en attentes ADMIN
		$modele = new ModeleLocation();
		$reservationsadmin = $modele->getCountReservationsAdmin($_SESSION['flyUser']['login']);
		return $reservationsadmin;
		//$data['reservationsadmin'] = $reservationsadmin;

	}

	public function getPaidAccueil(){

		//Toutes les réservations en attentes ADMIN
		$modele = new ModeleLocation();
		$reservationspayees = $modele->getCountReservationsPaidAdmin($_SESSION['flyUser']['login']);
		return $reservationspayees;
		//$data['reservationsadmin'] = $reservationsadmin;


	}

	public function getRes(){

		//Toutes les réservations en attentes ADMIN
		$modele = new ModeleLocation();
		$reservations = $modele->getCountReservationsUser($_SESSION['flyUser']['login']);
		return $reservations;
		//$data['reservationsadmin'] = $reservationsadmin;


	}

	public function getToPay(){

		//Toutes les réservations en attentes ADMIN
		$modele = new ModeleLocation();
		$reservationstopay = $modele->getCountReservationsToPayUser($_SESSION['flyUser']['login']);
		return $reservationstopay;
		//$data['reservationsadmin'] = $reservationsadmin;

	}

	public function getRequetes(){

		//Toutes les réservations en attentes ADMIN
		$modele = new ModeleLocation();
		$requetes = $modele->getCountRequetesOwner($_SESSION['flyUser']['login']);
		return $requetes;
		//$data['reservationsadmin'] = $reservationsadmin;

	}

	public function donneesNouveau() {
		$data = [];

		$modele = new ModeleUtilisateurs();
		$nouveauUser = $modele->getCountUserNouveau();
		$data['nouveauUser'] = $nouveauUser;

		$modeleMessagerie = new modeleMessagerie();
		$nbMessages= $modeleMessagerie->nbMessages($_SESSION['flyUser']['login']);
		$data['nbMessages'] = $nbMessages;

		//*********************************RESERVATIONS****************************************
		//Toutes les réservations en attentes ADMIN
		$modele = new ModeleLocation();
		$reservationsadmin = $modele->getCountReservationsAdmin($_SESSION['flyUser']['login']);
		$data['reservationsadmin'] = $reservationsadmin;

		//Toutes les réservations payées ADMIN
		$modele = new ModeleLocation();
		$reservationspayees = $modele->getCountReservationsPaidAdmin($_SESSION['flyUser']['login']);
		$data['reservationspayees'] = $reservationspayees;

		//Reservations en attentes pour locataires
		$modele = new ModeleLocation();
		$reservations = $modele->getCountReservationsUser($_SESSION['flyUser']['login']);
		$data['reservations'] = $reservations;

		//Reservations en attentes DE PAIEMENT pour locataires
		$modele = new ModeleLocation();
		$reservationstopay = $modele->getCountReservationsToPayUser($_SESSION['flyUser']['login']);
		$data['reservationstopay'] = $reservationstopay;

		//Vérification si user possède voiture
		//$modele = new ModeleLocation();
		//$cars = $modele->getCarsId($_SESSION['flyUser']['login']);
		//$data['cars'] = $cars;

		//Requêtes en attentes pour propriétaires
		$modele = new ModeleLocation();
		$requetes = $modele->getCountRequetesOwner($_SESSION['flyUser']['login']);
		$data['requetes'] = $requetes;
		//**************************************************************************************
		//var_dump($data); //die();
		return $data;
	}

	public function show() {

		$data = $this->donneesNouveau();

		$vue = new ControleurVue();
		$vue->create('accueilUser', ['data'=>$data] );

	} // end function

} // end class