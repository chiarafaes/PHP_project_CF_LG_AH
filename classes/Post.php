<?php
class Post
{
    private $m_iID;
    private $m_sPicture;
    private $m_sTitle;
    private $m_sDescription;
    private $m_sUserName;
    private $m_iLikes;
    private $m_iAantalComments;
    private $m_sCategorie;
    private $m_sMail;
    private $m_iinapr;
    private $m_sLocation;
    private $m_sURL;

    /**
     * @return mixed
     */
    public function getMSMail()
    {
        return $this->m_sMail;
    }

    /**
     * @param mixed $m_sMail
     */
    public function setMSMail($m_sMail)
    {
        $this->m_sMail = $m_sMail;
    }

    //getters & setters

    /**
     * @return mixed
     */
    public function getMSTitle()
    {
        return $this->m_sTitle;
    }

    /**
     * @param mixed $m_sTitle
     */
    public function setMSTitle($m_sTitle)
    {
        $this->m_sTitle = $m_sTitle;
    }

    /**
     * @return mixed
     */
    public function getMSCategorie()
    {
        return $this->m_sCategorie;
    }

    /**
     * @param mixed $m_sCategorie
     */
    public function setMSCategorie($m_sCategorie)
    {
        $this->m_sCategorie = $m_sCategorie;
    }


    /**
     * @return mixed
     */
    public function getMPicture()
    {
        return $this->m_sPicture;
    }

    /**
     * @param mixed $m_picture
     */
    public function setMPicture($m_sPicture)
    {
        $this->m_sPicture = $m_sPicture;
    }

    /**
     * @return mixed
     */
    public function getMSDescription()
    {
        return $this->m_sDescription;
    }

    /**
     * @param mixed $m_sDescription
     */
    public function setMSDescription($m_sDescription)
    {
        $this->m_sDescription = $m_sDescription;
    }


    /**
     * @return mixed
     */
    public function getMSUserName()
    {
        return $this->m_sUserName;
    }

    /**
     * @param mixed $m_sUserName
     */
    public function setMSUserName($m_sUserName)
    {
        $this->m_sUserName = $m_sUserName;
    }

    /**
     * @return mixed
     */
    public function getMILikes()
    {
        return $this->m_iLikes;
    }

    /**
     * @param mixed $m_iLikes
     */
    public function setMILikes($m_iLikes)
    {
        $this->m_iLikes = $m_iLikes;
    }

    /**
     * @return mixed
     */
    public function getMIAantalComments()
    {
        return $this->m_iAantalComments;
    }

    /**
     * @param mixed $m_iAantalComments
     */
    public function setMIAantalComments($m_iAantalComments)
    {
        $this->m_iAantalComments = $m_iAantalComments;
    }

    /**
     * @return mixed
     */
    public function getMIID()
    {
        return $this->m_iID;
    }

    /**
     * @return mixed
     */
    public function getMSPicture()
    {
        return $this->m_sPicture;
    }

    /**
     * @param mixed $m_sPicture
     */
    public function setMSPicture($m_sPicture)
    {
        $this->m_sPicture = $m_sPicture;
    }

    /**
     * @return mixed
     */
    public function getMIinapr()
    {
        return $this->m_iinapr;
    }

    /**
     * @param mixed $m_iinapr
     */
    public function setMIinapr($m_iinapr)
    {
        $this->m_iinapr = $m_iinapr;
    }

    /**
     * @return mixed
     */
    public function getMSLocation()
    {
        return $this->m_sLocation;
    }

    /**
     * @param mixed $m_sLocation
     */
    public function setMSLocation($m_sLocation)
    {
        $this->m_sLocation = $m_sLocation;
    }

    /**
     * @return mixed
     */
    public function getMSURL()
    {
        return $this->m_sURL;
    }

    /**
     * @param mixed $m_sURL
     */
    public function setMSURL($m_sURL)
    {
        $this->m_sURL = $m_sURL;
    }




    //save naar DB
    public function Save()
    {
        //connectie maken (PDO) -> geen mysqli, PDO kan voor meerdere data banken
        $conn = Db::getInstance();

        //query schrijven
        $statement = $conn->prepare("INSERT INTO posts (picture,title ,description,username, creator_mail, topic, location, URL) VALUES (:Picture,:Title,:Description,:Username, :creator_mail, :topic,:location,:url)");
        $statement->bindValue(":Picture", htmlspecialchars($this->m_sPicture));
        $statement->bindValue(":Title", htmlspecialchars($this->m_sTitle));
        $statement->bindValue(":Description", htmlspecialchars($this->m_sDescription));
        $statement->bindValue(":Username", htmlspecialchars($this->m_sUserName));
        $statement->bindValue(":creator_mail", htmlspecialchars($this->m_sMail));
        $statement->bindValue(":topic", htmlspecialchars($this->m_sCategorie));
        $statement->bindValue(":location", htmlspecialchars($this->m_sLocation));
        $statement->bindValue(":url", htmlspecialchars($this->m_sURL));

        //query executen
        $res = $statement->execute();

        //true or false?
        return ($res);
    }

    public static function getPosts($p_iLimit, $p_iOffset, $p_sUser)
    {
        $conn = Db::getInstance();

        $topic = new Topic();
        $topic->setMSUser($p_sUser);
        $param = $topic->getTopicsByUser();
        $placeholders = implode(',', array_fill(0, count($param), '?'));

        foreach ($param as $value){
           foreach ($value as $key => $val){
               $topics [] = $val;
           }
        }

        $statement = $conn->prepare("SELECT posts.*, users.avatar FROM posts LEFT JOIN users on users.username = posts.username WHERE posts.topic IN (".$placeholders.") ORDER BY postdate  DESC LIMIT ? OFFSET ?");

        foreach ($topics as $k => $id) {
            $statement->bindValue(($k + 1), $id);
        }

        $statement->bindValue(count($topics)+1, (int)trim($p_iLimit), PDO::PARAM_INT);
        $statement->bindValue(count($topics)+2, (int)trim($p_iOffset), PDO::PARAM_INT);

        if ($statement->execute()) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }


    public static function getCategorie($id)
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare('SELECT name FROM posts INNER JOIN topics ON posts.topic = topics.id WHERE posts.id = :postid');
        $statement->bindValue(':postid',$id );
        $statement->execute();

        $res = $statement->fetch();
        return($res);
    }



    public static function getPostsByID($p_iID)
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare('SELECT posts.*, users.avatar FROM posts INNER JOIN users ON posts.creator_mail = users.mail WHERE posts.id = :post');
        $statement->bindValue(':post', $p_iID);

        if ($statement->execute()) {
            return ($statement->fetchAll(PDO::FETCH_ASSOC));
        } else {
            return false;
        }
    }

    public static function getPostsLikedByUser($p_sUsername)
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare('SELECT * FROM users_likes_posts WHERE user = :user');
        $statement->bindValue(':user', $p_sUsername);

        if ($statement->execute()) {
            return ($statement->fetchAll(PDO::FETCH_ASSOC));
        } else {
            return false;
        }
    }

    public static function getPostsLikedByUserAndShow($p_sUsername)
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare('SELECT * FROM users_likes_posts INNER JOIN posts ON users_likes_posts.post = posts.id WHERE user = :user');
        $statement->bindValue(':user', $p_sUsername);

        if ($statement->execute()) {
            return ($statement->fetchAll(PDO::FETCH_ASSOC));
        } else {
            return false;
        }
    }

    public function report($id)
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare('SELECT * FROM users_inapr_posts WHERE user = :user AND post = :post');
        $statement->bindValue(':user', $_SESSION["email"]);
        $statement->bindValue(':post', $id);
        $statement->execute();

        if ($statement->rowCount() == 1) {

        } else {
            $statement = $conn->prepare('UPDATE posts SET reports = reports+1 WHERE id = :id');
            $statement->bindValue(':id', $id);
            $statement->execute();

            $statement1 = $conn->prepare('INSERT INTO users_inapr_posts (post, user) VALUES (:post,:user)');
            $statement1->bindValue(':post', $id);
            $statement1->bindValue(':user', $_SESSION["email"]);
            $statement1->execute();
        }
    }

    public static function ReportedByUser($id){
        $conn = Db::getInstance();

        $statement = $conn->prepare('SELECT * FROM users_inapr_posts WHERE user = :user AND post = :post');
        $statement->bindValue(':user', $_SESSION["email"]);
        $statement->bindValue(':post', $id);
        $statement->execute();
        $res = $statement->fetchAll();

        return $res;
    }

    public static function CountReport($id){
        $conn = Db::getInstance();

        $statement = $conn->prepare('SELECT reports FROM posts WHERE id = :post');
        $statement->bindValue(':post', $id);
        $statement->execute();
        $res = $statement->fetch();

        if($res["reports"] > 2){

            $statement = $conn->prepare('DELETE from posts WHERE id = :post');
            $statement->bindValue(':post', $id);
            $statement->execute();
            header('Location: home.php');

            return $res;
        } else {
            return $res;
        }
    }

    public static function getTimeAgo($p_dDate)
    {
        $currentDate = new DateTime();
        $postDate = new DateTime($p_dDate);
        $interval = $postDate->diff($currentDate);
        return $interval->format('%ad ago');
    }

    public static function getPostsByUser($useremail)
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare("SELECT * FROM posts WHERE creator_mail = :useremail ORDER BY postdate DESC");
        $statement->bindValue(':useremail', $useremail);
        if ($statement->execute()) {
            return ($statement->fetchAll(PDO::FETCH_ASSOC));
        } else {
            return false;
        }
    }


    public static function getPostsByTopic($topic)
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare("SELECT * FROM posts WHERE topic = :topic");
        $statement->bindValue(':topic', $topic);
        if ($statement->execute()) {
            return ($statement->fetchAll(PDO::FETCH_ASSOC));
        } else {
            return false;
        }
    }

    public static function deletePost($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("DELETE from posts WHERE id = :id");
        $statement->bindValue(":id", $id);
        $result = $statement->execute();
        return($result);
    }
}