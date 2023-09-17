<?php
namespace app\Model;

//require './vendor/autoload.php';
use JsonSerializable;

class Endereco implements JsonSerializable
{
    private ?string $logradouro;
    private ?string $bairro;
    private ?string $numero;
    private ?string $estado;
    private ?string $municipio;
    private ?string $pais;
    private ?string $cep;
    private ?string $id_cliente;
    private ?int $id;
    private $validateEndereco;

    public function __construct(?array $dadosRequest)
    {
      if ($dadosRequest){
        $this->logradouro = $dadosRequest['logradouro'];
        $this->bairro = $dadosRequest['bairro'];
        $this->numero = $dadosRequest['numero'];
        $this->estado = $dadosRequest['estado'];
        $this->municipio = $dadosRequest['municipio'];
        $this->pais = $dadosRequest['pais'];
        $this->cep = $dadosRequest['cep'];
        $this->id_cliente = array_key_exists('id_cliente',$dadosRequest)? $dadosRequest['id_cliente'] : null;   
        $this->id = array_key_exists('id',$dadosRequest)? $dadosRequest['id'] : null;
        $this->validateEndereco=$this->validaDadosEndereco();
      }
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

    public function getmunicipio()
    {
        return $this->municipio;
    }

    public function setmunicipio($municipio)
    {
        $this->municipio = $municipio;
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
        $this->municipio ? $result['municipio'] = true : $result['municipio'] = false;
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
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    public function returnEnderecoDb(array $resultDb)
    {
       $newEndereco = new self($resultDb);
       return $newEndereco;
    }

}
