<?php
class user{
    private $m_sFullname;
    private $m_sUsername;
    private $m_sMail;
    private $m_sPassword;


    public function __set($p_sProporty,$p_vValue){
        switch ($p_sProporty){
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
        }
    }

    public function __get($p_sProporty){
        switch ($p_sProporty)
        {
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

        }
    }

    public function Save(){
        //connectie maken (PDO) -> geen mysqli, PDO kan voor meerder data banken
        $conn= Db::getInstance();

        //query schrijven
        $statement = $conn->prepare("INSERT INTO Users (Fullname,Username,Mail,Password) VALUES (:Fullname,:Username,:Mail, :Password)");
        $statement->bindValue(":Fullname",$this->m_sFullname);
        $statement->bindValue(":Username",$this->m_sUsername);
        $statement->bindValue(":Mail",$this->m_sMail);
        $statement->bindValue(":Password",$this->m_sPassword);



        //query executen
        $res = $statement->execute();

        //gelukt of niet?
        return($res);

    }

    public function __toString()
    {
        $output = "<p>".$this->m_sFullname. " ".$this->m_sUsername."</p>";
        $output .= "<p>".$this->m_sMail."</p>";

        return ($output);
    }


}
?>

