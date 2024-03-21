<?php

abstract class Controller
{
    public $model;

    public function __construct()
    {
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
        // Lógica para lidar com requisições GET

    }

    private function handlePostRequest()
    {
        // Lógica para lidar com requisições POST
    }

    private function handlePutRequest()
    {
        // Lógica para lidar com requisições PUT
    }

    private function handleDeleteRequest()
    {
        // Lógica para lidar com requisições DELETE
    }
}

// Instanciar e executar o controlador
//$controller = new Controller();
//$controller->handleRequest();
