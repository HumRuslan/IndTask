<?php
namespace console;
require_once('../core/autoload.php');


use core\connectDB;

class Migration extends connectDB
{
    public function __construct()
    {
        $conn = connectDB::connectDB();
        echo 'OK';
    }
}

new Migration();