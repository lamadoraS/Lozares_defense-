<?php
include '../Abstraction/interface.php';
include '../Database/database.php';



class Department extends Database implements employee
{
    public $create="department";

    public function createTbl()
    {
        $this->create();

        $tbl = "CREATE TABLE IF NOT EXISTS $this->create(
            id int primary key auto_increment,
            department_name varchar(200) not null,
            department_head varchar(200) not null,
            location text null,
            phone_number int,
            email varchar(50),
            description text
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
    $departmentName = $params['department_name'] ?? '';


    $sql = "SELECT * FROM $this->create
           where department_name like '%$departmentName%'";

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

    if(!isset($params['department_name']) || empty($params['department_name'])) {
        return json_encode([
            'code' => 422,
            'message' => 'Department name is required',
        ]);
    }
    if(!isset($params['department_head']) || empty($params['department_head'])) {
        return json_encode([
            'code' => 422,
            'message' => 'Department head is required',
        ]);
    }
    if(!isset($params['location']) || empty($params['location'])) {
        return json_encode([
            'code' => 422,
            'message' => 'Location is required',
        ]);
    }
    if(!isset($params['phone_number']) || empty($params['phone_number'])) {
        return json_encode([
            'code' => 422,
            'message' => 'Phone Number is required',
        ]);
    }
    if(!isset($params['email']) || empty($params['email'])) {
        return json_encode([
            'code' => 422,
            'message' => 'Email is required',
        ]);
    }
    if(!isset($params['description']) || empty($params['description'])) {
        return json_encode([
            'code' => 422,
            'message' => 'Description is required',
        ]);
    }

    $departmentName = $params['department_name'];
    $departmentHead = $params['department_head'];
    $location = isset($params['location']) ? $params['location'] : '';
    $phone_number = isset($params['phone_number']) ? $params['phone_number'] : '';
    $email = isset($params['email']) ? $params['email'] : '';
    $description = isset($params['description']) ? $params['description'] : '';


    $sql = "INSERT INTO $this->create (department_name, department_head, location, phone_number,email,description) 
           VALUES ('$departmentName', '$departmentHead','$location','$phone_number','$email','$description')";

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
    if(!isset($params['department_name']) || empty($params['department_name'])) {
        return json_encode([
            'code' => 422,
            'message' => 'Department name is required',
        ]);
    }
    if(!isset($params['department_head']) || empty($params['department_head'])) {
        return json_encode([
            'code' => 422,
            'message' => 'Department Head is required',
        ]);
    }
    if(!isset($params['location']) || empty($params['location'])) {
        return json_encode([
            'code' => 422,
            'message' => 'Location is required',
        ]);
    }
    if(!isset($params['phone_number']) || empty($params['phone_number'])) {
        return json_encode([
            'code' => 422,
            'message' => 'Phone Number is required',
        ]);
    }
    if(!isset($params['email']) || empty($params['email'])) {
        return json_encode([
            'code' => 422,
            'message' => 'Email  is required',
        ]);
    }
    if(!isset($params['description']) || empty($params['description'])) {
        return json_encode([
            'code' => 422,
            'message' => 'Description  is required',
        ]);
    }
    if(!isset($params['id']) || empty($params['id'])) {
        return json_encode([
            'code' => 422,
            'message' => 'id is required',
        ]);
    }

    $id = $params['id'];
    $departmentName = $params['department_name'];
    $departmentHead =  $params['department_head'];
    $location =  $params['location'];
    $phone_number =   $params['phone_number'];
    $email =   $params['email'];
    $description =   $params['description'];


   $sql = "UPDATE $this->create SET department_name = '$departmentName', department_head = '$departmentHead',
           location = '$location', phone_number = '$phone_number',email='$email',description='$description'
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