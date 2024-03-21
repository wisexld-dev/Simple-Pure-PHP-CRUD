<?php

/**
 * Classe clienteController para manipulação de requisições relacionadas a clientes.
 */
require_once("./baseController.php");
require_once("../Model/clienteModel.php");

class clienteController extends Controller
{
    /**
     * Instância do modelo Cliente.
     * @var Cliente
     */
    public $cliente;

    /**
     * Construtor da classe clienteController.
     * Inicializa a instância do modelo Cliente.
     */
    public function __construct()
    {
        $this->cliente = new Cliente();
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
     * Lista todos os clientes cadastrados.
     * @return void
     */
    private function handleGetRequest()
    {
        require_once("../Model/clienteModel.php");

        $obj = new Cliente();
        $clientes = $obj->listarClientes();

        require_once("../View/clienteView.php");
    }

    /**
     * Manipula uma requisição POST.
     * Cadastra um novo cliente com base nos dados recebidos.
     * @return void
     */
    private function handlePostRequest()
    {
        $this->cliente->cadastrarCliente($_POST);
    }

    /**
     * Manipula uma requisição PUT.
     * Atualiza as informações de um cliente existente.
     * @return void
     */
    private function handlePutRequest()
    {
        $putDados = file_get_contents("php://input");

        $dados = json_decode($putDados, true);

        $this->cliente->atualizarCliente($dados);
    }

    /**
     * Manipula uma requisição DELETE.
     * Deleta um cliente existente com base no ID recebido.
     * @return void
     */
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
