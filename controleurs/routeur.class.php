<?php 
	defined('FLYCAR') or die('<h1 style="color:red">Acc&egrave;ss interdit!</h1>');
	
/**
 * La classe qui dirige quel contrôleur sera appliqué
 * @author Denis
 * @version 1.0
 */
class Routeur {

	private $_ctrlPage;
	private $_autentification;

	/**
	 * Vérification automatique si l'utilisateur est connecté
	 * @see lib/autentification.class.php
	 */
	public function __construct() {

		$this->_autentification = new Autentification;
		$this->_autentification->execute();

	} // end constructor

	/**
	 * Rediriger vers le contrôleur requis
	 * @param string $_GET['controleur']
	 */
	public function execute() {

		if (!isset($_GET['controleur'])) {
			$_GET['controleur'] = 'accueil';
		}

		switch ($_GET['controleur']) {
			case 'accueil':
				$this->accueil();
				break;
			case 'page':
				$this->page();
				break;
			case 'deconection':
				$this->deconection();
				break;
			case 'location':
				$this->location();
				break;
			case 'inscrire':
				$this->inscrire();
				break;
			case 'messagerie':
				$this->messagerie();
				break;
			case 'utilisateur':
				$this->utilisateur();
				break;
			case 'accueiluser':
				$this->accueilUser();
				break;
			case 'voitures':
				$this->voitures();
				break;
			case 'test':
			$this->test();
			break;

			default:
				$this->accueil();
				break;
		}


	} // end function

	private function accueil() {
		$_ctrlPage = new ControleurAccueil();
		$_ctrlPage->execute();
	}

	private function accueilUser() {
		if (!Utils::isConnecter()) {
			header("Location: ".PATH);
		} else {
			$_ctrlPage = new ControleurAccueilUser();
			$_ctrlPage->execute();
		}
	}

	private function page() {
		$_ctrlPage = new ControleurPage();
		$_ctrlPage->execute();
	}

	private function utilisateur() {
		if (!Utils::isConnecter()) {
			header("Location: ".PATH);
		} else {
			$_ctrlPage = new ControleurUtilisateur();
			$_ctrlPage->execute();
		}
	}

	private function inscrire() {
		if (Utils::isConnecter()) {
			header("Location: ".PATH);
		} else {
		$this->_autentification->inscrire();
		}
	}

	private function location() {
		$_ctrlPage = new ControleurLocation();
		$_ctrlPage->execute();
	}

	private function messagerie() {
		$_ctrlPage = new ControleurMessagerie();
		$_ctrlPage->execute();
	}

	private function voitures() {		
		$_ctrlPage = new ControleurVoiture();
		$_ctrlPage->execute();
	
	}

	private function deconection() {
		$_SESSION = array();
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		setcookie('flyUserLogin', '');
		setcookie('flyUserPass', '');
		session_destroy();
		//$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
		header("Location: ".PATH);
	}

	private function test() {
		$_ctrlPage = new ControleurTest();
		$_ctrlPage->execute();
	}

} // end class