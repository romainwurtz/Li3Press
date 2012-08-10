<?php
/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author 		Romain Wurtz (http://www.t3kila.com)
 * @copyright		Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 *
 */

namespace app\controllers;

use app\models\Users;
use lithium\security\Auth;
use lithium\action\DispatchException;

class UsersController extends \lithium\action\Controller {

	public function addUser($login, $password, &$errors) {
		$success = false;

		$user = Users::create(array('username' => $login, 'password' => $password));
		if (!($success = $user -> save())) {
			$errors = $user -> errors();
		}
		return $success;
	}

	public function index() {
		if (!Auth::check('default')) {
			return $this -> redirect('Sessions::add');
		}
	}

	public function addAction() {
		$success = false;
		$errors = array();

		if (!Auth::check('default')) {
			$errors['login'] = 'You need to be logged.';
		} else if (!$this -> request -> is('post')) {
			$errors['call'] = 'This action can only be called with post';
		} else if ($this -> request -> data) {
			$post = Users::create($this -> request -> data);
			if (!($success = $post -> save())) {
				$errors = $post -> errors();
			}
		}
		return compact('success', 'errors');
	}

	public function add() {
		if (!Auth::check('default')) {
			return $this -> redirect('Sessions::add');
		}
	}

}
?>