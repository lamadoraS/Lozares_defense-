<?php

class Database{
    public $conn;
    public $servername="localhost";
    public $username="root";
    public $password="";
    public $dbname="defense";


    public function __construct()
    {
        $this->conn= new mysqli ($this->servername, $this->username,$this->password);
        $db="CREATE DATABASE IF NOT EXISTS $this->dbname";
        $this->conn->query($db);
        $use="USE $this->dbname";
        $this->conn->query($use);
    }
}
