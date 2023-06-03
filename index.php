<?php
include 'database.php';
header("Content-Type: application/json; charset=utf-8");

class Department extends Database 
{
    public $tblName="employee";

    public function table()
    {
    
        $create="CREATE TABLE IF NOT EXISTS $this->tblName (
            id int primary key auto_increment,
            first_name varchar(200),
            last_name varchar(200)
            )"; 
        $this->conn->query($create);          
}
 public function insert()
 {
  $firstname= $_GET['first_name'];
  $lastname= $_GET['last_name'];

  $insert="INSERT INTO $this->tblName 
  VALUES ('$firstname',$lastname')";
  $this->conn->query($insert);
}
 
}
 