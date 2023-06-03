<?php
include 'database.php';

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
   $i= "INSERT INTO $this->tblName 
      VALUES (1,'antonette','lozares')";
      $this->conn->query($i);
      var_dump($this->conn->error);

}
    
} 
