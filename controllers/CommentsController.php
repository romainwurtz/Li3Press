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

class CommentsController extends \lithium\action\Controller {

    protected function getComment($id, &$comment) {
        $comment = null;
        $success = false;
        $request_details = array('with' => 'Comments',
            'condition' => array('post_id' => $id));

        if (!Auth::check('default'))
            $request_details['conditions'] = array('visibility' => 1);

        if ($id > 0)
            $success = (($comment = Comments::find($id, $request_details))) ? true : false;
        return $success;
    }

    protected function getComments(&$comments, $postId = 0) {
        $validates = array();

        if ($postId != 0) {
            $validates['post_id'] = $postId;
        }

        $comments = Comments::find('all', $validates);
        return count($comments);
    }

    public function indexAction() {
        $comments = array();
        $postId = 0;

        if ($this->request->id && $this->request->id)
            $postId = $this->request->id;
        self::getComments($comments, $postId);
        return compact('comments');
    }

}

?>
