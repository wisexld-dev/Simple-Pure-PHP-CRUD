<?php

require_once("./baseController.php");
require_once("../Model/produtoModel.php");


class produtoController extends Controller
{
    public $produto;

    public function __construct()
    {
        $this->produto = new Produto();
    }

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

    private function handleGetRequest()
    {
        require_once("../Model/produtoModel.php");

        $obj = new Produto();
        $produtos = $obj->listarProdutos();

        require_once("../View/produtoView.php");
    }

    private function handlePostRequest()
    {
        $this->produto->cadastrarProduto($_POST);
    }

    private function handlePutRequest()
    {
        $putDados = file_get_contents("php://input");

        $dados = json_decode($putDados, true);

        $this->produto->atualizarProduto($dados);
    }

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
