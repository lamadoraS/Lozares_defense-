<?php
include 'department.php';

header("Content-Type: application/json; charset=utf-8");

$department = new Department();
$department->createTbl();

echo $department->search($_GET);