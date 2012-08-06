<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

/**
 * The routes file is where you define your URL structure, which is an important part of the
 * [information architecture](http://en.wikipedia.org/wiki/Information_architecture) of your
 * application. Here, you can use _routes_ to match up URL pattern strings to a set of parameters,
 * usually including a controller and action to dispatch matching requests to. For more information,
 * see the `Router` and `Route` classes.
 *
 * @see lithium\net\http\Router
 * @see lithium\net\http\Route
 */
use lithium\net\http\Router;

if (file_exists($_SERVER['DOCUMENT_ROOT']."/install")) {
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
}
?>