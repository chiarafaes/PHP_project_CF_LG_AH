<?php
class Comment {

        private $m_sText;

        public function __set($p_sProperty,$p_vValue)
        {
            switch ($p_sProperty)
            {
                case "Text":
                    $this->m_sText = $p_vValue;
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

    public function Save()
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare("INSERT INTO Comments (comment, id_post, Mail_user ) VALUES (:comments, :iditem, :Mailuser )");
        $statement->bindValue(":Mailuser", $_SESSION["email"]);
        $statement->bindValue(":iditem", $_GET["post"]);
        $statement->bindValue(":comments", $_POST['comment']);
        return $statement->execute();
    }


    public function GetRecentActivities()
        {
            if ($conn = DB::getInstance())
            {

                $statement = $conn->prepare("SELECT * FROM Comments ORDER BY commentID ASC LIMIT 8");
                $statement->execute();
                return $statement->fetch(PDO::FETCH_ASSOC);
            }
            else
            {
                // er kon geen connectie gelegd worden met de databank
                throw new Exception('Ooh my, something terrible happened to the database connection');
            }


        }
        public function GetCommentsFromPost()
        {
            $conn = Db::getInstance();

            $statement = $conn->prepare("SELECT * FROM Comments WHERE id_post = :id_post");
            $statement->bindValue(":id_post", $_GET["post"]);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        }

        public function Comments()
        {
            $conn = Db::getInstance();

            $statement = $conn->prepare("select comment, users.Username, users.avatar from Comments inner join users on users.mail = Comments.Mail_user where Comments.id_post = :items");
            $statement->bindValue(":items", $_GET["post"]);
            $statement->execute();
            $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $comments;
        }


    }
?>