<?php
spl_autoload_register(function ($class) {
    include_once("classes/".$class.".php");
});

$getTopics = User::getTopics();


?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/default.css" />
    <link rel="stylesheet" href="css/profilepage.css" />
    <script src="js/create-board.js"></script>

    <title>Create collection</title>
</head>
<body>
<form method="post" name="create" action="board.php" id="create" >
    <a class="close" href="#close">x</a>


    <div class="collection_title">
        <label>Name</label>
        <input type="text" name="name" id="board-name" placeholder="Give your collection a name"/>
    </div>


    <div class="toggleSwitch">
        <label>Private</label>
        <label class="switch">
            <input type="checkbox" name="checkbox" id="private" value="off" onclick="if($(this).val() == 'off'){$(this).val('on')} else {$(this).val('off')}" >
            <div class="slider"></div>
        </label>
    </div>

    <div class="box_topics">

        <form id="topics" action="" method="post">
            <ul>
                <?php foreach ($getTopics as $topic): ?>
                    <li>
                        <label for="<?php echo $topic ['name'];?>"><?php echo $topic ['name'];?>

                            <input class="topicInput" id="<?php echo $topic['id'];?>" name="<?php echo $topic['name'];?>" type="checkbox" value="off" onclick="if($(this).val() == 'off'){$(this).val('on')} else {$(this).val('off')}">

                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="btn_collection">
                <input type="button" id="create-board" value="Create"/>
            </div>

        </form>
    </div>
</body>
</html>
