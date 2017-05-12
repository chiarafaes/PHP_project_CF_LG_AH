<?php
header("content-type:application/json");

session_start();
header('Content-Type: application/json');

spl_autoload_register(function ($class) {
    include_once("../classes/".$class.".php");
});

//controleer of er een comment wordt verzonden
if(!empty($_POST['comment'])) { // comment uit query

    $postContent = $_POST['comment'];
    $user = $_SESSION['email'];
    $post = $_POST['postID'];

    $userInfo = User::getUser($user);

    $comment = new Comment();
    $comment->Text = $postContent;

    try {
        $res = $comment->save($user, $post);
        $feedback = [
            "code" => 200,
            "message" => htmlspecialchars($_POST['comment']),
            "user" => $_SESSION['username'],
            "email" => $user,
            "avatar" => $userInfo['avatar'],
            "res" => $res
        ];

    } catch (Exception $e) {

    $error = $e->getMessage();
    $feedback = [
        "code" => 500,
        "message" => $error
    ];
}
echo json_encode($feedback); //{"code":500, "message:"}
}




?>




