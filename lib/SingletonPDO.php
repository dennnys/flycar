<?php
	//defined('FLYCAR') or die('<h1 style="color:red">Acc&egrave;ss interdit!</h1>');
/**
 * Connexion à la base de données en utilisant la méthode Singleton
 */

namespace lib;

class SingletonPDO {

		private $PDOInstance = null;
				
		private static $instance = null;
		
		private function __construct(){
				$this->PDOInstance = new PDO('mysql:host=localhost;dbname= flycar, root,, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
				$this->PDOInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		}
		
		public function getInstance(){
				if(is_null(self::$instance)){
						//echo 'Je vais creer une instance de PDO<br/>';
						self::$instance = new SingletonPDO();
				}
				//echo 'Je renvoie l\'instance<br/>';
				return self::$instance;
		}

		private function __clone(){}
		
		function __call($name, $arguments){
				
				return $this->PDOInstance->{$name}(implode(',', $arguments));
		}

}
