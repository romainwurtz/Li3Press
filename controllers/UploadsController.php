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

    /**
     * _init()
     * 
     * Setup the php library
     */
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

        /**
         * Get uploads
         * 
         * Get every files record
         * @param type $uploads Reference to the files
         * @return int Number of result
         */
    protected function getUploads(&$uploads) {
        $validates = array();
        $uploads = Uploads::find('all', $validates);
        return count($uploads);
    }

    /**
     * Add a file
     * 
     * Add a file to the DB with information in $params.
     * @param array $params Informations to save
     * @param array $errors
     * @param object $file Reference to the object created
     * @return bool
     */
    protected function addUpload($params, &$errors, &$file) {
        $success = false;
        $file = Uploads::create(array('filename' => $params['filename'], 'size' => $params['size'], 'type' => $params['type'], 'thumbnail' => $params['thumbnail']));
        if (!($success = $file->save())) {
            $errors = $file->errors();
        }
        return $success;
    }

    /**
     * Get a file by ID
     * 
     *  The function returns TRUE or FALSE on failure. If success the file is available in $file param.
     * @param int $id ID to get
     * @param object $file Reference to the object
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
     * @param string $name Name of the file
     * @param bool $thumb File as a $thumb to delete
     * @param array $errors Reference to an array used to handle errors
     * @return bool
     */
    protected function deleteFile($name, $thumb, &$errors) {
        $success = false;
        $fileTemp = $_SERVER['DOCUMENT_ROOT'] . '/webroot/upload/files/' . $name;
        if (($success = is_file($fileTemp))) {
            if (!($success = unlink($fileTemp))) {
                $errors['file'] = 'Not allowed to remove the file \'' . $name . '\'.';
            }
        } else {
            $errors['file'] = 'The file \'' . $name . '\' doesn\'t exist.';
        }
        if ($thumb) {
            $fileTemp = $_SERVER['DOCUMENT_ROOT'] . '/webroot/upload/thumbnails/' . $name;
            if (($success = is_file($fileTemp))) {
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
     * @param int $id ID to delete
     * @param array $errors Reference to an array used to handle errors
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

    /**
     * Process single file
     * 
     * Process the files uploaded using the upload library.
     * @todo Manage errors.
     * @todo Not sure of the implementation.
     * @param array $uploads Array with the file
     * @param array $info Reference to the informations of the file processed
     * @return bool 
     */
    public function processFile($upload, &$info) {
        $uploaded_file = isset($upload['tmp_name']) ? $upload['tmp_name'] : null;
        $name = isset($_SERVER['HTTP_X_FILE_NAME']) ? $_SERVER['HTTP_X_FILE_NAME'] : (isset($upload['name']) ? $upload['name'] : "");
        $size = isset($_SERVER['HTTP_X_FILE_SIZE']) ? $_SERVER['HTTP_X_FILE_SIZE'] : (isset($upload['size']) ? $upload['size'] : 0);
        $type = isset($_SERVER['HTTP_X_FILE_TYPE']) ? $_SERVER['HTTP_X_FILE_TYPE'] : (isset($upload['type']) ? $upload['type'] : null);
        $error = isset($upload['error']) ? $upload['error'] : null;
        $index = null;
        $info[] = static::$_uploadHandler->handle_file_upload(
                $uploaded_file, $name, $size, $type, $error, $index
        );
        return true;
    }

    /**
     * Process list of files
     * 
     * Process the files uploaded using the upload library.
     * @todo Manage errors.
     * @todo Not sure of the implementation.
     * @param array $uploads Array with the files
     * @param array $info Reference to the informations of the files processed
     * @return bool 
     */
    public function processFiles($uploads, &$info) {
        $success = true;
        $info = array();
        foreach ($uploads['tmp_name'] as $index => $value) {
            $uploaded_file = $uploads['tmp_name'][$index];
            $name = isset($_SERVER['HTTP_X_FILE_NAME']) ? $_SERVER['HTTP_X_FILE_NAME'] : $uploads['name'][$index];
            $size = isset($_SERVER['HTTP_X_FILE_SIZE']) ? $_SERVER['HTTP_X_FILE_SIZE'] : $uploads['size'][$index];
            $type = isset($_SERVER['HTTP_X_FILE_TYPE']) ? $_SERVER['HTTP_X_FILE_TYPE'] : $uploads['type'][$index];
            $error = isset($uploads['error'][$index]) ? $uploads['error'][$index] : null;
            $info[] = static::$_uploadHandler->handle_file_upload(
                    $uploaded_file, $name, $size, $type, $error, $index
            );
        }
        return $success;
    }

    /**
     * Find the correct handler
     * 
     * Used to find which handler to use.
     * @todo Manage errors
     * @param object $upload Content of the $FILES variable
     * @return array Result
     */
    public function dispatcherUpload($upload) {
        $details = array();
        if ($upload && is_array($upload['tmp_name'])) {
            self::processFiles($upload, $details);
        } elseif ($upload || isset($_SERVER['HTTP_X_FILE_NAME'])) {
            self::processFile($upload, $details);
        }
        return $details;
    }

    /**
     * Generate display
     * 
     * Generate object used by the jQuery Library and the js template.
     * @return object File
     */
    protected function generateDisplay($upload) {
        $file = new \stdClass();
        $file->upload_id = $upload->upload_id;
        $file->filename = $upload->filename;
        $file->size = intval($upload->size);
        $file->url = '/upload/files/' . $upload->filename;
        if ($upload->thumbnail == 1)
            $file->thumbnail_url = '/upload/thumbnails/' . $upload->filename;
        return $file;
    }

    /**
     * Add upload action
     * 
     * Add a new file to the disk and to the DB.
     * Function available if user logged and callable only by POST. Information in $_FILES are used.
     * @todo Make a difference if error when erasing file or if error in DB
     * @return array Array with success status, associative array of details and associative array of the files
     */
    public function addAction() {
        $success = false;
        $details = array();
        $files = array();
        if (!Auth::check('default')) {
            $details['login'] = 'You need to be logged.';
        } else if (!$this->request->is('post')) {
            $details['call'] = 'This action can only be called with post';
        } else if ($this->request->data) {
            if (!static::$_uploadHandler)
                self::_init();
            $filesTmp = self::dispatcherUpload($_FILES['files']);
            $success = true;
            foreach ($filesTmp as $file) {
                if (isset($file->name) && $file->name) {
                    $successTmp = false;
                    $fileDb = null;
                    if (!($successTmp = $this->addUpload(
                            array('filename' => $file->name,
                        'size' => $file->size,
                        'type' => $file->type,
                        'thumbnail' => (isset($file->thumbnail_url) && $file->thumbnail_url) ? true : false), $details, $fileDb)
                            ))
                        static::$_uploadHandler->delete($file->name);
                    else
                        array_push($files, self::generateDisplay($fileDb));
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
     * Delete an element from the disk and from the DB.
     * Function available if user logged and callable only by POST. Parameters in the post must contain id of the element.
     * @todo Make a difference if error when erasing file or if error in DB
     * @return array Array with success status and associative array of details
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

    /**
     * Load previous uploads
     * 
     * User must be logged to use this function.
     * @return array Associative array with success status, files to display, details
     */
    public function loadAction() {
        $success = false;
        $details = array();
        $files = array();
        $filesDb = array();
        if (!Auth::check('default')) {
            $details['login'] = 'You need to be logged.';
        } else {
            if (!static::$_uploadHandler)
                self::_init();
            self::getUploads($filesDb);
            foreach ($filesDb as $fileDb) {
                array_push($files, self::generateDisplay($fileDb));
            }
            $success = true;
        }
        if ($success == false)
            $details['_title'] = "Error in the upload.";
        return compact('success', 'files', 'details');
    }

    /**
     * Page add
     * 
     * User must be logged to use this page.
     */
    public function add() {
        if (!Auth::check('default')) {
            return $this->redirect('Sessions::add');
        }
    }

}

?>