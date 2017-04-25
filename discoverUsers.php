<?php
session_start();
spl_autoload_register(function ($class) {
    include_once("classes/".$class.".php");
});

$allUsers = User::getUsers();



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


    <title>Discover Users</title>

    <style>
            h1{
                text-align: center;
                color: rgb(80,80,80);
            }

            #wrapper{
                width: 95%;
                margin: 2em;
            }

            .allUsers {
                margin: 1em;
                padding: 0;
                -moz-column-gap: 1em;
                -webkit-column-gap: 1em;
                column-gap: 1em;
            }


            .item {
                display: inline-block;
                background-color: white;
                border-radius: 5px;
                padding: 1em;
                margin: 0 0 1em;
                width: 100%;
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
            }

            .item a{
                text-decoration: none;
                margin-left: auto;
                margin-right: auto;
                display: block;
                margin-top: 10px;
                background-color: #10a6ad;
                color: white;
                border-radius: 5px;
                padding: 10px 20px 10px 20px;
                font-weight: 400;
                font-size: 12px;
                letter-spacing: 1.5px;
                text-transform: uppercase;
                text-align:center;
                width: 100px;
            }

            .item a:hover{
                background-color: #0A6970;
                color: white;
            }

            .item p{
                font-size: 13px;
                font-weight: 400;
                letter-spacing: 1px;

                color:#666666;
                text-align: center;
            }

            .item img{
                margin-left: auto;
                margin-right: auto;
                display: block;
                margin-bottom: 20px;
                width: 120px;

            }


            @media only screen and (min-width: 400px) {
                .allUsers {
                    -moz-column-count: 2;
                    -webkit-column-count: 2;
                    column-count: 2;
                }
            }

            @media only screen and (min-width: 700px) {
                .allUsers {
                    -moz-column-count: 3;
                    -webkit-column-count: 3;
                    column-count: 3;
                }
            }

            @media only screen and (min-width: 900px) {
                .allUsers {
                    -moz-column-count: 4;
                    -webkit-column-count: 4;
                    column-count: 4;
                }
            }

            @media only screen and (min-width: 1100px) {
                .allUsers {
                    -moz-column-count: 5;
                    -webkit-column-count: 5;
                    column-count: 5;
                }
            }

            @media only screen and (min-width: 1280px) {
                #wrapper {
                    width: 1260px;
                }
            }


    </style>
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
<body>


<h1>Discover users</h1>
<div id="wrapper">
    <div class="allUsers">
        <?php foreach ($allUsers as $user): ?>
        <div class="item">
            <img src="<?php echo $user['avatar'] ?>">
            <p><?php echo $user['Username'] ?></p>
            <a href="profilepage_follower.php">View profile</a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>