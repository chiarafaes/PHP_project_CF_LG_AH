<?php
//vervangt includes, deze functie moet slechts 1 keer geschreven worden
    spl_autoload_register(function ($class){
        include_once ("classes/".$class.".php");
    });

// als er gesubmit is gaan we velden uitlezen
    if(!empty($_POST)){
        try{
            $options = [
                'cost'=> 12
            ];

            //lezen velden uit en steken dit in de waarden van de class user
            $user = new user();
            $user->Fullname = $_POST["fullname"];
            $user->Username = $_POST["username"];
            $user->Mail = $_POST["email"];
            $user->Password = password_hash($_POST["password"], PASSWORD_DEFAULT, $options);
            $user->Save();
            $res = "succes";
//            $password = password_hash($user->Password, PASSWORD_DEFAULT, $options);

            //maken connectie met de database door verwijzing naar de "klasse" DB
            $conn= Db::getInstance();


  /*          if ($res = "succes") {
                // sessie aanmaken indien registratie ok & redirect naar loggedin.php
                session_start();
               // $_SESSION['email'] = $_POST["email"];
                header('Location:loggedin.php');
                echo "$res";

            } else {
                //op de registarie pagina blijven wanneer de registratie niet gelukt is
                header('Location:registration.php');
            }
  */
        }
        catch (PDOException $e){
            $error= $e->getMessage();
        }


    }


?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
</head>
<body>
    <section>
        <h1>Welcome to inspir8</h1>
        <form method="post" name="loggin" action="#" id="loggin">

            <fieldset>
                <input
                        id="fullname" name="fullname" placeholder="fullname">
            </fieldset>
            <fieldset>
                <input id="username" name="username" placeholder="username">
            </fieldset>
            <fieldset>
                <input id="email" name="email" type="text" placeholder="email">
            </fieldset>
            <fieldset>
                <input id="password" name="password" type="password" placeholder="Password">
            </fieldset>

            <fieldset>
                <input type="submit" name='submit' value="registrate" />
            </fieldset>

        </form>
    </section>
</body>
</html>
