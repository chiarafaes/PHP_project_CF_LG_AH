<?php
session_start();
spl_autoload_register(function ($class) {
    include_once("classes/".$class.".php");
});

//error_reporting(0); zorgt voor verdwijnen van notice error

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
}

// Wordt er gezocht? Doe dan de search
if (!empty($_POST['search'])) {
    try {
        $search_param = $_POST['search'];
        $search = new Search();
        $search->setMSSearchParam($search_param);
        $renderedPosts = $search->Search();
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
} else {
    // Als er niet gezocht wordt, dan alle posts inladen
    try {

        $renderedPosts = Post::getPosts(20, 0, $_SESSION['email']); // Veranderd naar 20, want in briefing moet bij load more 20 items bijkomen
        $likedPosts = Post::getPostsLikedByUser($_SESSION['email']);

        // boards inladen voor save functie
        if(!empty($tmp = Board::getBoards($_SESSION['email']))){
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
        };


    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}

$allTopics = Topic::getAllTopics();


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
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <title>Home</title>

    <script src="js/loadmore.js"></script>
    <script src="js/like.js"></script>
    <script src="js/popup2.js"></script>
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

<div class="success"></div>

<div class="search_">
    <form method="post" name="searching" action="#" id="searching" >
        <input type="text" name="search" id="search" results=5 placeholder="Search title, description, place"; }">
        <button id="searchbutton" name="searchbutton" type="submit">Submit</button>

    </form>
</div>




<!-- Popup - overlay - add item -->
<div class="popup_additem" id="new_post">
    <?php include_once('createpost.php');?>
</div>

<!-- Popup - overlay - save to collection -->
<a href="#x" class="overlay" id="save_to_collection"></a>
<div class="popup_additem" id="save_to_collection_content">
    <p class="error">Hello</p>
    <h2>Save post to collection</h2>
    <?php foreach ($collections as $collection): ?>
        <label for="<?php echo $collection['title']?>"><?php echo $collection['title']?></label>
        <input type="radio" id="<?php echo $collection['title']?>" name="id" value="<?php echo $collection['id']?>"><br>
    <?php endforeach; ?>
    <button type="button" id="save">Save</button>
</div>

<!-- Button add item - rechterkolom -->
<div id="right" class="additem">
    <a href="#" id="login_pop">+</a>
</div>

<!-- Overzicht posts-->
<main>


    <?php if (!empty($search_param)):?>
        <div class="search_results">
            <h1>Search results for '<?php echo $search_param; ?>'</h1>
            <a href="home.php">Clear results</a>
        </div>
    <?php endif; ?>
    <div id="left" class="main_container likeable" >

        <?php foreach ($renderedPosts as $post):?>
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

<!-- Load more - over hele pagina -->
<?php if(count($renderedPosts) > 19):?>
<div id="loadmore">
    <a href="#" class="btn_loadmore" id="btn_loadmore">Load more...</a>
</div>
<?php endif; ?>



<script>
    $(function() {

        var $sidebar   = $("#right"),
            $window    = $(window),
            offset     = $sidebar.offset(),
            topPadding = 60;

        $window.scroll(function() {
            if ($window.scrollTop() > offset.top) {
                $sidebar.stop().animate({
                    marginTop: $window.scrollTop() - offset.top + topPadding
                });
            } else {
                $sidebar.stop().animate({
                    marginTop: 0
                });
            }
        });

    });

</script>

<script src="js/geolocation.js"></script>

</body>
</html>