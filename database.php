<?php
class Database{
    public static function dbConnect(){
        $conn = null;
        $host = "localhost";
        $dbname = "connexion_slid";
        $root = "root";
        $password = "";
        try{
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $root, $password);
        }catch(PDOException $e){
            $e->getMessage();
        }
        return $conn;
    }
}