<?php
session_start();
spl_autoload_register(function ($class) {
    include_once("classes/".$class.".php");
});

$posts= Post::getPostsByID($_GET["post"]);

$comment = new Comment();

//controleer of er een update wordt verzonden
if(!empty($_POST['comment']))
{
    $comment->Text = $_POST['comment'];
    try
    {
        $comment->Save();
    }
    catch (Exception $e)
    {
        $feedback = $e->getMessage();
    }
}





//altijd alle laatste activiteiten ophalen
$recentActivities = $comment->GetRecentActivities();






?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/default.css" />
    <link rel="stylesheet" href="css/home.css" />
    <link rel="stylesheet" href="css/comments.css" />

    <title>Detail Post</title>
</head>
<body>
<div id="modalOverlay">
    <div id="content">
        <?php foreach ($posts as $post):?>
                <div class="pon" id="pinID-<?php echo $post['id']?>">
                    <div class="img_holder">
                        <div class="buttons" id="1">
                            <a href="#" class="btn send">Send</a>
                            <a href="#" class="btn save">Save</a>
                            <a href="#" class="btn send">IN</a></br>
                        </div>
                        <a onclick="goBack()">x</a>
                        <a class="image ajax" href="#" title="photo 1" id="1">
                            <img src="<?php echo $post['picture']; ?>" alt="" >
                        </a>
                    </div>


                    <p class="icon_heart"><img src="img/icon_hartjeLikes.svg"></p>
                    <p class="likes"><span><?php echo $post['likes']; ?></span></p>
                    <p class="postdate"><?php echo Post::getTimeAgo($post['postdate']); ?></p>
                    <p class="title"><?php echo $post['title']; ?></p>
                    <p class="description"><?php echo $post['description']?></p>

                    <hr>
                    <div class="user_info">
                        <a href="profilepage_follower.php"><img src="<?php echo $post['avatar']; ?>" alt="#"></a>
                            <p><?php echo $post['username']; ?></p>
                            <p class="categorie">Categorie</p>
                    </div>

                    <div class="inappropriate">
                        <p class="inap"
                    </div>
                </div>
        <?php endforeach; ?>

        <?php if ($_SESSION['email'] == $post['creator_mail']):?>
        <div class="verwijderpost">

        <input id = "btnVerwijder" type="submit" value ="Verwijderen">
        </div>
        <?php endif; ?>




        <form method="post" action="" class="commentformulier">
            <div class="statusupdates">
                <h2>Comments</h2>
                <div class="commentform">
                    <input type="text" value="Leave a comment" id="comment" name="comment"/>
                </br>
                    <input id="btnSubmit" type="submit" value="Comment" class="btnsubmit"/>
                </div>


                <div class="listupdates">
                    <?php $comment = new Comment();
                    $comments = $comment->Comments();

                    foreach($comments as $c):?>

                    <div class="comment">
                        <img  id='avatar' src=' <?php echo $c["avatar"] ?> ' />
                        <div class="comment_zelf">
                            <a href="http://localhost/PHP_project_cf_lg_ah/profilepage_user.php?userid=<?php  echo $c['user_id']?>"><?php echo $c['Username'].":"?></a>
                            <p><?php echo $c['comment']?></p>
                        </div>
                    </div>
                        <?php endforeach; ?>
                </div>
            </div>
        </form>
    </div>
</div>
    <script   src="https://code.jquery.com/jquery-3.2.1.min.js"   integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="   crossorigin="anonymous"></script>

    <script src="js/bootstrap.min.js"></script>
 <!--   <script src="js/popup2.js"></script> -->

    <script>
        $(document).ready(function () {
            $("#btnSubmit").on("click", function (e) {
                //console.log("clicked");

                // tekst vak uitlezen
                var update = $("#comment").val();
                var postID = document.getElementById("post").getAttribute("data-id");
                // via AJAX update naar databank sturen
                $.ajax({
                    method: "POST",
                    url: "AJAX/ajax.saveupdate.php",
                    data: {update: update, postID: postID} //update: is de naam en update is de waarde (value)
                })

                    .done(function (response) {

                        // code + message
                        if (response.code == 200) {

                            // iets plaatsen?
                            var li = $("<li style='display: none;'>");
                            li.html("<img id='avatar' src='" + response.avatar + "' </img>" + "   " + "  " + "<a href='http://localhost/PHP_project_cf_lg_ah/user_profile.php?user=" + response.id + "'>" + response.user + "</a>: " + response.message);
                            // waar?
                            $("#listupdates").prepend(li);
                            $("#listupdates li").first().slideDown();
                            $("#comment").val("").focus();
                        }
                    });

                e.preventDefault();
            });
        });
    </script>


<script>
    function goBack() {
        window.history.back();
    }
</script>


</body>
</html>