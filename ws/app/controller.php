<?php
error_reporting(E_ALL);
if (!defined('SAFELOAD'))
    exit('ACCESS FORBIDDEN!');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Content-type: application/json');


// //CACHE
// header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
// header("Pragma: no-cache"); // HTTP 1.0.
// header("Expires: 0"); // Proxies.
// //error_reporting(E_ERROR);


function getTest($data = NULL) {
    $model = new Model;
    echo json_encode($model->getTest($data));
}

function login($user = NULL, $pass = NULL) {
    $model = new Model;
    $model->connect();
    echo json_encode($model->login($user, $pass));
    $model->close();
}

function checkUserExist($user = NULL) {
    $model = new Model;
    $model->connect();
    echo json_encode($model->checkUserExist($user));
    $model->close();
}

function forgotPass($user = NULL, $email = NULL) {
    $model = new Model;
    $model->connect();
    echo json_encode($model->forgotPass($user, $email));
    $model->close();
}

function register($data = NULL) {
    $model = new Model;
    $model->connect();
    echo json_encode($model->register($data));
    $model->close();
}

function getEmailAdmin() {
    $model = new Model;
    $model->connect();
    echo json_encode($model->getEmailAdmin());
    $model->close();
}

function getUsrDetail($id = NULL) {
    $model = new Model;
    $model->connect();
    echo json_encode($model->getUsrDetail($id));
    $model->close();
}

function getOrder($id = NULL, $mobil = NULL, $status = NULL) {
    $model = new Model;
    $model->connect();
    echo json_encode($model->getOrder($id, $mobil, $status));
    $model->close();
}

function cancelOrder($id = NULL) {
    $model = new Model;
    $model->connect();
    echo json_encode($model->cancelOrder($id));
    $model->close();
}

function getPaket() {
    $model = new Model;
    $model->connect();
    echo json_encode($model->getPaket());
    $model->close();
}

function getBayar() {
    $model = new Model;
    $model->connect();
    echo json_encode($model->getBayar());
    $model->close();
}

function getMobil($idClient = NULL) {
    $model = new Model;
    $model->connect();
    echo json_encode($model->getMobil($idClient));
    $model->close();
}

function getBrandMobil() {
    $model = new Model;
    $model->connect();
    echo json_encode($model->getBrandMobil());
    $model->close();
}

function createOrder($form = NULL) {
    $model = new Model;
    $model->connect();
    echo json_encode($model->createOrder($form));
    $model->close();
}

function createMobil($form = NULL) {
    $model = new Model;
    $model->connect();
    echo json_encode($model->createMobil($form));
    $model->close();
}

function deleteMobil($id = NULL) {
    $model = new Model;
    $model->connect();
    echo json_encode($model->deleteMobil($id));
    $model->close();
}

function updateUser($form = NULL) {
    $model = new Model;
    $model->connect();
    echo json_encode($model->updateUser($form));
    $model->close();
}

function checkPass($id = NULL, $pass = NULL) {
    $model = new Model;
    $model->connect();
    echo json_encode($model->checkPass($id, $pass));
    $model->close();
}

function changePassword($id = NULL, $pass = NULL) {
    $model = new Model;
    $model->connect();
    echo json_encode($model->changePassword($id, $pass));
    $model->close();
}
