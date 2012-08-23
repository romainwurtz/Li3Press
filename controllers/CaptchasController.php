<?php

/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */

namespace app\controllers;



class CaptchasController extends \lithium\action\Controller {

    public function generate() {
        $img = new \Securimage();
        $img->image_width = 120;
        $img->image_height = 47;
        $img->num_lines = 2;
        return array('img' => $img->show());
    }

  

}

?>