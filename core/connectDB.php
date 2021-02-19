<?php
namespace core;
use config\config;
use \PDO;

class connectDB extends config
{
    private static $connectDB = null;

    public static function connectDB()
    {
        if (!self::$connectDB){
            try {
                self::$connectDB = new PDO("mysql:host=" . self::ServerName . ";dbname=" . self::DBName, self::UserName, self::Password);
                self::$connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e){
                $error = 'Connected failed: ' . $e->getMessage;
                extract (['error' => $ex->getMessage()]);
                require_once ('views/__shared/error.php');
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
