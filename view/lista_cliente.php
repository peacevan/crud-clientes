<!DOCTYPE html>
<html>
<head>
    <title>Lista de Clientes</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Faz uma requisição AJAX para obter os dados de clientes em JSON
            $.ajax({
                url: "http://localhost/crud-clientes/controller/ClienteController.php?func=list",
                dataType: "json",
                success: function(data) {
                    // Loop pelos dados de clientes
                    $.each(data, function(index, cliente) {
                        // Cria uma nova linha na tabela
                        var newRow = $("<tr>");

                        // Adiciona as células com os dados do cliente
                        newRow.append("<td>" + cliente.razao_social + "</td>");
                        newRow.append("<td>" + cliente.nome_fantasia + "</td>");
                        newRow.append("<td>" + cliente.email + "</td>");
                        newRow.append("<td>" + cliente.telefone + "</td>");

                        // Adiciona a nova linha à tabela
                        $("#clientesTable").append(newRow);
                    });
                }
            });
        });
    </script>
</head>
<body>
    <table id="clientesTable">
        <tr>
            <th>Razão Social</th>
            <th>Nome Fantasia</th>
            <th>Email</th>
            <th>Telefone</th>
        </tr>
    </table>
</body>
</html>