<?php
namespace app\Repository;
require './vendor/autoload.php';
use app\Model\Endereco;
use PDO;
use PDOException;   
use app\config\Connection;
class EnderecoRepository {
    private $conn;
    private Endereco $enderecoModel;
    
    public function __construct($conn,Endereco $enderecoModel) {
        $this->conn = $conn;
        $this->enderecoModel = $enderecoModel;
    }
    
    public function findById($id) {
        $query = "SELECT * FROM enderecos WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
       
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function findAll() {
        $query = "SELECT * FROM enderecos";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function create($endereco) {
   
        $query = "INSERT INTO enderecos (numero,cep,logradouro,bairro, municipio, estado,pais,id_cliente) ";
        $query = $query . " VALUES (:numero,:cep,:logradouro,:bairro,:municipio,:estado,:pais,:id_cliente)"; 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":numero", $endereco->getNumero());
        $stmt->bindParam(":cep", $endereco->getCep());
        $stmt->bindParam(":logradouro", $endereco->getLogradouro());
        $stmt->bindParam(":bairro", $endereco->getBairro());
        $stmt->bindParam(":municipio", $endereco->getCep());
        $stmt->bindParam(":estado", $endereco->getEstado());
        $stmt->bindParam(":pais", $endereco->getPais());
        $stmt->bindParam(":id_cliente", $endereco->getIdCliente());
        $stmt->execute();
        $id=$this->conn->lastInsertId();
        $resultDb = $this->findById($id);
        return $this->enderecoModel->returnEnderecoDb($resultDb);
    }
    
    public function update($endereco) {
        $query = "UPDATE enderecos SET rua = :rua, numero = :numero, cidade = :cidade, estado = :estado WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":rua", $endereco->getRua());
        $stmt->bindParam(":numero", $endereco->getNumero());
        $stmt->bindParam(":cidade", $endereco->getCidade());
        $stmt->bindParam(":estado", $endereco->getEstado());
        $stmt->bindParam(":id", $endereco->getId());
        return $stmt->execute();
    }
}