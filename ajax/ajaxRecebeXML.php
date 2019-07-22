<?php
if(session_id()=="")
{
    session_start();
}

include $_SERVER["DOCUMENT_ROOT"]."/classes/Banco.php";
include $_SERVER["DOCUMENT_ROOT"]."/components/credenciais.php";

$bd = new Banco($dados["usuario"], $dados["senha"], $dados["host"], $dados["porta"], $dados["banco"], "pgsql");

$pdo = $bd->connectPdo();

if ( 0 < $_FILES['file']['error'] ) {

    print_r(json_encode([false,'Erro: ' . $_FILES['file']['error']]));
}else {

    $fileName = $_SERVER['DOCUMENT_ROOT'] . '/files/torcedores.xml';

    move_uploaded_file($_FILES['file']['tmp_name'], $fileName);

    $result = file_get_contents($fileName);

    if ($result === false) {
        print_r(json_encode([false,'Erro ao extrair dados do XML.']));
    }else{
        $xml = simplexml_load_string($result);

        $json = json_encode($xml);

        $array = json_decode($json,true);

        $nome       = [];
        $documento  = [];
        $cep        = [];
        $endereco   = [];
        $bairro     = [];
        $cidade     = [];
        $uf         = [];
        $telefone   = [];
        $email      = [];
        $ativo      = [];
        $idArray    = [];

        foreach ($array['torcedor'] as $dados){

            if(preg_match("/\'/m", $dados["@attributes"]["nome"]) === 1){
                $dados["@attributes"]["nome"] = preg_replace("/\'/",'',$dados["@attributes"]["nome"]);
            }
            if(preg_match("/\'/m", $dados["@attributes"]["endereco"]) === 1){
                $dados["@attributes"]["endereco"] = preg_replace("/\'/",'',$dados["@attributes"]["endereco"]);
            }
            if(preg_match("/\'/m", $dados["@attributes"]["cidade"]) === 1){
                $dados["@attributes"]["cidade"] = preg_replace("/\'/",'',$dados["@attributes"]["cidade"]);
            }

            if($dados["@attributes"]["ativo"] === '1'){
                $dados["@attributes"]["ativo"] = 'SIM';
            }else{
                $dados["@attributes"]["ativo"] = 'NÃO';
            }

            $indexa = $bd->executaQuery($pdo,"INSERT INTO torcedores (id, nome, documento, cep, endereco, bairro, cidade, uf, telefone, email, ativo) 
                                                        VALUES ('".$dados["@attributes"]["documento"]."','".$dados["@attributes"]["nome"]."','".$dados["@attributes"]["documento"]."','".$dados["@attributes"]["cep"]."','".$dados["@attributes"]["endereco"]."',
                                                        '".$dados["@attributes"]["bairro"]."','".$dados["@attributes"]["cidade"]."','".$dados["@attributes"]["uf"]."',
                                                        '".$dados["@attributes"]["telefone"]."','".$dados["@attributes"]["email"]."','".$dados["@attributes"]["ativo"]."') ON CONFLICT (documento) DO NOTHING");

            array_push($idArray, $dados["@attributes"]["documento"]);
            array_push($nome, $dados["@attributes"]["nome"]);
            array_push($documento, $dados["@attributes"]["documento"]);
            array_push($cep, $dados["@attributes"]["cep"]);
            array_push($endereco, $dados["@attributes"]["endereco"]);
            array_push($bairro, $dados["@attributes"]["bairro"]);
            array_push($cidade, $dados["@attributes"]["cidade"]);
            array_push($uf, $dados["@attributes"]["uf"]);

            if(isset($dados["@attributes"]["telefone"])){
                array_push($telefone, $dados["@attributes"]["telefone"]);
            }else{
                array_push($telefone, "");
            }

            if(isset($dados["@attributes"]["email"])){
                array_push($email, $dados["@attributes"]["email"]);
            }else{
                array_push($email, "");
            }

            if($dados["@attributes"]["ativo"] === '1'){
                $dados["@attributes"]["ativo"] = 'SIM';
            }else{
                $dados["@attributes"]["ativo"] = 'NÃO';
            }

            array_push($ativo, $dados["@attributes"]["ativo"]);

        }
        if($indexa !== null && $indexa !== "" && $indexa !== false){
            print_r(json_encode([true,'Torcedores indexados com sucesso.',[$idArray,$nome,$documento,$cep,$endereco,$bairro,$cidade,$uf,$telefone,$email,$ativo]]));
        }else{
            print_r(json_encode([false,'Erro ao indexar dados do XML no Banco de Dados. Erro: '.$bd->error]));
        }
    }
}

$bd->fechaBd($pdo);

