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
            $res = "succes";
            $MinimumLength = 6;

            // error handling voor lege velden
            if(empty($user->Fullname = $_POST["fullname"])){
                $error = "Field 'Fullname' can not be empty.";
            }
            elseif (empty($user->Username = $_POST["username"])){
                $error = "Field 'Username' can not be empty.";
            }
            elseif (empty($user->Mail = $_POST["email"])){
                $error = "Field 'Mail' can not be empty.";
            }
            elseif (empty($user->Password = $_POST['password'])){
                $error = "Field 'Password' can not be empty.";
            }
            elseif (strlen($user->Password) < $MinimumLength){
                $error = "Your password has to be at least 6 characters long.";
            }


            //maken connectie met de database door verwijzing naar de "klasse" DB
            $conn= Db::getInstance();

            // checken of er een error is door de lege velden
            if (!isset($error)) {
                // als er geen error is , zoek dan het mailadres op
                $statement = $conn->prepare("SELECT * FROM users WHERE Mail = :mail");
                $statement->bindValue(":mail", $user->Mail);

                //als het mailadres bestaat geef melding dat de mail reeds in gebruik is en niet save
                if ($statement->execute() && $statement->rowCount() != 0) {
                    $resultaat = $statement->fetch(PDO::FETCH_ASSOC);
                    $error = "Mail is already used";
                    $res = false;
                }else{
                    // doorsturen naar topics
                    if ($res != false) {
                        // OK
                        $succes = "Welcome, you are registered";
                        $user->Save();
                        header("location:topics.php");
                        session_start();

                        // we maken session vars aan voor later
                        $_SESSION['email'] = $user->Mail;
                        $_SESSION['username'] = $user->Username;
                        $_SESSION['fullname'] = $user->Fullname;

                    } else {
                        // Niet OK
                        $fail = "Oops, something went wrong! Try again!";
                        header("location:registration.php");
                    }
                }
            }
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

        <div>
            <?php if (isset($error)):?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </div>
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
                <input type="submit" name='submit' value="register" />
            </fieldset>

        </form>
    </section>
</body>
</html>
