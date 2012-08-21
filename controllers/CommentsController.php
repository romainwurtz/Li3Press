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
use app\models\Comments;
use app\controllers\PostsController;

class CommentsController extends \lithium\action\Controller {

    protected function getComment($id, &$comment) {
        $comment = null;
        $success = false;
        $request_details = array('with' => 'Comments',
            'condition' => array('post_id' => $id));

        /*
          if (!Auth::check('default'))
          $request_details['conditions'] = array('visibility' => 1);
         */

        if ($id > 0)
            $success = (($comment = Comments::find($id, $request_details))) ? true : false;
        return $success;
    }

    protected function commentExist($id) {
        return self::getComment($id, null);
    }

    protected function getComments(&$comments, $postId = 0) {
        $validates = array();

        if ($postId != 0) {
            $validates['post_id'] = $postId;
        }

        $comments = Comments::find('all', $validates);
        return count($comments);
    }

    protected function addComment($name, $email, $website, $body, $postId, &$errors) {
        $success = false;

        $comment = Comments::create(array('name' => $name, 'email' => $email, 'website' => $website, 'body' => $body, 'post_id' => $postId));
        if (!($success = $comment->save())) {
            $errors = $comment->errors();
        }
        return $success;
    }

    public function indexAction() {
        $comments = array();
        $postId = 0;

        if ($this->request->id && $this->request->id)
            $postId = $this->request->id;
        self::getComments($comments, $postId);
        return compact('comments');
    }

    public function addAction() {
        $success = false;
        $errors = array();

        if (!$this->request->is('post')) {
            $errors['call'] = 'This action can only be called with post';
        } else if ($this->request->data) {
            if (!isset($this->request->data['id']) || !PostsController::postExist($this->request->data['id'])) {
                $errors['post'] = 'This post doesn\'t exist';
            } else {
                $name = (isset($this->request->data['name']) ? $this->request->data['name'] : "");
                $email = (isset($this->request->data['email']) ? $this->request->data['email'] : "");
                $website = (isset($this->request->data['website']) ? $this->request->data['website'] : "");
                $body = (isset($this->request->data['body']) ? $this->request->data['body'] : "");
                $id = $this->request->data['id'];
                if (!($success = self::addComment($name, $email, $website, $body, $id, $errors))) {
                    $errors['comment'] = "Comment can't be created.";
                }
            }
        }
        return compact('success', 'errors');
    }

}
?>