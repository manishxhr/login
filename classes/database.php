<?php
class Database{
    private $host="localhost";
    private $user="root";
    private $pass="";
    private $dbname="admin-user";
    private $conn;

    public function __construct()
    {
        try{
            $this->conn= new PDO("mysql:host=$this->host; dbname=$this->dbname", $this->user, $this->pass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "database connected successful<br>";
        }
        catch(PDOException $e){
            die("database connection failed".$e->getMessage());
        }
    }

    public function getConnection(){
        return $this->conn;
    }
}
?>