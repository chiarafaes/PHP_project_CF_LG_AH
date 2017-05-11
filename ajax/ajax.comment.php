<?php
session_start();

spl_autoload_register(function ($class) {
    include_once("../classes/".$class.".php");
});

//controleer of er een comment wordt verzonden
if(!empty($_POST['comment'])) { // comment uit query

    $comment->Text = $_POST['comment'];
    try {
        $comment->Save();
        $feedback = [
            "code" => 200,
            "message" => htlmspecialchars($_POST['comment'])

        ];

    } catch (Exception $e) {

    $error = $e->getMessage();
    $feedback = [
        "code" => 500,
        "message" => $error
    ];
}
echo json_encode($feedback); //{"code":500, "message:"}
}




?>




