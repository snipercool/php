<?php
    abstract class Db{
        private static $conn;

        private static function getConfig(){
            return parse_ini_file(__DIR__."/../config/config.ini");
        }
        public static function getInstance(){
            if (self::$conn != null) {
                return self::$conn;
            } else {
                $config = self::getConfig();
                $db = $config["database"];
                $user = $config["user"];
                $password = $config["password"];
            
                self::$conn = new PDO('mysql:host=localhost;dbname='.$db.';', $user, $password);
                return self::$conn;
            }
            
        }
    }
?>