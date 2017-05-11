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

    $mode = $_POST['mode'];
    $input = $_POST['input'];

    $html = file_get_contents($input);
    $dom = new domDocument;
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $dom->preserveWhiteSpace = false;

    if ($mode == 'img') {
        preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i',$html, $matches );
        echo json_encode($matches[0]);
    }

    if ($mode == 'text') {
        if ($dom->getElementsByTagName('h1')->length != 0) {
            foreach ($dom->getElementsByTagName('h1') as $node) {
                echo json_encode($node->nodeValue);
            }
        } else {
            foreach ($dom->getElementsByTagName('h2') as $node) {
                echo json_encode($node->nodeValue);
            }
        }
    }

