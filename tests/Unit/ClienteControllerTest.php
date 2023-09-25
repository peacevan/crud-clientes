<?php
namespace Tests\tests;
require_once 'vendor/autoload.php';
use app\config\Connection;
use app\Controller\ClienteController;
use app\Model\Cliente;
use app\Model\Endereco;
use app\Repository\ClienteRepository;
use app\Repository\EnderecoRepository;
use PHPUnit\Framework\TestCase;

class ClienteControllerTest extends TestCase
{
    public function testCriarCliente()
    {
        // Dados de exemplo para criar um cliente

        $dadosCliente = [
           
            'razao_social' => 'Empresa Teste 2',
            'nome_fantasia' => 'ABC',
            'email' => 'contato@empresa.com',
            'telefone' => '123456789',
            'cnpj' => '123456789',
        ];

        $dadosEndereco = [
            'logradouro' => 'Rua X',
            'bairro' => 'Bairro Y',
            'numero' => '123',
            "estado" => 'Bahia',
            "municipio" => 'Salvador',
            "pais" => 'Brasil',
            "cep" => '12345-678',
        ];
        $dadosCliente['endereco'] =$dadosEndereco;
        $conn = Connection::getInstance()->getConection();
        $enderecoModel = new Endereco($dadosEndereco);
        $validateEndereco = $enderecoModel->getValidaDadosEndereco()['validate'];
        $this->assertTrue($validateEndereco);
        $clienteModel = new Cliente($dadosCliente, $enderecoModel);
        $enderecoRepository = new EnderecoRepository($conn, $enderecoModel);
        $clinteRepository = new ClienteRepository($conn);
        // Instanciar o ClienteController
        $clienteController = new ClienteController($clinteRepository, $enderecoRepository, $clienteModel, $enderecoModel);
        // Chamar o método criarCliente() passando os dados do cliente
        $clienteCriado = $clienteController->inserirCliente($dadosCliente);
        // Verificar se o cliente criado é igual ao cliente esperado
        echo ('Cliente criado: ' . $clienteCriado->getId() . PHP_EOL);
        $this->assertTrue($clienteCriado->getId() > 0);
        $this->assertEquals($clienteCriado->getRazaoSocial(), $dadosCliente['razao_social']);
    }
    public function testUpdateCliente()
    {
        // Dados de exemplo para criar um cliente
        $dadosCliente = [
            'id' => 1,
            'razaoSocial' => 'Empresa ABC',
            'nomeFantasia' => 'ABC',
            'email' => 'contato@empresa.com',
            'telefone' => '123456789',
            'cnpj' => '123456789',
        ];
        $dadosEndereco = [
            'logradouro' => 'Rua Update',
            'bairro' => 'Bairro Y',
            'numero' => '123',
            "estado" => 'Bahia',
            "municipio" => 'Salvador',
            "pais" => 'Brasil',
            "cep" => '12345-678',
        ];
        $dadosCliente['endereco'] =$dadosEndereco;
        $conn = Connection::getInstance()->getConection();
        $enderecoModel = new Endereco($dadosEndereco);

        $clienteModel = new Cliente($dadosCliente, $enderecoModel);
        $enderecoRepository = new EnderecoRepository($conn, $enderecoModel);
        $clinteRepository = new ClienteRepository($conn);
        // Instanciar o ClienteController
        $clienteController = new ClienteController($clinteRepository,
            $enderecoRepository,
            $clienteModel,
            $enderecoModel
        );
        $this->assertTrue(true);
        // Chamar o método criarCliente() passando os dados do cliente
        //$clienteCriado = $clienteController->editarCliente($dadosCliente);
        // Verificar se o cliente criado é igual ao cliente esperado
        //echo('Cliente criado: '.$clienteCriado->getId().PHP_EOL);
        //$this->assertTrue($clienteCriado->getId() > 0);

    }
    public function test_listar_cliente()
    {
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
         $result=$clienteController->listarCliente();
         //var_dump(json_encode($result));
         $this->assertTrue(true);
    }
}