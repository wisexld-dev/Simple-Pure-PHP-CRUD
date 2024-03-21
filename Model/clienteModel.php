<?php

require_once("../Config/Database.php");
require_once("../Model/baseModel.php");

class Cliente extends Model
{

    public $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function listarClientes()
    {
        if ($this->connection->statusConexao() === "Conectado") {
            try {

                $query = "SELECT id, nome, cpf, endereco FROM clientes";
                $query_exec = $this->connection->prepare($query);
                $query_exec->execute();

                return $query_exec->fetchAll();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    public function cadastrarCliente(array $dados)
    {
        if ($this->connection->statusConexao() === "Conectado") {
            try {

                $query = "INSERT INTO clientes (nome, cpf, endereco) VALUES (:nome, :cpf, :endereco)";
                $query_exec = $this->connection->prepare($query);

                $query_exec->bindParam(":nome", $dados["nome"]);
                $query_exec->bindParam(":cpf", $dados["cpf"]);
                $query_exec->bindParam(":endereco", $dados["endereco"]);


                $query_exec->execute();

                return json_encode("{status: \"OK\", message: \"Cliente cadastrado!\"}");
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    public function atualizarCliente(array $dados)
    {
        if ($this->connection->statusConexao() === "Conectado") {
            try {

                $query = "UPDATE clientes SET nome = :nome, cpf = :cpf, endereco = :endereco WHERE id = :id";
                $query_exec = $this->connection->prepare($query);

                $query_exec->bindParam(":nome", $dados["nome"]);
                $query_exec->bindParam(":cpf", $dados["cpf"]);
                $query_exec->bindParam(":endereco", $dados["endereco"]);
                $query_exec->bindParam(":id", $dados["id"]);

                $query_exec->execute();

                return json_encode("{status: \"OK\", message: \"Informaçoes do cilente atualizadas!!\"}");
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    public function deletarCliente(string $id)
    {
        if ($this->connection->statusConexao() === "Conectado") {
            try {

                $query = "DELETE FROM clientes WHERE id = :id";
                $query_exec = $this->connection->prepare($query);

                $query_exec->bindParam(":id", $id);

                $query_exec->execute();

                return json_encode("{status: \"OK\", message: \"Informaçoes do cliente atualizadas!\"}");
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }
}
