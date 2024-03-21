<?php

require_once("../Config/Database.php");
require_once("../Model/baseModel.php");

class Produto extends Model
{

    public $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function listarProdutos()
    {
        if ($this->connection->statusConexao() === "Conectado") {
            try {

                $query = "SELECT id, codigo, descricao, status, tempo_garantia FROM produtos";
                $query_exec = $this->connection->prepare($query);
                $query_exec->execute();

                return $query_exec->fetchAll();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    public function cadastrarProduto(array $dados)
    {
        if ($this->connection->statusConexao() === "Conectado") {
            try {

                $query = "INSERT INTO produtos (codigo, descricao, status, tempo_garantia) VALUES (:descricao, :status, :tempo_garantia)";
                $query_exec = $this->connection->prepare($query);

                $query_exec->bindParam(":descricao", $dados["descricao"]);
                $query_exec->bindParam(":status", $dados["status"]);
                $query_exec->bindParam(":tempo_garantia", $dados["tempo_garantia"]);

                $query_exec->execute();

                return json_encode("{status: \"OK\", message: \"Produto cadastrado!\"}");
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    public function atualizarProduto(array $dados)
    {
        if ($this->connection->statusConexao() === "Conectado") {
            try {

                $query = "UPDATE produtos SET descricao = :descricao, status = :status, tempo_garantia = :tempo_garantia WHERE id = :id";
                $query_exec = $this->connection->prepare($query);

                $query_exec->bindParam(":descricao", $dados["descricao"]);
                $query_exec->bindParam(":status", $dados["status"]);
                $query_exec->bindParam(":tempo_garantia", $dados["tempo_garantia"]);
                $query_exec->bindParam(":id", $dados["id"]);

                $query_exec->execute();

                return json_encode("{status: \"OK\", message: \"Informaçoes do produto atualizadas!!\"}");
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    public function deletarProduto(string $id)
    {
        if ($this->connection->statusConexao() === "Conectado") {
            try {

                $query = "DELETE FROM produtos WHERE id = :id";
                $query_exec = $this->connection->prepare($query);

                $query_exec->bindParam(":id", $id);

                $query_exec->execute();

                return json_encode("{status: \"OK\", message: \"Produto deletado!\"}");
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }
}
