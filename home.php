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
    <link rel="stylesheet" href="css/profilesettings.css">
    <title>Home</title>
</head>
<body>
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

<h1>Oh no, ...</h1>
<h2>There doesn't seem to be anything here!</h2>

</body>
</html>