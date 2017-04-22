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

<div>
    <img src="<?php echo Avatar::showAvatar(); ?>">
    <p>Naam gebruiker</p>
    <a href="profilepage_follower.php">View profile</a>

</div>


</body>
</html>