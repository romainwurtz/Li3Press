<?php

namespace models\controllers;

use models\models\PostsTestCreatesControllers;
use lithium\action\DispatchException;

class PostsTestCreatesControllersController extends \lithium\action\Controller {

	public function index() {
		$postsTestCreatesControllers = PostsTestCreatesControllers::all();
		return compact('postsTestCreatesControllers');
	}

	public function view() {
		$postsTestCreatesController = PostsTestCreatesControllers::first($this->request->id);
		return compact('postsTestCreatesController');
	}

	public function add() {
		$postsTestCreatesController = PostsTestCreatesControllers::create();

		if (($this->request->data) && $postsTestCreatesController->save($this->request->data)) {
			return $this->redirect(array('PostsTestCreatesControllers::view', 'args' => array($postsTestCreatesController->id)));
		}
		return compact('postsTestCreatesController');
	}

	public function edit() {
		$postsTestCreatesController = PostsTestCreatesControllers::find($this->request->id);

		if (!$postsTestCreatesController) {
			return $this->redirect('PostsTestCreatesControllers::index');
		}
		if (($this->request->data) && $postsTestCreatesController->save($this->request->data)) {
			return $this->redirect(array('PostsTestCreatesControllers::view', 'args' => array($postsTestCreatesController->id)));
		}
		return compact('postsTestCreatesController');
	}

	public function delete() {
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			$msg = "PostsTestCreatesControllers::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}
		PostsTestCreatesControllers::find($this->request->id)->delete();
		return $this->redirect('PostsTestCreatesControllers::index');
	}
}

?>