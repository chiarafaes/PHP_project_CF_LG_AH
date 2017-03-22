
<? php

session_start();

if (isset($_SESSION['username'])){

}
else {
    header('Location: login.php');
}


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" />

    <link rel="stylesheet" href="css/style.css" />



</head>
<body>
<div class="box">

    <div class="avatar">
        <img src="https://s3.amazonaws.com/uifaces/faces/twitter/sillyleo/128.jpg" alt="avatar" />
    </div>

    <h1>Welcome back <?php echo $_SESSION['username']; ?></h1>
    <p>Hier komt nog iets</p>


    <form action="home.php" action="post" class="home">
            <input name="continue" type="submit" value="Continue" />
    </form>


    <form action="logout.php" action="post" class="logout">
            <input name="logout" type="submit" value="Logout of account" />
     </form>

</div>
</body>
</html>
