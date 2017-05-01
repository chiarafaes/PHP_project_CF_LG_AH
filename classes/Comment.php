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

        $statement = $conn->prepare("INSERT INTO Comments (id_user, id_post, comment) VALUES (:iduser, :iditem, :comments)");
        $statement->bindValue(":iduser", $_SESSION['id']);
        $statement->bindValue(":iditem", $_GET["post"]);
        $statement->bindValue(":comments", $_POST["update"]);
        return $statement->execute();
    }


    public function GetRecentActivities()
        {

            if ($link = mysqli_connect($this->m_sHost, $this->m_sUser, $this->m_sPassword, $this->m_sDatabase))
            {
                $sSql = "select * from Comments ORDER BY commentID DESC LIMIT 8";
                $rResult = mysqli_query($link, $sSql);
                return $rResult;
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

            $statement = $conn->prepare("select comment, users.Username, users.avatar from Comments inner join users on users.id = Comments.id_user where Comments.id_post = :items");
            $statement->bindValue(":items", $_GET["post"]);
            $statement->execute();
            $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $comments;
        }


    }
?>