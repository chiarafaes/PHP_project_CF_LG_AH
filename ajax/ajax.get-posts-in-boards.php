<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 8/05/2017
 * Time: 21:33
 */

    header("content-type:application/json");

    session_start();

    spl_autoload_register(function ($class) {
        include_once("../classes/".$class.".php");
    });

    echo json_encode(Board::getPostsInBoards());