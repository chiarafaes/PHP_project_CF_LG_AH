<?php
session_start();
spl_autoload_register(function ($class){
    include_once ("classes/".$class.".php");
});
// Wordt er gezocht? Doe dan de search
if(!empty($_POST['search'])){
    try{
        $search_param = $_POST['search'];
        $search = new Search();
        $search->setMSSearchParam($search_param);
        $renderedPosts = $search->Search();
    } catch (PDOException $e){
        $error = $e->getMessage();
    }
} else {
    // Als er niet gezocht wordt, dan alle posts inladen
    try{
        $renderedPosts = Post::getPosts(5, 0);
        $likedPosts = Post::getPostsLikedByUser($_SESSION['email']);
    } catch (PDOException $e){
        $error = $e->getMessage();
    }
}

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


    <title>Home</title>
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <script src="js/loadmore.js"></script>
    <!-- Dit scriptje is het doorgeven van PHP sessions vars in JSON naar jQuery voor de AJAX -->
    <script> var username = <?php echo json_encode($_SESSION['username'])?></script>
    <script src="js/like.js"></script>
</head>
<body>

<!-- Default header -->
<header>
    <div class="logo">
        <a href="home.php"><img src="img/logo.png" alt="logo"/></a>

    </div>

    <div class="search">
        <form method="post" name="searching" action="#" id="searching" >
            <input type="text" name="search" id="search" results=5 value="Search" onblur="if(this.value == '')
                    { this.value = 'Search'; }" onfocus="if(this.value == 'Search') { this.value = ''; }">
            <button id="searchbutton" name="searchbutton" type="submit">Submit</button>

        </form>
    </div>

    <div class="iconen">
        <div class="functions">
            <div class="icon"> <a href="#" class="fa fa-th-large"></a> </div>
            <div class="icon"> <a href="#" class="fa fa-comment"></a> </div>
            <div class="icon"> <a href="#" class="fa fa-bell-o"></a> </div>
        </div>
    </div>
        <div class="avatar">
            <a href="profilesettings.php"><img src="<?php echo Avatar::showAvatar(); ?>"></a>
        </div>

</header>

<!-- Popup - overlay - add item -->
<a href="#x" class="overlay" id="add_form"></a>
<div class="popup_additem">
    <?php include_once('createpost.php');?>
</div>

<!-- Button add item - rechterkolom -->
<div id="right" class="additem">
    <a href="#add_form" id="login_pop">+</a>
</div>


<!-- Overzicht posts-->
<main>
    <?php if(!empty($search_param)):?>
        <h1>Search results for '<?php echo $search_param; ?>'</h1>
        <a href="home.php">Clear results</a>
    <?php endif; ?>
    <div id="left" class="main_container">
        <?php foreach ($renderedPosts as $post):?>
            <div class="pin" id="pinID-<?php echo $post['id']?>">
                <div class="img_holder">
                    <div class="buttons" id="1">
                        <a href="#" class="btn send">Send</a>
                        <a href="#" class="btn save">Save</a>
                        <a href="#" class="btn like">
                            <img src="img/<?php
                            if(!empty($likedPosts)) {
                                $isLiked = false;
                                foreach ($likedPosts as $item) {
                                    if ($post['id'] == $item['post']) {
                                        $isLiked = true;
                                    }
                                }
                                if($isLiked){
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
                    <a class="image ajax" href="#" title="photo 1" id="1">
                        <img src="<?php echo $post['picture']; ?>" alt="" >
                    </a>
                </div>
                <p class="description"><?php echo $post['title']; ?></p>
                <p class="info"><span>0</span></p>
                <hr>
                <div class="user_info">
                    <img src="#" alt="#">
                    <p><?php echo $post['username']; ?></p>
                    <p class="categorie">Categorie</p>
                </div>
            </div>
        <?php endforeach;?>
    </div>


</main>

<!-- Load more - over hele pagina -->

<div id="loadmore">
    <a href="#" class="btn_loadmore" id="btn_loadmore">Load more...</a>
</div>


<script src="js/popup.js"></script>


</body>
</html>