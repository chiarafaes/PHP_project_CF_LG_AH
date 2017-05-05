<?php
    session_start();

    spl_autoload_register(function ($class) {
        include_once("../classes/".$class.".php");
    });

    $code = array(
        "succes"=> false,
        "error" => ""
        );

    try {
        $report = new Post();
        $report->report($_POST["id"]);
        $code["succes"] = true;

    }catch (Exception $e){
        $code["succes"] = false;
        $code["error"] = $e->getMessage();
}

        echo json_encode($code);

