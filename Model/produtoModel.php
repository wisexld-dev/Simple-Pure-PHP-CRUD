<?php

/**
 * Classe Produto para manipulação de dados de produtos no banco de dados.
 */
require_once("../Config/Database.php");
require_once("../Model/baseModel.php");

class Produto extends Model
{
    /**
     * Conexão com o banco de dados.
     * @var Connection
     */
    public $connection;

    /**
     * Construtor da classe Produto.
     * Inicializa a conexão com o banco de dados.
     */
    public function __construct()
    {
        $this->connection = new Connection();
    }

    /**
     * Método para listar todos os produtos do banco de dados.
     * @return mixed Uma matriz contendo os produtos ou uma mensagem de erro.
     */
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

    /**
     * Método para cadastrar um novo produto no banco de dados.
     * @param array $dados Os dados do produto a serem cadastrados.
     * @return void
     */
    public function cadastrarProduto(array $dados)
    {
        if ($this->connection->statusConexao() === "Conectado") {
            try {

                // Gerar código aleatório
                $randomCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

                $tempo_garantia = !empty($dados["tempo_garantia"]) ? $dados["tempo_garantia"] : null;

                // Preparar a consulta SQL
                $query = "INSERT INTO produtos (codigo, descricao, status, tempo_garantia) VALUES (:codigo, :descricao, :status, :tempo_garantia)";
                $query_exec = $this->connection->prepare($query);

                // Vincular parâmetros
                $query_exec->bindParam(":codigo", $randomCode);
                $query_exec->bindParam(":descricao", $dados["descricao"]);
                $query_exec->bindParam(":status", $dados["status"]);
                $query_exec->bindParam(":tempo_garantia", $tempo_garantia);

                // Executar a consulta
                $success = $query_exec->execute();

                if ($success) {
                    // Retornar uma resposta JSON válida
                    echo json_encode(["status" => "OK", "message" => "Produto cadastrado!"]);
                } else {
                    // Retornar uma mensagem de erro
                    echo json_encode(["status" => "Erro", "message" => "Erro ao executar a consulta: " . implode(", ", $query_exec->errorInfo())]);
                }
            } catch (PDOException $e) {
                // Em caso de erro, retornar uma mensagem de erro
                echo json_encode(["status" => "Erro", "message" => $e->getMessage()]);
            }
        }
    }

    /**
     * Método para atualizar informações de um produto no banco de dados.
     * @param array $dados Os novos dados do produto a serem atualizados.
     * @return void
     */
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

                echo json_encode(["status" => "OK", "message" => "Informaçoes do produto atualizadas"]);
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    /**
     * Método para deletar um produto do banco de dados.
     * @param string $id O ID do produto a ser excluído.
     * @return void
     */
    public function deletarProduto(string $id)
    {
        if ($this->connection->statusConexao() === "Conectado") {
            try {

                $query = "DELETE FROM produtos WHERE id = :id";
                $query_exec = $this->connection->prepare($query);

                $query_exec->bindParam(":id", $id);

                $query_exec->execute();

                echo json_encode(["status" => "OK", "message" => "Produto deletado"]);
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }
}
