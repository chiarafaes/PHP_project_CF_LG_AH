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
        $vResult = null;

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
        return $vResult;

    }

    public function Save()
    {
        //connectie maken (PDO) -> geen mysqli, PDO kan voor meerder data banken
        $conn= Db::getInstance();

        $q_alreadyExists = $conn->prepare("SELECT * FROM users WHERE Mail = :mail");
        $q_alreadyExists->bindValue(":mail", $this->m_sMail);

        $q_alreadyExists1 = $conn->prepare("SELECT username FROM users WHERE username = :username");
        $q_alreadyExists1->bindValue(":username", $this->m_sUsername);


        if ($q_alreadyExists1->execute() && $q_alreadyExists1->rowCount() != 0) {
            return false;
        }else{
            //als het mailadres bestaat geef melding dat de mail reeds in gebruik is en niet save
            if ($q_alreadyExists->execute() && $q_alreadyExists->rowCount() != 0) {
                return false;
            }
            else {

                //query schrijven
                $statement = $conn->prepare("INSERT INTO users (fullname,username,mail,password, avatar) VALUES (:fullname,:username,:mail,:password, :avatar)");
                $statement->bindValue(":fullname", $this->m_sFullname);
                $statement->bindValue(":username", $this->m_sUsername);
                $statement->bindValue(":mail", $this->m_sMail);
                $statement->bindValue(":password", $this->m_sPassword);
                $statement->bindValue(":avatar", $this->m_sAvatar);

                //query execute
                $res = $statement->execute();

                //true or false?
                return ($res);

            }
        }
    }


    public function checkPassword(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM users WHERE Mail = :mail");
        $statement->bindValue(":mail", $this->Mail);

        if($statement->execute() && $statement->rowCount() != 0){
            $res = $statement->fetch(PDO::FETCH_ASSOC);

            // hier gaan we het opgeslagen wachtwoord vergelijken met het ingegeven wachtwoord
            if (password_verify($this->Password, $res['Password'])){
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public function UsernameAvailable() {

        $PDO = Db::getInstance();
        $statement = $PDO->prepare( "SELECT username FROM users WHERE username = :username" );
        $statement->bindValue( ":username", $this->m_sUsername );
        $statement->execute();
        $count = $statement->rowCount();
        if ( $count > 0 ) {
            return false;

        } else {
            return true;
        }
    }

    public function EmailAvailable() {

        $PDO = Db::getInstance();
        $statement = $PDO->prepare( "SELECT Mail FROM users WHERE Mail = :email" );
        $statement->bindValue( ":email", $this->m_sMail );
        $statement->execute();
        $count = $statement->rowCount();

        if( $count > 0 ){
            return false;

        } else {
            return true;
        }
    }

    public static function getUsers()
    {
        $conn= Db::getInstance();
        $stmt = $conn->prepare("SELECT * FROM users");
        $stmt->execute();

        return ($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function getUser($email)
    {
        $conn= Db::getInstance();
        $stmt = $conn->prepare("SELECT * FROM users WHERE mail= :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return ($stmt->fetch(PDO::FETCH_ASSOC));
    }

    public function updateUser(){
        $conn= Db::getInstance();

        $statement = $conn->prepare("UPDATE users SET Fullname=:fullname, Username=:username WHERE Mail=:user");
        $statement->bindValue(':fullname', $this->Fullname);
        $statement->bindValue(':username', $this->Username);
        $statement->bindValue(':user', $this->Mail);

        return $statement->execute();
    }

    public function updatePassword(){
        $conn = Db::getInstance();

        $statement = $conn->prepare('UPDATE users SET password = :password WHERE mail = :user');
        $statement->bindValue(':password', $this->Password);
        $statement->bindValue(':user', $this->m_sMail);

        return $statement->execute();
    }

    public static function followUser($p_sMail){
        $conn = Db::getInstance();

        $statement = $conn->prepare('INSERT INTO users_follower (userEmail, followEmail) VALUES (:userEmail, :followEmail)');
        $statement->bindValue(':userEmail', $_SESSION['email']);
        $statement->bindValue(':followEmail', $p_sMail);

        return $statement->execute();

    }



    public static function unfollowUser($p_sMail){
        $conn = Db::getInstance();

        $statement = $conn->prepare("DELETE FROM users_follower where userEmail = :userEmail and followEmail = :followEmail");
        $statement->bindValue(':userEmail', $_SESSION['email']);
        $statement->bindValue(':followEmail', $p_sMail);

        return $statement->execute();
    }

    public static function checkFollowing($p_sMail)
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare("SELECT * FROM users_follower where userEmail = :userEmail and followEmail = :followEmail");
        $statement->bindValue(':userEmail', $_SESSION['email']);
        $statement->bindValue(':followEmail', $p_sMail);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function getFollowingsByUser($p_sMail)
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare("SELECT * FROM users_follower WHERE userEmail = :userEmail ");
        $statement->bindValue(':userEmail', $p_sMail);
        if ($statement->execute()) {
            return ($statement->fetchAll(PDO::FETCH_ASSOC));
        } else {
            return false;
        }
    }

    public static function getFollowersByUser($p_sMail)
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare("SELECT * FROM users_follower WHERE followEmail = :followEmail");
        $statement->bindValue(':followEmail', $p_sMail);
        if ($statement->execute()) {
            return ($statement->fetchAll(PDO::FETCH_ASSOC));
        } else {
            return false;
        }
    }
}
?>