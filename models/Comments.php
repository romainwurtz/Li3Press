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

    protected $_schema = array('comments_id' => array('type' => 'id'),
        'name' => array('type' => 'string', 'default' => '', 'null' => false),
        'email' => array('type' => 'string', 'default' => '', 'null' => false),
        'website' => array('type' => 'string', 'default' => '', 'null' => false),
        'body' => array('type' => 'string', 'default' => '', 'null' => false),
        'updated' => array('type' => 'datetime', 'null' => false),
        'created' => array('type' => 'datetime', 'null' => false),
        'post_id' => array('type' => 'integer', 'default' => 0, 'null' => false));
    public $validates = array(
        'name' => array(
            array(
                'notEmpty',
                'required' => true,
                'message' => 'Please supply a title.')),
        'email' => array(
            array(
                'notEmpty',
                'required' => true,
                'message' => 'Please supply an email.'),
            array(
                'email',
                'skipEmpty' => true,
                'message' => 'Email not valid.'),
        ),
        'body' => array(
            array(
                'notEmpty',
                'required' => true,
                'message' => 'Please supply a content for this comment.')),
        'website' => array(
            array(
                'url',
                'skipEmpty' => true,
                'message' => 'Website is not a valid url.')),
        'post_id' => array(
            array(
                'notEmpty',
                'required' => true,
                'message' => 'A comment belongs to a post.'))
    );

}

?>
