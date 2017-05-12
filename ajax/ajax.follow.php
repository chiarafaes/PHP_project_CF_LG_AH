<?php

session_start();
header('Content-Type: application/json');
spl_autoload_register(function ($class) {
    include_once("../classes/".$class.".php");
});

$user = new User();

// get posted values
$action = $_POST['action'];
$userMail = $_POST['userMail'];

if($action === 'follow'){
        $user->followUser($userMail);
        $response['status'] = 'success';
        $response['action'] = 'follow';


} elseif ($action === 'unfollow'){
        $user->unfollowUser($userMail);
        $response['status'] = 'success';
        $response['action'] = 'unfollow';


} else{
    echo 'something went wrong';
}

echo json_encode($response);

?>









