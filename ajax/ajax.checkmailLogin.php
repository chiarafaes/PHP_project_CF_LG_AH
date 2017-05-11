<?php
/**
 * Created by PhpStorm.
 * User: chiarafaes
 * Date: 11/05/17
 * Time: 17:02
 */
header('Content-Type: application/json');

spl_autoload_register(function ($class) {
    include_once("../classes/".$class.".php");
});

$mailCheck = new User();
if(!empty($_POST['email'])){
    $mailCheck->Mail = $_POST['email'];

    if($mailCheck->EmailAvailable()) {
        $response['status'] = 'success';
        $response['message'] = 'Email does not exits';
    } else {
        $response['status'] = "error";
        $response['message'] = 'Email exits';
    }
    echo json_encode($response);
}
