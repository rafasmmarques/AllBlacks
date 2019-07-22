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

    $delete = $bd->executaQuery($pdo,"DELETE FROM torcedores WHERE id='".$id."'");

    if($delete === "" || $delete === null){
        print_r(json_encode([false,'Erro ao buscar torcedor no Banco de Dados.']));
    }else{
        print_r(json_encode([true,'Torcedor excluído com sucesso.',$delete]));
    }
}else{
    print_r(json_encode([false,'Erro ao receber dados do torcedor.']));
}

$bd->fechaBd($pdo);