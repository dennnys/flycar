<?php 
/**
 * La classe qui traite de l'affichage, de la création, de l'édition et de la suppression de pages statiques
 * @author Denis
 * @version 1.0
 */
class ControleurPage {

	/**
	 * La fonction qui dirige l'action choisie
	 * @param string $_GET['action']
	 */
	public function execute() {

		if (!Utils::getGet('action')) {
			$_GET['action'] = 'show';
		}

		if ($_GET['action'] == 'show') {
			$this->show();
		}

		if ($_GET['action'] == 'modification') {
			if (Utils::getGet('id')) {
				$id = Utils::getGet('id');
				$id = intval($_GET['id']);
				$this->modification($id);
			} else {
				$this->modificationAll();
			}
		}

		if ($_GET['action'] == 'cree') {
			$this->creePage();
		}

		if ($_GET['action'] == 'supprimer') {
			if (Utils::getGet('id')) {
				$id = Utils::getGet('id');
				$id = intval($_GET['id']);
				$this->souprimePage($id);
			} else {
				$this->modificationAll();
			}
		}

	} //end function

	/**
	 * Création d'informations de une page pour l'affichage
	 * appeler le modèle et la vue
	 */
	private function show() {

		if (!Utils::getGet('id')) {
			$_GET['id'] = '1';
		}

		$id = intval($_GET['id']);

		$modele = new ModelePage();
		$data = $modele->getPage($id);

		$vue = new ControleurVue();
		$vue->create('page', ['data'=>$data[0]] );

	} // end function

	/**
	 * Création d'informations de list des pages pour l'affichage 
	 * appeler le modèle et la vue
	 */
	private function modificationAll() {

		$modele = new ModelePage();
		$data = $modele->getPageAllCourt();

		$vue = new ControleurVue();
		$vue->create('modificationAllPages', ['data'=>$data] );

	} // end function

	/**
	 * Modifier une page static 
	 * appeler le modèle et la vue
	 * @param une array de $_POST
	 * @return le mesage de SUCCES ou de ERREUR
	 */
	private function modification($id) {
		$modele = new ModelePage();

		if (isset($_POST['modifie_page'])) {
			$id_page = Utils::getPost('id_page');
			$title_page = Utils::getPost('title_page');
			$description_page = Utils::getPost('description_page');
			$keywords_page = Utils::getPost('keywords_page');
			$contenu_page = Utils::getPost('contenu_page');
			$id_vie = Utils::getPost('id_vie');

			$id_page = intval($id_page);
			
			if (($title_page) == '') $title_page = false;

			if (($id_page != false)&&($title_page != false)) {
				if ($id_page != $id_vie) {
					$temp = $modele->existeIdPage($id_page); }
					else {
						$temp = [];
					}
				if (empty($temp)) {
					$user_donne = [
													'id_page' => $id_page,
													'title' => $title_page,
													'description' => $description_page,
													'keywords' => $keywords_page,
													'contenu' => $contenu_page,
													'id_vie' => $id_vie
												];

					$resultat = $modele->modificationPage($user_donne); 
					
					if ($resultat) {
						$_SESSION['success'] = 'SUCCES: Toutes les données sont enregistrées !';
						header("Location: ".PATH.'page/modification');
					} else {
						$_SESSION['erreur'] = 'ERREUR: Une erreur s\'est produite!';
						header("Location: ".PATH.'page/modification/'.$id_vie);
					} 
				} else {
					$_SESSION['erreur'] = 'ERREUR: Ce <b>ID</b> existe déjà!';
					header("Location: ".PATH.'page/modification/'.$id_vie);
				}

			} else {
				$_SESSION['erreur'] = 'ERREUR: Les champs <b>ID</b> et <b>titre</b> sont obligatoires!';
				header("Location: ".PATH.'page/modification/'.$id_vie);
			}

		} else {

			$modele = new ModelePage();
			$data = $modele->getPage($id);

			$vue = new ControleurVue();
			$vue->create('modificationPage', ['data'=>$data] );
		}
	} // end function

	/**
	 * Enregistre une page static 
	 * appeler le modèle et la vue
	 * @param une array de $_POST
	 * @return le mesage de SUCCES ou de ERREUR
	 */
	private function creePage() {

		if (isset($_POST['cree_page'])) {
			$modele = new ModelePage();

			$id_page_c = Utils::getPost('id_page_c');
			$title_page_c = Utils::getPost('title_page_c');
			$description_page_c = Utils::getPost('description_page_c');
			$keywords_page_c = Utils::getPost('keywords_page_c');
			$contenu_page_c = Utils::getPost('contenu_page_c');

			$id_page_c = intval($id_page_c);
			
			if (($title_page_c) == '') $title_page_c = false;

			if (($id_page_c != false)&&($title_page_c != false)) {
				
				$temp = $modele->existeIdPage($id_page_c);

				if (empty($temp)) {
					$user_donne = [
													'id_page' => $id_page_c,
													'title' => $title_page_c,
													'description' => $description_page_c,
													'keywords' => $keywords_page_c,
													'contenu' => $contenu_page_c
												];

					$resultat = $modele->creePage($user_donne); 
					
					if ($resultat) {
						$_SESSION['success'] = 'SUCCÈS: Toutes le données sont enregistrées!';

						header("Location: ".PATH.'page/modification');

					} else {
						$_SESSION['erreur'] = 'ERREUR: Une erreur s\'est produite !';
						header("Location: ".PATH.'page/cree');
					} 
				} else {
					$_SESSION['erreur'] = 'ERREUR: Ce <b>ID</b> existe déjà!';
					header("Location: ".PATH.'page/cree');
				}

			} else {
				$_SESSION['erreur'] = 'ERREUR: Les champs <b>ID</b> et <b>titre</b> sont obligatoires!';
				header("Location: ".PATH.'page/cree');
			}
			$_SESSION['id_page_c'] = $_POST['id_page_c'];
			$_SESSION['title_page_c'] = $_POST['title_page_c'];
			$_SESSION['description_page_c'] = $_POST['description_page_c'];
			$_SESSION['keywords_page_c'] = $_POST['keywords_page_c'];
			$_SESSION['contenu_page_c'] = $_POST['contenu_page_c'];

		} else {

			if (!isset($_SESSION['erreur'])) {
				unset($_SESSION['id_page_c']);
				unset($_SESSION['title_page_c']);
				unset($_SESSION['description_page_c']);
				unset($_SESSION['keywords_page_c']);
				unset($_SESSION['contenu_page_c']);
			}

			$data = [];
			$vue = new ControleurVue();
			$vue->create('creePage', ['data'=>$data] );
		}

	} // end function

	/**
	 * Supprimer une page statique
	 * @param int $id
	 * @return le mesage de SUCCES ou de ERREUR
	 */
	private function souprimePage($id) {

		$modele = new ModelePage();
		$souprime = $modele->souprimePage($id);

		if ($souprime) {
			$_SESSION['success'] = 'SUCCÈS: La page a été supprimée!';
		} else {
			$_SESSION['erreur'] = 'ERREUR: La page n\'a pas été supprimée!';
		}

		$this->modificationAll();

	}

} // end class