<?php 
	defined('FLYCAR') or die('<h1 style="color:red">Acc&egrave;ss interdit!</h1>');
/**
 * La classe qui traite de la connexion et de l'inscription des utilisateurs
 */
class Autentification {

	public function execute() {

		/**
		 * Vérifiez l'action activée, connectez ou inscrivez
		 */
			if (!Utils::getSession('flyUser')) {
				if(isset($_COOKIE['flyUserLogin'])
					&&isset($_COOKIE['flyUserLogin'])) {
					$this->entreCookie();
				}

				if(isset($_POST['enregistrer'])){
					$this->enregistrer();
				}
			}
	} // end function

	/**
	 * Enregistrez votre identifiant et votre mot de passe dans le cookie
	 */
	private function entreCookie() {
		$login = $_COOKIE['flyUserLogin'];
		$pass = $_COOKIE['flyUserPass'];

		$modeleUser = new ModeleUtilisateurs;
		$utilisateur = $modeleUser->existeUtilisateur($login, $pass);
		if(!empty($utilisateur)) {
			$_SESSION['flyUser'] = $utilisateur[0];
		}
	}

	/**
	 * Vérification de login et mot de passe pour l'authentification
	 * En cas de connexion réussie, entrée de données utilisateur en session
	 */
	private function enregistrer() {
		$login = Utils::getPost('login');
		$pass = Utils::getPost('pass');
		$url =  Utils::getPost('url');
		if (($login !== false)&&($pass !== false)) {

			$login = Utils::filtreFort($login);
			$pass = Utils::filtreFort($pass);

			// verification dans la base de données si existe set login et pass
			$modeleUser = new ModeleUtilisateurs;
			$utilisateur = $modeleUser->existeUtilisateur($login, $pass);

			// ecrire dans la SESSION la resultate de recherche
			if(empty($utilisateur)) {
				$_SESSION['erreur'] = 'ERREUR: Votre login ou mot de passe est incorrect !';
			} else {
				if ($utilisateur[0]['valider'] == null) {
					$_SESSION['erreur'] = 'ATENTION: Votre statut est en linghne de validation par administrateur !';
					//header("Location: ".PATH);
				}elseif ($utilisateur[0]['suspendre'] != null) {
					$_SESSION['erreur'] = 'ERREUR: Votre statut est suspendu par administrateur !';
				} else {
						$_SESSION['flyUser'] = $utilisateur[0];
						$memorise = Utils::getPost('memorise');
						// memorise les login et mot de pass dans la variable  cookies
						if ( $memorise == 'oui' ) {
							$cookieLogin = $login;
							$cookiePass = md5($pass.SEL);
							setcookie('flyUserLogin', $cookieLogin, time()+3600*24*30);
							setcookie('flyUserPass', $cookiePass, time()+3600*24*30);
						} else {
							setcookie('flyUserLogin', '');
							setcookie('flyUserPass', '');
						}
						header("Location: ".$url);
					}
			}
		}
	} // end function

	/**
	 * Enregistrer un nouvel utilisateur
	 */
	public function inscrire() {

		if(isset($_POST['inscrire'])) {

			if (Utils::getPost('checkboxe') && $_POST['checkboxe'] == 1) {

				$modeleUser = new ModeleUtilisateurs;

				$id_user = Utils::getPost('permis_u_c');
				$nom_user = Utils::getPost('nom_u_c');
				$prenom_user = Utils::getPost('prenom_u_c');
				$login = Utils::getPost('login_u_c');
				$email = Utils::getPost('email_u_c');
				$telephone = Utils::getPost('tel_u_c');
				$adresse = Utils::getPost('adresse_u_c');
				$cod_post = Utils::getPost('codepostal_u_c');
				$passoword = Utils::getPost('pass_u_c');
				$passoword2 = Utils::getPost('passconf_u_c');
				$arrayInput['id_user'] = $id_user;
				$arrayInput['nom_user'] = $nom_user;
				$arrayInput['prenom_user'] = $prenom_user;
				$arrayInput['login'] = $login;
				$arrayInput['email'] = $email;
				$arrayInput['telephone'] = $telephone;
				$arrayInput['adresse'] = $adresse;
				$arrayInput['cod_post'] = $cod_post;
				$_SESSION['temp_flycar'] = $arrayInput;

				if (($id_user !== false)&&($nom_user !== false)
						&&($prenom_user !== false)&&($login !== false)
						&&($email !== false)&&($telephone !== false)
						&&($adresse !== false)&&($passoword !== false)
						&&($passoword2 !== false)&&($cod_post !== false)) {

					if ($passoword == $passoword2) {

						$id_user = Utils::filtreFort($id_user);
						$nom_user = Utils::filtreFort($nom_user);
						$prenom_user = Utils::filtreFort($prenom_user);
						$login = Utils::filtreFort($login);
						$email = Utils::filtreFort($email);
						$telephone = Utils::filtreFort($telephone);
						$adresse = Utils::filtreFort($adresse);
						$passoword = Utils::filtreFort($passoword);
						$cod_post = Utils::filtreFort($cod_post);

						$passoword = md5($passoword.SEL);

						if($modeleUser->existeLogin($login)) {
							$_SESSION['erreur'] = 'ERREUR: Utilisateur avec set login deja existe!';
							header("Location: ".PATH.'inscrire');
						} else {
							if($modeleUser->existePermis($id_user)) {
								$_SESSION['erreur'] = 'ERREUR: Set numero de permis existe deja dan la sisteme!';
								header("Location: ".PATH.'inscrire');
							} else {

			// upload file
			$type_file = pathinfo($_FILES["img-phot_u_c"]["name"], PATHINFO_EXTENSION);
			$type_file2 = pathinfo($_FILES["img-permis_u_c"]["name"], PATHINFO_EXTENSION);
			$type_file = strtolower($type_file);
			$type_file2 = strtolower($type_file2);
			//var_dump($_FILES); die();
			if ($type_file == 'jpg' && $type_file2 == 'jpg') {
				move_uploaded_file($_FILES['img-phot_u_c']['tmp_name'], 'upload/utilisateurs/'.$login.'.jpg');
				move_uploaded_file($_FILES['img-permis_u_c']['tmp_name'], 'upload/utilisateurs/'.$login.'_p.jpg');
			

								// inscrire dan la base de donne le utilisateur
								$user_donne = [
																'login' => $login,
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
								$utilisateur = $modeleUser->inscrireUtilisateur($user_donne);
								if($utilisateur) { 
									unset($_SESSION['temp_flycar']);
									$_SESSION['succes'] = 'SUCCES: Le demande a ete envoie avec succes!'; 
									$modeleMessagerie = new modeleMessagerie();
									$texte = 'Bonjour!
									Bienvenue dans le plus grande banque de voitures à louer de particulier. Nous sommes heureux de vous avoir comme nouveau membre chez Flycar. Profiter des belles voitures offertes chez nous!
									Au plaisir
									L\'administration';
									$data_message = [
										'auteur' => 'superadmin',
										'destinataire' => $login,
										'sujet' => 'Bienvenue chez Flycar',
										'text_message' => $texte,
										'ecrire' => $date
									];
									$creationMessage = $modeleMessagerie->creerMessage($data_message);
									header("Location: ".PATH);
								}
									else { $_SESSION['erreur'] = 'ERREUR: Le utilisateur ete pas cree!'; 
									header("Location: ".PATH.'inscrire');
									}
								} else {
									$_SESSION['erreur'] = 'ERREUR: Juste de image avec extansion <b>.jpg</b>!';
									header("Location: ".PATH.'inscrire');
								}
							}
						}
					} else {
						$_SESSION['erreur'] = 'ERREUR: Le mot de passe sont pas edantique!';
						header("Location: ".PATH.'inscrire');
					}
				}
				 else {
					$_SESSION['erreur'] = 'ERREUR: Toutes le champs sont obligatoare!';
					header("Location: ".PATH.'inscrire');
				}
			} else {
				$_SESSION['erreur'] = 'ERREUR: Pour etre membre vous doi accepe le condition!';
				header("Location: ".PATH.'inscrire');
			}
		} else {

			$data = [];

			$vue = new ControleurVue();
			$vue->create('inscrirerUser', ['data'=>$data] );
		}

	} // end function

} //end class