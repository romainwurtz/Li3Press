<?php
 /**
  * Li3Press: A simple blog using Lithium framework
  *
  * @author 		Romain Wurtz (http://www.t3kila.com)
  * @copyright		Copyright 2012, Romain Wurtz (http://www.t3kila.com)
  * 
  */
  
namespace app\models;

class Users extends \lithium\data\Model {

	    public $validates = array(
        'username' => array(
            array(
                'notEmpty',
                'required' => true,
                'message' => 'Please supply a username.'
            ),
            array(
                'alphaNumeric',
                'message' => 'A username may only contain letters and numbers.'
            ),
            array(
                'usernameTaken',
                'message' => 'This username already exist.'
            ),
            array(
            	'lengthBetween',
            	'min' => 4,
                'message' => 'A username must be at least 4 characters.'
			),
        ),
        'password' => array(
            array(
                'notEmpty',
                'required' => true,
                'message' => 'Please supply a password.'
            ),
             array(
            	'lengthBetween',
            	'min' => 4,
                'message' => 'A password must be at least 4 characters.'
			),
        )
    );
	
}

?>