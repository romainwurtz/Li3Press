<?php

namespace app\controllers;

use app\models\Users;
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

}

?>