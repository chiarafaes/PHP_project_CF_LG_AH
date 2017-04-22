<?php
session_start();
spl_autoload_register(function ($class){
    include_once ("classes/".$class.".php");
});

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
            <a href="#">
                <div class="collection_collections">
                    <p>0</p>
                    <p>collections</p>
                </div>
            </a>

            <a href="#">
                <div class="collection_items">
                    <p>0</p>
                    <p>items</p>
                </div>
            </a>

            <a href="#">
                <div class="collection_likes">
                    <p>0</p>
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

        <div id="collections_boards">
            <div class="collections_boards_">
                <a href="#">
                    <div class="board 1">
                        <p>Name board</p> <!-- get name from collection -->
                        <div class="board_info">
                            <p>0 items</p>
                            <p>0 followers</p>
                        </div>
                        <div class="collection_images">
                            <img src="#" class="img_1"/> <!-- get image from collection -->
                        </div>
                    </div>
                </a>
                <a href="#">
                    <div class="board 2">
                        <p>Name board</p> <!-- get name from collection -->
                        <div class="board_info">
                            <p>0 items</p>
                            <p>0 followers</p>
                        </div>
                        <div class="collection_images">
                            <img src="#" class="img_1"/> <!-- get image from collection -->
                        </div>
                    </div>
                </a>
                <a href="#">
                    <div class="board 3">
                        <p>Name board</p> <!-- get name from collection -->
                        <div class="board_info">
                            <p>0 items</p>
                            <p>0 followers</p>
                        </div>
                    </div>
                </a>
                <a href="#">
                    <div class="board 4">
                        <p>Name board</p> <!-- get name from collection -->
                        <div class="board_info">
                            <p>0 items</p>
                            <p>0 followers</p>
                        </div>
                        <div class="collection_images">
                            <img src="#" class="img_1"/> <!-- get image from collection -->
                        </div>
                    </div>
            </div>
            </a>
        </div>
    </div>
</div>

<script src="js/popup.js"></script>

</body>
</html>
