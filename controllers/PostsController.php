<?php

namespace app\controllers;

use app\models\Posts;

class PostsController extends \lithium\action\Controller {

    public function index() {
	    $posts = Posts::all();
        return compact('posts');
    }
    
    public function add() {
    $success = false;

    if ($this->request->data) {
        $post = Posts::create($this->request->data);
        $success = $post->save();
    }
    return compact('success');
    }

}

?>