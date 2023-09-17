
<?php 
     include_once '../../src/view/header.php';
    ?>
<body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            lista_cliente();
        });

         function delete_cliente(id){
            
             $.ajax({
                url: "http://localhost:81/src/Controller/ClienteController.php?id_cliente="+id, 
                dataType: "json",
                method: "DELETE",
                success: function(data) {
                    // Loop pelos dados de clientes
                     alert('Cliente deletado com sucesso');
                     lista_cliente();
                    console.log(data);
                }
                ,
                error: function (jqXHR, textStatus, errorThrown) {
                   alert('erro ao deletar cliente');
                }
            });

         }
         function lista_cliente(){
            // var objeto = JSON.parse(data["data"]);
            // Faz uma requisição AJAX para obter os dados de clientes em JSON
            $.ajax({
                url: "http://localhost:81/src/Controller/ClienteController.php", 
                dataType: "json",
                success: function(data) {
                    // Loop pelos dados de clientes
                    $("#clientesTable").empty(); 
                    $.each( data["data"], function(index, cliente) {
                        // Cria uma nova linha na tabela
                        var newRow = $("<tr>");
                        // Adiciona as células com os dados do cliente
                        $item=index+1;
                        newRow.append("<td>" +cliente.id_cliente +"</td>");
                        newRow.append("<td>" +cliente.razao_social+ "</td>");
                        newRow.append("<td>" +cliente.nome_fantasia+ "</td>");
                        newRow.append("<td>" +cliente.email+"</td>");
                        newRow.append("<td>" +cliente.telefone+ "</td>");
                        newRow.append("<td> <a href='#' class='edit-icon'><i class='fa fa-pencil'></i></a>&nbsp; <a href='#' onclick='delete_cliente("+cliente.id_cliente +")' class='remove-icon'><i class='fa fa-trash'></i></a> </td>"); 
                        // Adiciona a nova linha à tabela
                        $("#clientesTable").append(newRow);
                    });
                    console.log(data);
                  
                }
            });
         }
         
    </script>

<body>
<?php 
     include_once '../../src/view/siderbar.php';
    ?>
      <div id="formulario">
    <table id="clientesTable">
        <tr>
            <th>#</th>
            <th>Razão Social</th>
            <th>Nome Fantasia</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Opção</th> 
        </tr>
    </table>
</div>
</body>
</html>