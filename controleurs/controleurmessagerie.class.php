<?php 

class ControleurMessagerie {

	public function execute() {
		if(!isset($_SESSION['flyUser'])){
			if($_GET['action']!='alladmin'){
				header('Location:' .PATH);

			}else{
				$this->ecrireMessageAdmins();

			}
		}
		if (!Utils::getGet('action')) {
			$_GET['action'] = 'showAll';
		}

		if ($_GET['action'] == 'showAll') {
			$this->showAll();
		}

		if ($_GET['action'] == 'sent') {
			$this->showAllSent();
		}

		if ($_GET['action'] == 'show') {
			$this->show();
		}
		if ($_GET['action'] == 'showsent') {
			$this->showSent();
		}



		if ($_GET['action'] == 'ecrire') {
			$this->ecrireMessage();
		}

		if ($_GET['action'] == 'lu') {
			$this->messageLu();
		}

		if ($_GET['action'] == 'alladmin') {
			if(isset($_SESSION['flyUser'])){
				$this->ecrireMessageAdmins();

			}
		}

		if ($_GET['action'] == 'envoyer') {
			$this->creerMessage();
			$this->showAll();
		}

		if ($_GET['action'] == 'supprimer') {
			if (Utils::getGet('id')) {
				$id = Utils::getGet('id');
				$id = intval($id);
				$this->supprimerMessage($id);
			} else if(Utils::getPost('id_message')){
				$id = Utils::getPost('id_message');
				$id = intval($id);
				$this->supprimerMessage($id);
			}else{
				$this->showAll();

			}
		}

	} //end function

	private function showAll() {


		$modele = new ModeleMessagerie();
		$data['messages'] = $modele->getMessages($_SESSION['flyUser']['login']);
		$data['recu']=true;
		$vue = new ControleurVue();
		$vue->create('messagerie', ['data'=>$data] );

	} // end function

	private function showAllSent() {
		$modele = new ModeleMessagerie();
		$data['messages'] = $modele->getMessagesEnvoyer($_SESSION['flyUser']['login']);
		$data['recu']=false;

		$vue = new ControleurVue();
		$vue->create('messagerie', ['data'=>$data] );

	} // end function

	private function show() {

		if (!Utils::getGet('id')) {
			header('Location:' .PATH.'messagerie/');
		}

		$id = intval($_GET['id']);
		$modele = new ModeleMessagerie();
		$data = $modele->getMessage($id);
		$json = json_encode($data);
        echo $json;
		

	} // end function
	
	private function showSent() {

		if (!Utils::getGet('id')) {
			header('Location:' .PATH.'messagerie/');
		}

		$id = intval($_GET['id']);
		$modele = new ModeleMessagerie();
		$data = $modele->getMessageEnvoyer($id);
		$json = json_encode($data);
        echo $json;
		

	} // end function

	private function messageLu() {

		if (!Utils::getGet('id')) {
			header('Location:' .PATH.'messagerie/');
		}

		$id = intval($_GET['id']);
		$modele = new ModeleMessagerie();
		$date = date("Y-m-d H:i:s");
		$data = [
					'lire' => $date,
					'id_message' => $id
				];
		$resultat = $modele->messageLu($data);
		
		// $vue = new ControleurVue();
		// $vue->create('page', ['data'=>$data[0]] );

	} // end function


	private function ecrireMessage() {
		$data=[];
		if (isset($_POST['envoieMessage'])) {
			$modele = new ModeleUtilisateurs();
			$id = Utils::getPost('id');
			$id = intval($id);

			$destinataire=$modele->getUtilisateur($id);
			$data['destinataire']=$destinataire;
		}else if(isset($_POST['reponseMessage'])){
			$modele = new ModeleMessagerie();

			$id = Utils::getPost('id_message');
			$id = intval($id);
			$data_message = $modele->getMessage($id);
			$data['message']=$data_message;
		}else{
			header('Location:' .PATH.'messagerie/');
		}
		
		$vue=new ControleurVue();
		$vue->create('ecrire-message', ['data'=>$data] );

	} // end function

	private function ecrireMessageAdmins(){
		$data=[];
		if (isset($_POST['contact-message'])) {
			// echo 'hello';
			$modele = new ModeleMessagerie();
			$ModeleUtilisateurs= new ModeleUtilisateurs();
			$admins = $ModeleUtilisateurs->getAllAdmins();

			$destinataire = $admins;
			if(isset($_SESSION['flyUser']['login'])){
				$auteur = $_SESSION['flyUser']['login'];
			}else{
				$auteur = 'defaultUser';
			}

			$prenom=Utils::getPost('prenom');
			$nom=Utils::getPost('nom');
			$email=Utils::getPost('email');
			$url=Utils::getPost('url');
			$texte=Utils::getPost('texte');
			$sujet=Utils::getPost('sujet');

			$url = Utils::filtreFort($url);
			$prenom = Utils::filtreFort($prenom);
			$nom = Utils::filtreFort($nom);
			$email = Utils::filtreFort($email);
			$sujet = Utils::filtreFort($sujet);
			$texte = Utils::filtreFort($texte);
			$texte = 'Message envoyé aux administrateurs via le bas de page du site web.
			Email : ' .$email . ' 
			Prenom : '. $prenom . '
			Nom : '.$nom . ' 
			Message : 
			' . $texte;
			$date = date("Y-m-d H:i:s");
			foreach ($admins as $admin) {
				// echo $admin['login'];
				// echo '<br>';
				$data_message = [
									'auteur' => $auteur,
									'destinataire' => $admin['login'],
									'sujet' => $sujet,
									'text_message' => $texte,
									'ecrire' => $date
								];

				$creationMessage = $modele->creerMessage($data_message);
			}
			if($creationMessage){
				$_SESSION['succes'] = 'SUCCÈS: Le message a été envoyé';
			}else{
				$_SESSION['erreur'] = 'ERREUR: Le message n\'a pas été envoyé';
			}
			header('Location:'.$url);
			
		}else{
			header('Location:'.PATH);
		}
	}

	private function creerMessage() {
		$data=[];
		if (isset($_POST['message'])) {
			$modele = new ModeleMessagerie();

			$destinataire = Utils::getPost('destinataire');
			$auteur = $_SESSION['flyUser']['login'];
			$texte=Utils::getPost('texte');
			$sujet=Utils::getPost('sujet');
			$destinataire = Utils::filtreFort($destinataire);
			$texte = Utils::filtreFort($texte);
			$sujet = Utils::filtreFort($sujet);
			$date = date("Y-m-d H:i:s");
			$data_message = [
								'auteur' => $auteur,
								'destinataire' => $destinataire,
								'sujet' => $sujet,
								'text_message' => $texte,
								'ecrire' => $date,
							];

			$creationMessage = $modele->creerMessage($data_message);
			if($creationMessage){
				$_SESSION['success'] = 'SUCCÈS: Le message a été envoyé';
			}else{
				$_SESSION['erreur'] = 'ERREUR: Le message n\'a pas été envoyé';
			}
			
		}else{
			header('Location:' .PATH.'messagerie/');
		}
		

	} // end function


	

	private function supprimerMessage($id) {

		$modele = new ModeleMessagerie();
		$date = date("Y-m-d H:i:s");

		$supprimer = $modele->supprimerMessage($id, $date);

		if ($supprimer) {
			$_SESSION['success'] = 'SUCCÈS: Le message a été supprimée!';
		} else {
			$_SESSION['erreur'] = 'ERREUR: Le message n\'a pas été supprimée!';
		}

		header('Location:' .PATH.'messagerie/');

	}

} // end class