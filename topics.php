<?php
    session_start();
    $error = '';
    $userTopics = [];
    $insertTopics = [];
    $mergedTopics = [];
    $mode = '';

    spl_autoload_register(function ($class){
        include_once ("classes/".$class.".php");
    });

    try {
        // enkel ingelogde users toegelaten!
        if (isset($_SESSION['email'])) {
            $user = $_SESSION['email'];

            $conn = Db::getInstance();

            // alle topics inladen
            $statement = $conn->prepare("SELECT * FROM topics");
            if($statement->execute()){

                // nu dat de topics zijn ingeladen gaan we zien dewelke de user al had aangevinkt op voorhand
                $userTopicsQuery = $conn->prepare("SELECT * FROM users_topics WHERE fk_users = :user ");
                $userTopicsQuery->bindValue(':user', $user);

                // We steken de resultaten in een array
                if($userTopicsQuery->execute()){
                    while($x = $userTopicsQuery->fetch(PDO::FETCH_ASSOC)){
                        array_push($userTopics, $x['fk_topics']);
                    }
                }
            } else {
                $error = "There was a problem.";
            }

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

                // Omdat we niet telkens opnieuw dezelfde topics willen inserten gaan we de twee arrays met topics
                // met elkaar vergelijken en enkel de nieuwe topics onthouden. Als er een topic geen checkmark
                // meer heeft moeten we deze verwijderen

                if (count($topics) > count($userTopics)) {
                    $insertTopics = array_diff($topics, $userTopics);
                    $mode = 'add';
                } elseif (count($topics) < count($userTopics)){
                    $insertTopics = array_diff($userTopics, $topics);
                    $mode = 'delete';
                }



                // we zien of er wel degelijk 5 topics gekozen zijn (XSS)
                if (count($topics)>= 5) {

                    //naargelang de mode gaan we de query aanpassen
                    switch ($mode){
                        case 'add':
                            $query = $conn->prepare("INSERT INTO users_topics (fk_users, fk_topics) VALUES (:user, :topic)");
                        break;
                        case 'delete':
                            $query = $conn->prepare("DELETE FROM users_topics WHERE fk_users = :user AND fk_topics = :topic");
                    }

                    // we gaan per topic een query doen
                    foreach ($insertTopics as $topic) {
                        $query->bindValue(":user", $user);
                        $query->bindValue(":topic", $topic);
                        if ($query->execute()) {
                            $succes = "Your topics have been saved";
                        }
                    }
                } else {
                    $error = "You need to pick at least 5 topics to continue.";
                }
            }

            $mergedTopics = $userTopics;

            // semi ajax ding
            switch ($mode){
                case 'add':
                    $mergedTopics = array_merge($insertTopics, $userTopics);
                break;
                case 'delete':
                    $mergedTopics = array_diff($userTopics, $insertTopics);
                break;
            }

        } else {
            header('location:login.php');
        }
    } catch (PDOException $e){
        $error = $e->getMessage();
    }
var_dump($insertTopics);
echo '<br>';
var_dump($userTopics);
echo '<br>';
var_dump($mergedTopics);

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
    <link rel="stylesheet" href="css/topics.css" />


    <style>
        .error {

            color: #dd6b47;
            font-size: 14px;
            font-weight: 300;
            margin-left: 15px;
        }
    </style>
</head>
<body>
<div class="box_topics">
    <h1>Thanks for joining us! </br>Let's get you started.</h1>
    <h2>First, choose 5 topics you're interested in.</h2>

    <fieldset class="search">
        <input id="search" name="search" type="text" placeholder="search for any topic">
    </fieldset>

    <?php if(!empty($error)):?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form id="topics" action="" method="post">
        <fieldset>
            <?php while($res = $statement->fetch(PDO::FETCH_ASSOC)): ?>
                <label for="<?php echo $res['name'];?>"><?php echo $res['name'];?></label>
                <input <?php foreach($mergedTopics as $key => $value){
                    if ($value == $res['id']){
                        echo 'checked';
                    }
                }?> class="topicInput" id="<?php echo $res['name'];?>" name="<?php echo $res['name'];?>" type="checkbox" value="<?php echo $res['id'];?>"><br>
            <?php endwhile; ?>
        </fieldset>
        <fieldset>
            <button id="submit" disabled type="submit">Save topics</button>
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
                            if (ammountChecked >= requiredAmmount){
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
</div>
</body>
</html>
