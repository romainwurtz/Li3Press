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

	protected function getUsers(&$users) {
		$users = Users::find('all');
		return count($users);
	}

	protected function getUser($id, &$user) {
		$user = null;
		$success = false;

		if ($id > 0)
			$success = (($user = Users::find($id))) ? true : false;
		return $success;
	}

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
			$user = Users::create($this -> request -> data);
			if (!($success = $user -> save())) {
				$errors = $user -> errors();
			}
		}
		return compact('success', 'errors');
	}

	public function add() {
		if (!Auth::check('default')) {
			return $this -> redirect('Sessions::add');
		}
	}

	public function listUsers() {
		$users = array();

		if (!Auth::check('default')) {
			return $this -> redirect('Sessions::add');
		}
		self::getUsers($users);
		return compact('users');
	}

	public function deleteAction() {
		$url = "";
		$success = false;
		$errors = array();

		if (!Auth::check('default')) {
			$errors['login'] = 'You need to be logged.';
		} else if (!$this -> request -> is('post')) {
			$errors['call'] = 'This action can only be called with post';
		} else {
			if (!($success = self::getUser($this -> request -> data['id'], $user))) {
				$errors['user'] = 'This user doesn\'t exist';
			} else if (!($success = $user -> delete())) {
				$errors = $post -> errors();
			}
		}
		return compact('success', 'errors');
	}

	public function view() {
		$success = self::getUser($this -> request -> id, $user);
		return compact('success', 'user');
	}

	public function edit() {
		if (!Auth::check('default')) {
			return $this -> redirect('Sessions::add');
		}
		if (!($success = self::getUser($this -> request -> id, $user))) {
			$this -> redirect(array('Users::add'));
		}
		return compact('success', 'user');
	}

	public function editAction() {
		$errors = array();
		$success = false;
		$errors = array();

		if (!Auth::check('default')) {
			$errors['login'] = 'You need to be logged.';
		} else if (!$this -> request -> is('post')) {
			$errors['call'] = 'This action can only be called with post';
		} else {
			if (!($success = self::getUser($this -> request -> data['id'], $user))) {
				$errors['user'] = 'This post doesn\'t exist';
			}
			if ($success && $this -> request -> data) {
				if (!($success = $user -> save($this -> request -> data))) {
					$errors += $user -> errors();
				} else {
					$currentSession = Auth::check('default');
					if ($currentSession && $currentSession['id'] == $this -> request -> data['id']) {
						$currentSession = $this -> request -> data + $currentSession;
						Auth::set('default', $currentSession);
					}
				}
			}
		}
		return compact('success', 'errors');
	}

}
?>
