<?php
// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_cliente";



    // Cria uma nova conexão PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Define o modo de erro PDO para exceções
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if($_POST['func'] == 'inserir'){

   
    inserirCliente( $conn);
    }
    if($_POST['func'] == 'listar'){
     listar_cliente ();   
    }
     

// Fecha a conexão com o banco de dados
$conn = null;
function inserirCliente( $conn){
    
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
try {

    
// Prepara a consulta SQL para inserir os dados do cliente
    $stmt = $conn->prepare("INSERT INTO clientes(`razao_social`, `nome_fantasia`, `telefone`, `email`) VALUES (:razao_social, :nome_fantasia, :telefone, :email)");

// Define os valores dos parâmetros
    $razao_social = $_POST["razao_social"];
    $nome_fantasia =$_POST["nome_fantasia"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];

// Executa a consulta SQL
    $stmt->execute(array(':razao_social' => $razao_social, ':nome_fantasia' => $nome_fantasia, ':email' => $email, ':telefone' => $telefone));

echo "Dados do cliente inseridos com sucesso!";
} catch(PDOException $e) {
    echo "Erro ao inserir os dados do cliente: " . $e->getMessage();
  }
 }
} 

function listar_cliente (){
    try {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "db_cliente";
        
        // Cria uma nova conexão PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
        // Define o modo de erro PDO para exceções
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Consulta SQL para obter a lista de clientes
        $sql = "SELECT razao_social, nome_fantasia, email, telefone FROM clientes";
        $stmt = $conn->query($sql);
    
        // Verifica se há clientes encontrados
        if ($stmt->rowCount() > 0) {
            // Array para armazenar os clientes
            $clientes = array();
    
            // Loop pelos resultados da consulta
            while ($row = $stmt->fetch()) {
                // Cria um array associativo com os dados do cliente
                $cliente = array(
                    "razao_social" => $row["razao_social"],
                    "nome_fantasia" => $row["nome_fantasia"],
                    "email" => $row["email"],
                    "telefone" => $row["telefone"]
                );
    
                // Adiciona o cliente ao array de clientes
                $clientes[] = $cliente;
            }
    
            // Converte o array de clientes para JSON
            $jsonClientes = json_encode($clientes);
    
            // Retorna o JSON como resposta para a requisição AJAX
            header('Content-Type: application/json');
            echo $jsonClientes;
        } else {
            echo "Nenhum cliente encontrado.";
        }
    } catch(PDOException $e) {
        echo "Erro ao obter a lista de clientes: " . $e->getMessage();
    }
    
    // Fecha a conexão com o banco de dados
    $conn = null;
}
?>