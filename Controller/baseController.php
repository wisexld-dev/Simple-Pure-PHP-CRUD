<?php

/**
 * Classe abstrata Controller para manipulação de requisições.
 */
abstract class Controller
{
    /**
     * Instância do modelo associado ao controlador.
     * @var mixed
     */
    public $model;

    /**
     * Construtor da classe Controller.
     * @return void
     */
    public function __construct()
    {
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
     * @return void
     */
    private function handleGetRequest()
    {
        // Lógica para lidar com requisições GET
    }

    /**
     * Manipula uma requisição POST.
     * @return void
     */
    private function handlePostRequest()
    {
        // Lógica para lidar com requisições POST
    }

    /**
     * Manipula uma requisição PUT.
     * @return void
     */
    private function handlePutRequest()
    {
        // Lógica para lidar com requisições PUT
    }

    /**
     * Manipula uma requisição DELETE.
     * @return void
     */
    private function handleDeleteRequest()
    {
        // Lógica para lidar com requisições DELETE
    }
}

// Instanciar e executar o controlador
//$controller = new Controller();
//$controller->handleRequest();
