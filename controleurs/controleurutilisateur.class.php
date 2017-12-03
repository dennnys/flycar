<?php 
/**
 * La classe qui traite de l'affichage, de la création, de l'édition et de la suppression de utilisateur
 * @author Denis
 * @version 1.0
 */
class ControleurUtilisateur {
	/**
	 * La fonction qui dirige l'action choisie
	 * @param string $_GET['action']
	 */
	public function  execute() {

		if (!Utils::getGet('action')) {
			header("Location: ".PATH);
		}

		if ($_GET['action'] == 'all') {
			if (Utils::getStatut()<2) {
				$this->showAll();
			} else {
				header("Location: ".PATH);
			}
		}

		if ($_GET['action'] == 'show') {
			if(Utils::getGet('id')) {
				$id = $_GET['id'];
				$this->show($id);
			} else {
				header("Location: ".PATH);
			}
		}

		if ($_GET['action'] == 'profil') {
			if(Utils::isConnecter()) {
				$this->profil();
			} else {
				header("Location: ".PATH);
			}
		}

	} // end function

	/**
	 * Création d'informations de list des utilisateurs 
	 * appeler le modèle et la vue
	 */
	private function showAll() {
		$modele = new ModeleUtilisateurs();
		$inputSearch = Utils::getPost('input-user-search');

		if(isset($_POST['user-search']) && $inputSearch) {
			$data = $modele->getUtilisateursAllCourt($inputSearch);
		} else {
			$data = $modele->getUtilisateursAllCourt();
		}

		$vue = new ControleurVue();
		$vue->create('utilisateursAll', ['data'=>$data] );
	} // end function

	/**
	 * Modification de la profil de utilisateur
	 * @param $_POST - dates de changement
	 */
	private function profil() {

		if(isset($_POST['modifie-profile'])) {
			$modeleUser = new ModeleUtilisateurs;

			$id_user = Utils::getPost('permis_u_m');
			$nom_user = Utils::getPost('nom_u_m');
			$prenom_user = Utils::getPost('prenom_u_m');
			$email = Utils::getPost('email_u_m');
			$telephone = Utils::getPost('tel_u_m');
			$adresse = Utils::getPost('adresse_u_m');
			$cod_post = Utils::getPost('codepostal_u_m');

			$passoword = Utils::getPost('pass1_u_m');
			$passoword2 = Utils::getPost('pass2_u_m');

			$pass_u_m = Utils::getPost('pass_u_m');

			if (($id_user !== false)&&($nom_user !== false)
				&&($prenom_user !== false)
				&&($email !== false)&&($telephone !== false)
				&&($adresse !== false)&&($pass_u_m !== false)
				&&($cod_post !== false)) {

					$utilisateur = $modeleUser->existeUtilisateur($_SESSION['flyUser']['login'], $pass_u_m);

					if(!empty($utilisateur)) {

						if(($passoword == false && $passoword2 == false)
							 || ($passoword != false && ($passoword == $passoword2))) {

							if($modeleUser->existePermis($id_user) 
								&& ($id_user != $_SESSION['flyUser']['id_user'])) {
								$_SESSION['erreur'] = 'ERREUR: Set numero de permis existe deja dan la sisteme!';
								header("Location: ".PATH.'utilisateur/profil');
							} else { 

			// upload file
								//var_dump($_FILES["img-permis_u_m"]); die();
		if ((isset($_FILES["img-phot_u_m"])) 
			&& ($_FILES["img-phot_u_m"]['error'] != 4)) {
			$type_file = pathinfo($_FILES["img-phot_u_m"]["name"], PATHINFO_EXTENSION);
			$type_file = strtolower($type_file);
			if ($type_file == 'jpg') {
				move_uploaded_file($_FILES['img-phot_u_m']['tmp_name'], 'upload/utilisateurs/'.$_SESSION['flyUser']['login'].'.jpg');
			} else {
				$_SESSION['erreur'] = 'ERREUR: Juste de image avec extansion <b>.jpg</b>!';
			}
		}
		if ((isset($_FILES["img-permis_u_m"]))
			 && ($_FILES["img-permis_u_m"]['error'] != 4)) {
			$type_file2 = pathinfo($_FILES["img-permis_u_m"]["name"], PATHINFO_EXTENSION);
			$type_file2 = strtolower($type_file2);
			if ($type_file2 == 'jpg') {
				move_uploaded_file($_FILES['img-permis_u_m']['tmp_name'], 'upload/utilisateurs/'.$_SESSION['flyUser']['login'].'_p.jpg');
			} else {
				$_SESSION['erreur'] = 'ERREUR: Juste de image avec extansion <b>.jpg</b>!';
			}
		} // fin upload file
			// modifie dan la base de donne le utilisateur
		if ($passoword != null) {
				$passoword = md5($passoword.SEL);
				$user_donne = [
												'id_user' => $id_user,
												'nom_user' => $nom_user,
												'prenom_user' => $prenom_user,
												'email' => $email,
												'telephone' => $telephone,
												'adresse' => $adresse,
												'password' => $passoword,
												'cod_post' => $cod_post,
												'statut' => '3'
											];
			} else {
				$user_donne = [
												'id_user' => $id_user,
												'nom_user' => $nom_user,
												'prenom_user' => $prenom_user,
												'email' => $email,
												'telephone' => $telephone,
												'adresse' => $adresse,
												'cod_post' => $cod_post,
												'statut' => '3'
											];
			}

			$utilisateur = $modeleUser->modifierUtilisateur($user_donne, $_SESSION['flyUser']['id']);
			if($utilisateur) { 
				$_SESSION['succes'] = 'SUCCES: Le modification sont enregistre avec succes! <br><i>Pour le donne aparetre deconecte et reconecte</i>'; 
				header("Location: ".PATH);
			}
				else { $_SESSION['erreur'] = 'ERREUR: Une erreur se produit!';
				header("Location: ".PATH);
				}
								}
						} else {
							$_SESSION['erreur'] = 'ERREUR: Le mot de passe sont pas edantique!';
							header("Location: ".PATH.'utilisateur/profil');
						}

					} else {
						$_SESSION['erreur'] = 'ERREUR: Votre mot de passe est incorrect !';
						header("Location: ".PATH.'utilisateur/profil');
					}
			} else {
				$_SESSION['erreur'] = 'ERREUR: Toutes le champs sont obligatoare!';
				header("Location: ".PATH.'utilisateur/profil');
			}

		} else {
			$modele = new ModeleUtilisateurs();
			$data = $modele->getUtilisateur($_SESSION['flyUser']['id']);
			$vue = new ControleurVue();
			$vue->create('utilisateurProfil', ['data'=>$data] );
		}
	}

	/**
	 * Création d'informations de une utilisateur pour l'affichage
	 * appeler le modèle et la vue
	 * Activez, bloquez, supprimez et modifiez le statut d'un utilisateur si vous êtes une superadmin.
	 */
	private function show($id) {
		$modele = new ModeleUtilisateurs();

		if (isset($_POST['change-statut-user'])) {
			$idchange = Utils::getPost('statut-user-admin');
			if ($idchange) {
				$changeStatut = $modele->changeStatut($idchange, $id);
				if ($changeStatut) {
					$_SESSION['succes'] = 'SUCCES: Le statut a ete modifie!';
				} else {
					$_SESSION['erreur'] = "ERREUR: Le statut n'a pas ete modifie!";
				}
			}
		}

		if (isset($_POST['bloque-user-admin'])) {
			$idLocation = Utils::getPost('accepter-location-id');
			if ($idLocation) {
				$changeStatut = $modele->bloqueUser($idqui, $id);
				if ($changeStatut) {
					$_SESSION['succes'] = 'SUCCES: Le utilisateur a ete bloqué!';
				} else {
					$_SESSION['erreur'] = "ERREUR: Le utilisateur n'a pas ete bloqué!";
				}
			}
		}

		if (isset($_POST['debloque-user-admin'])) {
				$changeStatut = $modele->debloqueUser($id);
				if ($changeStatut) {
					$_SESSION['succes'] = 'SUCCES: Le utilisateur a ete debloqué!';
				} else {
					$_SESSION['erreur'] = "ERREUR: Le utilisateur n'a pas ete debloqué!";
				}
		}


		if (isset($_POST['active-user-admin'])) {
				$activeUser = $modele->activeUser($id);
				if ($activeUser) {
					$_SESSION['succes'] = 'SUCCES: Le utilisateur a ete active!';
				} else {
					$_SESSION['erreur'] = "ERREUR: Le utilisateur n'a pas ete active!";
				}
		}

		if (isset($_POST['supprimer-user-admin'])) {
				$activeUser = $modele->supprimerUser($id);
				if ($activeUser) {
					$_SESSION['succes'] = 'SUCCES: Le utilisateur a ete supprimer!';
					$this->showAll();
				} else {
					$_SESSION['erreur'] = "ERREUR: Le utilisateur n'a pas ete supprimer!";
				}
		}

		$data = $modele->getUtilisateur($id);

		$modeleVoitures = new ModeleVoitures();
		$voitures = $modeleVoitures->getVoituresProprietaire($data[0]['login']);

		$vue = new ControleurVue();
		$vue->create('utilisateurShow', ['data'=>$data, 'voitures'=>$voitures] );
	}

} // end class