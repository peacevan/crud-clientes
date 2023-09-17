

<?php 
     include_once '../../src/view/header.php';
    ?>
<body>


   

    <div  id="body">
    <?php 
     include_once '../../src/view/siderbar.php';
    ?>

    <form id="formulario">
        <div>
  
        <h3>Dados Do Cliente</h3>
        <input type="hidden" id="id" name="id">
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
        </div>
        <hr>
        <div>
        <h3>Endereço Do Cliente</h3>
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
       </div>
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
            debugger;
            $("#id").val(44);

            if($('#id').val() != ''){
                loadFormularioAjax($('#id').val()); 
            }
  
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
                var cnpj          = $("#cnpj").val();
                var id          = $("#id").val();
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
                    id: id,
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
                    method: "PUT",
                   // dataType: "json",
                    data: dados,
                    success: function (data) {
                        console.log(data);
                        //var objeto = JSON.parse(data);
                       // alert(objeto.message);
                        // A função de sucesso é chamada quando a solicitação é bem-sucedida
                        // 'data' contém os dados retornados pela API (no formato JSON)
                        // Exibe os resultados na div 'resultado'

                        // Limpa o formulário
                        $('#formulario').each (function(){
                       // this.reset();
                       });
                     },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("Erro na requisição AJAX:"+errorThrown);
                        alert("Erro ao Cadastrar Cliente");

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
         function loadFormularioAjax(id_cliente){
            
            $('#id').val(id_cliente);
            $.ajax({
                    url: "http://localhost:81/src/Controller/ClienteController.php?id="+id_cliente, // URL da API de exemplo
                    method: "GET",
                    //data: dados,    
                    success: function (data) {
                        debugger;
                        console.log(data['data']);
              
                        data=JSON.parse(data).data[0];
                        $("#razao_social").val(data.razao_social);
                        $("#nome_fantasia").val(data.nome_fantasia);
                        $("#telefone").val(data.telefone);
                        $("#email").val(data.email);
                        $("#cnpj").val(data.cnpj);
                        //endereço 
                        $("#logradouro").val(data.logradouro);
                        $("#bairro").val(data.bairro);
                        $("#numero").val(data.numero);
                        $("#estado").val(data.estado);
                        $("#municipio").val(data.municipio);
                        $("#pais").val(data.pais);
                        $("#cep").val(data.cep);

                        
                    }, 
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert("cliente não encontrado");
                    }
            });

         }
    </script>
</body>
</html>