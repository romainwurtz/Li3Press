<?php

/**
 * Li3Press: A CMS with the Lithium (Li3) framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */

namespace app\controllers;

class CaptchasController extends \lithium\action\Controller {

    protected static $_securimage = null;

    public function init() {
        self::$_securimage = new \Securimage();
    }

    public function __construct() {
        self::init();
    }

    public function generate() {
        if (!self::$_securimage)
            self::init();
        self::$_securimage->image_width = 120;
        self::$_securimage->image_height = 47;
        self::$_securimage->num_lines = 2;
        return array('img' => self::$_securimage->show());
    }

    public function check($captcha, &$errors) {
        $success = false;
        if (!self::$_securimage)
            self::init();

        if ($captcha == "")
            $errors['captcha'] = 'No security code entered';
        else if (!($success = self::$_securimage->check($captcha))) {
            $errors['captcha'] = 'Incorrect security code entered';
        }
        return $success;
    }

}

?>