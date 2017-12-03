<?php 
/**
 * La classe qui traite des commentaires 
 * et des notes dans la base de données
 * @author Denis
 * @version 1.0
 */
class ModeleAvis {

	public function getAvisVoiture($id) {

			$db = SingletonPDO::getInstance();

			$utilisateur = $db->prepare("SELECT id_avis, date_avis, text_avis, note_avis, login, prenom_user, nom_user, id FROM avis JOIN utilisateurs ON id = id_user_avis WHERE id_voiture_avis = ? ORDER BY date_avis");
			$utilisateur->execute([$id]);

			return $utilisateur->fetchAll(PDO::FETCH_ASSOC);

	}// end function

	/**
	 * Vérifiez s'il y a déjà un avis
	 * @param $id_louer - id de location
	 * @param $id_voiture - id de voiture
	 * @param $id_user - id de utilisateur
	 * @return si OUI - id de avis, si NON - FALSE
	 */
	public function existeAvis($id_louer, $id_voiture, $id_user) {
		$db = SingletonPDO::getInstance();

			$avis = $db->prepare("SELECT id_avis FROM avis WHERE id_louer_avis = ? AND id_voiture_avis = ? AND id_user_avis = ?");
			$avis->execute([$id_louer, $id_voiture, $id_user]);

			return $avis->fetchColumn(); 
	}

	/**
	 * Enregistrement d'un nouvel avis
	 * et calculer la note moyenne de voiture 
	 * @param $user_donne array - toutes les données nécessaires pour enregistrer un nouvel avis dans la base de données
	 * @return boolean - la confirmation
	 */
	public function enregistreAvis($user_donne) {
		$db = SingletonPDO::getInstance();

		$query = 'INSERT INTO avis ( ';
		foreach ($user_donne as $key => $value) {
			$query .= $key.', ';
		};
		$query = rtrim($query, ', ');
		$query .= ' ) VALUES ( ';
		foreach ($user_donne as $value) {
			$query .= ' ?, ';
		};
		$query = rtrim($query, ', ');
		$query .= ' );';

		$inscrire = $db->prepare($query);

		$inputs = [];

		foreach ($user_donne as $value) {
			$inputs[] = $value;
		}

		$temp = $inscrire->execute($inputs);

		// modification automatique de note generale ou voiture
		$this->noteMoyen($user_donne['id_voiture_avis']);
		// fin modification automatique de note generale ou voiture

		return $temp;

	}

	/**
	 * Supprimer un avis de la base de données
	 * @param $id_avis - avis à supprimer
	 * @param $id_voiture - pour recalculer la note moyenne
	 * @return boolean - la confirmation
	 */
	public function souprimeAvis($id_avis, $id_voiture) {
		$db = SingletonPDO::getInstance();

		$query = 'DELETE FROM avis WHERE id_avis = ?;';

		$modifie = $db->prepare($query);

		$temp = $modifie->execute([$id_avis]);

		$this->noteMoyen($id_voiture);

		return $temp;
	}

	/**
	 * Calcul automatique de la note moyenne de l'automobile
	 * @param $id_voiture
	 * @return modifie la note de voiture
	 */
	private function noteMoyen($id_voiture) {
		$db = SingletonPDO::getInstance();

		$notes = $db->prepare("SELECT note_avis FROM avis WHERE id_voiture_avis = ? ");
		$notes->execute([$id_voiture]);

		$arrayNotes = $notes->fetchAll(PDO::FETCH_ASSOC);
		
		$sum = 0;
		$i = 0;
		foreach ($arrayNotes as $value) {
			if($value['note_avis']>0 && $value['note_avis']<=5) {
				$sum += $value['note_avis'];
				$i++;
			}
		}

		if ($i != 0 ) $moyen = $sum / $i; else $moyen = 0;
		
		$modifier = $db->prepare('UPDATE voitures SET note = ? WHERE id_voiture = ?');
		$modifier->execute([$moyen, $id_voiture]);

	}

} // end class
