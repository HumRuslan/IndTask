<?php
namespace core;
use core\connectDB;
use \PDO;

abstract class baseModel
{
    static $table = 'table';

    static $sql_str = '';

    abstract public function rules();

    public function loadPost()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $data = $_POST;
            $fields = get_object_vars($this);
            foreach ($fields as $key => $field){
                if(isset($data[$key])){
                    $this->{$key} = $data[$key];
                }
            }
            return true;
        }
        return false;
    }

    public function loadGet()
    {
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $data = $_GET;
            $fields = get_object_vars($this);
            foreach ($fields as $key => $field){
                if(isset($data[$key])){
                    $this->{$key} = $data[$key];
                }
            }
            return true;
        }
        return false;
    }

    public function validate()
    {
        $error = false;
        $error_message = '';
        $rules = $this->rules();
        foreach ($rules as $key => $fields){
            switch ($key){
                case 'required':
                    foreach ($fields as $field){
                        if ($this->{$field} == ''){
                            $error_message .= $field . " is required. <br>";
                            $error = true;
                        }
                    }
                break;
                case 'email':
                    foreach ($fields as $field){
                        if (!filter_var($this->{$field}, FILTER_VALIDATE_EMAIL)){
                            $error_message .= "$field is not valid email. <br>";
                            $error = true;
                        }
                    } 
                break;
                case 'string':
                    foreach ($fields as $field){
                        if (gettype($this->{$field}) != $key){
                            $error_message .= "$field expected $key recived " . gettype($this->{$field}) . ". <br>";
                            $error = true;
                        }
                    }
                break;
                case 'integer':
                    foreach ($fields as $field){
                        if (gettype(intval($this->{$field})) != $key){
                            $error_message .= "$field expected $key recived " . gettype($this->{$field}) . ". <br>";
                            $error = true;
                        }
                    }
                break;
                case 'double':
                    foreach ($fields as $field){
                        if (gettype(floatval($this->{$field})) != $key){
                            $error_message .= "$field expected $key recived " . gettype($this->{$field}) . ". <br>";
                            $error = true;
                        }
                    }
                break;
                case 'boolean':
                    foreach ($fields as $field){
                        if (gettype(boolval($this->{$field})) != $key){
                            $error_message .= "$field expected $key recived " . gettype($this->{$field}) . ". <br>";
                            $error = true;
                        }
                    }
                break;
            }
        }
        if (!isset($_SESSION)) session_start();
        if ($error) $_SESSION['error'] = $error_message;
        return !$error;
    }



    public function save()
    {
        $fields = get_object_vars($this);
        $keys = [];
        $values = [];
        foreach ($fields as $key => $value){
            if ($value){
                $keys[] = "`$key`";
                $values[] = ":$key";
            }
        }
        $conn = connectDB::connectDB();
        $table = static::$table;
        $sql_keys = implode(', ', $keys);
        $sql_values = implode(', ', $values);
        $stmt = $conn->prepare("INSERT INTO `$table` ($sql_keys) VALUES ($sql_values)");
        foreach ($fields as $key => $value){
            if ($value){
                $stmt->bindParam(":$key", $fields[$key]);
            }
        }
        if ($stmt->execute()) {
            $this->id = $conn->lastInsertId();
            return $this;
        }
        return false;
    }

    public function count()
    {
        $conn = connectDB::connectDB();
        $table = static::$table;
        $stmt = $conn->prepare("SELECT COUNT(*) as `count` FROM $table");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->count;
    }

    static public function find()
    {
        $obj_name = get_called_class();
        $obj = new $obj_name;
        $table = static::$table;
        static::$sql_str = "SELECT * FROM `$table`";
        return $obj;
    }

    public function where($params = [])
    {
        if ($params){
            $sql = [];
            foreach ($params as $key => $value){
                $value = htmlspecialchars($value);
                $sql[] = "`$key` = '$value'";
            }
            static::$sql_str .= " WHERE " . implode(' AND ', $sql);
        }
        return $this;
    }

    public function orderBy($params = [])
    {
        if ($params){
            $sql = [];
            foreach ($params as $key => $value){
                $sql[] = "$key $value";
            }
            static::$sql_str .= " ORDER BY " . implode(', ', $sql);
        }
        return $this;
    }

    public function limit($params = [])
    {
        extract($params);
        if (isset($start) && isset($step)){
            static::$sql_str .= " LIMIT $step OFFSET $start";
        }
        return $this;
    }

    public function all()
    {
        $conn = connectDB::connectDB();
        $stmt = $conn->prepare(static::$sql_str);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function one()
    {
        $conn = connectDB::connectDB();
        $stmt = $conn->prepare(static::$sql_str);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function update($params = []){
        $conn = connectDB::connectDB();
        $table = static::$table;
        $data = get_object_vars($this);
        $values = [];
        foreach ($data as $key => $value){
            $values[] = "`$key`=:$key";
        }
        $sql_set = implode(', ', $values);
        $sql_where = [];
        foreach ($params as $key => $values){
            $sql_where[] = "`$key`='$values'";
        }
        $sql_where = implode(' AND ', $sql_where);
        $sql = "UPDATE `$table` SET $sql_set WHERE $sql_where";
        $stmt = $conn->prepare($sql);
        foreach ($data as $key => $value){
            $stmt->bindParam(":$key", $data[$key]);
        }
        return $stmt->execute();
    }

    static public function delete($params = []){
        $conn = connectDB::connectDB();
        $table = static::$table;
        $sql_where = [];
        foreach ($params as $key => $values){
            $sql_where[] = "`$key`='$values'";
        }
        $sql_where = implode(' AND ', $sql_where);
        $sql = "DELETE FROM `$table` WHERE $sql_where";
        $stmt = $conn->prepare($sql);
        return $stmt->execute();
    }
}
