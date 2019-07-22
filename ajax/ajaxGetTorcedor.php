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

    $id = $_POST['id'];

    $busca = $bd->executaQuery($pdo,"SELECT * FROM torcedores WHERE id='".$id."'");

    if($busca === "" || $busca === null || $busca === []){
        print_r(json_encode([false,'Erro ao buscar torcedor no Banco de Dados.']));
    }else{
        print_r(json_encode([true,$busca]));
    }
}else{
    print_r(json_encode([false,'Erro ao receber dados do torcedor.']));
}

$bd->fechaBd($pdo);