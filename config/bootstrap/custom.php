<?php

/**
 * Li3Press: A CMS with the Lithium (Li3) framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
use app\models\Users;
use app\models\Comments;
use app\models\Uploads;
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

Comments::applyFilter('save', function($self, $params, $chain) {
            if ($params['data']) {
                $params['entity']->set($params['data']);
                $params['data'] = array();
            }
            if (!$params['entity']->id)
                $params['entity']->created = date('Y-m-d H:i:s');
            $params['entity']->updated = date('Y-m-d H:i:s');
            return $chain->next($self, $params, $chain);
        });

Uploads::applyFilter('save', function($self, $params, $chain) {
            if ($params['data']) {
                $params['entity']->set($params['data']);
                $params['data'] = array();
            }
            if (!$params['entity']->id)
                $params['entity']->created = date('Y-m-d H:i:s');
            return $chain->next($self, $params, $chain);
        });

use lithium\util\Validator;

Validator::add('usernameTaken', function($value) {
            $success = false;

            if (strlen($value) != 0)
                $success = count(Users::findByUsername($value)) == 0 ? false : true;
            return !$success;
        });

use lithium\core\Libraries;

Libraries::add('upload', array('path' => LITHIUM_APP_PATH . '/libraries/_source/upload/'));
Libraries::add('captcha', array('path' => LITHIUM_APP_PATH . '/libraries/_source/captcha/', 'webroot' => LITHIUM_APP_PATH . '/libraries/_source/captcha/', "bootstrap" => "securimage.php",));

define('_INSTALL', file_exists($_SERVER['DOCUMENT_ROOT'] . "/install") ? '1' : '0');

function getBaseUrl() {
    $protocol = (isset($_SERVER["HTTPS"]) && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    return $protocol . "://" . $_SERVER['HTTP_HOST'];
}

use lithium\core\Environment;

Environment::is(function($request) {
             return in_array($request->env('SERVER_ADDR'), array('::1', '127.0.0.1')) ? 'development' : 'production';
        });
?>
