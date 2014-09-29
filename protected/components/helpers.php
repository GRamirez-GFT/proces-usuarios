<?php
defined('DOCUMENT_PATH') or define('DOCUMENT_PATH', preg_replace('/protected/', 'documents', Yii::app()->basePath));
defined('DOCUMENT_URL') or define('DOCUMENT_URL', 'documents/');
defined('WS_SERVER') or define('WS_SERVER', "http://" . $_SERVER['HTTP_HOST'] . Yii::app()->baseUrl . "/ws/access");

function assignFile(&$file, &$model, $attribute) {
    $full_path = DOCUMENT_PATH . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, date('Y/m/d/'));

    if(!empty($model->url_logo))
    {
        $namePattern = 'company_'.$model->subdomain.'_logo';
        $extension = explode('.', $model->url_logo);
        $extension = $extension[1];
        $full_path = str_replace($namePattern.$extension, '', $model->url_logo);
    } 
    if (! ($file = CUploadedFile::getInstance($model, $attribute))) return false;
    if (! is_dir($full_path)) mkdir($full_path, 0777, true);
    return $model->setAttribute($attribute, $file->name);
}

function saveFile(&$file, &$model, $attribute, $prevUrl = null) {
    if (!$file) return false;
    $namePattern = 'company_'.$model->subdomain.'_logo';
    $namePattern .= ($file->extensionName) ? '.'.$file->extensionName : '';
    $finalUrl = DOCUMENT_URL . date('Y/m/d/') . $namePattern;

    if ($file->saveAs(str_replace('documents', DOCUMENT_PATH, $finalUrl))) {
        if($prevUrl)
        {
            unlink(str_replace('documents', DOCUMENT_PATH, $prevUrl));
        }
        $model->setAttribute($attribute, $finalUrl);
        return true;
    }
    return false;
}

// function removeFile(&$file, &$model, $attribute) {
//     $model->setAttribute($attribute, $file->name);
//     $full_path = DOCUMENT_PATH . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, date('Y/m/d/'));
//     if (is_dir($full_path)) unlink($full_path . $file->name);
// }

function getUserCompany($id = null) {
    $client = new SoapClient(WS_SERVER);
    $request = array();
    foreach (json_decode($client->getUserCompany(Yii::app()->user->company_id), true) as $item) {
        $request[$item['id']] = $item;
    }
    return $id ? (array_key_exists($id, $request) ? $request[$id] : null) : $request;
}

function getUserCompanyLists() {
    $client = new SoapClient(WS_SERVER);
    $request = array(
        'name' => array(),
        'id' => array()
    );
    foreach (json_decode($client->getUserCompany(Yii::app()->user->company_id), true) as $item) {
        $request['name'][] = $item['name'];
        $request['id'][$item['id']] = $item['name'];
    }
    return $request;
}