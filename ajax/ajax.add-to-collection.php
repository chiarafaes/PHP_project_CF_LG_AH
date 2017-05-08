<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 8/05/2017
 * Time: 10:49
 */

    header('Content-Type: application/json');

    spl_autoload_register(function ($class) {
        include_once("../classes/".$class.".php");
    });

    $board = $_POST['board'];
    $post = $_POST['post'];

    echo json_encode(Board::saveToBoard($board, $post));

