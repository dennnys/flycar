<?php 
//On empeche les utilisateurs non registrées d'avoir accèss directement au fichiers
defined('FLYCAR') or die('<h1 style="color:red">Acc&egrave;ss interdit!</h1>');
/**
 * Le modèle qui gère la messagerie
 * dans la base de données
 * @author Jonathan
 * @version 1.0
 */
class ModeleMessagerie {
	/**
	 * liste les messages recu par l'utilisateur
	 * @param $login - username de l'utilisateur
	 * @return array - information sur les messages envoyé à l'utilisateur
	 */
	public function getMessages($username) {
		$db = SingletonPDO::getInstance();

		$page = $db->prepare("SELECT * FROM messages JOIN utilisateurs on utilisateurs.login = messages.auteur WHERE destinataire = ? AND supprimer IS NULL ORDER BY messages.ecrire DESC");
		$page->execute([$username]);

		return $page->fetchAll(PDO::FETCH_ASSOC);
	} // end function
	/**
	 * Liste les messages envoyé par l'utilisateur
	 * @param $login - username de l'utilisateur
	 * @return array - information sur les messages envoyé par l'utilisateur
	 */
	public function getMessagesEnvoyer($username) {
		$db = SingletonPDO::getInstance();

		$page = $db->prepare("SELECT * FROM messages JOIN utilisateurs on utilisateurs.login = messages.destinataire WHERE auteur = ? ORDER BY messages.ecrire DESC");
		$page->execute([$username]);

		return $page->fetchAll(PDO::FETCH_ASSOC);
	} // end function
	/**
	 * Liste le message envoyé par l'utilisateur
	 * @param $id - id du message envoyé
	 * @return array - information sur le message envoyé par l'utilisateur
	 */
	public function getMessageEnvoyer($id) {
		$db = SingletonPDO::getInstance();

		$message = $db->prepare("SELECT * FROM messages JOIN utilisateurs on utilisateurs.login = messages.destinataire WHERE id_message = ?");
		$message->execute([$id]);

		return $message->fetchAll(PDO::FETCH_ASSOC);
	} // end function
	

	/**
	 * Liste le message envoyé à l'utilisateur
	 * @param $id - id du message recu
	 * @return array - information sur le message envoyé à l'utilisateur
	 */

	public function getMessage($id) {
		$db = SingletonPDO::getInstance();

		$message = $db->prepare("SELECT * FROM messages JOIN utilisateurs on utilisateurs.login = messages.auteur WHERE id_message = ?");
		$message->execute([$id]);

		return $message->fetchAll(PDO::FETCH_ASSOC);
	} // end function

	/**
	 * Nombre de messages non lu par l'utilisateur
	 * @param $login - username de l'utilisateur
	 * @return int - nombre de message non lu
	 */
	public function nbMessages($username) {
		$db = SingletonPDO::getInstance();

		$nbMessages = $db->prepare("SELECT COUNT(id_message) FROM messages WHERE destinataire = ? AND lire IS NULL");
		$nbMessages->execute([$username]);

		return $nbMessages->fetchColumn();
	} // end function

	/**
	 * Supprimer le message pour plus qu'il ne s'affiche dans la liste de message de l'utilisateur. Cependant on garde le message dans la DB (pour que celui qui l'a envoyé puisse toujours le voir dans sa boite "Messages Envoyés")
	 * @param $id - id du message à "supprimer"
	 * @param $date - valeur qui entre dans le champ supprimer pour garder la date de suppression.
	 * 
	 * @return booleon - opération bien réussi on non
	 */

	public function supprimerMessage($id, $date) {
		$db = SingletonPDO::getInstance();
		$query = "UPDATE messages SET supprimer='".$date."' WHERE id_message = ?";

		$supprimer = $db->prepare($query);
		
		return $supprimer->execute([$id]);

	} // end function
	public function messageLu($data) {
		$db = SingletonPDO::getInstance();

		$query = "UPDATE messages SET ";
		foreach ($data as $key => $value) {
			if ($key != 'id_message') $query .= $key.' = ?, '; 
		}
		$query = rtrim($query, ', ');
		$query .= ' WHERE id_message = ? AND lire IS NULL;';

		$inscrire = $db->prepare($query);
		// var_dump($query);
		$inputs = [];

		foreach ($data as $value) {
			$inputs[] = $value;
		}

		return $inscrire->execute($inputs);

	}// end function

	public function creerMessage($message_data) {
		$db = SingletonPDO::getInstance();

		$query = "INSERT INTO messages (";
		foreach ($message_data as $key => $value) {
			$query .= $key.', ';
		};
		$query = rtrim($query, ', ');
		$query .= ") VALUES ( ";
		foreach ($message_data as $value) {
			$query .= ' ?, ';
		};
		$query = rtrim($query, ", ");
		$query .= ");";

		$message = $db->prepare($query);

		$inputs = [];

		foreach ($message_data as $value) {
			$inputs[] = $value;
		}
		return $message->execute($inputs);

	}// end function

} // end class