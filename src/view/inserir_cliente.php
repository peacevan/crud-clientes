<!DOCTYPE html>
<html>
<head>
    <title>Exemplo de AJAX POST com jQuery</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Cadastro de cliente</h1>

    <form id="formulario">
        <label for="nome">Razão social:</label>
        <input type="text" id="razao_social" name="razao_social">
        <br>
        <label for="nome">Nome fantasia:</label>
        <input type="text" id="nome_fantasia" name="nome_fantasia">
        <br>
        <label for="nome">Telefone:</label>
        <input type="text" id="telefone" name="telefone">
        <br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email">
        <br>
        <button onclick="enviar_dados()">Enviar</button>
    </form>

    <div id="resultado">
        <!-- Os resultados da solicitação AJAX serão exibidos aqui -->
    </div>
    <?php
    
    ?>


    <script>
        $(document).ready(function () {
             

            // Quando o formulário for enviado
         /*  $("#formulario").submit(function (event) {
               
            });*/

        });
        function enviar_dados(){
            if (validar_dados ()){
                debugger
                
                event.preventDefault(); // Impede o comportamento padrão do formulário

                // Obtem os dados do formulário
                var razao_social = $("#razao_social").val();
                var nome_fantasia = $("#nome_fantasia").val();
                var telefone = $("#telefone").val();
                var email = $("#email").val();

                // Cria um objeto com os dados a serem enviados
                var dados = {
                    razao_social: razao_social,
                    nome_fantasia: nome_fantasia,
                    telefone: telefone,
                    email: email
                };
       
                // Faz uma solicitação AJAX POST para uma API
                $.ajax({
                    url: "http://localhost/crud-clientes/controller/ClienteController.php", // URL da API de exemplo
                    method: "POST",
                    data: dados,
                    success: function (data) {
                        debugger
                        alert("Dados Enviados com Sucesso");
                        // A função de sucesso é chamada quando a solicitação é bem-sucedida
                        // 'data' contém os dados retornados pela API (no formato JSON)

                        // Exibe os resultados na div 'resultado'
                        $("#resultado").html("<h2>Dados Enviados com Sucesso</h2><p>ID do Novo Post: " + data.id + "</p>");
                    },
                    error: function (err) {
                        debugger
                        // A função de erro é chamada se houver algum problema com a solicitação AJAX
                        $("#resultado").html("<p>Ocorreu um erro ao enviar os dados.</p>");
                    }
                });
            };
        }
        function validar_dados (){
               if($('#razao_social').val() == ""){
                    alert("o campo razão social é obrigatorio");
                    $('#razao_social').focus();
                    $('#razao_social').css('background', 'red');
                    return false;
                }
                if($('#nome_fantasia').val() == ""){
                    alert("o campo nome fantasia é obrigatorio");
                    $('#nome_fantasia').focus();
                    $('#nome_fantasia').css('background', 'red');
                    return false;
                }
                if($('#email').val() == ""){
                    alert("o campo email é obrigatorio");
                    $('#email').focus();
                    $('#email').css('background', 'red');
                    return false;
                }
                if($('#telefone').val() == ""){
                    alert("o campo telefone é obrigatorio");
                    $('#telefone').focus();
                    $('#telefone').css('background', 'red');
                    return false;
                }
                return true;
        }
    </script>
</body>
</html>