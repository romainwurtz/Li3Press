<?php
 /**
  * Li3Press: A simple blog using Lithium framework
  *
  * @author 		Romain Wurtz (http://www.t3kila.com)
  * @copyright		Copyright 2012, Romain Wurtz (http://www.t3kila.com)
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
	Router::connect('/blog/page/{:page:[0-9]+}', array('controller' => 'posts', "action" => 'index'));
	Router::connect('/blog/page/{:page:[0-9]+}.{:type}', array('controller' => 'posts', "action" => 'indexAction'));
	Router::connect('/blog/{:action}/{:id:[0-9]+}.{:type}', array('controller' => 'posts'));
	Router::connect('/blog/{:action}/{:id:[0-9]+}', array('controller' => 'posts'));
	Router::connect('/blog/{:action}.{:type}', array('controller' => 'posts'));
	Router::connect('/blog/{:action}', array('controller' => 'posts'));
	Router::connect('/admin/{:action}.{:type}', array('controller' => 'users'));
	Router::connect('/admin/{:action}', array('controller' => 'users'));
}
?>