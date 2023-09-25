# Crud-cliente

<!---Esses são exemplos. Veja https://shields.io para outras pessoas ou para personalizar este conjunto de escudos. Você pode querer incluir dependências, status do projeto e informações de licença aqui--->



<img src="src/public/crud-cliente.png" alt="exemplo imagem">

> Crud  para aula prática de programação  PHP,MYSQL,jQUERY.

### Ajustes e melhorias

tarefas:

- [x] Montagem do ambiente  no windows
- [x] criação da crud com PHP,Jquery,Ajax e Mysql
- [x] montar o ambiente no linux
- [ ] correção de erro instalar o módul PHP no apache
- [ ] corrigir erro de autentição Mysql  no ambiente linux
- [x] corrigir a função inserir cliente
- [x] criação do banco de dados e das tbelas
- [ ] refazer a crud com um microframework
- [ ] Fazer uma API em laravel e  consumir com Jequery e Ajax
- [ ] 
- [ ] depuração do código com test automatizado

## 💻 Pré-requisitos

Antes de começar, verifique se você atendeu aos seguintes requisitos:
<!---Estes são apenas requisitos de exemplo. Adicionar, duplicar ou remover conforme necessário--->
* Você instalou a versão mais recente de `<PHP/MYSQL/ PDO>`
* Você tem uma máquina `<Windows / Linux />`.
## 🚀 Instalando ambiente no windows 
Para montar o ambiente no windows, siga estas etapas:

Windows:
  1. instalação do Laragon 
  2. instalação  do MYSQL 
  3. instalação do vscode
  4. instalar plugin mysql no vscode
  

Linux :
 1. instalação do PHP 
 2. instalação do apache
 3. instalação do mysql
 4. configuração do mysql
 3. Habilitar modo de autenticação do MYSQL antiga no linux para logar com phpMyadmin
 ```
Correção  do erro de autentição Mysql com o vsCode no ubuntu execute:
sudo mysql
SELECT user,authentication_string,plugin,host FROM mysql.user;
para o modo nativo o mais antigo
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';

FLUSH PRIVILEGES;
```



## ☕ Usando crud-cliente>

Para usar crud-cliente, siga estas etapas:

```
<exemplo_de_uso>
```



## 📫 Contribuindo para crud-cliente
<!---Se o seu README for longo ou se você tiver algum processo ou etapas específicas que deseja que os contribuidores sigam, considere a criação de um arquivo CONTRIBUTING.md separado--->
Para contribuir com crud-cliente, siga estas etapas:

1. Bifurque este repositório.
2. Crie um branch: `git checkout -b <nome_branch>`.
3. Faça suas alterações e confirme-as: `git commit -m '<mensagem_commit>'`
4. Envie para o branch original: `git push origin <nome_do_projeto> / <local>`
5. Crie a solicitação de pull.

Como alternativa, consulte a documentação do GitHub em [como criar uma solicitação pull](https://help.github.com/en/github/collaborating-with-issues-and-pull-requests/creating-a-pull-request).

## 🤝 Colaboradores

## 😄 Seja um dos contribuidores<br>

Quer fazer parte desse projeto? Clique [AQUI](CONTRIBUTING.md) e leia como contribuir.

## 📝 Licença

Esse projeto está sob licença. Veja o arquivo [LICENÇA](LICENSE.md) para mais detalhes.

[⬆ Voltar ao topo](#crud-cliente)<br>
