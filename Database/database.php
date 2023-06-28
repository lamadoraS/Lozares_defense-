<?php 

include '../Abstraction/abstract.php';

class Database extends Db 
{
    protected $connection;
    private $servername="localhost";
    private $username="root";
    private $password="";
    private $db="defense";

    public function create()
    {
        $this->connection = new mysqli($this->servername,$this->username,$this->password);
        $this->connection->query("CREATE DATABASE IF NOT EXISTS $this->db");
        $this->connection = new mysqli($this->servername,$this->username,$this->password,$this->db);
        $d = "USE $this->db";
        $this->connection->query($d);
    }
    public function getError()
    {
        return $this->connection->error;
    }
    
}