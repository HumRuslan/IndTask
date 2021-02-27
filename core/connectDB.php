<?php
namespace core;
use \PDO;

class ConnectDB
{
    private static $connectDB = null;

    public static function connectDB()
    {
        if (!self::$connectDB){
            try {
                self::$connectDB = new PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DB_NAME, USER_NAME, PASSWORD);
                self::$connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e){
                $error = 'Connected failed: ' . $e->getMessage;
                extract (['error' => $e->getMessage()]);
                require_once ('views/_shared/error.php');
            }
        }
        return self::$connectDB;
    }

    private function __construct(){}

    private function __clone(){}

    public function __destruct(){
        self::$connectDB = null;
    }
}
