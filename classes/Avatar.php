<?php

    class Avatar
    {
        private $m_sAvatar;

        public function __set($p_sProperty, $p_vValue)
        {
            switch ($p_sProperty) {
                case 'file':
                    $this->m_sAvatar = $p_vValue;
                break;
            }
        }

        public function __get($p_sProperty)
        {
            return $this->m_sAvatar;
        }

        public function saveAvatar()
        {
            // deze functie slaat de avatar op naar de database.

            $conn = Db::getInstance();

            $user = new User();
            $user->Mail = $_SESSION['email'];

            $statement = $conn->prepare("UPDATE users SET avatar = :avatar WHERE Mail = :user");
            $statement->bindValue(':avatar', $this->m_sAvatar);
            $statement->bindValue(':user', $user->Mail);

            if ($statement->execute()) {
                header('location:profilesettings.php');
            }
        }

        public function deleteOldAvatar()
        {
            // deze functie dient om mensen maar 1 profile pic tegelijk te bewaren op de file server
            // anders geraakt deze vol.

            $conn = Db::getInstance();

            $user = new User();
            $user->Mail = $_SESSION['email'];

            $statement = $conn->prepare("SELECT avatar FROM users WHERE Mail = :mail");
            $statement->bindValue(':mail', $user->Mail);

            if ($statement->execute()) {
                $res = $statement->fetch(PDO::FETCH_ASSOC);
                @unlink($res['avatar']);
            }
        }

        public static function showAvatar()
        {
            $user = new User();
            $user->Mail = $_SESSION['email'];

            $conn = Db::getInstance();

            $retrieveQuery = $conn->prepare("SELECT avatar FROM users WHERE Mail = :user");
            $retrieveQuery->bindValue(':user', $user->Mail);

            if ($retrieveQuery->execute()) {
                $res = $retrieveQuery->fetch(PDO::FETCH_ASSOC);
                return $res['avatar'];
            }
        }
    }
