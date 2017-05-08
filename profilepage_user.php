<?php
session_start();
spl_autoload_register(function ($class) {
    include_once("classes/".$class.".php");
});

    //eerst checken of user boards heeft, anders gewoon doorgaan
    if (!empty($tmp = Board::getBoards($_SESSION['email']))) {

        $collections = [];

        // resultatenlijst opdelen in collections en bijbehorende categorieën
        foreach ($tmp as $val) {
            $categoriesPerCollection[] = array_slice($val, -3);
            $tmp_col[] = array_slice($val, 0, 4);
        }

        // ervoor zorgen dat collections geen dubbele rows bevatten
        foreach ($tmp_col as $val) {
            if (!in_array($val, $collections)) {
                $collections[] = $val;
            }
        }
    }

$user = User::getUser($_SESSION['email']);
$posts = Post::getPostsByUser($user['Mail']);
$likes = Post::getPostsLikedByUser($_SESSION['email']);
$likedPostsShow = Post::getPostsLikedByUserAndShow($_SESSION['email']);

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
    <link rel="stylesheet" href="css/profilepage.css">

    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <script src="js/showcollections.js"></script>
    <title><?php echo $_SESSION['username']; ?></title>
</head>
<body>

<header>
    <div class="logo">
        <a href="home.php"><img src="img/logo_header.svg" alt="logo"/></a>

    </div>

    <div class="search">
        <form method="post" name="searching" action="#" id="searching" >
            <input type="text" name="search" id="search" results=5 value="Search" onblur="if(this.value == '')
                    { this.value = 'Search'; }" onfocus="if(this.value == 'Search') { this.value = ''; }">
            <button id="searchbutton" name="searchbutton" type="submit">Submit</button>

        </form>
    </div>

    <div class="iconen">
        <div class="icon_1">
            <a href="#" ></a>
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


<!-- Popup - overlay - create collection -->
<a href="#x" class="overlay" id="add_form"></a>
<div class="popup_additem">
    <?php include_once('createcollection.php');?>
</div>
<div id="main">
    <div id="profile_left">

        <div class="profile_user_info">
            <img src="<?php echo Avatar::showAvatar(); ?>">
            <h2><?php echo $_SESSION['username']; ?></h2>
            <h3>City, BE</h3>
            <p>hier komt een woordje uitleg over persoon in kwestie</p>
        </div>

        <div class="create_collection">
            <h3>Create collection</h3>
            <a href="#add_form" id="login_pop">+</a>
        </div>
    </div>

    <div id="profile_right">

        <div id="header_info">
            <a href="#" id="btn_collections">
            <div class="collection_collections">
                <p>0</p>
                <p>collections</p>
            </div>
            </a>

            <a href="#">
            <div class="collection_items">
                <p><?php echo count($posts);?></p>
                <p>items</p>
            </div>
            </a>

            <a href="#" id="btn_likes">
            <div class="collection_likes">
                <p><?php echo count($likes);?></p>
                <p>likes</p>
            </div>
            </a>

            <a href="#">
            <div class="collection_followers">
                <p>0</p>
                <p>Followers</p>
            </div>
            </a>

            <a href="#">
            <div class="collection_following">
                <p>0</p>
                <p>Following</p>
            </div>
            </a>
        </div>

        <!-- dit stukje geeft alle posts weer die geliked zijn door de gebruiker

        <div class="main_container_profile" class="likeable">
            <?php foreach ($likedPostsShow as $post):?>
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
                    </div>
                    <p class="description"><?php echo $post['title']; ?></p>
                    <p class="icon_heart"><img src="img/icon_hartjeLikes.svg"></p>
                    <p class="likes"><span><?php echo $post['likes']; ?></span></p>
                    <p class="postdate"><?php echo Post::getTimeAgo($post['postdate']); ?></p>

                    <?php

                    $id = $post['id'];
                    $topic = Post::getCategorie($id);

                    ?>

                    <hr>
                    <div class="user_info">
                        <a href="profilepage_follower.php"><img src="<?php echo $post['avatar']; ?>" alt="#"></a>
                        <p><?php echo $post['username']; ?></p>
                        <p class="categorie"><?php echo $topic['name']?></p>
                    </div>
                </div>
            <?php endforeach;?>
        </div>

-->



    <div class="main_container_profile" class="likeable">
        <?php foreach ($posts as $post):?>
            <div class="pin" id="pinID-<?php echo $post['id']?>">
                <div class="img_holder">
                    <div class="buttons" id="1">
                        <a href="#" class="btn send">Send</a>
                        <a href="#" class="btn save">Save</a></br>
                    </div>
                    <a href="detailpagina.php?post=<?php echo $post['id'];?>" onclick="PopupCenter();" class="image ajax" title="photo 1" id="loginpop">
                        <img src="<?php echo $post['picture']; ?>" alt="" >
                    </a>
                </div>
                <p class="description"><?php echo $post['title']; ?></p>
                <p class="icon_heart"><img src="img/icon_hartjeLikes.svg"></p>
                <p class="likes"><span><?php echo $post['likes']; ?></span></p>
                <p class="postdate"><?php echo Post::getTimeAgo($post['postdate']); ?></p>

                <?php

                $id = $post['id'];
                $topic = Post::getCategorie($id);

                ?>

                <hr>
                <div class="user_info">
                    <a href="profilepage_follower.php"><img src="<?php echo $post['avatar']; ?>" alt="#"></a>
                    <p><?php echo $post['username']; ?></p>
                    <p class="categorie"><?php echo $topic['name']?></p>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
</div>
<script src="js/popup.js"></script>

</body>
</html>
