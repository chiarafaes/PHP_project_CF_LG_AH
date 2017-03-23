<?php
    spl_autoload_register(function ($class){
        include_once ("classes/".$class.".php");
    });

    if (!empty($_POST)){
        try{
            // gegevens opslaan
            $user = new user();
            $user->Mail = $_POST['email'];
            $user->Password = $_POST['password'];

            // query doen naar db om bcrypt wachtwoord terug te krijgen en te verifyen
            $conn= Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM users WHERE Mail = :mail");
            $statement->bindValue(":mail", $user->Mail);

            if($statement->execute() && $statement->rowCount() != 0) {
                $res = $statement->fetch(PDO::FETCH_ASSOC);

                // hier gaan we het opgeslagen wachtwoord vergelijken met het ingegeven wachtwoord
               if(password_verify($user->Password, $res['Password'])){
                   // correct dus we starten de session
                   session_start();

                   // we maken session vars aan voor later
                   $_SESSION['email'] = $user->Mail;
                   $_SESSION['username'] = $res['Username'];
                   $_SESSION['fullname'] = $res['Fullname'];

                   // we sturen de user door
                   header('location:loggedin.php');
               } else{
                   $error = 'Password does not match. Please try again';
               }

            } else {
                $error = "User does not exist in database. Please register first.";
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
    <title>Welcome to INSPIR8</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div class="box">
        <?php if (isset($error)):?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post" id="login">
        
           <div class="form-group">
                <label for="email">email </label>
                <input name="email" id="email" type="email" />
            </div>
  
            <div class="form-group">
                <label for="password">Password</label>
                <input name="password" id="password" type="password" /> 
            </div>
  
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
        </form> 
    </div>
</body>
</html>
