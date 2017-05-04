<?php
/**
 * Created by PhpStorm.
 * User: chiarafaes
 * Date: 4/05/17
 * Time: 15:45
 */

header('Content-Type: application/json');

spl_autoload_register(function ($class) {
    include_once("classes/".$class.".php");
});

$mailCheck = new User();

if(!empty($_POST['email'])){
    $mailCheck->__set("Mail",$_POST['email']);

    try
    {
        if($mailCheck->Check()==false){
            $feedback = [
                "message" => "mail available!"
            ];
        }else{
            $feedback = [
                "message" => "mail is not available!"
            ];
        }
        ;
    }
    catch (Exception $e)
    {
        $error = $e->getMessage();
    }
    echo json_encode($feedback);
}
?>