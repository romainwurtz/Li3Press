<?php

/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author 		Romain Wurtz (http://www.t3kila.com)
 * @copyright		Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */

namespace app\controllers;

use app\models\Uploads;
use lithium\security\Auth;
use upload\UploadHandler;

class UploadsController extends \lithium\action\Controller {

    public function index() {
        
    }

    public function add() {
        $upload_handler = new UploadHandler();
        ob_start();
        $upload_handler->post();
        $output = ob_get_contents();
        ob_end_clean();
        return compact('output');
    }

}

?>