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




    //save naar DB
    public function Save()
    {
        //connectie maken (PDO) -> geen mysqli, PDO kan voor meerdere data banken
        $conn= Db::getInstance();

        //query schrijven
        $statement = $conn->prepare("INSERT INTO Posts (Picture,Title ,Description,Username,Categorie) VALUES (:Picture,:Title,:Description,:Username,:Categorie)");
        $statement->bindValue(":Picture", $this->m_sPicture);
        $statement->bindValue(":Title", $this->m_sTitle);
        $statement->bindValue(":Description", $this->m_sDescription);
        $statement->bindValue(":Username", $this->m_sUserName);
        $statement->bindValue(":Categorie", $this->m_sCategorie);

        //query executen
        $res = $statement->execute();

        //true or false?
        return ($res);
    }

    public static function getPosts($p_iLimit, $p_iOffset)
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare("SELECT posts.*, users.avatar FROM posts LEFT JOIN users on users.username  = posts.username ORDER BY postdate DESC LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', (int) trim($p_iLimit), PDO::PARAM_INT);
        $statement->bindValue(':offset', (int) trim($p_iOffset), PDO::PARAM_INT);

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
        $statement->bindValue(':useremail' , $useremail);
        if ($statement->execute()) {
            return ($statement->fetchAll(PDO::FETCH_ASSOC));
        } else {
            return false;
        }
    }
}
