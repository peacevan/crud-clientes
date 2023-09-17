<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Cliente</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../public/css/style.css">
</head>
<body>
    <div id="cabecalho">
        <h1>Cadastro de cliente</h1>
    </div>
   
    <div  id="body">

    <form id="formulario">
        <h3>Dados Do Cliente</h3>
        <label for="razao_social">Razão social:</label>
        <input type="text" id="razao_social" name="razao_social">
        <br>
        <br>
        <label for="nome_fantasia">Nome fantasia:</label>
        <input type="text" id="nome_fantasia" name="nome_fantasia">
               <br>
        <br>
        <label for="cnpj">CNPJ:</label>
        <input type="text" id="cnpj" name="nome_fantasia">
        <br>
        <br>
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone">
        <br>
        <br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email">
        <br>
        <hr>
        <hr>
        <h3>Endereço</h3>
        <br>
        <br>

        <label for="logradouro">Logradouro:</label>
        <input type="text" id="logradouro" name="logradouro">
        <br>
        <br>
        <label for="bairro">Bairro:</label>
        <input type="text" id="bairro" name="bairro">
        <br>
        <br>
        <label for="numero">Numero:</label>
        <input type="text" id="numero" name="numero">
        <br>
        <br>
        <label for="estado">Estado:</label>
        <input type="text" id="estado" name="estado">
        <br>
        <br>
        <label for="municipio">municipio:</label>
        <input type="text" id="municipio" name="municipio">
        <br>
        <br>
        <label for="pais">Pais:</label>
        <input type="text" id="pais" name="pais">
        <br>
        <br>
        <label for="cep">CEP:</label>
        <input type="text" id="cep" name="cep">
        <br>
        <br>
        <button onclick="enviar_dados()">Enviar</button>
        <button onclick=" preencheformulário()">Carregar Dados</button>
        <br>
       <br>
       
    </form>
    </div>

    <div id="resultado">
        <!-- Os resultados da solicitação AJAX serão exibidos aqui -->
    </div>
    <?php
    
    ?>


    <script>
        $(document).ready(function () {
          
          
        });
        function enviar_dados(){
            event.preventDefault(); // Impede o comportamento padrão do formulário
            if (validar_dados ()){
                debugger
               
                // Obtem os dados do formulário
                var razao_social  = $("#razao_social").val();
                var nome_fantasia = $("#nome_fantasia").val();
                var telefone      = $("#telefone").val();
                var email         = $("#email").val();
                var cnpj         = $("#cnpj").val();


                // Cria um objeto com os dados a serem enviados

                var dadosEndereco = {
                    logradouro: $("#logradouro").val(),
                    bairro: $("#bairro").val(),
                    numero: $("#numero").val(),
                    estado: $("#estado").val(),
                    municipio: $("#municipio").val(),
                    pais: $("#pais").val(),
                    cep: $("#cep").val()
                }
                var dados = {
                    razao_social: razao_social,
                    nome_fantasia: nome_fantasia,
                    telefone: telefone,
                    email: email,
                    cnpj: cnpj,
                    endereco: dadosEndereco
                };
                
                // Faz uma solicitação AJAX POST para uma API
                $.ajax({
                    url: "http://localhost:81/src/Controller/ClienteController.php", // URL da API de exemplo
                    method: "POST",
                    data: dados,
                    success: function (data) {
                        console.log(data);
                        //alert(data.message);
                        // A função de sucesso é chamada quando a solicitação é bem-sucedida
                        // 'data' contém os dados retornados pela API (no formato JSON)
                        // Exibe os resultados na div 'resultado'
                        $("#resultado").html("<h2>Dados Enviados com Sucesso</h2><p>ID do Novo Post: " + data.id + "</p>");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        debugger
                        console.log("Erro na requisição AJAX: " +errorThrown);
                        alert("Dados Enviados com Sucesso");
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
                    $('#razao_social').css('border', '1px solid #d71919');
                    return false;
                }
                if($('#nome_fantasia').val() == ""){
                    alert("o campo nome fantasia é obrigatorio");
                    $('#nome_fantasia').focus();
                    $('#nome_fantasia').css('border', '1px solid #d71919');
                    return false;
                }
                if($('#email').val() == ""){
                    alert("o campo email é obrigatorio");
                    $('#email').focus();
                    $('#email').css('border', '1px solid #d71919');
                    return false;
                }
                if($('#telefone').val() == ""){
                    alert("o campo telefone é obrigatorio");
                    $('#telefone').focus();
                    $('#telefone').css('border', '1px solid #d71919');
                    return false;
                }
                return true;
        }

         function preencheformulário(){
            event.preventDefault(); // Impede o comportamento padrão do formulário
            $("#razao_social").val("Empresa ABC");
            $("#nome_fantasia").val("Empresa ABC");
            $("#telefone").val("123456789");
            $("#email").val("contato@empresa.com");
            $("#cnpj").val("123456789");
            //endereço 
            $("#logradouro").val("Rua ABC");
            $("#bairro").val("Bairro ABC");
            $("#numero").val("123");
            $("#estado").val("Bahia");
            $("#municipio").val("Salvador");
            $("#pais").val("Brasil");
            $("#cep").val("12345-678");
         }
    </script>
</body>
</html>