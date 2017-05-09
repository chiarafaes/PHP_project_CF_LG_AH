<?php
/**
 * Created by PhpStorm.
 * User: chiarafaes
 * Date: 9/05/17
 * Time: 13:42
 */


header("content-type:application/json");

session_start();

spl_autoload_register(function ($class) {
    include_once("../classes/".$class.".php");
});
var_dump($_GET["profile"]);

$user = User::getUser($_GET['profile']);
echo json_encode(Post::getPostsByUser($user['mail']));
