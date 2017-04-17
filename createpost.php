<?php
//
//spl_autoload_register(function ($class){
//    include_once ("classes/".$class.".php");
//});
//
//if (!empty($_POST)){
//    try{
//        // doe iets
//    } catch (PDOException $e){
//        $error = $e->getMessage();
//    }
//}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/default.css" />
    <link rel="stylesheet" href="css/home.css" />

    <title>CreatePost</title>
</head>
<body>
<form method="post" name="Posten" action="upload.php" id="Posten" enctype="multipart/form-data"/>
<a class="close" href="#close">x</a>
<div class="create_uploadphoto">
    <label>Upload photo</label>
    <div class="picgroup">
        <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
        <input type="hidden" name="img_type" value="post" />
        <img id="target" src="http://placehold.it/180x280" alt="#" />
        <input type="file" name="fileToUpload" id="fileToUpload" class="inputfile">
    </div>
</div>

<div class="right_column">

    <div class="create_title">
        <label>Title</label>
        <input type="text" name="title" />
    </div>


    <div class="create_description">
    <label>Description</label>
    <textarea rows="10" cols="19" name="Description" form="Posten" placeholder="Enter Description here..."></textarea>
</div>

    <div class="create_btnPost">
    <input type="submit" name='submit' value="Post" />
    </div>
</div>
</form>
</body>
</html>
