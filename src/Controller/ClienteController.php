<?php
namespace app\controller;

require_once(__DIR__.'/../../vendor/autoload.php');

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
    function inserirCliente(array $clienteRequest)
    {
        $this->setRequestCliente($clienteRequest);
        $this->cliente = $this->clienteRepository->create($this->cliente); 
        if($this->cliente->getId()){
            $this->enderecoModel->setIdCliente($this->cliente->getId());
            $newEndereco = $this->enderecoRepository->create($this->enderecoModel);
            $this->cliente->setEndereco($newEndereco);              
        }
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
                $cliente->setRazaoSocial($dados['razao_social']);
                $cliente->setNomeFantasia($dados['nome_fantasia']);
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

    function getRequestEndereco( $renderecoRequest)
    {
       

        return array("logradouro" => $renderecoRequest['logradouro'],
            "bairro" => $renderecoRequest['bairro'],
            "numero" => $renderecoRequest['numero'],
            "estado" => $renderecoRequest['estado'],
            "municipio" => $renderecoRequest['municipio'],
            "pais"   => $renderecoRequest['pais'],
            "cep"    => $renderecoRequest['cep']);
    }

    function getRequestCliente($clienteRequest)
    {
        return array("razao_social" => $_POST['razao_social'],
            "nome_fantasia" => $_POST['nome_fantasia'],
            "email" => $_POST['email'],
            "telefone" => $_POST['telefone'],
            "cnpj" => $_POST['cnpj'],
        );

    }
    function setRequestCliente($dados)
    {
        // Atualiza os dados do cliente com base nos dados fornecidos
        $this->cliente->setRazaoSocial($dados['razao_social']);
        $this->cliente->setNomeFantasia($dados['nome_fantasia']);
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

    function runController()
    {

        switch ($_SERVER["REQUEST_METHOD"]) {
            case 'POST':
               
                $this->requestCliente =$_POST;   //$this->getRequestCliente($_POST);
                $this->requestEndereco = $this->getRequestEndereco($_POST['endereco']);
                $validateEndereco = $this->enderecoModel->getValidaDadosEndereco()['validate'];
                if ($validateEndereco) {
                   return $this->inserirCliente($this->requestCliente);
                   echo $this->getMessageResponse(200, 'Dados de endereço inseridos com sucesso', null);
                } 
                else {
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

//conexão
 $conn = Connection::getInstance()->getConection();

//instancia os models

$enderecoModel = new Endereco($_POST['endereco']);
$clienteModel = new Cliente($_POST, $enderecoModel);

//instancia os repositories
$enderecoRepository = new EnderecoRepository($conn, $enderecoModel);
$clinteRepository = new ClienteRepository($conn);

$clienteController = new ClienteController($clinteRepository, $enderecoRepository, $clienteModel,$enderecoModel);
$clienteController->runController();
