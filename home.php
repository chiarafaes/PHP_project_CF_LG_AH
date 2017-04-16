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
            $post = new Post();

            $renderedPosts = $post->getAllPosts();
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
</head>
<body>

<!-- Default header -->
<header>
    <div class="logo">
        <a href="home.php"><img src="img/logo.png" alt="logo"/></a>

    </div>

    <div class="search">
        <form method="post" name="searching" action="#" id="searching" >
            <input id="search" name="search" type="search" placeholder="search"/>
            <button class="fa fa-search" aria-hidden="true" id="searchbutton" name="searchbutton" type="submit"></button>
        </form>
    </div>

    <div class="iconen">
        <div class="functions">
            <div class="icon"> <a href="#" class="fa fa-th-large"></a> </div>
            <div class="icon"> <a href="#" class="fa fa-comment"></a> </div>
            <div class="icon"> <a href="#" class="fa fa-bell-o"></a> </div>
        </div>
        <div class="avatar">
            <a href="profilesettings.php"><img src="<?php echo Avatar::showAvatar(); ?>"></a>
        </div>
    </div>
</header>

<!-- Popup - overlay - add item -->
<a href="#x" class="overlay" id="add_form"></a>
<div class="popup_additem">
    <?php include_once('createpost.php');?>
    <!--    <div class="header">-->
    <!--        <a class="close" href="#close">x</a>-->
    <!--        <h2>Add item</h2>-->
    <!--    </div>-->
    <!---->
    <!--    <div class="btn_createpost">-->
    <!--        <a onclick="PopupCenter('createpost.php','',800,500)">Create post</a>-->
    <!--    </div>-->

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
            <div class="pin">
                <div class="img_holder">
                    <div class="buttons" id="1">
                        <a href="#" class="btn send">Send</a>
                        <a href="#" class="btn save">Save</a>
                        <a href="#" class="btn like">
                            <img src="img/like_icon.svg" />
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
        <div class="pin">
            <div class="img_holder">
                <div class="buttons" id="1">
                    <a href="#" class="btn send">Send</a>
                    <a href="#" class="btn save">Save</a>
                    <a href="#" class="btn like">
                        <img src="img/like_icon.svg" />
                    </a>

                </div>
                <a class="image ajax" href="#" title="photo 1" id="1">
                    <img src="http://webneel.com/daily/sites/default/files/images/daily/01-2014/3-typography.jpg" alt="" >
                </a>
            </div>
            <p class="description">Hier komt beschrijving </p>
            <p class="info"><span>0</span></p>
            <hr>
            <div class="user_info">
                <img src="#" alt="#">
                <p>Naam user</p>
                <p class="categorie">Categorie</p>
            </div>
        </div>

        <div class="pin">
            <div class="img_holder">
                <div class="buttons" id="1">
                    <a href="#" class="btn send">Send</a>
                    <a href="#" class="btn save">Save</a>
                    <a href="#" class="btn like">
                        <img src="img/like_icon.svg" />
                    </a>

                </div>
                <a class="image ajax" href="#" title="photo 1" id="1">
                    <img src="http://webneel.com/daily/sites/default/files/images/daily/01-2014/3-typography.jpg" alt="" >
                </a>
            </div>
            <p class="description">Hier komt beschrijving </p>
            <p class="info"><span>0</span></p>
            <hr>
            <div class="user_info">
                <img src="#" alt="#">
                <p>Naam user</p>
                <p class="categorie">Categorie</p>
            </div>
        </div>

        <div class="pin">
            <div class="img_holder">
                <div class="buttons" id="1">
                    <a href="#" class="btn send">Send</a>
                    <a href="#" class="btn save">Save</a>
                    <a href="#" class="btn like">
                        <img src="img/like_icon.svg" />
                    </a>

                </div>
                <a class="image ajax" href="#" title="photo 1" id="1">
                    <img src="http://webneel.com/daily/sites/default/files/images/daily/01-2014/3-typography.jpg" alt="" >
                </a>
            </div>
            <p class="description">Hier komt beschrijving </p>
            <p class="info"><span>0</span></p>
            <hr>
            <div class="user_info">
                <img src="#" href="#">
                <p>Naam user</p>
                <p class="categorie">Categorie</p>
            </div>
        </div>

        <div class="pin">
            <div class="img_holder">
                <div class="buttons" id="1">
                    <a href="#" class="btn send">Send</a>
                    <a href="#" class="btn save">Save</a>
                    <a href="#" class="btn like">
                        <img src="img/like_icon.svg" />
                    </a>

                </div>
                <a class="image ajax" href="#" title="photo 1" id="1">
                    <img src="http://webneel.com/daily/sites/default/files/images/daily/01-2014/3-typography.jpg" alt="" >
                </a>
            </div>
            <p class="description">Hier komt beschrijving </p>
            <p class="info"><span>0</span></p>
            <hr>
            <div class="user_info">
                <img src="#" alt="#">
                <p>Naam user</p>
                <p class="categorie">Categorie</p>
            </div>
        </div>

        <div class="pin">
            <div class="img_holder">
                <div class="buttons" id="1">
                    <a href="#" class="btn send">Send</a>
                    <a href="#" class="btn save">Save</a>
                    <a href="#" class="btn like">
                        <img src="img/like_icon.svg" />
                    </a>

                </div>
                <a class="image ajax" href="#" title="photo 1" id="1">
                    <img src="http://webneel.com/daily/sites/default/files/images/daily/01-2014/3-typography.jpg" alt="" >
                </a>
            </div>
            <p class="description">Hier komt beschrijving </p>
            <p class="info"><span>0</span></p>
            <hr>
            <div class="user_info">
                <img src="#" alt="#">
                <p>Naam user</p>
                <p class="categorie">Categorie</p>
            </div>
        </div>

        <div class="pin">
            <div class="img_holder">
                <div class="buttons" id="1">
                    <a href="#" class="btn send">Send</a>
                    <a href="#" class="btn save">Save</a>
                    <a href="#" class="btn like">
                        <img src="img/like_icon.svg" />
                    </a>

                </div>
                <a class="image ajax" href="#" title="photo 1" id="1">
                    <img src="http://webneel.com/daily/sites/default/files/images/daily/01-2014/3-typography.jpg" alt="" >
                </a>
            </div>
            <p class="description">Hier komt beschrijving </p>
            <p class="info"><span>0</span></p>
            <hr>
            <div class="user_info">
                <img src="#" alt="#">
                <p>Naam user</p>
                <p class="categorie">Categorie</p>
            </div>
        </div>

        <div class="pin">
            <div class="img_holder">
                <div class="buttons" id="1">
                    <a href="#" class="btn send">Send</a>
                    <a href="#" class="btn save">Save</a>
                    <a href="#" class="btn like">
                        <img src="img/like_icon.svg" />
                    </a>

                </div>
                <a class="image ajax" href="#" title="photo 1" id="1">
                    <img src="http://webneel.com/daily/sites/default/files/images/daily/01-2014/3-typography.jpg" alt="" >
                </a>
            </div>
            <p class="description">Hier komt beschrijving </p>
            <p class="info"><span>0</span></p>
            <hr>
            <div class="user_info">
                <img src="#" alt="#">
                <p>Naam user</p>
                <p class="categorie">Categorie</p>
            </div>
        </div>

        <div class="pin">
            <div class="img_holder">
                <div class="buttons" id="1">
                    <a href="#" class="btn send">Send</a>
                    <a href="#" class="btn save">Save</a>
                    <a href="#" class="btn like">
                        <img src="img/like_icon.svg" />
                    </a>

                </div>
                <a class="image ajax" href="#" title="photo 1" id="1">
                    <img src="http://webneel.com/daily/sites/default/files/images/daily/01-2014/3-typography.jpg" alt="" >
                </a>
            </div>
            <p class="description">Hier komt beschrijving </p>
            <p class="info"><span>0</span></p>
            <hr>
            <div class="user_info">
                <img src="#" alt="#">
                <p>Naam user</p>
                <p class="categorie">Categorie</p>
            </div>
        </div>

    </div>

</main>

<!-- Load more - over hele pagina -->

<div id="loadmore">
    <a href="#" class="btn_loadmore">Load more...</a>
</div>


<script src="js/popup.js"></script>

</body>
</html>