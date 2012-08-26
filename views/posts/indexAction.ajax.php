<?php

/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
if ($posts) {
    foreach ($posts as $post) {
        echo $this->_render('element', 'post', compact('post'), array('type' => 'html'));
    }
}
?>