<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 27/04/2017
 * Time: 9:00
 */

    header("content-type:application/json");
    session_start();

    spl_autoload_register(function ($class) {
        include_once("../classes/".$class.".php");
    });

    $board = new Board();
    $board->setMSTitle($_POST['name']);
    $board->setMSUser($_SESSION['email']);
    $board->setMBPrivate($_POST['private']);
    $board->setMATopics($_POST['topics']);

    echo json_encode($board->createBoard());