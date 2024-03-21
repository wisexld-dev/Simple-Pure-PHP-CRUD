<?php

require_once("../Config/Database.php");
require_once("../Model/baseModel.php");

class OrdemServico extends Model
{

    public $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function listarOS()
    {
        if ($this->connection->statusConexao() === "Conectado") {
            try {

                $query = "SELECT 
                os.numero_ordem AS numero_ordem,
                os.data_abertura AS data_abertura,
                os.id_cliente AS id_cliente,
                os.nome_consumidor AS nome_consumidor,
                os.cpf_consumidor AS cpf_consumidor
            FROM 
                ordemservico os";

                $query_exec = $this->connection->prepare($query);
                $query_exec->execute();

                return $query_exec->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    public function getProdutosOS($numero_ordem)
    {
        try {

            $query = "SELECT op.id_produto, p.descricao
            FROM ordemservico_produtos op
            INNER JOIN produtos p ON op.id_produto = p.id
            WHERE op.numero_ordem = :numero_ordem";

            $query_exec = $this->connection->prepare($query);
            $query_exec->bindParam(":numero_ordem", $numero_ordem);
            $query_exec->execute();

            return $query_exec->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function cadastrarOS(array $dados)
    {
        if ($this->connection->statusConexao() === "Conectado") {
            try {
                $cpf_consumidor = preg_replace('/[^0-9]/', '', $dados['cpf_consumidor']);

                // Valida se cliente já está cadastrado
                $query = "SELECT id FROM clientes WHERE cpf = :cpf_consumidor";
                $query_exec = $this->connection->prepare($query);
                $query_exec->bindParam(":cpf_consumidor", $cpf_consumidor);

                $query_exec->execute();

                // Gerar código aleatório
                $randomCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

                $NUMERO_COLUNA_CPF_QUERY = 0;
                if ($query_exec->rowCount() == 1) {
                    $idCliente = $query_exec->fetchColumn($NUMERO_COLUNA_CPF_QUERY);

                    try {
                        $query = "INSERT INTO ordemservico (numero_ordem, data_abertura, id_cliente, nome_consumidor, cpf_consumidor) VALUES (:numero, :data_abertura, :id_cliente, :nome_consumidor, :cpf_consumidor)";
                        $query_exec = $this->connection->prepare($query);

                        $numeroOS = $dados['numero_os'] !== null ? $dados['numero_os'] : $randomCode;
                        $query_exec->bindParam(":numero", $numeroOS);

                        $query_exec->bindParam(":data_abertura", $dados["data_abertura"]);
                        $query_exec->bindParam(":id_cliente", $idCliente);
                        $query_exec->bindParam(":nome_consumidor", $dados['nome_consumidor']);
                        $query_exec->bindParam(":cpf_consumidor", $cpf_consumidor);

                        $success = $query_exec->execute();

                        if ($success) {

                            try {
                                foreach ($dados['produtosId'] as $produtoId) {
                                    $query = "INSERT INTO ordemservico_produtos (numero_ordem, id_produto) VALUES (:numero, :id_produto)";
                                    $query_exec = $this->connection->prepare($query);

                                    $query_exec->bindParam(":numero", $numeroOS);
                                    $query_exec->bindParam(":id_produto", $produtoId);

                                    $success = $query_exec->execute();
                                }
                                if ($success) {
                                    echo json_encode(["status" => "OK", "message" => "O.S Cadastrada !"]);
                                }
                            } catch (PDOException $e) {
                                echo json_encode(["status" => "Erro", "message" => "Erro ao cadastrar produtos da O.S: " . implode(", ", $query_exec->errorInfo())]);
                            }
                        }
                    } catch (PDOException $e) {
                        echo json_encode(["status" => "Erro", "message" => "Erro ao cadastrar nova O.S: " . implode(", ", $query_exec->errorInfo())]);
                    }
                }

                // Cadastrar novo cliente caso não esteja cadastrado
                try {
                    $endereco = null;
                    $query = "INSERT INTO clientes (nome, cpf, endereco) VALUES (:nome, :cpf, :endereco)";
                    $query_exec = $this->connection->prepare($query);

                    $query_exec->bindParam(":nome", $dados["nome_consumidor"]);
                    $query_exec->bindParam(":cpf", $cpf_consumidor);
                    $query_exec->bindParam(":endereco", $endereco);

                    $success = $query_exec->execute();

                    if ($success) {
                        $idCliente = $this->connection->lastInsertId();

                        try {
                            $query = "INSERT INTO ordemservico (numero_ordem, data_abertura, id_cliente, nome_consumidor, cpf_consumidor) VALUES (:numero, :data_abertura, :id_cliente, :nome_consumidor, :cpf_consumidor)";
                            $query_exec = $this->connection->prepare($query);

                            $query_exec->bindParam(":numero", $randomCode);
                            $query_exec->bindParam(":data_abertura", $dados["data_abertura"]);
                            $query_exec->bindParam(":id_cliente", $idCliente);
                            $query_exec->bindParam(":nome_consumidor", $dados['nome_consumidor']);
                            $query_exec->bindParam(":cpf_consumidor", $cpf_consumidor);

                            $success = $query_exec->execute();

                            if ($success) {

                                try {
                                    foreach ($dados['produtosId'] as $produtoId) {
                                        $query = "INSERT INTO ordemservico_produtos (numero_ordem, id_produto) VALUES (:numero, :id_produto)";
                                        $query_exec = $this->connection->prepare($query);

                                        $query_exec->bindParam(":numero", $numeroOS);
                                        $query_exec->bindParam(":id_produto", $produtoId);

                                        $success = $query_exec->execute();
                                    }
                                    if ($success) {
                                        echo json_encode(["status" => "OK", "message" => "O.S Cadastrada !"]);
                                    }
                                } catch (PDOException $e) {
                                    echo json_encode(["status" => "Erro", "message" => "Erro ao cadastrar produtos da O.S: " . implode(", ", $query_exec->errorInfo())]);
                                }
                            }
                        } catch (PDOException $e) {
                            echo json_encode(["status" => "Erro", "message" => "Erro ao cadastrar O.S!" . implode(", ", $query_exec->errorInfo())]);
                        }
                    }
                } catch (PDOException $e) {
                    echo json_encode(["status" => "Erro", "message" => "Erro ao cadastrar novo cliente!" . implode(", ", $query_exec->errorInfo())]);
                }
            } catch (PDOException $e) {
                echo json_encode(["status" => "Erro", "message" => $e->getMessage()]);
            }
        }
    }

    public function atualizarOS(array $dados)
    {
        if ($this->connection->statusConexao() === "Conectado") {
            try {
                // Obter os produtos existentes na ordem de serviço
                $query = "SELECT id_produto FROM ordemservico_produtos WHERE numero_ordem = :numero_ordem";
                $query_exec = $this->connection->prepare($query);
                $query_exec->bindParam(":numero_ordem", $dados['numero_os']);
                $query_exec->execute();
                $produtos_existentes = $query_exec->fetchAll(PDO::FETCH_COLUMN);

                // Comparar os produtos existentes com os produtos enviados
                $produtos_a_remover = array_diff($produtos_existentes, $dados['produtos_selecionados']);
                $produtos_a_adicionar = array_diff($dados['produtos_selecionados'], $produtos_existentes);


                // Remover os produtos que não estão mais na lista
                if (!empty($produtos_a_remover)) {
                    try {
                        // Construir a lista de IDs dos produtos para a cláusula IN
                        $ids_produtos = implode(',', $produtos_a_remover);

                        // Construir a consulta com os IDs dos produtos
                        $query = "DELETE FROM ordemservico_produtos WHERE numero_ordem = :numero_ordem AND id_produto IN ($ids_produtos)";
                        $query_exec = $this->connection->prepare($query);

                        // Vincular o número da ordem
                        $query_exec->bindParam(":numero_ordem", $dados['numero_os']);

                        $query_exec->execute();
                    } catch (PDOException $e) {
                        echo json_encode(["status" => "Erro", "message" => "Erro ao remover produtos da O.S" . implode(", ", $query_exec->errorInfo())]);
                    }
                }


                // Adicionar os produtos que estão na lista mas não na tabela
                if (!empty($produtos_a_adicionar)) {
                    try {
                        // Iniciar uma transação
                        $this->connection->beginTransaction();

                        // Preparar a consulta de inserção
                        $query = "INSERT INTO ordemservico_produtos (numero_ordem, id_produto) VALUES (:numero_ordem, :id_produto)";
                        $query_exec = $this->connection->prepare($query);

                        // Vincular o número da ordem para cada produto e executar a inserção
                        foreach ($produtos_a_adicionar as $produto_id) {
                            $query_exec->bindParam(":numero_ordem", $dados['numero_os']);
                            $query_exec->bindParam(":id_produto", $produto_id);
                            $query_exec->execute();
                        }

                        // Commit da transação
                        $this->connection->commit();

                        // Resposta JSON de sucesso
                        echo json_encode(["status" => "OK", "message" => "Produtos adicionados com sucesso!"]);
                    } catch (PDOException $e) {
                        // Rollback da transação em caso de erro
                        $this->connection->rollBack();

                        // Resposta JSON de erro
                        echo json_encode(["status" => "Erro", "message" => "Erro ao adicionar produtos na ordem de serviço: " . $e->getMessage()]);
                    }
                }

                echo json_encode(["status" => "OK", "message" =>  "Produtos da ordem de serviço atualizados com sucesso!"]);
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    public function deletarOS(string $numero_ordem)
    {
        if ($this->connection->statusConexao() === "Conectado") {
            try {

                $query = "DELETE FROM ordemservico WHERE numero_ordem = :numero_ordem";
                $query_exec = $this->connection->prepare($query);

                $query_exec->bindParam(":numero_ordem", $numero_ordem);

                $query_exec->execute();

                echo json_encode(["status" => "OK", "message" =>  "Ordem de Serviço deletada!"]);
            } catch (PDOException $e) {
                echo json_encode(["status" => "Erro", "message" =>  "Erro ao deletar ordem de serviço!" . $e->getMessage()]);
            }

            try {

                $query = "DELETE FROM ordemservico_produtos WHERE numero_ordem = :numero_ordem";
                $query_exec = $this->connection->prepare($query);

                $query_exec->bindParam(":numero_ordem", $numero_ordem);

                $query_exec->execute();
            } catch (PDOException $e) {
                echo json_encode(["status" => "Erro", "message" =>  "Erro ao deletar produtos da ordem de serviço!" . $e->getMessage()]);
            }
        }
    }
}
