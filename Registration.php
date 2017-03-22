<?php
    include_once ("classes/user.php");

    if(!empty($_POST)){
        try{
            $user = new User();
            $user->Fullname = $_POST["fullname"];
            $user->Username = $_POST["username"];
            $user->Mail = $_POST["email"];
            $user->Password = password_hash($_POST["password"], PASSWORD_DEFAULT, $options); 

            $options = [
                'cost'=> 12
            ];

//            $password = password_hash($user->Password, PASSWORD_DEFAULT, $options);

            $conn= Db::getInstance();


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
        <h1>Welcome to #####</h1>
        <form method="post" name="loggin" action="#" id="loggin">

            <fieldset>
                <input id="fullname" name="fullname" type="fullname" placeholder="fullname">
            </fieldset>
            <fieldset>
                <input id="username" name="username" type="username" placeholder="username">
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
