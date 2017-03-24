<?php
    session_start();

    spl_autoload_register(function ($class){
        include_once ("classes/".$class.".php");
    });

    try {
        // enkel ingelogde users toegelaten!
        if (isset($_SESSION['email'])) {
            echo "allez tis goed";
            $user = $_SESSION['email'];

            $conn = Db::getInstance();

            // alle topics inladen
            $statement = $conn->prepare("SELECT * FROM topics");
            $statement->execute();

            // Wanneer er gesubmit word, de inputs opslaan en queryen
            if(!empty($_POST)){
                $topics = [];

                foreach ($_POST as $key => $value){
                    if($key != "search"){
                        array_push($topics, $value);
                    } else {
                        // TODO : logic for search
                    }
                }

                foreach ($topics as $topic){
                    $insert = $conn->prepare("INSERT INTO users_topics (fk_users, fk_topics) VALUES (:user, :topic)");
                    $insert->bindValue(":user", $user);
                    $insert->bindValue(":topic", $topic);
                    if($insert->execute()){
                        $succes = "Your topics have been saved";
                    }
                }
            }

        } else {
            echo "feckoff";
        }
    } catch (PDOException $e){
        $error = $e->getMessage();
    }

?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Choose your topics - Inspir8</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" />
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <h1>Thanks for joining us! Let's get you started.</h1>
    <h2>First, choose 5 topics you're interested in.</h2>

    <form id="topics" action="" method="post">
        <fieldset>
            <?php while($res = $statement->fetch(PDO::FETCH_ASSOC)): ?>
                <label for="<?php echo $res['name'];?>"><?php echo $res['name'];?></label>
                <input id="<?php echo $res['name'];?>" name="<?php echo $res['name'];?>" type="checkbox" value="<?php echo $res['id'];?>">
            <?php endwhile; ?>
        </fieldset>
        <fieldset><button type="submit">Save topics</button></fieldset>
        <fieldset>
            <h3>Or search for specific topics:</h3>
            <label for="search">Search</label>
            <input id="search" name="search" type="text">
        </fieldset>


    </form>
</body>
</html>
