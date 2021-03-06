<?php
session_start();
spl_autoload_register(function ($class) {
    include_once("classes/".$class.".php");
});

// error_reporting(0); zorgt voor geen errors

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

$allTopics = Topic::getAllTopics();

$following = User::getFollowingsByUser($_SESSION['email']);
$followers = User::getFollowersByUser($user['Mail']);




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
    <script src="js/jquery.js"></script>
    <script src="js/show-collections.js"></script>
    <script src="js/delete-collection.js"></script>
    <script src="js/showLikedposts.js"></script>

    <title><?php echo $_SESSION['username']; ?></title>
</head>
<body>

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

<!-- Popup - overlay - create collection -->
<a href="#x" class="overlay" id="add_form"></a>
<div class="popup_additem">
    <?php include_once('createcollection.php');?>
</div>
<div id="main">
    <div id="profile_left">

        <div class="profile_user_info">
            <a class="user_profile" href="profilepage_user.php"><img src="<?php echo Avatar::showAvatar(); ?>"></a>
            <h2><?php echo $_SESSION['username']; ?></h2>
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
                <p id="counter" class="amount"><?php if(!empty($collections)){echo count($collections);} else {echo '0';}?></p>
                <p class="info_name">collections</p>
            </div>
            </a>

            <a href="#" id="btn_items">
            <div class="collection_items">
                <p class="amount"><?php echo count($posts);?></p>
                <p class="info_name">items</p>
            </div>
            </a>

            <a href="#" id="btn_likes">
            <div class="collection_likes">
                <p class="amount"><?php echo count($likes);?></p>
                <p class="info_name">likes</p>
            </div>
            </a>

            <a href="#" id="btn_followers ">
            <div class="collection_followers">
                <p class="amount"><?php echo count($followers);?></p>
                <p class="info_name">Followers</p>
            </div>
            </a>

            <a href="#" id="btn_following">
            <div class="collection_following">
                <p class="amount"><?php echo count($following);?></p>
                <p class="info_name">Following</p>
            </div>
            </a>
        </div>


    <div id="main-container" class="main_container_profile likeable">
        <?php foreach ($posts as $post):?>
            <div class="pin" id="pinID-<?php echo $post['id']?>">
                <div class="img_holder">
                    <div class="buttons" id="1">
                        <a href="#" class="btn send">Send</a>
                        <a href="#" class="btn save">Save</a></br>
                    </div>
                    <a href="detailpagina.php?post=<?php echo $post['id'];?>" class="image ajax" title="photo 1" id="loginpop">
                        <img src="<?php echo $post['picture']; ?>" alt="" >
                    </a>
                </div>
                <p class="description"><?php echo $post['title']; ?></p>
                <p class="icon_heart"><img src="img/icon_hartjeLikes.svg"></p>
                <p class="likes"><span><?php echo $post['likes']; ?></span></p>
                <p class="comment_count"><span> Comments: <?php echo count(Comment::countComments($post['id'])); ?></span></p>
                <p class="postdate"><?php echo Post::getTimeAgo($post['postdate']); ?></p>
                <?php
                $id = $post['id'];
                $topic = Post::getCategorie($id);
                ?>
                <hr>
                <div class="user_info">
                    <a href="profilepage_follower.php?profile=<?php echo $post['creator_mail']?>"><img src="<?php echo $user['avatar']; ?>" alt="#"></a>
                    <p><?php echo $post['username']; ?></p>
                    <p class="categorie"><?php echo $topic['name']?></p>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
</div>
<script src="js/popup.js"></script>
<script src="js/ShowOwnItems.js"></script>
</body>
</html>
