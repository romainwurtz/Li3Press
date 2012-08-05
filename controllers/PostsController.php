<?php
/*
 * Li3Press
 * Created by Romain Wurtz and Adrien Candiotti
 */
namespace app\controllers;

use lithium\net\http\Router;
use lithium\security\Auth;
use app\models\Posts;

define('ITEMS_PAGE', 10);

class PostsController extends \lithium\action\Controller {

	protected function getPost($id, &$post) {
		$post = null;
		$success = false;

		if ($id > 0)
			$success = (($post = Posts::find($id))) ? true : false;
		return $success;
	}

	protected function getPosts($page, &$posts) {
		$page = ($page <= 0) ? 1 : $page;
		$posts = Posts::find('all', array('limit' => ITEMS_PAGE, 'page' => $page));
		return count($posts);
	}

	public function index() {
		$page = 1;

		if (isset($this -> request -> page) && $this -> request -> page > 0)
			$page = $this -> request -> page;
		self::getPosts($page, $posts);
		return compact('posts');
	}

	public function indexAction() {
		$page = 1;

		if (isset($this -> request -> page) && $this -> request -> page > 0)
			$page = $this -> request -> page;
		self::getPosts($page, $posts);
		return compact('posts');
	}

	public function add() {
		if (!Auth::check('default')) {
			return $this -> redirect('Sessions::add');
		}
	}

	public function addAction() {
		$success = false;
		$url = "";
		$errors = array();

		if (!Auth::check('default')) {
			$errors['login'] = 'You need to be logged.';
		} else if ($this -> request -> data) {
			$post = Posts::create($this -> request -> data);
			if (($success = $post -> save())) {
				$url = "http://" . $_SERVER['HTTP_HOST'] . Router::match(array('controller' => 'posts', 'action' => 'view', 'id' => $post -> id));
			} else {
				$errors = $post -> errors();
			}
		}
		return compact('success', 'errors', 'url');
	}

	public function edit() {
		if (!Auth::check('default')) {
			return $this -> redirect('Sessions::add');
		}
		if (!($success = self::getPost($this -> request -> id, $post))) {
			$this -> redirect(array('Posts::add'));
		}
		return compact('success', 'post');
	}

	public function editAction() {
		$errors = array();
		$success = false;
		$errors = array();

		if (!Auth::check('default')) {
			$errors['login'] = 'You need to be logged.';
		} else {
			if (!($success = self::getPost($this -> request -> id, $post))) {
				$errors['post'] = 'This post doesn\'t exist';
			}
			if ($success && $this -> request -> data) {
				if (!($success = $post -> save($this -> request -> data))) {
					$errors += $post -> errors();
				}
			}
		}
		return compact('success', 'errors');
	}

	public function view() {
		$success = self::getPost($this -> request -> id, $post);

		return compact('success', 'post');
	}

	public function delete() {
		if (!$this -> request -> is('post') && !$this -> request -> is('delete')) {
			$msg = "Users::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}
		Users::find($this -> request -> id) -> delete();
		return $this -> redirect('Users::index');
	}

}
?>