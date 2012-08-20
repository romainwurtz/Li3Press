<?php
/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
  
namespace app\models;

class Posts extends \lithium\data\Model {
      public $hasMany = array('Comments');

      public $validates = array(
        'title' => array(
            array(
                'notEmpty',
                'required' => true,
                'message' => 'Please supply a title.'
            )
        ),
        'body' => array(
            array(
                'notEmpty',
                'required' => true,
                'message' => 'Please supply a content for this post.'
            )
        )
    );
	
}

?>
