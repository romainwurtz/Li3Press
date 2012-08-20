<?php

/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
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
        $request_details = array('with' => 'Comments',
            'condition' => array('post_id' => $id));

        if (!Auth::check('default'))
            $request_details['conditions'] = array('visibility' => 1);
        if ($id > 0)
            $success = (($post = Posts::find($id, $request_details))) ? true : false;
        return $success;
    }

    protected function getPosts(&$posts, $page = 0) {
        $page = ($page < 0) ? 1 : $page;
        $validates = array();

        if ($page != 0) {
            $validates['limit'] = ITEMS_PAGE;
            $validates['page'] = $page;
        }
        if (!Auth::check('default'))
            $validates['conditions'] = array('visibility' => 1);
        $posts = Posts::find('all', $validates);
        return count($posts);
    }

    public function addPost($title, $body, &$errors) {
        $success = false;

        $post = Posts::create(array('title' => $title, 'body' => $body));
        if (!($success = $post->save())) {
            $errors = $post->errors();
        }
        return $success;
    }

    public function index() {
        $page = 1;
        $posts = array();

        if (isset($this->request->page) && $this->request->page > 0)
            $page = $this->request->page;
        self::getPosts($posts, $page);
        return compact('posts', 'page');
    }

    public function indexAction() {
        $page = 1;
        $posts = array();

        if (isset($this->request->page) && $this->request->page > 0)
            $page = $this->request->page;
        self::getPosts($posts, $page);
        return compact('posts', 'page');
    }

    public function add() {
        if (!Auth::check('default')) {
            return $this->redirect('Sessions::add');
        }
    }

    public function addAction() {
        $success = false;
        $url = "";
        $errors = array();

        if (!Auth::check('default')) {
            $errors['login'] = 'You need to be logged.';
        } else if (!$this->request->is('post')) {
            $errors['call'] = 'This action can only be called with post';
        } else if ($this->request->data) {
            $post = Posts::create($this->request->data);
            if (($success = $post->save())) {
                $url = "http://" . $_SERVER['HTTP_HOST'] . Router::match(array('controller' => 'posts', 'action' => 'view', 'id' => $post->id));
            } else {
                $errors = $post->errors();
            }
        }
        return compact('success', 'errors', 'url');
    }

    public function edit() {
        if (!Auth::check('default')) {
            return $this->redirect('Sessions::add');
        }
        if (!($success = self::getPost($this->request->id, $post))) {
            $this->redirect(array('Posts::add'));
        }
        return compact('success', 'post');
    }

    public function editAction() {
        $errors = array();
        $success = false;
        $errors = array();

        if (!Auth::check('default')) {
            $errors['login'] = 'You need to be logged.';
        } else if (!$this->request->is('post')) {
            $errors['call'] = 'This action can only be called with post';
        } else {
            if (!($success = self::getPost($this->request->data['id'], $post))) {
                $errors['post'] = 'This post doesn\'t exist';
            }
            if ($success && $this->request->data) {
                if (!($success = $post->save($this->request->data))) {
                    $errors += $post->errors();
                }
            }
        }
        return compact('success', 'errors');
    }

    public function view() {
        $success = self::getPost($this->request->id, $post);
        return compact('success', 'post');
    }

    public function hide() {
        
    }

    public function hideAction() {
        $success = true;
        $errors = array();
        $post = null;

        if (!($success = self::getPost($this->request->data['id'], $post))) {
            $errors['post'] = 'This post doesn\'t exist';
        } else {
            $post->visibility = $this->request->data['visibility'] == 'true' ? 1 : 0;
            $post->save();
        }
        return compact('success', 'errors', 'debug', 'post');
    }

    public function listPosts() {
        $posts = array();

        if (!Auth::check('default')) {
            return $this->redirect('Sessions::add');
        }
        self::getPosts($posts);
        return compact('posts');
    }

    public function deleteAction() {
        $url = "";
        $success = false;
        $errors = array();

        if (!Auth::check('default')) {
            $errors['login'] = 'You need to be logged.';
        } else if (!$this->request->is('post')) {
            $errors['call'] = 'This action can only be called with post';
        } else {
            if (!($success = self::getPost($this->request->data['id'], $post))) {
                $errors['post'] = 'This post doesn\'t exist';
            } else {
                if (($success = $post->delete())) {
                    $url = "http://" . $_SERVER['HTTP_HOST'];
                } else {
                    $errors = $post->errors();
                }
            }
        }
        return compact('success', 'errors', 'url');
    }

}

?>
