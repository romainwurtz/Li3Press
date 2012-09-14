<?php

/**
 * Li3Press: A CMS with the Lithium (Li3) framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
use lithium\net\http\Router;

if (_INSTALL) {
    Router::connect('/', 'Installs::index');
    Router::connect('/install/{:action}.{:type}', array('controller' => 'installs'));
} else {

    Router::connect('/', 'Posts::index');
    Router::connect('/login', 'Sessions::add');
    Router::connect('/logout', 'Sessions::delete');

    // MORE USER FRIENDLY
    Router::connect('/admin/comments/list', array('controller' => 'comments', 'action' => 'listComments'));
    Router::connect('/admin/users/list', array('controller' => 'users', 'action' => 'listUsers'));
    Router::connect('/admin/posts/list', array('controller' => 'posts', 'action' => 'listPosts'));
    Router::connect('/admin/posts/add', array('controller' => 'posts', 'action' => 'add'));
    Router::connect('/admin/posts/edit/{:id:[0-9]+}', array('controller' => 'posts', 'action' => 'edit'));
    Router::connect('/admin/files/{:action}', array('controller' => 'uploads'));
    
    Router::connect('/blog/page/{:page:[0-9]+}', array('controller' => 'posts', "action" => 'index'));
    Router::connect('/blog/page/{:page:[0-9]+}.{:type}', array('controller' => 'posts', "action" => 'indexAction'));
    Router::connect('/blog/{:action}/{:id:[0-9]+}.{:type}', array('controller' => 'posts'));
    Router::connect('/blog/{:action}/{:id:[0-9]+}', array('controller' => 'posts'));
    Router::connect('/blog/{:action}.{:type}', array('controller' => 'posts'));
    Router::connect('/blog/{:action}', array('controller' => 'posts'));

    Router::connect('/admin', 'Users::index');
    Router::connect('/users/{:action}.{:type}', array('controller' => 'users'));
    Router::connect('/users/{:action}', array('controller' => 'users'));
    Router::connect('/user/{:action}/{:id:[0-9]+}', array('controller' => 'users'));

    Router::connect('/upload/{:action}.{:type}', array('controller' => 'uploads'));
    
    Router::connect('/comments/list/{:id:[0-9]+}', array('controller' => 'comments', 'action' => 'indexAction'));
    Router::connect('/comments/list/{:id:[0-9]+}.{:type}', array('controller' => 'comments', 'action' => 'indexAction'));
    Router::connect('/comments/{:id:[0-9]+}/{:action}.{:type}', array('controller' => 'comments'));
    Router::connect('/comments/{:action}.{:type}', array('controller' => 'comments'));
    Router::connect('/comments/{:action}', array('controller' => 'comments'));

    
    Router::connect('/captcha/{:action}', array("controller" => 'captchas', 'type' => 'ajax'));
    Router::connect('/captcha/{:args}', array("controller" => 'captchas'));
}
?>
