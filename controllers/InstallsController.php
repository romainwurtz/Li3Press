<?php
 /**
  * Li3Press: A simple blog using Lithium framework
  *
  * @author 		Romain Wurtz (http://www.t3kila.com)
  * @copyright		Copyright 2012, Romain Wurtz (http://www.t3kila.com)
  * 
  */
 
namespace app\controllers;

use app\models\Users;
use app\controllers\PostsController;
use app\controllers\UsersController;
use lithium\data\Model;
use lithium\action\DispatchException;

class InstallsController extends \lithium\action\Controller {

	protected static $_install = false;

	# FIXME : put into a file
	protected static $_sql = "

DROP TABLE IF EXISTS `posts`;

CREATE TABLE IF NOT EXISTS `posts` (`id` int(11) NOT NULL AUTO_INCREMENT,
				    `title` text NOT NULL,
				    `body` text NOT NULL,
				    `visibility` tinyint NOT NULL DEFAULT 1,
				     PRIMARY KEY (`id`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS `users`;

CREATE TABLE IF NOT EXISTS `users` (`id` int(11) NOT NULL AUTO_INCREMENT,
				    `username` varchar(256) NOT NULL,
				    `password` varchar(256) NOT NULL,
				    PRIMARY KEY (`id`), UNIQUE KEY `username` (`username`)) ENGINE=InnoDB;";
	# ENDFIXME

	# FIXME : put into the unittest mock, replace with some instructions 
	# about the blog maybe?
	protected static $_lorem = "Cupcake ipsum dolor sit. Amet pastry cheesecake. Danish sesame snaps caramels wypas. Caramels candy dragée dragée halvah cupcake. Bear claw gingerbread tiramisu candy tart sweet roll marzipan. Icing macaroon faworki.\
Halvah chocolate macaroon bonbon jelly macaroon faworki. Cheesecake dessert chocolate cake cotton candy sesame snaps fruitcake.<br />Marshmallow dragée chocolate cake tiramisu candy muffin sugar plum sesame snaps. Sugar plum halvah ice cream wafer toffee icing. Chocolate bar candy donut topping gummies tiramisu muffin pudding. Gummies oat cake marzipan pie ice cream marshmallow macaroon marzipan caramels.\
Pie biscuit pudding jelly beans chocolate oat cake. Danish cotton candy tootsie roll. Jelly muffin lemon drops wafer bonbon wafer chocolate bar dessert. Pie danish tootsie roll cotton candy. Halvah chocolate pie dragée apple pie candy canes marshmallow. Liquorice bonbon apple pie jelly-o jelly-o.\
Biscuit bonbon powder pie pastry cheesecake gummies. Tootsie roll jelly marzipan pastry tootsie roll chupa chups chupa chups wafer.<br />Gummies marshmallow sugar plum apple pie marzipan cookie.\ Cupcake gummies pastry. Chupa chups lollipop croissant. Tart lollipop carrot cake applicake.<br />Gummies caramels cheesecake liquorice dragée. Chocolate bar sesame snaps chupa chups candy canes. Soufflé cookie chupa chups cheesecake pudding cookie.\
Toffee cheesecake cupcake caramels jujubes gingerbread cookie sesame snaps. Candy canes caramels cupcake cotton candy oat cake. Cheesecake cheesecake dessert tart. Donut tiramisu apple pie. Sweet roll pudding donut chocolate tiramisu tiramisu marzipan. Chocolate cake sesame snaps sweet.";
	# ENDFIXME

	protected function _init() {
		parent::_init();

		$isPostsExist = Model::connection() -> read("SHOW TABLES LIKE 'posts'") ? true : false;
		$isUsersExist = Model::connection() -> read("SHOW TABLES LIKE 'users'") ? true : false;
		if ($isPostsExist && $isUsersExist) {
			$users = Users::first();
			self::$_install = empty($users) ? false : true;
		}
	}

	public function index() {
		$this -> _render['layout'] = "install";
		return array('display' => !self::$_install);
	}

	public function addAction() {
		$success = false;
		$errors = array();
		if (!self::$_install && $this -> request -> data) {
		  Model::connection() -> read(self::$_sql);
		  if (!($success = UsersController::addUser($this -> request -> data['user'], $this -> request -> data['password'], $errors))) {
		    $errors['User'] = "User can't be created.";
		  }
		  if ($success && !($success = PostsController::addPost("Post example", self::$_lorem, $errors))) {
				$errors['Post'] = "Post can't be created.";
		  }
		  if ($success) {
		    self::$_install = true;
		  }
		}
		return compact('success', 'errors');
	}

}
?>
