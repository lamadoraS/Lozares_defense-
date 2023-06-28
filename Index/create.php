<?php

include 'index.php';

header("Content-Type: application/json; charset=utf-8");

$department = new Department();
$department->createTbl();

echo $department->creates($_POST);
