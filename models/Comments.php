<?php
/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author 				Adrien Candiotti
 * @copyright		Copyright 2012, Adrien Candiotti
 *
 */
  
namespace app\models;

class Comments extends \lithium\data\Model {
      public $validates = array(
        'title' => array(
           array(
                'notEmpty',
                'required' => true,
                'message' => 'Please supply a title.')),
        'body' => array(
           array(
                'notEmpty',
                'required' => true,
                'message' => 'Please supply a content for this comment.'))
      );
	
}

?>
