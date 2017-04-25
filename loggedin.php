<?php

session_start();
spl_autoload_register(function ($class) {
    include_once("classes/".$class.".php");
});

if (isset($_SESSION['email'])) {
} else {
    header('Location: login.php');
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" />

    <link rel="stylesheet" href="css/default.css" />
    <link rel="stylesheet" href="css/loggedin.css" />


</head>
<body>
    <div class="box">

        <div class="avatar">
            <img src="<?php echo Avatar::showAvatar(); ?>">
        </div>

        <h1>Welcome back, <?php echo $_SESSION['username']; ?></h1>
        <p>Discover more inspiration!</p>

            <form action="home.php" action="post" class="home" id="loggedin">
                    <input type="submit" value="Continue" />
            </form>
            <form action="logout.php" action="post" class="logout" id="logout">
                    <input type="submit" value="Logout of account" />
             </form>


    </div>
</body>
</html>
