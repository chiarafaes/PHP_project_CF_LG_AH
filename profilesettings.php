<?php
    session_start();
    $feedback = '';

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
        $feedback = "Failed to get user-data from database. Please reload to try again.";
    }

    //Enkel bij post iets doen
    if(!empty($_POST)){
        try{

            // we checken of er gezocht wordt of niet. Search krijgt voorang op update van userprofile
            if(isset($_POST['search'])){
                // TODO: Search integereren
            } else {
                //nieuwe input user aanmaken
                $userNew = new user();
                $options = [
                    'cost' => 12
                ];
                $MinimumLength = 6;

                // We zien of alle velden zijn ingevuld en vullen alles reeds correct in voor de update
                if(empty($userNew->Fullname = $_POST["fullname"])){
                    $feedback = "Field 'Fullname' can not be empty.";
                }
                elseif (empty($userNew->Username = $_POST["username"])){
                    $feedback = "Field 'Username' can not be empty.";
                }
                elseif (empty($userNew->Password = $_POST['password'])){
                    $feedback = "Field 'Password' can not be empty.";
                }
                elseif (strlen($userNew->Password) < $MinimumLength){
                    $feedback = "Your password has to be at least 6 characters long.";
                }

                // enkel indien er geen fouten waren met het formulier gaan we door
                if(empty($feedback)){

                    // Wachtwoord encrypten
                    $userNew->Password = password_hash($userNew->Password, PASSWORD_DEFAULT, $options);

                    $updateQuery = $conn->prepare("UPDATE users SET Fullname=:fullname, Username=:username, Password=:password WHERE Mail=:user");
                    $updateQuery->bindValue(':fullname', $userNew->Fullname);
                    $updateQuery->bindValue(':username', $userNew->Username);
                    $updateQuery->bindValue(':password', $userNew->Password);
                    $updateQuery->bindValue(':user', $user->Mail);

                    if ($updateQuery->execute()) {
                        // als de update gelukt is dan gaan we de originele user vars overschrijven met de nieuwe vars
                        $user->Fullname = $userNew->Fullname;
                        $user->Username = $userNew->Username;
                        $feedback = 'Your profile has been updated!';
                    } else {
                        $feedback = 'Failed to save profile changes. Please try again.';
                    }
                }
            }
        } catch (PDOException $e){
            $feedback = $e->getMessage();
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
    <link rel="stylesheet" href="css/profilesettings.css">
    <script src="js/pagename.js"></script>
    <title>IMD'terest - <?php echo $user->Username; ?> </title>

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
<div class="wrap">
    <div class="sideBar">
        <div class="sideBar__section">
            <div class="sideBar__item is-side-bar-item-selected">Profile ></div>
            <div class="sideBar__item">Privacy ></div>
            <div class="sideBar__item">Conditions ></div>
            <div class="sideBar__item">Contact ></div>
            <div class="sideBar__item_2">Help ></div>
        </div>
        <div class="sideBar__section">
            <div class="sideBar__item_">
                <a href="logout.php" class="item_logout">Logout</a>
            </div>
        </div>
    </div>

    <div class="right">
        <div id="pagename">
        </div>
        <div class="profile">
            <div class="profilepicture">
                <img src="<?php echo $res['avatar']?>" alt="profile picture">
                <div class="changepicture">
                    <form name="upload" id="upload" action="upload.php" method="post" enctype="multipart/form-data">
                        <label>Profile photo</label>
                        <div class="picgroup">
                            <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
                            <input type="hidden" name="img_type" value="avatar" />
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <input type="submit" value="Upload photo" name="uploadphoto">
                        </div>
                    </form>
                </div>
            </div>
            <?php if(!empty($feedback)):?>
                <div class="feedback"><?php echo $feedback;?></div>
            <?php endif; ?>
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
                    <input disabled id="email" name="email" type="text" placeholder="email" value="<?php echo $user->Mail; ?>"/>
                </fieldset>

                <fieldset>
                    <label>Password</label>
                    <input id="password" name="password" type="password" placeholder="password"/>
                </fieldset>

                <fieldset>
                    <button type="submit">Save changes</button>
                </fieldset>
            </form>

        </div>
    </div>
</div>


</body>
</html>

