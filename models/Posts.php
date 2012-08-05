<?php

namespace app\models;

class Posts extends \lithium\data\Model {
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
