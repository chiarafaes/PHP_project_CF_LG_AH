<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 17/04/2017
 * Time: 21:57
 */

    session_start();

    spl_autoload_register(function ($class) {
        include_once("../classes/".$class.".php");
    });

    $user = $_SESSION['email'];
    $post = $_POST['post'];
    $likes = $_POST['likes'];

    $conn = Db::getInstance();

    $statement = $conn->prepare('SELECT post, user FROM users_likes_posts WHERE user = :user AND post = :post');
    $statement->bindValue(':user', $user);
    $statement->bindValue(':post', $post);

    if ($statement->execute()) {
        if (count($res = $statement->fetchAll(PDO::FETCH_ASSOC)) == 0) {
            $insert = $conn->prepare('INSERT INTO users_likes_posts (user, post) VALUES (:user, :post)');
            $insert->bindValue(':user', $user);
            $insert->bindValue(':post', $post);

            $res = $statement->fetch(PDO::FETCH_ASSOC);

            $likes = +1;


            if ($insert->execute()) {
                echo json_encode($likes);
            }
        } else {
            $delete = $conn->prepare('DELETE FROM users_likes_posts WHERE user = :user and post = :post');
            $delete->bindValue(':user', $user);
            $delete->bindValue(':post', $post);

            $likes = -0;

            if ($delete->execute()) {
                echo json_encode($likes);
            }
        }

        // nu gaan we de like opslaan in de tabel posts
        $update = $conn->prepare('UPDATE posts SET likes = :likes WHERE id = :post');
        $update->bindValue(':likes', $likes);
        $update->bindValue(':post', $post);

        $update->execute();
    } else {
        echo json_encode("niet gelukt");
    }
