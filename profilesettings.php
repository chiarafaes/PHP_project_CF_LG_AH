<?php
session_start();
$error = '';

//vervangt includes, deze functie moet slechts 1 keer geschreven worden
spl_autoload_register(function ($class){
    include_once ("classes/".$class.".php");
});

// eerst de usergegevens gaan halen uit db
$user = new user();
$user->Mail = $_SESSION['email'];

$conn = Db::getInstance();

$retrieveQuery = $conn->prepare("SELECT * FROM users WHERE Mail = :user");
$retrieveQuery->bindValue(':user', $user->Mail);

if($retrieveQuery->execute()){
    $res = $retrieveQuery->fetch(PDO::FETCH_ASSOC);
    $user->Fullname = $res['Fullname'];
    $user->Username = $res['Username'];


} else {
    $error = "failed";
    echo $error;
}

//Enkel bij post iets doen
if(!empty($_POST)){
    try{

        // we checken of er gezocht wordt of niet. Search krijgt voorang op update van userprofile
        if(isset($_POST['search'])){
            echo "er is gezocht";
            // TODO: Search integereren
        } else {
            echo "er is geupdate";

            //nieuwe input user aanmaken
            $userNew = new user();
            $options = [
                'cost' => 12
            ];
            $MinimumLength = 6;

            // We zien of alle velden zijn ingevuld en vullen alles reeds correct in voor de update
            if(empty($userNew->Fullname = $_POST["fullname"])){
                $error = "Field 'Fullname' can not be empty.";
            }
            elseif (empty($userNew->Username = $_POST["username"])){
                $error = "Field 'Username' can not be empty.";
            }
            elseif (empty($userNew->Mail = $_POST["email"])){
                $error = "Field 'Email' can not be empty.";
            }
            elseif (empty($userNew->Password = $_POST['password'])){
                $error = "Field 'Password' can not be empty.";
            }
            elseif (strlen($userNew->Password) < $MinimumLength){
                $error = "Your password has to be at least 6 characters long.";
            }

            // Wachtwoord encrypten
            $userNew->Password = password_hash($userNew->Password, PASSWORD_DEFAULT, $options);


        }

    } catch (PDOException $e){
        $error = $e->getMessage();
    }
}

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
    <title>Home</title>

</head>
<body>
<div class="wrap">
    <header>
        <div class="logo">
            <img src="img/logo.png" alt="logo"/>
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
                <img src="https://s3.amazonaws.com/uifaces/faces/twitter/sillyleo/128.jpg">
            </div>
        </div>

    </header>

    <div class="sideBar">
        <div class="sideBar__section">
            <div class="sideBar__item is-side-bar-item-selected">Profile ></div>
            <div class="sideBar__item">Privacy ></div>
            <div class="sideBar__item">Conditions ></div>
            <div class="sideBar__item">Contact ></div>
            <div class="sideBar__item">Help ></div>
        </div>
        <div class="sideBar__section">
            <div class="sideBar__item">Legal ></div>
        </div>
    </div>

    <div class="right">
        <div class="pagename">
            <p>hier komt de naam uit de kolom</p>
        </div>
        <div class="profile">
            <div class="profilepicture">
                <img src="https://s3.amazonaws.com/uifaces/faces/twitter/sillyleo/128.jpg">
                <div class="changepicture">
                    <form name="upload" id="upload" action="upload.php" method="post" enctype="multipart/form-data">
                        <label>Profile photo</label>
                        <div class="picgroup">
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <input type="submit" value="Upload photo" name="uploadphoto">
                        </div>
                    </form>
                </div>
            </div>
            <form name="changeprofile" id="changeprofile" action="#" method="post">
                <fieldset>
                    <label>Fullname</label>
                    <input id="fullname" name="fullname" type="text" placeholder="fullname" value="<?php echo $user->Fullname; ?>"/>
                </fieldset>

                <fieldset>
                    <label>Username</label>
                    <input id="username" name="username" type="text" placeholder="username" value="<?php echo $user->Username; ?>"/>
                </fieldset>

                <fieldset>
                    <label>Email</label>
                    <input id="email" name="email" type="text" placeholder="email" value="<?php echo $user->Mail; ?>"/>
                </fieldset>

                <fieldset>
                    <label>Password</label>
                    <input id="password" name="password" type="password" placeholder="password"/>
                </fieldset>

                <fieldset>
                    <!--                    <input type="submit" name='submit' value="Save changes" />-->
                    <button type="submit">Save changes</button>
                </fieldset>
            </form>

        </div>
    </div>
</div>

</body>
</html>

