<?php
header("Content-Type: application/json; charset=utf-8");
include 'index.php';

$d= new Database;
$e= new Department();
$e->table();
$e->insert();   

