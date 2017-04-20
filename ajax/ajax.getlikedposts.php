<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18/04/2017
 * Time: 21:10
 */

header("content-type:application/json");
session_start();

spl_autoload_register(function ($class){
    include_once ("../classes/".$class.".php");
});

echo json_encode(Post::getPostsLikedByUser($_SESSION['email']));