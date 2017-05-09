<?php
/**
 * Created by PhpStorm.
 * User: chiarafaes
 * Date: 9/05/17
 * Time: 13:19
 */


header("content-type:application/json");

session_start();

spl_autoload_register(function ($class) {
    include_once("../classes/".$class.".php");
});

echo json_encode(Post::getPostsByUser($_SESSION['email']));
