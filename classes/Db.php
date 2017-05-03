<?php
class Db
{
    private static $conn = null; // want we werken met isset ne isset checkt of iets niet null is

    public static function getInstance()
    {
        //bij static moet je geen object maken maar meteen aanspreken
        if (isset(self::$conn)) { // niet $this want er bestaat geen opject, je werkt met :: , dus kijk naar basis classe => self
            // er is al connectie, geeft die terug
            return self::$conn;
        } else {
            //er is nog geen connectie, maak aan en geef terug
            self::$conn = new PDO("mysql:host=localhost;dbname=pinterest", "root", "");
            return self::$conn;
        }
    }
}
