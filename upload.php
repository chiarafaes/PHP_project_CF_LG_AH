<?php
/**
 * Created by PhpStorm.
 * User: Chiara
 * Date: 25/03/2017
 * Time: 22:14
 */

session_start();

var_dump($_POST);

//vervangt includes, deze functie moet slechts 1 keer geschreven worden
spl_autoload_register(function ($class){
    include_once ("classes/".$class.".php");
});

$target_dir = "uploads/";
$target_file = $target_dir . $_SESSION['email'] . "_" . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 30000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        // hier gaan we zien van waar er geupload wordt om te zien welke statische functie we moeten oproepen
        switch ($_POST['img_type']){
            case "avatar":
                $avatar = new Avatar();
                $avatar->file = $target_file;
                $avatar->deleteOldAvatar();
                $avatar->saveAvatar();
            break;
            case "post":
                $post = new Post();

                $post->setMPicture($target_file);
                $post->setMSDescription($_POST['Description']);
                $post->setMSTitle($_POST['title']);
                $post->setMSUserName($_SESSION['username']);

                if($post->Save()){
                    header('location:home.php');
                }
            break;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
