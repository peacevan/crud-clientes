<?php
namespace app\controller;

require_once __DIR__ . '/../../vendor/autoload.php';

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
        if ($this->cliente->getId()) {
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
        }
        return $this->clienteRepository->findByAll();

    }
    public function deleteCliente($id)
    {
        return $this->clienteRepository->delete($id);
    }

    public function editarCliente($clienteModel)
    {
        try {

            if ($clienteModel) {

                $this->clienteRepository->update($clienteModel);
                $jsonResponse = json_encode(array("coode" => 200,
                    "message" => "Cliente atualizado com sucesso.",
                    "data" => $clienteModel));
                echo $jsonResponse;
            } else {
                echo $this->getMessageResponse(500, "Cliente não encontrado", null);
                return false;
            }
        } catch (Exception $e) {
            echo $this->getMessageResponse(500, 'error' . $e->getMessage(), null);
        }
    }

    function getRequestEndereco($renderecoRequest)
    {
        return array(
            "logradouro" => $renderecoRequest['logradouro'],
            "bairro" => $renderecoRequest['bairro'],
            "numero" => $renderecoRequest['numero'],
            "estado" => $renderecoRequest['estado'],
            "municipio" => $renderecoRequest['municipio'],
            "pais" => $renderecoRequest['pais'],
            "cep" => $renderecoRequest['cep']);
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
        if (isset($dados['id'])) {
            $this->cliente->setId($dados['id']);
        }
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
                $this->requestCliente = $_POST; //$this->getRequestCliente($_POST);
                $this->requestEndereco = $this->getRequestEndereco($_POST['endereco']);
                $validateEndereco = $this->enderecoModel->getValidaDadosEndereco()['validate'];

                if ($validateEndereco) {
                    $result = $this->inserirCliente($this->requestCliente);
                    echo $this->getMessageResponse(200, 'cliente cadastrado com sucesso', $result);
                } else {
                    echo $this->getMessageResponse(400, 'Dados de endereço inválidos', null);
                }
                break;
            case 'GET':

                if (array_key_exists('id', $_GET)) {
                    $result = $this->listarCliente($_GET['id']);
                    echo $this->getMessageResponse(200, "cliente encontrado", $result);
                    return true;
                }
                $result = $this->listarCliente();
                echo $this->getMessageResponse(200, "lista.", $result);
                break;
            case 'DELETE':
                $result = $this->deleteCliente($_GET['id_cliente']);

                if ($result) {
                    echo $this->getMessageResponse(200, "Cliente deletado com sucesso.", $result);
                } else {
                    echo $this->getMessageResponse(400, "Erro ao excluir cliente.", $result);
                }
                return;
                break;
            case 'PUT':
                parse_str(file_get_contents("php://input"), $request);
                $this->requestCliente  = $this->setRequestCliente($request);
                $this->requestEndereco = $this->getRequestEndereco($request['endereco']);
                // $validateEndereco = $this->enderecoModel->getValidaDadosEndereco()['validate'];
                $validateEndereco = true;
                if ($validateEndereco) {

                    $result = $this->editarCliente($this->requestCliente);
                    echo $this->getMessageResponse(200, 'cliente cadastrado com sucesso', $result);
                } else {
                    echo $this->getMessageResponse(400, 'Dados de endereço inválidos', null);
                }
                break;
        }
    }
}

//conexão
$conn = Connection::getInstance()->getConection();
//instancia os models
$requestEndereco = array_key_exists('endereco', $_POST) ? $_POST['endereco'] : null;
$enderecoModel = new Endereco($requestEndereco);
$clienteModel = new Cliente($_POST, $enderecoModel);

//instancia os repositories
$enderecoRepository = new EnderecoRepository($conn, $enderecoModel);
$clinteRepository = new ClienteRepository($conn);
$clienteController = new ClienteController($clinteRepository, $enderecoRepository, $clienteModel, $enderecoModel);

$clienteController->runController();
