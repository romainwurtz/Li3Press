<?php

/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */

namespace app\controllers;

use lithium\security\Auth;

class SessionsController extends \lithium\action\Controller {

    public function add() {
        if ($this->request->data && Auth::check('default', $this->request)) {
            return $this->redirect('/');
        } else {
            
        }
    }

    public function delete() {
        Auth::clear('default');
        return $this->redirect('/');
    }

}

?>