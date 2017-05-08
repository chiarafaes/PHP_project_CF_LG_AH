<?php
header('Content-Type: application/json');

spl_autoload_register(function ($class) {
    include_once("../classes/".$class.".php");
});

$mailCheck = new User();
if(!empty($_POST['email'])){
    $mailCheck->Mail = $_POST['email'];

        if($mailCheck->EmailAvailable()) {
            $response['status'] = 'success';
            $response['message'] = 'Email available';
        } else {
            $response['status'] = "error";
            $response['message'] = 'Email already taken';
        }
    echo json_encode($response);
}
