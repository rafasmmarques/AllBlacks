<?php
if(session_id()=="")
{
    session_start();
}

include $_SERVER["DOCUMENT_ROOT"]."/classes/Banco.php";
include $_SERVER["DOCUMENT_ROOT"]."/components/credenciais.php";

$bd = new Banco($dados["usuario"], $dados["senha"], $dados["host"], $dados["porta"], $dados["banco"], "pgsql");

$pdo = $bd->connectPdo();


if(isset($_POST)){

    $email = $_POST['usuario'];
    $senha = $_POST['senha'];

    $usuarios = $bd->executaQuery($pdo, "SELECT * FROM usuarios WHERE email='".$email."' AND senha='".$senha."'");

    if($usuarios === "" || $usuarios === null || $usuarios === []){
        print_r(json_encode([false,'INCORRECTAUT','Usuário e/ou senha incorreta. Tente Novamente ou verifique a conexão.']));
    }else{
        $_SESSION['usuario'] = $usuarios[0]['email'];

        print_r(json_encode([true,'LOGGED',$_SESSION['usuario']]));
    }
}else{
    print_r(json_encode([false,'CNNTCONN','Erro ao receber dados do formulário.']));
}

$bd->fechaBd($pdo);