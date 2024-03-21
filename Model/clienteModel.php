<?php

/**
 * Classe Cliente para manipulação de dados de clientes no banco de dados.
 */
require_once("../Config/Database.php");
require_once("../Model/baseModel.php");

class Cliente extends Model
{
    /**
     * Conexão com o banco de dados.
     * @var Connection
     */
    public $connection;

    /**
     * Construtor da classe Cliente.
     * Inicializa a conexão com o banco de dados.
     */
    public function __construct()
    {
        $this->connection = new Connection();
    }

    /**
     * Método para listar todos os clientes do banco de dados.
     * @return mixed Uma matriz contendo os clientes ou uma mensagem de erro.
     */
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

    /**
     * Método para cadastrar um novo cliente no banco de dados.
     * @param array $dados Os dados do cliente a serem cadastrados.
     * @return string Uma mensagem de status de cadastro.
     */
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

                echo json_encode(["status" => "OK", "message" => "Cliente cadastrado"]);
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    /**
     * Método para atualizar informações de um cliente no banco de dados.
     * @param array $dados Os novos dados do cliente a serem atualizados.
     * @return string Uma mensagem de status da atualização.
     */
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

                echo json_encode(["status" => "OK", "message" => "Informaçoes do cliente atualizadas."]);
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    /**
     * Método para deletar um cliente do banco de dados.
     * @param string $id O ID do cliente a ser excluído.
     * @return string Uma mensagem de status da exclusão.
     */
    public function deletarCliente(string $id)
    {
        if ($this->connection->statusConexao() === "Conectado") {
            try {

                $query = "DELETE FROM clientes WHERE id = :id";
                $query_exec = $this->connection->prepare($query);

                $query_exec->bindParam(":id", $id);

                $query_exec->execute();

                echo json_encode(["status" => "OK", "message" => "Informaçoes do cliente excluídas"]);
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }
}
