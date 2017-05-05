<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 17/04/2017
 * Time: 16:47
 */
    session_start();

    header("content-type:application/json");

    spl_autoload_register(function ($class) {
        include_once("../classes/".$class.".php");
    });

    $offset = $_POST['offset'];
    $user = $_SESSION['email'];

    $res = Post::getPosts(20, $offset, $user);

    if (count($res) == 0){
        echo json_encode(false);
    } else{
        echo json_encode($res);
    }
