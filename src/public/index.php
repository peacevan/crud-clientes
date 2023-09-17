<?php

require_once 'vendor/autoload.php';
use app\Controller\ClienteController;
use app\Model\Cliente;
use app\Model\Endereco;
use app\Repository\ClienteRepository;
use app\Repository\EnderecoRepository;
use PHPUnit\Framework\TestCase;
use app\config\Connection;

$route->run();