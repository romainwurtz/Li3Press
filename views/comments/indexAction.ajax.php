<?php
/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */

if ($comments) {
    foreach ($comments as $comment) {
        echo $this->_render('element', 'comment', compact('comment'), array('type' => 'html'));
    }
}
?>