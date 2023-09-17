<?php
namespace app\Model;

require './vendor/autoload.php';
use JsonSerializable;

class Endereco implements JsonSerializable
{

    private $logradouro;
    private $bairro;
    private $numero;
    private $estado;
    private $cidade;
    private $pais;
    private $cep;
    private $id_cliente;
    private $id;
    private $validateEndereco;

    public function __construct(array $dadosRequest)
    {

        $this->logradouro = $dadosRequest['logradouro'];
        $this->bairro = $dadosRequest['bairro'];
        $this->numero = $dadosRequest['numero'];
        $this->estado = $dadosRequest['estado'];
        $this->cidade = $dadosRequest['cidade'];
        $this->pais = $dadosRequest['pais'];
        $this->cep = $dadosRequest['cep'];
        $this->id_cliente = $dadosRequest['id_cliente'];
        $this->id = array_key_exists('id',$dadosRequest)? $dadosRequest['id'] : null;
        $this->validateEndereco=$this->validaDadosEndereco();
    }

    // Getters e Setters para os atributos
    public function getValidaDadosEndereco()
    {
        return $this->validateEndereco;
    }

    public function getLogradouro()
    {
        return $this->logradouro;
    }

    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    public function getPais()
    {
        return $this->pais;
    }

    public function setPais($pais)
    {
        $this->pais = $pais;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setCep($cep)
    {
        $this->cep = $cep;
    }
    public function getIdCliente()
    {
        return $this->id_cliente;
    }
    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id_cliente = $id;
    }
    public function validaDadosEndereco()
    {
        trim($this->logradouro) ? $result['logradouro'] = true : $result['logradouro'] = false;
        $this->bairro ? $result['bairro'] = true : $result['bairro'] = false;
        $this->numero ? $result['numero'] = true : $result['numero'] = false;
        $this->estado ? $result['estado'] = true : $result['estado'] = false;
        $this->cidade ? $result['cidade'] = true : $result['cidade'] = false;
        $this->pais ? $result['pais'] = true : $result['pais'] = false;
        trim($this->cep) ? $result['cep'] = true : $result['cep'] = false;
        $result['validate'] = true;
        foreach ($result as $key => $value) {
            if (!$value) {
                $result['validate'] = false;
            }
        }
        return $result;
    }
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function returnEnderecoDb(array $resultDb)
    {
       $newEndereco = new self($resultDb);
       return $newEndereco;
    }

}
