<?php

/**
 * Li3Press: A CMS with the Lithium (Li3) framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */

namespace app\controllers;

use app\controllers\CaptchasController;
use app\controllers\PostsController;
use app\models\Comments;
use lithium\security\Auth;

/**
 * 
 */
class CommentsController extends \lithium\action\Controller {

    /**
     * 
     * @param type $id
     * @param type $comment
     * @return type
     */
    protected function getComment($id, &$comment) {
        $comment = null;
        $success = false;
        $request_details = array('conditions' => array('comment_id' => $id));

        if ($id > 0)
            $success = (($comment = Comments::find('first', $request_details))) ? true : false;
        return $success;
    }

    protected function commentExist($id) {
        return self::getComment($id, null);
    }

    protected function getComments(&$comments, $postId = 0) {
        $validates = array();
        $comments = array();

        if ($postId != 0 || $postId == 0 && Auth::check('default')) {
            if ($postId != 0) {
                $validates['post_id'] = $postId;
            }
            $comments = Comments::find('all', $validates);
        }
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

    protected function deleteComment($id, &$errors) {
        $success = false;
        $comment = null;

        if ($id > 0) {
            if (!($success = self::getComment($id, $comment))) {
                $errors['comment'] = 'This comment doesn\'t exist';
            } else if (!($success = $comment->delete(array('conditions' => array('comment_id' => $id))))) {
                $errors = $comment->errors();
            }
        }
        return $success;
    }

    public function indexAction() {
        $comments = array();
        $postId = 0;

        if ($this->request->id && $this->request->id > 0)
            $postId = $this->request->id;
        self::getComments($comments, $postId);
        return compact('comments');
    }

    public function addAction() {
        $success = false;
        $details = array();

        if (!$this->request->is('post')) {
            $details['call'] = 'This action can only be called with post';
        } else if ($this->request->data) {
            if (!isset($this->request->data['id']) || !PostsController::postExist($this->request->data['id'])) {
                $details['post'] = 'This post doesn\'t exist';
            } else {
                $captcha = (isset($this->request->data['captcha']) ? $this->request->data['captcha'] : "");
                if (CaptchasController::check($captcha, $details)) {
                    $name = (isset($this->request->data['name']) ? $this->request->data['name'] : "");
                    $email = (isset($this->request->data['email']) ? $this->request->data['email'] : "");
                    $website = (isset($this->request->data['website']) ? $this->request->data['website'] : "");
                    $body = (isset($this->request->data['body']) ? $this->request->data['body'] : "");
                    $id = $this->request->data['id'];
                    if (($success = self::addComment($name, $email, $website, $body, $id, $details)))
                        $details['_desc'] = "Your comment has been posted.";
                }
            }
        }
        if ($success == false)
            $details['_title'] = "Comment can't be created.";
        return compact('success', 'details');
    }

    public function listComments() {
        $comments = array();

        if (!Auth::check('default')) {
            return $this->redirect('Sessions::add');
        }
        self::getComments($comments);
        return compact('comments');
    }

    public function viewAction() {
        $comment = null;
        $id = (isset($this->request->id) && $this->request->id > 0) ? $this->request->id : 0;
        $success = false;

        if (Auth::check('default')) {
            $success = self::getComment($id, $comment);
        }
        return compact('success', 'comment');
    }

    public function deleteAction() {
        $success = false;
        $details = array();
        $comment = null;

        if (!Auth::check('default')) {
            $details['login'] = 'You need to be logged.';
        } else if (!($this->request->is('post'))) {
            $details['call'] = 'This action can only be called with post';
        } else {
            $id = (isset($this->request->data['id'])) ? $this->request->data['id'] : 0;
            if (!($success = self::getComment($id, $comment))) {
                $details['comment'] = 'This comment doesn\'t exist';
            } else if (!($success = $comment->delete(array('conditions' => array('comment_id' => $id))))) {
                $details = $comment->errors();
            }
        }
        if ($success == false)
            $details['_title'] = "Comment can't be deleted.";
        return compact('success', 'details');
    }

}

?>