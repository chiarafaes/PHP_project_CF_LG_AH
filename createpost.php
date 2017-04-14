<?php
    session_start();

    spl_autoload_register(function ($class){
        include_once ("classes/".$class.".php");
    });

    if (!empty($_POST)){
        try{
            $post = new Post();

            $post->setMPicture($_POST['fileToUpload']);
            $post->setMSDescription($_POST['Description']);
            $post->setMSUserName($_SESSION['email']);

            var_dump($post->Save());

        } catch (PDOException $e){
            $error = $e->getMessage();
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CreatePost</title>
</head>
<body>
    <form method="post" name="Posten" action="#" id="Posten"/>
        <fieldset>
            <label>Profile photo</label>
            <div class="picgroup">
                <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
                <input type="hidden" name="img_type" value="post" />
                <input type="file" name="fileToUpload" id="fileToUpload">
            </div>
        </fieldset>

        <fieldset>
            <label>Description</label>
            <textarea rows="4" cols="50" name="Description" form="Posten">Enter Description here...</textarea>
        </fieldset>

        <fieldset>
            <input type="submit" name='submit' value="Post" />
        </fieldset>

    </form>
</body>
</html>
