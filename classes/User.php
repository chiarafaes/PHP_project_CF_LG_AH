<?php
class User
{
    private $m_sFullname;
    private $m_sUsername;
    private $m_sMail;
    private $m_sPassword;
    private $m_sAvatar;

    public function __set($p_sProperty, $p_vValue)
    {
        switch ($p_sProperty) {
            case "Fullname":
                $this->m_sFullname = $p_vValue;
                break;

            case "Username":
                $this->m_sUsername  = $p_vValue;
                break;

            case "Mail":
                $this->m_sMail  = $p_vValue;
                break;
                
            case "Password":
                $this->m_sPassword  = $p_vValue;
                break;

            case "Avatar":
                $this->m_sAvatar = $p_vValue;
            break;
        }
    }

    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case "Fullname":
                return $this->m_sFullname;
            break;

            case "Username":
                return $this->m_sUsername;
            break;

            case "Mail":
                return $this->m_sMail;
            break;

           case "Password":
                return $this->m_sPassword;
            break;

            case "Avatar":
                return $this->m_sAvatar;
            break;
        }
    }

    public function Save()
    {
        //connectie maken (PDO) -> geen mysqli, PDO kan voor meerder data banken
        $conn= Db::getInstance();

        //query schrijven
        $statement = $conn->prepare("INSERT INTO Users (Fullname,Username,Mail,Password, Avatar) VALUES (:Fullname,:Username,:Mail,:Password, :Avatar)");
        $statement->bindValue(":Fullname", $this->m_sFullname);
        $statement->bindValue(":Username", $this->m_sUsername);
        $statement->bindValue(":Mail", $this->m_sMail);
        $statement->bindValue(":Password", $this->m_sPassword);
        $statement->bindValue(":Avatar", $this->m_sAvatar);

        //query executen
        $res = $statement->execute();

        //true or false?
        return ($res);
    }

    public function __toString()
    {
        $output = "<p>".$this->m_sFullname." ".$this->m_sUsername."</p>";
        $output .= "<p>".$this->m_sMail."</p>";

        return ($output);
    }

    public static function getUsers()
    {
        $conn= Db::getInstance();
        $stmt = $conn->prepare("SELECT * FROM Users");
        $stmt->execute();

        return ($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function getUser($email)
    {
        $conn= Db::getInstance();
        $stmt = $conn->prepare("SELECT * FROM Users WHERE mail= :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return ($stmt->fetch(PDO::FETCH_ASSOC));
    }


    public static function getTopics()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM topics");
        $statement->execute();

        return ($statement->fetchAll(PDO::FETCH_ASSOC));
    }
}
?>

