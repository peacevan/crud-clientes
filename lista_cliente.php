<?php

// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "seu_banco_de_dados";

try {
    // Cria uma nova conexão PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Define o modo de erro PDO para exceções
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL para obter a lista de clientes
    $sql = "SELECT razao_social, nome_fantasia, email, telefone FROM clientes";
    $stmt = $conn->query($sql);

    // Verifica se há clientes encontrados
    if ($stmt->rowCount() > 0) {
        // Exibe a tabela de clientes
        echo "<table>";
        echo "<tr><th>Razão Social</th><th>Nome Fantasia</th><th>Email</th><th>Telefone</th></tr>";

        // Loop pelos resultados da consulta
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . $row["razao_social"] . "</td>";
            echo "<td>" . $row["nome_fantasia"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["telefone"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Nenhum cliente encontrado.";
    }
} catch(PDOException $e) {
    echo "Erro ao obter a lista de clientes: " . $e->getMessage();
}

// Fecha a conexão com o banco de dados
$conn = null;

?>