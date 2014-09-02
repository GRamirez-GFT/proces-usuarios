<?php
defined('WS_SERVER') or define('WS_SERVER', "http://{$_SERVER['HTTP_HOST']}/proces-usuarios/ws/access");

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