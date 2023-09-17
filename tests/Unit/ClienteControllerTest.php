<?php
namespace Tests\tests;

require_once 'vendor/autoload.php';
use app\Controller\ClienteController;
use app\Model\Cliente;
use app\Model\Endereco;
use app\Repository\ClienteRepository;
use app\Repository\EnderecoRepository;
use PHPUnit\Framework\TestCase;
use app\config\Connection;

class ClienteControllerTest extends TestCase
{
    public function testCriarCliente()
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
            'logradouro' => 'Rua X',
            'bairro' => 'Bairro Y',
            'numero' => '123',
            "estado" => 'Bahia',
            "municipio" => 'Salvador',
            "pais"   => 'Brasil',
            "cep"    => '12345-678',
        ];
        $conn = Connection::getInstance()->getConection();
        $enderecoModel = new Endereco($dadosEndereco); 
        $validateEndereco=$enderecoModel->getValidaDadosEndereco()['validate'];  
        $this->assertTrue($validateEndereco);
        
        $clienteModel= new Cliente($dadosCliente, $enderecoModel);
        $enderecoRepository = new EnderecoRepository($conn, $enderecoModel);
        $clinteRepository = new ClienteRepository($conn);
      
        // Instanciar o ClienteController
        $clienteController = new ClienteController($clinteRepository, $enderecoRepository, $clienteModel, $enderecoModel);
        // Chamar o método criarCliente() passando os dados do cliente
        $clienteCriado = $clienteController->inserirCliente($dadosCliente);
        // Verificar se o cliente criado é igual ao cliente esperado
        echo('Cliente criado: '.$clienteCriado->getId().PHP_EOL);
        $this->assertTrue($clienteCriado->getId() > 0);
       
    }
    public function testUpdateCliente(){   
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
            "pais"   => 'Brasil',
            "cep"    => '12345-678',
        ];
        $conn = Connection::getInstance()->getConection();
        $enderecoModel = new Endereco($dadosEndereco); 
        
        $clienteModel= new Cliente($dadosCliente, $enderecoModel);
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
}
