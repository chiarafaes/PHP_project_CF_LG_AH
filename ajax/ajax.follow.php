<?php

session_start();

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
        $response['action'] = 'following';

}else if($action != 'follow'){
    $user->unfollowUser($userMail);
    $response['status'] = 'standard';
    $response['action'] = 'unfollow';

}

header('Content-type: application/json');
echo json_encode($response);

?>









