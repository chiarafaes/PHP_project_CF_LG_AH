<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 17/04/2017
 * Time: 16:47
 */

header("content-type:application/json");

spl_autoload_register(function ($class) {
    include_once("../classes/".$class.".php");
});

$offset = $_POST['offset'];

echo json_encode(Post::getPosts(20, $offset)); // moeten er 20 bijkomen (zoals in briefing)
