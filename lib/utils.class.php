<?php 

/**
 * Classe avec des fonctions statique utilitaires qui aident dans la programmation
 */
class Utils {

	/**
	 * Vérifiant s'il y a la variable $_POST['value']
	 * @param string $value
	 * @return si existe - la valeur de la variable $_POST[$value]
	 * @return s'il n'existe pas - boolean FALSE
	 */
	static function getPost($value) {
		if (isset($_POST[$value])) {
			return $_POST[$value];
		} else { return false; }
	}

	/**
	 * Vérifiant s'il y a la variable $_GET['value']
	 * @param string $value
	 * @return si existe - la valeur de la variable $_GET[$value]
	 * @return s'il n'existe pas - boolean FALSE
	 */
	static function getGet($value) {
		if (isset($_GET[$value])) {
			return $_GET[$value];
		} else { return false; }
	}

	/**
	 * Vérifiant s'il y a la variable $_SESSION['value']
	 * @param string $value
	 * @return si existe - la valeur de la variable $_SESSION[$value]
	 * @return s'il n'existe pas - boolean FALSE
	 */
	static function getSession($value) {
		if (isset($_SESSION[$value])) {
			return $_SESSION[$value];
		} else { return false; }
	}

		/**
	 * Vérifiant s'il y a la variable $_SESSION['flyUser'][$value]
	 * @param string $value
	 * @return si existe - la valeur de la variable $_SESSION['flyUser'][$value]
	 * @return s'il n'existe pas - boolean FALSE
	 */
	static function getFlyUserSession($value) {
		if (isset($_SESSION['flyUser'][$value])) {
			return $_SESSION['flyUser'][$value];
		} else { return false; }
	}

	/**
	 * Fonction qui supprime toutes les étiquettes
	 * @param string $str
	 * @return string $str
	 */
	static function filtreFort($str) {
		$str = trim($str);
		$str = strip_tags($str);
		//$str = mysqli_real_escape_string(SingletonPDO::getInstance(), $str);
		return $str;
	}

	/**
	 * Vérifiez si l'utilisateur est connecté
	 * @return boolean si Oui - TRUE si Non - False
	 */
	static function isConnecter() {
		if (isset($_SESSION['flyUser'])) {
			return true;
		} else { return false; }
	}

	/**
	 * Vérifiez si l'utilisateur est superadmin et est connecté
	 * @return si Oui - 1 si Non - False
	 */
	static function isSuperAdmin() {
		if (self::isConnecter()) {
			if ($_SESSION['flyUser']['statut'] == 1) {
				return 1;
			} else { return false; }
		} else { return false; }
	}

	/**
	 * Vérifiez si l'utilisateur est admin et est connecté
	 * @return si Oui - 2 si Non - False
	 */
	static function isAdmin() {
		if (self::isConnecter()) {
			if ($_SESSION['flyUser']['statut'] == 2) {
				return 2;
			} else { return false; }
		} else { return false; }
	}

	/**
	 * Vérifiez si l'utilisateur est user et est connecté
	 * @return si Oui - 3 si Non - False
	 */
	static function isUser() {
		if (self::isConnecter()) {
			if ($_SESSION['flyUser']['statut'] == 3) {
				return 3;
			} else { return false; }
		} else { return false; }
	}

	/**
	 * Vérifiez l'état de l'utilisateur connecté
	 * @return statut de utilizateur si est pas connecte - FALSE
	 */
	static function getStatut() {
		if (isset($_SESSION['flyUser']['statut'])) {
				return $_SESSION['flyUser']['statut'];
		} else { return false; }
	}

}


