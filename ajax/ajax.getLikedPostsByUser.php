<?php
/**
 * Created by PhpStorm.
 * User: chiarafaes
 * Date: 8/05/17
 * Time: 10:14
 */

header("content-type:application/json");

session_start();

spl_autoload_register(function ($class) {
    include_once("../classes/".$class.".php");
});

echo json_encode(Post::getPostsLikedByUserAndShow($_SESSION['email']));