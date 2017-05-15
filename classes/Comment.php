<?php
class Comment {

        private $m_sText;

        public function __set($p_sProperty,$p_vValue)
        {
            switch ($p_sProperty)
            {
                case "Text":
                    $this->m_sText = htmlspecialchars($p_vValue);
                    break;
            }
        }

        public function __get($p_sProperty)
        {
            $vResult = null;
            switch ($p_sProperty)
            {
                case "Text":
                    $vResult = $this->m_sText;
                    break;

            }
            return $vResult;
        }

    public function save($p_sUser, $p_iPost)
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare("INSERT INTO comments (comment, id_post, Mail_user ) VALUES (:comment, :idItem, :mailuser )");
        $statement->bindValue(":mailuser", $p_sUser);
        $statement->bindValue(":idItem", $p_iPost);
        $statement->bindValue(":comment", $this->m_sText);

       if($statement->execute()){
           return $conn->lastInsertId();
       }
    }

    public function GetCommentsFromPost()
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare("SELECT * FROM comments WHERE id_post = :id_post");
        $statement->bindValue(":id_post", $_GET["post"]);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function Comments()
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare("SELECT comments.commentId, comment, users.Username, users.avatar, Mail_user from comments inner join users on users.mail = comments.Mail_user where comments.id_post = :items ORDER BY commentID DESC LIMIT 10");
        $statement->bindValue(":items", $_GET["post"]);
        $statement->execute();
        $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
    }

    public static function countComments($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * from comments WHERE id_post = :commentID");
        $statement->bindValue(":commentID", $id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return($result);
    }


    public static function deleteOwnComments($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("DELETE from comments WHERE commentID =:id");
        $statement->bindValue(":id", $id);
        $result = $statement->execute();
        return($result);
    }
}
?>