<?php

session_start();

spl_autoload_register(function ($class) {
    include_once("../classes/".$class.".php");
});

$user = new User;
$user_email = $_SESSION['Mail'];

if(isset($_POST['follow'])){
    $follow_email = $_POST['follow'];

    $submit->follow($user_email,$follow_email);
}
if(isset($_POST['unfollow'])){
    $follow_email = $_POST['unfollow'];
    $submit->unfollow($user_email,$follow_email);
}
?>

