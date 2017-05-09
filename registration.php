<?php

//vervangt includes, deze functie moet slechts 1 keer geschreven worden
    spl_autoload_register(function ($class) {
        include_once("classes/".$class.".php");
    });

// als er gesubmit is gaan we velden uitlezen
    if (!empty($_POST)) {
        try {
            $options = [
                'cost'=> 12
            ];

            //lezen velden uit en steken dit in de waarden van de class user
            $user = new User();

            $res = "succes";
            $MinimumLength = 6;
            // we moeten deze get in een var steken omdat empty() een foutieve result teruggeeft als het een magic get is
            $email = $user->Mail = $_POST['email'];

            // error handling voor lege velden en het nakijken voor correct email adress
            if (empty($user->Fullname = $_POST["fullname"])) {
                $error = "Field 'Fullname' can not be empty.";
            } elseif (empty($user->Username = $_POST["username"])) {
                $error = "Field 'Username' can not be empty.";
            } elseif (empty($email)) {
                $error = "Field 'Email' can not be empty.";
            } elseif (substr_count($email, "@") < 1 || substr_count(substr($email, strpos($email, "@")), ".") < 1) {
                $error = "hallo";
            } elseif (empty($user->Password = $_POST['password'])) {
                $error = "Field 'Password' can not be empty.";
            } elseif (strlen($user->Password) < $MinimumLength) {
                $error = "Your password has to be at least 6 characters long.";
            }

            $user->Fullname = htmlspecialchars($_POST["fullname"]);
            $user->Username = htmlspecialchars($_POST["username"]);
            $user->Mail = htmlspecialchars($_POST["email"]);
            $user->Password = password_hash($_POST["password"], PASSWORD_DEFAULT, $options);
            // we maken een standaard avatar voor nieuwe profielen
            $user->Avatar = "https://s3.amazonaws.com/uifaces/faces/twitter/sillyleo/128.jpg";

            // checken of er een error is door de lege velden
            if (!isset($error)) {
                    if ($user->save()) {

                        session_start();

                        $_SESSION['email'] = $user->Mail;
                        $_SESSION['username'] = $user->Username;
                        $_SESSION['fullname'] = $user->Fullname;

                        header('location: topics.php');

                    } else {
                        // Niet OK
                        $error = "This e-mail address is already in use in the database. Please try again with another address.";
                    }

            }else{
            }
        } catch (PDOException $e) {
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
    <title>Imd-terest - registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" />

    <link rel="stylesheet" href="css/default.css" />
    <link rel="stylesheet" href="css/registration.css" />

    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/checkemail.js"></script>
    <script type="text/javascript" src="js/checkUsername.js"></script>

    <style>

        .error {

            color: #dd6b47;
            font-size: 14px;
            font-weight: 300;
            margin-left: 10px;
        }

    </style>
</head>
<body>

    <section class="left">
        <a href="index.php"><img src="img/logo_icon.svg" class="logo_icon"/></a>
        <a href="index.php"><img src="img/logo_naam.png" class="login_name"/></a>
    </section>


    <section class="right">
        <h2>Sign up to discover</h2> </br>
        <h2>IMD'terest</h2>

        <div>
            <?php if (isset($error)):?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </div>
        <form method="post" name="loggin" action="#" id="loggin"/>

            <fieldset>
                <label>Fullname</label>
                <input id="fullname" name="fullname" type="text" placeholder="fullname"/>
            </fieldset>

        <div class="usernameFeedback"><span></span></div>
        <?php if(isset($_SESSION['loginfeedback'])): ?>
            <div class="feedback"><?php echo $_SESSION['loginfeedback']; ?></div>
        <?php endif; ?>


        <fieldset>
                <label>Username</label>
                <input id="username" name="username" type="text" placeholder="username"/>
            </fieldset>

        <div class="mailFeedback"><span></span></div>
        <?php if(isset($_SESSION['loginfeedback'])): ?>
            <div class="feedback"><?php echo $_SESSION['loginfeedback']; ?></div>
        <?php endif; ?>

            <fieldset>
                <label>Email</label>
                <input id="email" name="email" type="text" placeholder="email"/>
            </fieldset>

            <fieldset>
                <label>Password</label>
                <input id="password" name="password" type="password" placeholder="password"/>
            </fieldset>

            <fieldset>
                <input id="createAccount" type="submit" name='submit' value="Sign up" />
            </fieldset>

        </form>
    </section>




</body>
</html>
