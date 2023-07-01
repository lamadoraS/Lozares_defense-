<?php

interface employee 
{
    public function createTbl();
    public function getid($getid);
    public function search($params);
    public function getAll();
    public function creates($params);
    public function update($params);
    public function delete($params);
    
}