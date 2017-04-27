<?php

header('Content-Type: application/json');
include_once("../classes/comment.php");
$comment = new Comment();

//controleer of er een update wordt verzonden
if(!empty($_POST['update'])) //update uit de jquery
{
    $comment->Text = $_POST['update'];
    try
    {
        $comment->Save();
        $feedback = [
            "code"=> 200,
            "message"=> htmlspecialchars($_POST['update'])
        ];
    }
    catch (Exception $e)
    {
        $error = $e->getMessage();
        $feedback = [
            "code"=> 500,
            "message"=> $error
        ];
    }
    echo json_encode($feedback); //{"code":500, "message:"}
}
?>