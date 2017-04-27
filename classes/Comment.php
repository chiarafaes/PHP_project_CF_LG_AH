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
            /*
            De methode Save dient om een nieuwe activity te bewaren in onze databank.
            De methode geeft boolean "true" terug wanneer het invoegen geslaagd is.
            Wanneer het invoegen van de subscriber niet gelukt is, geeft de functie "false" terug.
            Databank gegevens kunnen eventueel in een aparte klasse DbConnectie gestopt worden.
            */
        {

            $bResult = false;

            if ($link = mysqli_connect($this->m_sHost, $this->m_sUser, $this->m_sPassword))
            {
                if(mysqli_select_db($link, $this->m_sDatabase))
                {
                    //vergeet niet te beschermen tegen SQL Injection wanneer je een query uitvoert
                    $sSql = "INSERT INTO Comments (comment) VALUES ('".mysqli_real_escape_string($link, $this->Text)."');";
                    if ($rResult = mysqli_query($link, $sSql) != false)
                    {
                        $bResult = true;
                    }
                    else
                    {
                        // er zijn geen query resultaten, dus query is gefaald
                        throw new Exception('Caramba! Could not update your status!');
                    }
                }
                else
                {
                    // database kon niet geselecteerd worden
                    throw new Exception('Woops. Where did the database go!?');
                }
            }
            else
            {
                // er kon geen connectie gelegd worden met de databank
                throw new Exception('Ooh my, something terrible happened to the database connection');
            }
            return $bResult;
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


    }
?>