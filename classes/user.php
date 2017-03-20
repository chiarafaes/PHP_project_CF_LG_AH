<?php
class User{
    private $m_sFullname;
    private $m_sUsername;
    private $m_sMail;


    public function __set($p_sProporty,$p_vValue){
        switch ($p_sProporty){
            case "Fullname":
                $this->m_sFirstname = $p_vValue;
                break;

            case "Username":
                $this->m_sLastname  = $p_vValue;
                break;

            case "Mail":
                $this->m_iAge  = $p_vValue;
                break;
        }
    }

    public function __get($p_sProporty){
        switch ($p_sProporty)
        {
            case "Fullname":
                return $this->m_sFirstname;
                break;
            case "Username":
                return $this->m_sLastname;
                break;
            case "Mail":
                return $this->m_iAge;
                break;

        }
    }

    public function Save(){
        //connectie maken (PDO) -> geen mysqli, PDO kan voor meerder data banken
        $conn= new PDO("mysql:host=localhost;dbname=studentimdis","root","");

        //query schrijven
        $statement = $conn->prepare("INSERT INTO Users (Fullname,Username,Mail) VALUES (:Fullname,:Username,:Mail)");
        $statement->bindValue(":Fullname",$this->m_sFirstname);
        $statement->bindValue(":Username",$this->m_sLastname);
        $statement->bindValue(":Mail",$this->m_iAge);



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

