<?php
spl_autoload_register(function ($class) {
    include_once("classes/".$class.".php");
});

$getTopics = Topic::getAllTopics();


?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/default.css" />
    <link rel="stylesheet" href="css/home.css" />
    <script src="js/jquery.js"></script>
    <script src="js/scrape.js"></script>

    <title>CreatePost</title>
</head>
<body>
<form method="post" name="Posten" action="upload.php" id="Posten" enctype="multipart/form-data"/>
<a class="close" href="#close">x</a>
<div class="create_uploadphoto">
    <div class="upload_file">
    <div class="picgroup">
        <label>Upload photo</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
        <input type="hidden" name="img_type" value="post"/>
        <input type="file" name="fileToUpload" id="fileToUpload" class="inputfile">
    </div>

    <div class="url_link">
        <label for="url">URL</label>
        <input type="url" class="url" name="url" id="url" placeholder="Enter URL here" />
    </div>

</div>
    <div class="rendered-images">
        <label for="">Select an image</label>
    </div>

    <div class="create_title">
        <label>Title</label>
        <input type="text" name="title" id="title" />
    </div>

    <div class="create_description">
        <label>Description</label>
        <textarea rows="10" cols="19" name="Description" form="Posten" placeholder="Enter Description here..."></textarea>
    </div>

    <div class="box_topics">
        <label class="boxTitle">Choose collection</label>
        <form id="topics" action="" method="post">
            <ul>
                <?php foreach ($getTopics as $topic): ?>
                    <li>
                        <label for="<?php echo $topic ['name'];?>"><?php echo $topic ['name'];?>

                            <input class="topicInput" id="<?php echo $topic['name'];?>" name="topic" type="radio" value="<?php echo $topic['id'];?>">

                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>

        </form>
    </div>


  <div class="locationPost">
<div class="locationField">
    <label for="location">Locatie</label>
    <input type="text" id="location" name="location" readonly/>
</div>

<div class="create_btnPost">
    <input type="submit" name='submit' value="Post" />
</div>
  </div>


</div>
</form>


<script src="js/geolocation.js"></script>
<script src="js/emptyfieldspost.js"></script>


</body>
</html>
