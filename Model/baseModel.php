<?php

/**
 * Classe abstrata Model para manipulação de dados no banco de dados.
 */
require_once("../Config/Database.php");

abstract class Model extends Connection
{
    /**
     * Conexão com o banco de dados.
     * @var Connection
     */
    public $connection;

    /**
     * Construtor da classe Model.
     * Inicializa a conexão com o banco de dados.
     */
    public function __construct()
    {
        $this->connection = new Connection();
    }

    /**
     * Método para criar um novo registro no banco de dados.
     * @return void
     */
    public function create()
    {
    }

    /**
     * Método para ler registros do banco de dados.
     * @return void
     */
    public function read()
    {
    }

    /**
     * Método para encontrar um registro pelo seu ID no banco de dados.
     * @param int $id O ID do registro a ser encontrado.
     * @return void
     */
    public function find($id)
    {
    }

    /**
     * Método para atualizar um registro no banco de dados.
     * @param array $dados Os novos dados do registro a serem atualizados.
     * @param int $id O ID do registro a ser atualizado.
     * @return void
     */
    public function update(array $dados, $id)
    {
    }

    /**
     * Método para excluir um registro do banco de dados.
     * @param int $id O ID do registro a ser excluído.
     * @return void
     */
    public function delete($id)
    {
    }
}
