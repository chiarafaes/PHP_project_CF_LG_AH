<?php
session_start();
spl_autoload_register(function ($class) {
    include_once("classes/".$class.".php");
});


$allTopics = Topic::getAllTopics();

$categorie = Topic::getIdTopic($_GET['categorie']);
$posts = Post::getPostsByTopic($categorie['id']);
$user = User::getUser($_SESSION['email']);


?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/profilesettings.css">


    <title>Categorie | <?php echo $categorie['name']?></title>
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <script src="js/loadmore.js"></script>
    <script src="js/like.js"></script>
    <script src="js/add-to-collection.js"></script>
</head>
<body>

<!-- Default header -->
<header>
    <div class="logo">
        <a href="home.php"><img src="img/logo_header.svg" alt="logo"/></a>

    </div>


    <div class="search">
        <form method="post" name="searching" action="#" id="searching" >
            <input type="text" name="search" id="search" results=5 placeholder="Search title, description, place"; }">
            <button id="searchbutton" name="searchbutton" type="submit">Submit</button>

        </form>
    </div>

    <div class="iconen">
        <div class="icon_1">
            <a href="home.php" class="dropbtn_categorie"><img src="img/icon_categories.svg"></a>
            <div class="dropdown-content_categorie">
                <div class="left_categorie">
                    <?php foreach ($allTopics as $topic): ?>
                        <a href="categorie.php?categorie=<?php echo $topic['id']?>"><?php echo $topic['name']?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    <div class="icon_2">
        <a href="#" ></a>
    </div>
    <div class="icon_3">
        <a href="#" ></a>
    </div>

    </div>

    <div class="avatar">
        <a href="profilepage_user.php" class="dropbtn"><img src="<?php echo Avatar::showAvatar(); ?>"></a>
        <div class="dropdown-content">
            <a href="discoverUsers.php">Discover users</a>
            <hr class="hr_dropdown">
            <a href="profilepage_user.php">My profile</a>
            <a href="profilepage_user.php">My collections</a>
            <a href="profilepage_user.php">My uploads</a>
            <hr class="hr_dropdown">
            <a href="profilesettings.php">Settings</a>
            <a href="logout.php" class="btn_logout">Logout</a>
        </div>
    </div>

    </header>

<main>

    <div id="left" class="main_container_likeable" >
        <h1 class="topic_title"><?php echo $categorie['name']?></h1>
        <?php foreach ($posts as $post):?>
            <div class="pin" id="pinID-<?php echo $post['id']?>">
                <div class="img_holder">
                    <div class="buttons" id="1">
                        <a href="#" class="btn send">Send</a>
                        <a href="#" class="btn save">Save</a></br>
                        <a href="#" class="btn like">
                            <img src="img/<?php
                            if (!empty($likedPosts)) {
                                $isLiked = false;
                                foreach ($likedPosts as $item) {
                                    if ($post['id'] == $item['post']) {
                                        $isLiked = true;
                                    }
                                }
                                if ($isLiked) {
                                    echo 'liked_icon.svg';
                                } else {
                                    echo 'like_icon.svg';
                                }
                            } else {
                                echo 'like_icon.svg';
                            }
                            ?>"/>
                        </a>

                    </div>

                    <a href="detailpagina.php?post=<?php echo $post['id'];?>" onclick="PopupCenter();" class="image ajax" title="photo 1" id="loginpop">
                        <img src="<?php echo $post['picture']; ?>" alt="" >
                    </a>

                    <?php

                    $id = $post['id'];
                    $topic = Post::getCategorie($id);

                    ?>


                </div>
                <div class="info_photo">
                    <p class="description"><?php echo $post['title']; ?></p>
                    <p class="icon_heart"><img src="img/icon_hartjeLikes.svg"></p>
                    <p class="likes"><span><?php echo $post['likes']; ?></span></p>
                    <p class="comment_count"><span> Comments: <?php echo count(Comment::countComments($post['id'])); ?></span></p>
                    <p class="postdate"><?php echo Post::getTimeAgo($post['postdate']); ?></p>
                </div>

                <hr>




                <div class="user_info">
                    <a href="profilepage_follower.php?profile=<?php echo $post['creator_mail']?>"><img src="<?php echo $post['avatar']; ?>" alt="#"></a>
                    <p><?php echo $post['username']; ?></p>
                    <p class="categorie"><?php echo $topic['name']?></p>
                </div>
            </div>
        <?php endforeach;?>
    </div>


</main>
</body>
</html>
