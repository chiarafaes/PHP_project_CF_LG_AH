<?php

    spl_autoload_register(function ($class){
        include_once ("classes/".$class.".php");
    });

    if (!empty($_POST)){
        try{
            // gegevens opslaan
            $user = new User();

            // error handling voor lege velden
            if(empty($user->Mail = $_POST['email'])){
                $error = "Field 'email' can not be empty.";
            } elseif (empty($user->Password = $_POST['password'])){
                $error = "Field 'password' can not be empty.";
            }

            // enkel code doen indien alle velden ingevuld zijn
            if (!isset($error)) {

                // query doen naar db om bcrypt wachtwoord terug te krijgen en te verifyen
                $conn = Db::getInstance();
                $statement = $conn->prepare("SELECT * FROM users WHERE Mail = :mail");
                $statement->bindValue(":mail", $user->Mail);

                if ($statement->execute() && $statement->rowCount() != 0) {
                    $res = $statement->fetch(PDO::FETCH_ASSOC);

                    // hier gaan we het opgeslagen wachtwoord vergelijken met het ingegeven wachtwoord
                    if (password_verify($user->Password, $res['Password'])) {
                        // correct dus we starten de session
                        session_start();

                        // we maken session vars aan voor later
                        $_SESSION['email'] = $user->Mail;
                        $_SESSION['username'] = $res['Username'];
                        $_SESSION['fullname'] = $res['Fullname'];

                        // we sturen de user door
                        header('location:loggedin.php');
                    } else {
                        $error = 'Password does not match. Please try again.';
                    }

                } else {
                    $error = "User does not exist in database. Please register first." . "</br>" . "<a href='registration.php'>Sign up here</a>";
                }
            }

            // Normaal gezien gaan we niet zeggen of het wachtwoord of de username fout is.
            // We gaan gewoon zeggen dat indien één van de twee fout is dat de user niet kan inloggen.
            // Dit is nu zo om te testen, maar in production kunnen/moeten we dat veranderen.

        } catch (PDOException $e){
            $error = $e->getMessage();
        }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Imd'terest - login</title>
    <link rel="stylesheet" href="css/default.css" />
    <link rel="stylesheet" href="css/registration.css" />

    <style>

        .error {

            margin-top: 15px;
            color: #dd6b47;
            font-size: 14px;
            font-weight: 300;
        }

        .error a{
            color: #dd6b47;
            font-size: 14px;
            font-weight: 300;
            padding-top: 10px;

        }

    </style>
</head>
<body>

<section class="left">
    <a href="index.php"><img src="img/logo_icon.svg"/></a>
    <img src="img/logo_naam.png" class="login_name"/>
</section>



<section class="right">

    <h2>Welcome back</h2> </br>
    <h2>Sign in to continue</h2>

        <?php if (isset($error)):?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" id="login">
        
           <fieldset>
                <label for="email">Email</label>
                <input name="email" id="email" type="email" placeholder="email" />
           </fieldset>

            <fieldset>
                <label for="password">Password</label>
                <input name="password" id="password" type="password" placeholder="password"/>
            </fieldset>
  
            <fieldset>
                <button type="submit">Login</button>
            </fieldset>
        </form> 
    </section>

</body>
</html>
