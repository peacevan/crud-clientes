<?php
namespace app\Model;
//require './vendor/autoload.php';
use app\Model\Endereco;
use JsonSerializable;
class Cliente implements JsonSerializable {
    private ?string $razaoSocial;
    private ?string  $nomeFantasia;
    private ?string  $email;
    private ?string  $telefone;
    private ?string  $cnpj;
    private ?int  $id;
    private  $endereco;
       
    public function __construct( array $dadosRequest, Endereco $enderecoRequest) {
     if($dadosRequest){
        $this->id = array_key_exists('id',$dadosRequest)? $dadosRequest['id'] : null;   
        $this->razaoSocial =  $dadosRequest['razao_social'];
        $this->nomeFantasia = $dadosRequest['nome_fantasia'];
        $this->email = $dadosRequest['email'];
        $this->telefone = $dadosRequest['telefone'];
        $this->cnpj = $dadosRequest['cnpj'];
        $this->endereco = $enderecoRequest;
      }
    }
    
    // Getters e Setters para os atributos
    
    public function getRazaoSocial() {
        return $this->razaoSocial;
    }
    
    public function setRazaoSocial($razaoSocial) {
        $this->razaoSocial = $razaoSocial;
    }
    
    public function getNomeFantasia() {
        return $this->nomeFantasia;
    }
    
    public function setNomeFantasia($nomeFantasia) {
        $this->nomeFantasia = $nomeFantasia;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getTelefone() {
        return $this->telefone;
    }
    
    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }
    
    public function getCnpj() {
        return $this->cnpj;
    }
    
    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getEndereco() {
        return $this->endereco;
    }
    
    public function setEndereco(Endereco $endereco) {
        $this->endereco = $endereco;
    }

    public function jsonSerialize(): mixed
    {
        $vars = get_object_vars($this);
        //$vars['endereco']= $this->endereco->jsonSerialize();
        return $vars;
    }
}
