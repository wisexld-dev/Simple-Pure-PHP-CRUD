<?php

/**
 * Classe ordemservicoController para manipulação de requisições relacionadas a ordens de serviço.
 */
require_once("./baseController.php");
require_once("../Model/ordemservicoModel.php");
require_once("../Model/produtoModel.php");

class ordemservicoController extends Controller
{
    /**
     * Instância do modelo OrdemServico.
     * @var OrdemServico
     */
    public $os;

    /**
     * Construtor da classe ordemservicoController.
     * Inicializa a instância do modelo OrdemServico.
     */
    public function __construct()
    {
        $this->os = new OrdemServico();
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
     * Lista todas as ordens de serviço e produtos associados.
     * @return void
     */
    private function handleGetRequest()
    {
        require_once("../Model/ordemservicoModel.php");

        $os = new OrdemServico();
        $ordens = $os->listarOS();

        $produto = new Produto();
        $produtos = $produto->listarProdutos();

        require_once("../View/ordemservicoView.php");
    }

    /**
     * Manipula uma requisição POST.
     * Executa diferentes ações com base nos parâmetros recebidos.
     * @return void
     */
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

    /**
     * Manipula uma requisição PUT.
     * Atualiza uma ordem de serviço existente.
     * @return void
     */
    private function handlePutRequest()
    {
        $putDados = file_get_contents("php://input");

        $dados = json_decode($putDados, true);

        $this->os->atualizarOS($dados);
    }

    /**
     * Manipula uma requisição DELETE.
     * Deleta uma ordem de serviço existente.
     * @return void
     */
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
