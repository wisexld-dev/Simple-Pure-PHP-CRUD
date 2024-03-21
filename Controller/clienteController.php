<?php

require_once("./baseController.php");
require_once("../Model/clienteModel.php");


class clienteController extends Controller
{
    public $cliente;

    public function __construct()
    {
        $this->cliente = new Cliente();
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
        require_once("../Model/clienteModel.php");

        $obj = new Cliente();
        $clientes = $obj->listarClientes();

        require_once("../View/clienteView.php");
    }

    private function handlePostRequest()
    {
        $this->cliente->cadastrarCliente($_POST);
    }

    private function handlePutRequest()
    {
        $putDados = file_get_contents("php://input");

        $dados = json_decode($putDados, true);

        $this->cliente->atualizarCliente($dados);
    }

    private function handleDeleteRequest()
    {
        $putDados = file_get_contents("php://input");

        $id = json_decode($putDados, true)['id'];

        $this->cliente->deletarCliente($id);
    }
}

// Instanciar e executar o controlador
$controller = new clienteController();
$controller->handleRequest();
