<?php
    if(session_id()=="")
    {
        session_start();
    }

    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 'On');

    include $_SERVER["DOCUMENT_ROOT"]."/classes/Banco.php";
    include $_SERVER["DOCUMENT_ROOT"]."/components/credenciais.php";

    $bd = new Banco($dados["usuario"], $dados["senha"], $dados["host"], $dados["porta"], $dados["banco"], "pgsql");

    $pdo = $bd->connectPdo();

    $verifica = $bd->verificaECriaTabela($pdo,'usuarios','CREATE TABLE usuarios (id SERIAL PRIMARY KEY NOT NULL, email TEXT NOT NULL UNIQUE, senha TEXT NOT NULL)');

    $torcedores = $bd->executaQuery($pdo,"INSERT INTO usuarios (email, senha) VALUES ('suporte@allblacks.com', '1q2w3e4r,') ON CONFLICT (email) DO NOTHING");

    $bd->fechaBd($pdo);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel='shortcut icon' href='../public/images/all-blacks-icon.jpg' type='image/x-icon'/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>AllBlacks - Login</title>
        <?php include('../components/header.php'); ?>
        <link href="../public/css/login.css" rel="stylesheet">
    </head>

    <body class="hidden-sn">
    <header>
        <?php include('../components/navbar.php'); ?>
        <div class="progress">
            <div id="progressBarLogin" style="display: none" class="indeterminate"></div>
        </div>
    </header>
    <main>
        <form id="loginForm" method="POST" action="">
            <div class="conteudo">

                <div title="Digite seu usuário" id="formusuario" class="md-form">
                    <input type="text" id="formuser" class="form-control input-login" required>
                    <label for="formuser">Usuário</label>
                </div>

                <div class="md-form" style="margin-bottom: 0">
                    <input type="password" id="formpass" class="form-control input-login" required>
                    <label title="Digite sua senha" for="formpass">Senha</label>
                    <i class="fa fa-eye-slash fa-lg white-text icon-senha" aria-hidden="true" data-toggle="tooltip" title="Mostrar senha"></i>
                </div>
                <div class='divinput'>
                    <input class="botao" type="submit" name="enviar"/>
                </div>

            </div>
        </form>
    </main>
    <?php include('../components/footer.php'); ?>
    <script type="text/javascript" src="../public/js/login.js"></script>
    </body>
</html>