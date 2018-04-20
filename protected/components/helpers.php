<?php
defined('DOCUMENT_PATH') or define('DOCUMENT_PATH', preg_replace('/protected/', 'documents', Yii::app()->basePath));
defined('DOCUMENT_URL') or define('DOCUMENT_URL', 'documents/');
defined('WS_SERVER') or define('WS_SERVER', "http://" . $_SERVER['HTTP_HOST'] . Yii::app()->baseUrl . "/api/ws");
ini_set("soap.wsdl_cache_enabled", "0");

function saveFile(&$model, $attribute, $name = null, $admittedExtensions = array()) {
    
    $admittedExtensions = empty($admittedExtensions) ? array(
        'pdf',
        'xls',
        'xlsx',
        'ppt',
        'pptx',
        'doc',
        'docx',
    ) : $admittedExtensions;
    
    if ($name) {
        $file = CUploadedFile::getInstanceByName($name);
    } else {
        $file = CUploadedFile::getInstance($model, $attribute);
    }
    if (! $file) return false;
    if (! in_array($file->extensionName, $admittedExtensions)) return false;
    
    $uniqueId = getUniqueId();
    $uniqueFolder = date('Y/m/d/') . $uniqueId;
    
    $relative_path = DOCUMENT_URL . $uniqueFolder;
    $full_path = DOCUMENT_PATH . DIRECTORY_SEPARATOR . $uniqueFolder; 
    
    if (! is_dir($full_path)) mkdir($full_path, 0777, true);
    
    if ($file->saveAs($full_path . DIRECTORY_SEPARATOR . $uniqueId . "." . $file->extensionName)) {

        $model->setAttribute($attribute, $relative_path . DIRECTORY_SEPARATOR . $uniqueId . "." . $file->extensionName);
        return true;
    } else {

        rmdir($full_path);        
        return false;
    }
}

function getUniqueId() {
    return uniqid() . substr(md5(Yii::app()->user->getStateKeyPrefix()), 0, 8);
}

function removeFile($path) {
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $fullDir = str_replace('documents', DOCUMENT_PATH, $path);
    $fullDir = str_replace('/', DIRECTORY_SEPARATOR, $fullDir);
    $folderDir = str_replace(basename($fullDir), '', $fullDir);
    
    if (file_exists($fullDir)) unlink($fullDir);
    
    if (is_dir($folderDir)) {
        rmdir($folderDir);
    }
}