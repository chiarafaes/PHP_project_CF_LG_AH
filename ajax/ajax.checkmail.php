<?php
header('Content-Type: application/json');

spl_autoload_register(function ($class) {
    include_once("classes/".$class.".php");
});

$mailCheck = new User();
if(!empty($_POST['email'])){
    $mailCheck-> Mail =$_POST['email'];

        if($mailCheck->Check()) {
            $response['status'] = 'success';
            $response['message'] = 'Username available';
        } else {
            $response['status'] = "error";
            $response['message'] = 'Username already taken';
        }
    echo json_encode($response);
}
