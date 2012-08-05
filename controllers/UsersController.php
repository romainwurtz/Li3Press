<?php

namespace app\controllers;

use app\models\Users;
use lithium\action\DispatchException;

class UsersController extends \lithium\action\Controller {

	public function index() {
		$users = Users::all();
		return compact('users');
	}

	public function view() {
		$user = Users::first($this->request->id);
		return compact('user');
	}

	public function add() {
		$user = Users::create();

		if (($this->request->data) && $user->save($this->request->data)) {
			return $this->redirect(array('Users::view', 'args' => array($user->id)));
		}
		return compact('user');
	}
}

?>