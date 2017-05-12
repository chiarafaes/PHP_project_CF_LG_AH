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
        $response['status'] = 'follow';
        $response['action'] = 'follow';

        $post = new Post();
        $postsFollower = Post::getPostsByUser($user['Mail']);

}else {
    echo "error";

}

header('Content-type: application/json');
echo json_encode($response);

?>









