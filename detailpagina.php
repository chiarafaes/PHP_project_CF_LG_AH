<?php
session_start();
spl_autoload_register(function ($class) {
    include_once("classes/".$class.".php");
});

$posts= Post::getPostsByID($_GET["post"]);


//COMMENTS
$comment = new Comment();

//controleer of er een comment wordt verzonden
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

//altijd alle laatste commentaren ophalen
$recentActivities = $comment->GetRecentActivities();


$test = Post::CountReport($_GET["post"]);

if (!empty($_POST['id'])){
  if(Post::deletePost($_POST['id'])){
      header('location: home.php');
  }else{
      echo "er ging iets fout";
  }
}

$ReportedBy = Post::ReportedByUser($_GET["post"]);

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

                    <p class = > dislikes : <?php echo count($test); ?></p>
                    <p class="icon_heart"><img src="img/icon_hartjeLikes.svg"></p>
                    <p class="likes"><span><?php echo $post['likes']; ?></span></p>
                    <p class="postdate"><?php echo Post::getTimeAgo($post['postdate']); ?></p>
                    <p class="title"><?php echo $post['title']; ?></p>
                    <p class="description"><?php echo $post['description']?></p>
                    <?php
                    $id = $post['id'];
                    $topic = Post::getCategorie($id);
                    ?>
                    <hr>
                    <div class="user_info">
                        <a href="profilepage_follower.php"><img src="<?php echo $post['avatar']; ?>" alt="#"></a>
                            <p><?php echo $post['username']; ?></p>
                            <p class="categorie"><?php echo $topic['name']; ?></p>
                    </div>

                </div>

            <?php if(count($ReportedBy) == 0):?>
                <div class="inappropriate">
                    <a href="#" class="btnReport" data-id="<?php echo $post['id']?> "> Inapproriate </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- VERWIJDER POST -->

        <? if ($_SESSION['email'] == $post['creator_mail']):?>
        <div class="verwijderpost">
            <form method="post" action="">
                <input type="hidden" name="id" value="<?php echo $post['id']?>">
                <input id = "btnVerwijder" type="submit" value ="Verwijderen">
            </form>
        </div>
        <?php endif; ?>


        <!-- COMMENTAAR -->


        <form method="post" action="" class="commentformulier">
            <div class="statusupdates">
                <h4>Comments</h4>
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
                        <!-- <a href="http://localhost/PHP_project_cf_lg_ah/profilepage_user.php?user=<?php  echo $c['mail']?>"> -->
                            <img  id='avatar' src=' <?php echo $c["avatar"] ?> ' />

                        <!-- </a> -->
                        <div class="comment_zelf">
                            <a href="http://localhost/PHP_project_cf_lg_ah/profilepage_user.php?user=<?php  echo $c['mail']?>"><?php echo $c['Username'].":"?></a>
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
    <script src="js/inapr.js"></script>


<script>
    function goBack() {
        window.history.back();
    }
</script>

<script src="js/comment.js"></script>

</body>
</html>