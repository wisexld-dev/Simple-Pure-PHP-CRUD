<?php

require_once("../Config/Database.php");

abstract class Model extends Connection
{

    public $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function create()
    {
    }

    public function read()
    {
    }

    public function find($id)
    {
    }

    public function  update(array $dados, $id)
    {
    }

    public function  delete($id)
    {
    }
}
