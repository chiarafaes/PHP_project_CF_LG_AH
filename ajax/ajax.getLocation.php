<?php
/**
 * Created by PhpStorm.
 * User: chiarafaes
 * Date: 6/05/17
 * Time: 15:00
 */
session_start();

spl_autoload_register(function ($class) {
    include_once("../classes/".$class.".php");
});

if(!empty($_POST['latitude']) && !empty($_POST['longitude'])){
    //Send request and receive json data by latitude and longitude
    $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($_POST['latitude']).','.trim($_POST['longitude']).'&sensor=false';
    $json = @file_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
    if($status=="OK"){
        //Get address from json data
        $location = $data->results[3]->formatted_address;
        $newpost = new Post();
        $newpost->setMSLocation($location);
    }else{
        $location =  '';
    }

    //Print address
    echo json_encode($location);
}
?>