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
<link>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Post</title>
    <link rel="stylesheet" href="css/default.css" />
    <link rel="stylesheet" href="css/home.css" />
    <style>
        .picgroup img{
            max-width:180px;
        }

    </style>

</head>
    <form method="post" name="Posten" action="#" id="Posten"/>

        <div class="create_uploadphoto">
            <label>Upload photo</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
                <input type="hidden" name="img_type" value="post" />
                <img id="target" src="http://placehold.it/250x400" alt="#" />
            <input type="file" name="file" id="fileToUpload" class="inputfile" onchange="readURL(this);"/>
            <label for="file">Choose a file</label>


        </div>

    <div class="right_column">
        <div class="create_description">
            <label>Description</label>
            <textarea rows="6" cols="50" name="Description" form="Posten">Enter Description here...</textarea>
        </div>

        <div class="create_btnPost">
            <input type="submit" name='submit' value="Post" />
        </div>
    </div>

    </form>

    <script>

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#target').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            });

    </script>



</body>


</html>
