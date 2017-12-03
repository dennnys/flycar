<?php

use PHPUnit\Framework\TestCase;
use modeles;

/**
 * Test quelques fonctions de la classe ModelesUtilisateur
 * avec PHPUnit
 * @author Denis
 * @version 1.0
 */
class FlycarTest extends TestCase {

	/**
	 * Vérifier s'il y a une connexion
	 * @param $str - login pour teste
	 * @param $strbool - boolean
	 * @dataProvider providerExiteLogin
	 */
	public function testExiteLogin($str, $strbool) {

		$modele = new modeles\ModeleUtilisateurs();

		$this->assertEquals($modele->existeLogin($str), $strbool);
	}

	public function providerExiteLogin() {
		return [
			['superadmin', true],
			['admin', true],
			['dennys', true],
			[456546, false],
			['asdfg', false],
			['', false]
		];
	} // fin provider

	/**
	 * Vérifier s'il y a une permis de conduit
	 * @param $id - login pour teste
	 * @param $idbool - boolean
	 * @dataProvider providerExistePermis
	 */ 
	public function testExistePermis($id, $idbool) {

		$modele = new modeles\ModeleUtilisateurs();

		$this->assertEquals($modele->existePermis($id), $idbool);
	}

	public function providerExistePermis() {
		return [
			['B1234-567890-12', true],
			['B6523-310183-07', true],
			['TRUMP-POWER1234', true],
			[456546, false],
			['asdfg', false],
			['', false]
		];
	} // fin provide

	/**
	 * Vérifier s'il existe le utilisateur
	 * @param $login - login pour teste
	 * @param $pass - mot de pass
	 * @dataProvider providerExisteUtilisateur
	 */ 
	public function testExisteUtilisateur($login, $pass) {

		$modele = new modeles\ModeleUtilisateurs();

		$this->assertCount(1, $modele->existeUtilisateur($login, $pass));
	}

	public function providerExisteUtilisateur() {
		return [
			['dennys', '123'],
			['superadmin', '123'],
			['admin', '123']
		];
	} // fin provide

	/**
	 * Vérifier s'il existe les données de l'utilisateur
	 * @param $id - id de l'utilisateur
	 * @dataProvider providerGetUtilisateur
	 */ 
	public function testGetUtilisateur($id) {

		$modele = new modeles\ModeleUtilisateurs();

		$this->assertCount(1, $modele->getUtilisateur($id));
	}

	public function providerGetUtilisateur() {
		return [
			['1'],
			[1],
			['2'],
			[2],
			['20'],
			[20]
		];
	} // fin provide


} // fin class