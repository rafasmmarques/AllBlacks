# DESAFIO TÉCNICO - All Blacks

Solução web para o cadastro e manutenção de torcedores da All Blacks.

## Componentes

Essa solução foi desenvolvida com os seguintes componentes e bibliotecas:

 - PHP 7.2
 - Javascript ES6
 - jQuery 3.1.1
 - MDBootstrap
 - PostgreSQL 9.6
 - PhpSpreadSheet
 - PhpMailer
 - jQuery Datatables

## Banco de Dados
Dentro do projeto, existe um arquivo 'psql.ini' na pasta 'componentes'. Esse arquivo é usado para autenticação do banco de dados na aplicação.
Em anexo neste projeto, está o arquivo 'dump_sql.txt' para a configuração do banco de dados. Neste arquivo vem uma configuração padrão para a autenticação na aplicação (usuário e senha), recomenda-se não alterá-la para evitar refatoração de código em arquivos que usam a conexão com o banco.
>Nota: é imprescindível a utilização da versão 9.5 ou superior do PostgreSQL para a aplicação funcionar corretamente.

## Alertas

Para o envio de alertas por e-mail aos torcedores, foi usado a biblioteca **PhpMailer**. 
O arquivo 'ajaxEnviaEmail.php', na pasta 'ajax', contém todas as configurações para o envio de e-mail para os torcedores. Recomenda-se também não alterar as configurações deste arquivo para a funcionalidade da aplicação. 
(alterar apenas as linhas 53 e 55 com um endereço e senha Gmail válidos para o uso do servidor SMTP da própria Google).
>53 $mail->Username = "email@gmail.com"; 
>55 $mail->Password = "senha";

## Primeiros Passos
A aplicação conta com uma página de login para autenticação (o usuário e senha estão no arquivo 'dump_sql.txt' mencionado anteriormente). 
Após realizado o login, você irá para a página principal da aplicação onde se encontra o botão para upload de arquivos (conforme as figuras 1 e 2 abaixo).

![Figura 1](https://i.imgur.com/Kcqcd8r.png)

![Figura 2](https://i.imgur.com/rUXbKtm.png)

Na segunda seção da página está a tabela dos torcedores da All Blacks, porém, não haverá nenhum conteúdo nela ainda. Basta indexar os clientes da planilha excel e depois atualizar a tabela com os torcedores do arquivo XML.