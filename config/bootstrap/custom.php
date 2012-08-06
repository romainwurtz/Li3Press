<?php

use app\models\Users;
use lithium\security\Password;

Users::applyFilter('save', function($self, $params, $chain) {
    if ($params['data']) {
        $params['entity']->set($params['data']);
        $params['data'] = array();
    }
    if (!$params['entity']->exists()) {
    	if ($params['entity']->password && strlen($params['entity']->password) >= 4)
        $params['entity']->password = Password::hash($params['entity']->password);
    }
    return $chain->next($self, $params, $chain);
});

use lithium\util\Validator;
 
Validator::add('usernameTaken', function($value) {
	$success = false;
		
	if (strlen($value) != 0)
    	$success = count(Users::findByUsername($value)) == 0 ? false : true;
    return !$success;
});

?>