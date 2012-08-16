<?php

namespace app\extensions\helper;
use lithium\security\Auth;

class Login extends \lithium\template\Helper {
	protected function user() {
		return Auth::check('default');
	}
		
	public function isUserAuth() {
		return Auth::check('default') ? true : false;
	}

	public function displayName() {
		$displayName = "";
		$user = self::user();
		if ($user)
			$displayName .= $user['username'];
		return $displayName;
	}
	
}
?>