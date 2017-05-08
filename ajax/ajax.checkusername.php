<?php
/**
 * Created by PhpStorm.
 * User: chiarafaes
 * Date: 8/05/17
 * Time: 09:47
 */

header('Content-Type: application/json');

spl_autoload_register(function ($class) {
    include_once("../classes/".$class.".php");
});

$mailCheck = new User();
if(!empty($_POST['username'])){
    $mailCheck->Username = $_POST['username'];

    if($mailCheck->UsernameAvailable()) {
        $response['status'] = 'success';
        $response['message'] = 'Username available';
    } else {
        $response['status'] = "error";
        $response['message'] = 'Username already taken';
    }
    echo json_encode($response);
}
