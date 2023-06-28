<?php
include '../Abstraction/interface.php';
include '../Database/database.php';



class Department extends Database implements employee
{
    public $create="employee";

    public function createTbl()
    {
        $this->create();

        $tbl = "CREATE TABLE IF NOT EXISTS $this->create(
            id int primary key auto_increment,
            first_name varchar(200) not null,
            last_name varchar(200) not null,
            position text null,
            address text null
            )";
        $this->connection->query($tbl);
                    
    }

    public function getid($getid)
    {
        if(!isset($getid['id']) || empty($getid['id']))
        {
            $response = [
                'code' => 102,
                'message' => 'id is required!'
            ];
            return json_encode($response);
        }
        $id = $getid['id'];

        $data = $this->connection->query("SELECT * FROM $this->create WHERE id= '$id'");
        if($data->num_rows == 0)
        {
            $response = [
                'code' => 404,
                'message' => 'index not found'
            ];
            return json_encode($response);
        }
        return json_encode($data->fetch_assoc());
    }

    public function search($params) {
        if($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return json_encode([
                'code'=> 422,
                'message'=> 'GET method is only allowed',
            ]);
        }
    $firstName = $params['first_name'] ?? '';


    $sql = "SELECT * FROM $this->create
           where first_name like '%$firstName%'";

   $select= $this->connection->query($sql);

        if(empty($this->getError()))
        {
            return json_encode($select->fetch_all(MYSQLI_ASSOC));  
        } else {
            return json_encode([
                'code' => 500,
                'message' => $this->getError(),
            ]);
        }
    }


   public function getAll()
   {
    $select = $this->connection->query("SELECT * FROM $this->create");
    
    return json_encode($select->fetch_all(MYSQLI_ASSOC));
   }

  public function creates($params)
  {
    if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return json_encode([
            'code'=> 422,
            'message'=> 'POST method is only allowed',
        ]);
    }

    if(!isset($params['first_name']) || empty($params['first_name'])) {
        return json_encode([
            'code' => 422,
            'message' => 'First name is required',
        ]);
    }
    if(!isset($params['last_name']) || empty($params['last_name'])) {
        return json_encode([
            'code' => 422,
            'message' => 'Last name is required',
        ]);
    }
    if(!isset($params['position']) || empty($params['position'])) {
        return json_encode([
            'code' => 422,
            'message' => 'position is required',
        ]);
    }
    if(!isset($params['address']) || empty($params['address'])) {
        return json_encode([
            'code' => 422,
            'message' => 'address is required',
        ]);
    }

    $firstName = $params['first_name'];
    $lastName = $params['last_name'];
    $position = isset($params['position']) ? $params['position'] : '';
    $address = isset($params['address']) ? $params['address'] : '';

    $sql = "INSERT INTO $this->create (first_name, last_name, position, address) VALUES ('$firstName', '$lastName','$position','$address')";

    $added = $this->connection->query($sql);

    if($added) {
        return json_encode([
            'code' => 200,
            'message' => 'User successfully added',
        ]);

    } else {
        return json_encode ([
            'code'=> 500,
            'message' => $this->getError(),
        ]);
    }
  }

  public function update($params)
  {
    if($_SERVER['REQUEST_METHOD'] != 'POST') {
        return json_encode ([
            'code' => 422,
            'message' => 'only POST method is allowed',
        ]);
    }
    if(!isset($params['first_name']) || empty($params['first_name'])) {
        return json_encode([
            'code' => 422,
            'message' => 'First name is required',
        ]);
    }
    if(!isset($params['last_name']) || empty($params['last_name'])) {
        return json_encode([
            'code' => 422,
            'message' => 'Last name is required',
        ]);
    }
    if(!isset($params['id']) || empty($params['id'])) {
        return json_encode([
            'code' => 422,
            'message' => 'id is required',
        ]);
    }

    $id = $params['id'];
    $firstName = $params['first_name'];
    $lastName =  $params['last_name'];
    $position =  $params['position'];
    $address =   $params['address'];

   $sql = "UPDATE $this->create SET first_name = '$firstName', last_name = '$lastName',
           position = '$position', address = '$address'
           where id= '$id' ";

    $updated = $this->connection->query($sql);

    if($updated) {
        return json_encode([
            'code'=> 200,
            'message'=> ' User successfully updated',
        ]);
    }else {
        return json_encode ([
            'code' => 500,
            'message' => $this->getError(),
        ]);
    }
  }

  public function delete($params) 
  {
    if($_SERVER['REQUEST_METHOD'] != 'GET') {
        return json_encode ([
            'code'=>422,
            'message' => 'Only GET method is allowed',
        ]);
    }
    if(!isset($params['id']) || empty($params['id'])) {
        return json_encode([
            'code' => 422,
            'message' => 'id is required',
        ]);
    }
    $id = $params['id'];

    $sql = "DELETE FROM $this->create where id='$id'";
    $deleted = $this->connection->query($sql);

    if($deleted) {
        return json_encode([
            'code'=>422,
            'message'=> 'user successfully deleted',
        ]);
    }else {
        return json_encode([
            'code'=>500,
            'message'=> $this->getError(),
        ]);
    }
  }
}