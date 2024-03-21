<?php

require_once("./baseController.php");
require_once("../Model/ordemservicoModel.php");
require_once("../Model/produtoModel.php");

class ordemservicoController extends Controller
{
    public $os;

    public function __construct()
    {
        $this->os = new OrdemServico();
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
        require_once("../Model/ordemservicoModel.php");

        $os = new OrdemServico();
        $ordens = $os->listarOS();

        $produto = new Produto();
        $produtos = $produto->listarProdutos();

        require_once("../View/ordemservicoView.php");
    }

    private function handlePostRequest()
    {
        if (!isset($_POST['action'])) {
            $this->os->cadastrarOS($_POST);
            return;
        }

        $action = trim($_POST['action']);

        if ($action === 'getProdutosOS') {

            $os = new OrdemServico();
            $produtosOS = $os->getProdutosOS($_POST['numero_ordem']);

            if (isset($produtosOS)) {
                header('Content-Type: application/json');
                echo json_encode($produtosOS);
            }
        }
    }


    private function handlePutRequest()
    {
        $putDados = file_get_contents("php://input");

        $dados = json_decode($putDados, true);

        $this->os->atualizarOS($dados);
    }

    private function handleDeleteRequest()
    {
        $putDados = file_get_contents("php://input");

        $numero_ordem = json_decode($putDados, true)['numero_ordem'];

        $this->os->deletarOS($numero_ordem);
    }
}

// Instanciar e executar o controlador
$controller = new ordemservicoController();
$controller->handleRequest();
