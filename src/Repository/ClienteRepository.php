<?php
namespace app\Repository;

//require './vendor/autoload.php';
use app\config\Connection;
use app\Model\Cliente;
use PDO;

class ClienteRepository
{
    private PDO $conn;
    private Cliente $clienteModel;

    public function __construct( PDO $conn)
    {
        $this->conn = $conn;
    }

    public function findById($id)
    {
        $query = "SELECT * FROM clientes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByAll()
    {
        $query = "SELECT * FROM clientes inner join enderecos on clientes.id = enderecos.id_cliente";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $dadosClientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $clienteModel= new Cliente($dadosClientes,$dadosClientes['endereco']);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(Cliente $cliente)
    {
        $query = "INSERT INTO clientes (razao_social, nome_fantasia, email, telefone, cnpj)
                  VALUES (:razao_social, :nome_santasia, :email, :telefone, :cnpj)";
        $stmt = $this->conn->prepare($query);
        $razao=$cliente->getRazaoSocial();
        $fantasia=$cliente->getNomeFantasia();
        $email=$cliente->getEmail();
        $telefone=$cliente->getTelefone();
        $cnpj=$cliente->getCnpj();

        $stmt->bindParam(":razao_social",$razao);
        $stmt->bindParam(":nome_santasia", $fantasia);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telefone",$telefone);
        $stmt->bindParam(":cnpj",$cnpj);
        //$stmt->bindParam(":endereco", $cliente->getEndereco());
        $stmt->execute();
        $id = $this->conn->lastInsertId();
        $result=$this->findById($id);
        return $this->returnCliente($result,$cliente);
    }

    public function update(Cliente $cliente)
    {
        $query = "UPDATE clientes SET razao_social = :razaoSocial, nome_fantasia = :nomeFantasia,
                  email = :email, telefone = :telefone, cnpj = :cnpj, endereco = :endereco WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":razaoSocial", $cliente->getRazaoSocial());
        $stmt->bindParam(":nomeFantasia", $cliente->getNomeFantasia());
        $stmt->bindParam(":email", $cliente->getEmail());
        $stmt->bindParam(":telefone", $cliente->getTelefone());
        $stmt->bindParam(":cnpj", $cliente->getCnpj());
        $stmt->bindParam(":endereco", $cliente->getEndereco());
        $stmt->bindParam(":id", $cliente->getId());
        return $stmt->execute();
    }

    public function delete(Cliente $cliente)
    {
        $query = "DELETE FROM clientes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $cliente->getId());
        return $stmt->execute();
    }

    public function returnCliente($result, $cliente)
    {
        $cliente->setId($result['id']);
        $cliente->setRazaoSocial($result['razao_social']);
        $cliente->setNomeFantasia($result['nome_fantasia']);
        $cliente->setEmail($result['email']);
        $cliente->setTelefone($result['telefone']);
        $cliente->setCnpj($result['cnpj']);
        //$cliente->setEndereco($result['endereco']);
        return $cliente;
    }
    
}
