<?php

class Connection extends PDO
{
    private $host = 'localhost';
    private $database = 'Telecontrol';
    private $username = 'postgres';
    private $password = 'root';
    private $port = '5432';
    private $sgbd = 'pgsql';
    private $status = 'Erro';

    public function __construct()
    {
        try {
            parent::__construct("{$this->sgbd}:host={$this->host};dbname={$this->database};port={$this->port}", $this->username, $this->password);
            return $this->status = 'Conectado';
        } catch (PDOException $e) {
            return 'Erro ao conectar com o banco de dados!' . $e->getMessage();
            return $this->status;
        }
    }

    public function statusConexao()
    {
        return $this->status;
    }
}
