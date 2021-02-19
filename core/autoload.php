<?php
    function autoloadClass($name)
    {
        require_once($name . '.php');
        if (!class_exists($name)){
            throw new Exception ("Controller class $name not found in file: $name.php");
        }
    }
    
    spl_autoload_register('autoloadClass');