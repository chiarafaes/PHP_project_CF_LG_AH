<?php
    session_start();
    $error = '';

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
            // TODO: Query aanpassen naar inner join zodat topics van user kunnen worden vergeleken
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

                if (count($topics)>= 5) {

                    // we gaan per topic een query doen
                    foreach ($topics as $topic) {
                        $insert = $conn->prepare("INSERT INTO users_topics (fk_users, fk_topics) VALUES (:user, :topic)");
                        $insert->bindValue(":user", $user);
                        $insert->bindValue(":topic", $topic);
                        if ($insert->execute()) {
                            $succes = "Your topics have been saved";
                        }

                    }
                } else {
                    $error = "You need to pick at least 5 topics to continue.";
                }
            }

        } else {
            header('location:login.php');
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
    <link rel="stylesheet" href="css/default.css" />
</head>
<body>
    <h1>Thanks for joining us! Let's get you started.</h1>
    <h2>First, choose 5 topics you're interested in.</h2>

    <?php if(!empty($error)):?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form id="topics" action="" method="post">
        <fieldset>
            <?php while($res = $statement->fetch(PDO::FETCH_ASSOC)): ?>
                <label for="<?php echo $res['name'];?>"><?php echo $res['name'];?></label>
                <input class="topicInput" id="<?php echo $res['name'];?>" name="<?php echo $res['name'];?>" type="checkbox" value="<?php echo $res['id'];?>">
            <?php endwhile; ?>
        </fieldset>
        <fieldset><button id="submit" disabled type="submit">Save topics</button></fieldset>
        <fieldset>
            <h3>Or search for specific topics:</h3>
            <label for="search">Search</label>
            <input id="search" name="search" type="text">
        </fieldset>
        <script>
            window.onload = function () {
                var form = document.getElementById('topics');
                var topics =  document.getElementsByClassName('topicInput');
                var btn = document.getElementById('submit');
                var requiredAmmount = 5;
                var ammountChecked = 0;

                // we gaan zien of we vijf (requiredAmmount) veldjes hebben aangeduid
                // anders is submit button niet actief
                form.addEventListener('change',function () {
                    for (i = 0; i<topics.length; i++){
                        if (topics[i].checked){
                            ammountChecked += 1;
                            if (ammountChecked == requiredAmmount){
                                btn.disabled = false;
                            } else{
                                btn.disabled = true;
                            }
                        }
                    };

                    // resetten van de counter
                    ammountChecked = 0;
                })

            }
        </script>

    </form>
</body>
</html>
