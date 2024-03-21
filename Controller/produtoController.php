<?php

/**
 * Classe produtoController para manipulação de requisições relacionadas a produtos.
 */
require_once("./baseController.php");
require_once("../Model/produtoModel.php");

class produtoController extends Controller
{
    /**
     * Instância do modelo Produto.
     * @var Produto
     */
    public $produto;

    /**
     * Construtor da classe produtoController.
     * Inicializa a instância do modelo Produto.
     */
    public function __construct()
    {
        $this->produto = new Produto();
    }

    /**
     * Manipula a requisição recebida pelo controlador.
     * Determina a ação com base no método HTTP.
     * @return void
     */
    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                $this->handleGetRequest();
                break;
            case 'POST':
                $this->handlePostRequest();
                break;
            case 'PUT':
                $this->handlePutRequest();
                break;
            case 'DELETE':
                $this->handleDeleteRequest();
                break;
            default:
                http_response_code(405); // Método não permitido
                echo "Método não permitido";
                break;
        }
    }

    /**
     * Manipula uma requisição GET.
     * Lista todos os produtos.
     * @return void
     */
    private function handleGetRequest()
    {
        require_once("../Model/produtoModel.php");

        $obj = new Produto();
        $produtos = $obj->listarProdutos();

        require_once("../View/produtoView.php");
    }

    /**
     * Manipula uma requisição POST.
     * Cadastra um novo produto.
     * @return void
     */
    private function handlePostRequest()
    {
        $this->produto->cadastrarProduto($_POST);
    }

    /**
     * Manipula uma requisição PUT.
     * Atualiza um produto existente.
     * @return void
     */
    private function handlePutRequest()
    {
        $putDados = file_get_contents("php://input");

        $dados = json_decode($putDados, true);

        $this->produto->atualizarProduto($dados);
    }

    /**
     * Manipula uma requisição DELETE.
     * Deleta um produto existente.
     * @return void
     */
    private function handleDeleteRequest()
    {
        $putDados = file_get_contents("php://input");

        $id = json_decode($putDados, true)['id'];

        $this->produto->deletarProduto($id);
    }
}

// Instanciar e executar o controlador
$controller = new produtoController();
$controller->handleRequest();
