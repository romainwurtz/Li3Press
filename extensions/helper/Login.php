<?php

namespace app\extensions\helper;
use lithium\security\Auth;

class Login extends \lithium\template\Helper {
	public function isUserAuth() {
		return Auth::check('default') ? true : false;
	}
}
?>