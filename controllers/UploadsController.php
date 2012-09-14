<?php

/**
 * Li3Press: A CMS with the Lithium (Li3) framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 */

namespace app\controllers;

use app\models\Uploads;
use lithium\security\Auth;
use upload\UploadHandler;
use lithium\net\http\Router;

/**
 * Manage files
 *  
 */
class UploadsController extends \lithium\action\Controller {

    protected static $_uploadHandler = null;

    public function _init() {
        parent::_init();
        //var_dump(getBaseUrl());
        static::$_uploadHandler = new UploadHandler(array(
                    'script_url' => Router::match(array('Uploads::deleteAction', 'type' => 'json')),
                    'upload_dir' => LITHIUM_APP_PATH . '/webroot/upload/files/',
                    'upload_url' => '/upload/files/',
                    'param_name' => 'files',
                    'delete_type' => 'DELETE',
                    'max_file_size' => null,
                    'min_file_size' => 1,
                    'accept_file_types' => '/.+$/i',
                    'max_number_of_files' => null,
                    'max_width' => null,
                    'max_height' => null,
                    'min_width' => 1,
                    'min_height' => 1,
                    'discard_aborted_uploads' => true,
                    'orient_image' => false,
                    'image_versions' => array(
                        'thumbnail' => array(
                            'upload_dir' => LITHIUM_APP_PATH . '/webroot/upload/thumbnails/',
                            'upload_url' => '/upload/thumbnails/',
                            'max_width' => 80,
                            'max_height' => 80
                        )
                    )
                ));
    }

    protected function getUploads(&$uploads) {
        $validates = array();
        $uploads = Uploads::find('all', $validates);
        return count($uploads);
    }

    protected function addUpload($filename, $size, $type, $thumbnail, &$errors) {
        $success = false;
        $file = Uploads::create(array('filename' => $filename, 'size' => $size, 'type' => $type, 'thumbnail' => $thumbnail));
        if (!($success = $file->save())) {
            $errors = $file->errors();
        }
        return $success;
    }

    /**
     * Get a file by ID
     * 
     *  The function returns TRUE or FALSE on failure. If success the file is available in $file param.
     * @param int $id id to get
     * @param mixed $file reference to the object
     * @return bool
     */
    protected function getUpload($id, &$file) {
        $file = null;
        $success = false;
        $request_details = array('conditions' => array('upload_id' => $id));
        if ($id > 0)
            $success = (($file = Uploads::find('first', $request_details))) ? true : false;
        return $success;
    }

    /**
     * Delete a file on hard drive by name
     * 
     *  The function returns TRUE or FALSE on failure. Reason of failure is available in $errors param.
     * @param string $name name of the file
     * @param bool $thumb file as a $thumb to delete
     * @param array $errors reference to an array used to handle errors
     * @return bool
     */
    protected function deleteFile($name, $thumb, &$errors) {
        $success = false;
        $fileTemp = $_SERVER['DOCUMENT_ROOT'] . '/webroot/upload/files/' . $name;
        if ($success = is_file($fileTemp)) {
            if (!($success = unlink($fileTemp))) {
                $errors['file'] = 'Not allowed to remove the file \'' . $name . '\'.';
            }
        } else {
            $errors['file'] = 'The file \'' . $name . '\' doesn\'t exist.';
        }
        if ($thumb) {
            $fileTemp = $_SERVER['DOCUMENT_ROOT'] . '/webroot/upload/thumbnails/' . $name;
            if ($success = is_file($fileTemp)) {
                if (!($success = unlink($fileTemp))) {
                    $errors['file_thumb'] = 'Not allowed to remove the thumbnail \'' . $name . '\'.';
                }
            } else {
                $errors['file_thumb'] = 'The thumbnail \'' . $name . '\' doesn\'t exist.';
            }
        }
        return $success;
    }

    /**
     * Delete upload by ID
     * 
     *  The function returns TRUE or FALSE on failure. Reason of failure is available in $errors param.
     * @todo Use delete without array of params (not supported or bug with li3)
     * @param int $id id to delete
     * @param array $errors reference to an array used to handle errors
     * @return bool
     */
    protected function deleteUpload($id, &$errors) {
        $success = false;
        $file = null;
        if ($id > 0) {
            if (!($success = $this->getUpload($id, $file))) {
                $errors['file'] = 'This file doesn\'t exist';
            } else {
                $name = $file->filename;
                $thumb = ($file->thumbnail) ? true : false;
                if (!($success = $file->delete(array('conditions' => array('upload_id' => $id))))) {
                    $errors = $file->errors();
                }
                if ($success) {
                    $success = $this->deleteFile($name, $thumb, $errors);
                }
            }
        }
        return $success;
    }

    public function index() {
        
    }

    public function addAction() {
        $success = false;
        $details = array();
        if (!Auth::check('default')) {
            $details['login'] = 'You need to be logged.';
        } else if (!$this->request->is('post')) {
            $details['call'] = 'This action can only be called with post';
        } else if ($this->request->data) {
            if (!static::$_uploadHandler)
                self::_init();
            ob_start();
            static::$_uploadHandler->post();
            $ob = ob_get_contents();
            ob_end_clean();
            $files = json_decode($ob);
            $success = true;
            foreach ($files as $file) {
                if (isset($file->name) && $file->name) {
                    $successTmp = false;
                    if (!($successTmp = $this->addUpload($file->name, $file->size, $file->type, (isset($file->thumbnail_url) && $file->thumbnail_url) ? true : false, $details)))
                        static::$_uploadHandler->delete($file->name);
                } else {
                    $details['fileName'] = "The file seems corrupted or invalid.";
                }
                $success = ($successTmp != $success && $success != false) ? $successTmp : $success;
            }
        }
        if ($success == false)
            $details['_title'] = "Error in the upload.";
        return compact('success', 'files', 'details');
    }

    /**
     * Delete upload action
     * 
     * Function available if user logged and callable only by POST.
     * Parameters in the post must contain id of the element.
     * @todo Make a difference if error when erasing file or if error in DB
     * @return array
     */
    public function deleteAction() {
        $success = false;
        $details = array();
        if (!Auth::check('default')) {
            $details['login'] = 'You need to be logged.';
        } else if (!$this->request->is('post')) {
            $details['call'] = 'This action can only be called with post';
        } else if ($this->request->data) {
            if (!static::$_uploadHandler)
                self::_init();
            $id = $this->request->data['id'];
            $success = $this->deleteUpload($id, $details);
        }
        if ($success == false)
            $details['_title'] = "Error in the upload.";
        else
            $details['_title'] = "File has been successfully deleted.";
        return compact('success', 'details');
    }

    public function loadAction() {
        $success = false;
        $details = array();
        $files = array();
        $files2 = array();
        $filesDb = array();
        if (!Auth::check('default')) {
            $details['login'] = 'You need to be logged.';
        } else {
            if (!static::$_uploadHandler)
                self::_init();
            ob_start();
            self::$_uploadHandler->get();
            $ob = ob_get_contents();
            ob_end_clean();
            $files2 = json_decode($ob);
            self::getUploads($filesDb);
            foreach ($filesDb as $fileDb) {
                $file = new \stdClass();
                $file->upload_id = $fileDb->upload_id;
                $file->filename = $fileDb->filename;
                $file->size = intval($fileDb->size);
                $file->url = '/upload/files/' . $fileDb->filename;
                if ($fileDb->thumbnail == 1)
                    $file->thumbnail_url = '/upload/thumbnails/' . $fileDb->filename;
                array_push($files, $file);
            }
            $success = true;
        }
        if ($success == false)
            $details['_title'] = "Error in the upload.";
        return compact('success', 'files', 'files2', 'details');
    }

    public function addFiles() {
        if (!Auth::check('default')) {
            return $this->redirect('Sessions::add');
        }
    }

}

?>