<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11/05/2017
 * Time: 9:07
 */

    session_start();

    header("content-type:application/json");

    spl_autoload_register(function ($class) {
        include_once("../classes/".$class.".php");
    });

    $input = $_POST['input'];

    $html = file_get_contents($input);

    preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i',$html, $matchesIMG );
    preg_match_all( '|<h1>|i',$html, $matchesH1 );

//    foreach ($images as $image) {
//        echo json_encode($image->getAttribute('src'));
//    }


    echo json_encode($matchesIMG[0]);