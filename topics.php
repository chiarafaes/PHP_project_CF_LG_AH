<?php
    session_start();
    $error = '';

    spl_autoload_register(function ($class) {
        include_once("classes/".$class.".php");
    });

    try {
        // enkel ingelogde users toegelaten!
        if (isset($_SESSION['email'])) {
            $topic = new Topic();
            $user = $_SESSION['email'];
            $topic->setMSUser($user);

            // alle topics inladen en indien fout ==> fout gooien
            if (!$allTopics = Topic::getAllTopics()) {
                $error = "There was a problem loading topics.";
            }

//            // alle user topics inladen en indien fout ==> fout gooien
//            if (!$userTopics = $topic->getTopicsByUser()){
//                $error = "There was a problem loading user topics.";
//            }

            // Wanneer er gesubmit word, de inputs opslaan
            if (!empty($_POST)) {

                foreach ($_POST as $key => $value) {
                    $topics[] = $value;
                }

                // we zien of er wel degelijk 5 topics gekozen zijn (XSS)
                if (count($topics)>= 5) {
                    $topic->setMATopics($topics);

                    $topic->saveTopics();
                }
                else {
                    $error = "You need to pick at least 5 topics to continue.";
                }
            }
        } else {
            header('location:registration.php');
        }
    } catch (PDOException $e) {
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
    <link rel="stylesheet" href="css/topics.css" />
    <script src="js/jquery.js"></script>


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


    <?php if (isset($error)):?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form id="topics" action="" method="post">
        <ul>
            <?php foreach ($allTopics as $topic): ?>
                <li>
                    <label for="<?php echo $topic['name'];?>"><?php echo $topic['name'];?>
                        <input class="topicInput" id="<?php echo $topic['name'];?>" name="<?php echo $topic['name'];?>" type="checkbox" value="<?php echo $topic['id'];?>">
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>

        <fieldset>
            <button class="disabled" id="submit" type="submit">Save topics</button>
        </fieldset>

        <script>
            $(document).ready( function () {
                var form = document.getElementById('topics');
                var topics =  document.getElementsByClassName('topicInput');
                var btn = $('#submit');
                var requiredAmmount = 5;
                var ammountChecked = 0;

                // we gaan zien of we vijf (requiredAmmount) veldjes hebben aangeduid
                // anders is submit button niet actief
                form.addEventListener('change',function () {
                    for (i = 0; i<topics.length; i++){
                        if (topics[i].checked){
                            ammountChecked += 1;
                            if (ammountChecked >= requiredAmmount){
                                btn.removeAttr('disabled');
                                btn.removeClass()
                                btn.addClass('enabled');
                                console.log("tis goe");

                            } else{
                                btn.attr('disabled', 'true');
                                btn.removeClass()
                                btn.addClass('disabled');

                                console.log("neje");
                            }
                        }
                    };

                    // resetten van de counter
                    ammountChecked = 0;
                })

            });
        </script>

    </form>
</div>
</body>
</html>
