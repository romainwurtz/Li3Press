<?php

/**
 * Li3Press: A CMS with the Lithium (Li3) framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */

namespace app\models;

class Uploads extends \lithium\data\Model {
    protected $_schema = array('upload_id' => array('type' => 'id'),
    'filename' => array('type' => 'string', 'default' => '', 'null' => false),
    'size' => array('type' => 'integer', 'default' => '', 'null' => false),
    'type' => array('type' => 'string', 'default' => '', 'null' => false),
    'thumbnail' => array('type' => 'boolean', 'default' => true, 'null' => false),
    'created' => array('type' => 'datetime', 'null' => false));
}

?>