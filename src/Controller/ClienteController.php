<?php
namespace app\controller;

require './vendor/autoload.php';

use app\config\Connection;
use app\Model\Cliente;
use app\Model\Endereco;
use app\Repository\ClienteRepository;
use app\Repository\EnderecoRepository;
use Exception;

class ClienteController
{

    private ClienteRepository $clienteRepository;
    private EnderecoRepository $enderecoRepository;
    private $conn;
    private $requestCliente;
    private $requestEndereco;
    private Cliente $cliente;
    private Endereco $enderecoModel;

    public function __construct(
        ClienteRepository $clienteRepository,
        EnderecoRepository $enderecoRepository,
        Cliente $clienteModel,
        Endereco $enderecoModel
    ) {
        $this->clienteRepository = $clienteRepository;
        $this->enderecoRepository = $enderecoRepository;
        $this->cliente = $clienteModel;
        $this->enderecoModel = $enderecoModel;
    }
    function inserirCliente(array $clienteRequest, array $enderecoRequest)
    {
        $this->setRequestCliente($clienteRequest);
        $this->cliente = $this->clienteRepository->create($this->cliente); //tem que retornar o cliente prrenchido
        $this->enderecoModel->setIdCliente($this->cliente->getId());
        $newEndereco = $this->enderecoRepository->create($this->enderecoModel);

        var_dump($newEndereco);
        return $this->cliente;
    }

    function listarCliente($id = null)
    {

        if ($id) {
            return $this->clienteRepository->findById($id);
        } else {
            return $this->clienteRepository->findByAll();
        }

    }
    public function deleteCliente($id)
    {
        $cliente = $this->clienteRepository->findById($id);

        if ($cliente) {
            $this->clienteRepository->delete($cliente);
            return $this->getMessageResponse(200, "Cliente deletado com sucesso.", null);
        } else {
            return $this->getMessageResponse(400, "Erro ao excluir cliente.", null);
        }
    }

    public function editarCliente($id, $dados)
    {
        try {
            $cliente = $this->clienteRepository->findById($id);

            if ($cliente) {
                // Atualiza os dados do cliente com base nos dados fornecidos
                $cliente->setRazaoSocial($dados['razaoSocial']);
                $cliente->setNomeFantasia($dados['nomeFantasia']);
                $cliente->setEmail($dados['email']);
                $cliente->setTelefone($dados['telefone']);
                $cliente->setCnpj($dados['cnpj']);
                $cliente->setEndereco($dados['endereco']);

                $this->clienteRepository->update($cliente);
                $jsonResponse = json_encode(array("coode" => 200,
                    "message" => "Cliente atualizado com sucesso.",
                    "data" => $cliente));
                echo $jsonResponse;
            } else {
                echo $this->getMessageResponse(500, "Cliente não encontrado", null);
                return false;
            }
        } catch (Exception $e) {
            echo $this->getMessageResponse(500, 'error' . $e->getMessage(), null);
        }
    }

    function getRequestEndereco(Endereco $enderecoRequest)
    {
        //valida request aqui ;

        return array("logradouro" => $_POST['logradouro'],
            "bairro" => $_POST['bairro'],
            "numero" => $_POST['numero'],
            "estado" => $_POST['estado'],
            "cidade" => $_POST['cidade'],
            "pais" => $_POST['pais'],
            "cep" => $_POST['cep']);
    }

    function getRequestCliente($clienteRequest)
    {
        return array("razaoSocial" => $_POST['razaoSocial'],
            "nomeFantasia" => $_POST['nomeFantasia'],
            "email" => $_POST['email'],
            "telefone" => $_POST['telefone'],
            "cnpj" => $_POST['cnpj'],
        );

    }
    function setRequestCliente($dados)
    {
        // Atualiza os dados do cliente com base nos dados fornecidos
        $this->cliente->setRazaoSocial($dados['razaoSocial']);
        $this->cliente->setNomeFantasia($dados['nomeFantasia']);
        $this->cliente->setEmail($dados['email']);
        $this->cliente->setTelefone($dados['telefone']);
        $this->cliente->setCnpj($dados['cnpj']);
        //$this->cliente->setEndereco($dados['endereco']);
        return $this->cliente;
    }

    function getMessageResponse($code, $message, $dataReponse = null)
    {
        return json_encode(array("code" => $code, "message" => $message, "data" => $dataReponse));

    }

    function run()
    {

        switch ($_SERVER["REQUEST_METHOD"]) {
            case 'POST':
                $this->requestCliente = $this->getRequestCliente($_POST);
                $this->requestEndereco = $this->getRequestEndereco($_POST);
                $validateEndereco = $this->enderecoModel->getValidaDadosEndereco()['validate'];
                if ($validateEndereco) {
                    $this->inserirCliente($this->requestCliente, $this->requestEndereco);
                } else {
                    echo $this->getMessageResponse(400, 'Dados de endereço inválidos', null);
                }

                break;

            case 'GET':
                $this->listarCliente();
                break;
            case 'DELETE':
                $this->deleteCliente($_POST['id']);
            case 'PUT':
                $this->editarCliente($_POST['id'], $_POST);

        }

    }

}

$conn = Connection::getInstance()->getConection();
$enderecoModel = new Endereco($this->requestEndereco);
$clienteModel = new Cliente($this->requestCliente, $enderecoModel);
$enderecoRepository = new EnderecoRepository($conn, $enderecoModel);
$clinteRepository = new ClienteRepository($conn);
$clienteController = new ClienteController($clinteRepository, $enderecoRepository, $clienteModel, $enderecoModel);
$clienteController->run($conn, $enderecoModel, $clienteModel, $enderecoRepository, $clinteRepository);
