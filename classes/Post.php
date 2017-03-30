<?php
class Post {
    private $m_picture;
    private $m_sDescription;
    private $m_sUserName;
    private $m_iLikes;
    private $m_iAantalComments;

    //getters & setters
    /**
     * @return mixed
     */
    public function getMPicture()
    {
        return $this->m_picture;
    }

    /**
     * @param mixed $m_picture
     */
    public function setMPicture($m_picture)
    {
        $this->m_picture = $m_picture;
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

    //save naar DB
    public function Save(){
        //connectie maken (PDO) -> geen mysqli, PDO kan voor meerder data banken
        $conn= Db::getInstance();

        //query schrijven
        $statement = $conn->prepare("INSERT INTO Posts (Picture,Description,Username,Likes,AantalComments) VALUES (:Picture,:Description,:Username,:Likes, :AantalComments)");
        $statement->bindValue(":Picture",$this->m_picture);
        $statement->bindValue(":Description",$this->m_sDescription);
        $statement->bindValue(":Username",$this->m_sUserName);
        $statement->bindValue(":Likes",$this->m_iLikes);
        $statement->bindValue(":AantalComments", $this->m_iAantalComments);

        //query executen
        $res = $statement->execute();

        //true or false?
        return ($res);

    }

    public function __toString()
    {
        $output = "<p>".$this->m_sUserName."</p>";
        $output .= "<p>".$this->m_sDescription."</p>";

        return ($output);
    }


}
?>