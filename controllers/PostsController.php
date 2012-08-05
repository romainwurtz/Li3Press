<?php
/*
 * Li3Press
 * Created by Romain Wurtz and Adrien Candiotti
 */
namespace app\controllers;

use lithium\net\http\Router;
use app\models\Posts;

define('ITEMS_PAGE', 10);

class PostsController extends \lithium\action\Controller {

	protected function getPost($id, &$post) {
		$success = false;

		if ($id > 0) {
			$post = Posts::find($id);
			$success = ($post) ? true : false;
		}
		return $success;
	}

	public function index() {
		$page = 1;
		if (isset($this -> request -> page) && $this -> request -> page > 0)
			$page = $this -> request -> page;
		$posts = Posts::find('all', array('limit' => ITEMS_PAGE, 'page' => $page));
		return compact('posts');
	}

	public function indexAction() {
		$page = 1;
		if (isset($this -> request -> page) && $this -> request -> page > 0)
			$page = $this -> request -> page;
		$posts = Posts::find('all', array('limit' => ITEMS_PAGE, 'page' => $page));
		return compact('posts');
	}

	public function add() {
	}

	public function addAction() {
		$success = false;
		$url = "";
		$errors = array();
		if ($this -> request -> data) {
			$post = Posts::create($this -> request -> data);
			$success = $post -> save();
			if ($success) {
				$url = "http://" . $_SERVER['HTTP_HOST'] . Router::match(array('controller' => 'posts', 'action' => 'view', 'id' => $post -> id));
			} else {
				$errors = $post -> errors();
			}
		}
		return compact('success', 'errors', 'url');
	}

	public function edit() {
		$success = self::getPost($this -> request -> id, $post);
		if (!$success) {
			$this -> redirect(array('Posts::add'));
		}
		return compact('success', 'post');
	}

	public function editAction() {
		$errors = array();
		$success = self::getPost($this -> request -> id, $post);
		if (!$success) {
			$errors['post'] = 'This post doesn\'t exist';
		} else if ($this -> request -> data) {
			$success = ($post -> save($this -> request -> data)) ? true : false;
			if (!$success) {
				$errors = $post -> errors();
			}
		}

		return compact('success', 'post', 'errors');
	}

	public function view() {
		$success = self::getPost($this -> request -> id, $post);
		return compact('success', 'post');
	}

}
?>