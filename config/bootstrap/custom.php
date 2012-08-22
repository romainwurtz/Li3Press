<?php

/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
use app\models\Users;
use app\models\Comments;
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

use lithium\util\Validator;

Validator::add('usernameTaken', function($value) {
            $success = false;

            if (strlen($value) != 0)
                $success = count(Users::findByUsername($value)) == 0 ? false : true;
            return !$success;
        });

use lithium\core\Libraries;

Libraries::add('upload', array('path' => LITHIUM_APP_PATH . '/libraries/_source/upload/'));

define('_INSTALL', file_exists($_SERVER['DOCUMENT_ROOT'] . "/install") ? '1' : '0');
?>
