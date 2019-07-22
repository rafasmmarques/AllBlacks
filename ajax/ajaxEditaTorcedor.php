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

    $id         = $_POST['id'];
    $nome       = $_POST['nome'];
    $documento  = $_POST['documento'];
    $cep        = $_POST['cep'];
    $endereco   = $_POST['endereco'];
    $bairro     = $_POST['bairro'];
    $cidade     = $_POST['cidade'];
    $telefone   = $_POST['telefone'];
    $email      = $_POST['email'];
    $uf         = $_POST['uf'];
    $ativo      = $_POST['ativo'];

    $update = $bd->executaQuery($pdo,"UPDATE torcedores SET nome='".$nome."',documento='".$documento."',cep='".$cep."',endereco='".$endereco."',bairro='".$bairro."',cidade='".$cidade."',telefone='".$telefone."',email='".$email."',uf='".$uf."' WHERE id='".$id."'");

    if($update === "" || $update === null){
        print_r(json_encode([false,'Erro ao buscar torcedor no Banco de Dados.',$update]));
    }else{
        print_r(json_encode([true,'Dados do torcedor '.$nome.' atualizados com sucesso.',$update]));
    }

    $bd->fechaBd($pdo);
}else{
    print_r(json_encode([false,'Erro ao receber dados do torcedor.']));
}
