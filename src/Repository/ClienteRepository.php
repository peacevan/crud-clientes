<?php
namespace app\Repository;

//require './vendor/autoload.php';
use app\Model\Cliente;
use PDO;
use PDOException;

class ClienteRepository
{
    private PDO $conn;
    private Cliente $clienteModel;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

   
   
    public function findById($id)
    {
        $query = " SELECT clientes.* FROM clientes ";
        $query = $query . "  WHERE clientes.id = :id ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function findByClienteIdWithEndereco($id)
    {
        $query = " SELECT clientes.*, enderecos.* FROM clientes ";
        $query = $query . " inner join enderecos on clientes.id = enderecos.id_cliente";
        $query = $query . "  WHERE clientes.id = :id ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByAll()
    {
        $query = "SELECT * FROM clientes inner join enderecos on clientes.id = enderecos.id_cliente";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function create(Cliente $cliente)
    {

        try {
            $query = "INSERT INTO clientes (razao_social, nome_fantasia, email, telefone, cnpj)
                  VALUES (:razao_social, :nome_santasia, :email, :telefone, :cnpj)";
            $stmt = $this->conn->prepare($query);
            $razao = $cliente->getRazaoSocial();
            $fantasia = $cliente->getNomeFantasia();
            $email = $cliente->getEmail();
            $telefone = $cliente->getTelefone();
            $cnpj = $cliente->getCnpj();

            $this->conn->beginTransaction();

            $stmt->bindParam(":razao_social", $razao);
            $stmt->bindParam(":nome_santasia", $fantasia);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":telefone", $telefone);
            $stmt->bindParam(":cnpj", $cnpj);
            //$stmt->bindParam(":endereco", $cliente->getEndereco());
            $stmt->execute();
            $id = $this->conn->lastInsertId();
         
            $this->conn->commit();
            $result = $this->findById($id);
            return $this->returnCliente($result[0],$cliente);
        } catch (PDOException $e) {
            $this->conn->rollBack();
            die($e->getMessage());

        }
    }

    public function update(Cliente $cliente)
    {

        try {
            $query = "UPDATE clientes SET razao_social = :razao_social, nome_fantasia = :nome_fantasia,
                  email = :email, telefone = :telefone, cnpj = :cnpj WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $razao = $cliente->getRazaoSocial();
            $fantasia = $cliente->getNomeFantasia();
            $email = $cliente->getEmail();
            $telefone = $cliente->getTelefone();
            $cnpj = $cliente->getCnpj();
            $id = $cliente->getId();
            $stmt->bindParam(":razao_social", $razao);
            $stmt->bindParam(":nome_fantasia", $fantasia);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":telefone", $telefone);
            $stmt->bindParam(":cnpj", $cnpj);
            //$stmt->bindParam(":endereco", $cliente->getEndereco());
            $stmt->bindParam(":id", $id);
            // endereço
            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function delete($id)
    {

        try {
            $id = intval($id);
            $query = "DELETE FROM enderecos WHERE id_cliente = :id_cliente";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":id_cliente", $id);
            $stmt->execute();

            $query = "DELETE FROM clientes WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    public function returnCliente($result,Cliente $cliente)
    {
        $cliente->setId($result['id']);
        $cliente->setRazaoSocial($result['razao_social']);
        $cliente->setNomeFantasia($result['nome_fantasia']);
        $cliente->setEmail($result['email']);
        $cliente->setTelefone($result['telefone']);
        $cliente->setCnpj($result['cnpj']);
        if(isset($result['endereco'])){
            $cliente->setEndereco($result['endereco']);
        }
        return $cliente;
    }

}
