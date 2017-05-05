<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/05/2017
 * Time: 11:31
 */
    session_start();

    spl_autoload_register(function ($class) {
        include_once("../classes/".$class.".php");
    });

    $tmp = Board::getBoards($_SESSION['email']);

    $collections = [];

    // resultatenlijst opdelen in collections en bijbehorende categorieën
    foreach ($tmp as $val) {
        $categoriesPerCollection[] = array_slice($val, -3);
        $tmp_col[] = array_slice($val, 0, 4);
    }

    // ervoor zorgen dat collections geen dubbele rows bevatten
    foreach ($tmp_col as $val) {
        if (!in_array($val, $collections)) {
            $collections[] = $val;
        }
    }

    echo json_encode($collections);

