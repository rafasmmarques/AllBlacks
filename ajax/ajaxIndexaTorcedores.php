<?php
if(session_id()=="")
{
    session_start();
}

require '../vendor/autoload.php';
include $_SERVER["DOCUMENT_ROOT"]."/classes/Banco.php";
include $_SERVER["DOCUMENT_ROOT"]."/components/credenciais.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$bd = new Banco($dados["usuario"], $dados["senha"], $dados["host"], $dados["porta"], $dados["banco"], "pgsql");

$pdo = $bd->connectPdo();

    if ( 0 < $_FILES['file']['error'] ) {
        print_r(json_encode([false,'Erro: ' . $_FILES['file']['error']]));
    }else{

        $fileName = $_SERVER['DOCUMENT_ROOT'].'/files/clientes.xlsx';

        move_uploaded_file($_FILES['file']['tmp_name'], $fileName);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        try{
            $spreadsheet = $reader->load($fileName);
            $worksheet = $spreadsheet->getActiveSheet()->toArray();
            $arrayTorcedores = array_slice($worksheet, 1);

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

            for($i = 0; $i < count($arrayTorcedores); $i++){

                if(preg_match("/\'/m", $arrayTorcedores[$i][0]) === 1){
                    $arrayTorcedores[$i][0] = preg_replace("/\'/",'',$arrayTorcedores[$i][0]);
                }
                if(preg_match("/\'/m", $arrayTorcedores[$i][3]) === 1){
                    $arrayTorcedores[$i][3] = preg_replace("/\'/",'',$arrayTorcedores[$i][0]);
                }
                if(preg_match("/\'/m", $arrayTorcedores[$i][5]) === 1){
                    $arrayTorcedores[$i][5] = preg_replace("/\'/",'',$arrayTorcedores[$i][0]);
                }

                $indexa = $bd->executaQuery($pdo,"INSERT INTO torcedores (id, nome, documento, cep, endereco, bairro, cidade, uf, telefone, email, ativo) 
                                        VALUES ('".$arrayTorcedores[$i][1]."','".$arrayTorcedores[$i][0]."','".$arrayTorcedores[$i][1]."','".$arrayTorcedores[$i][2]."',
                                        '".$arrayTorcedores[$i][3]."','".$arrayTorcedores[$i][4]."','".$arrayTorcedores[$i][5]."',
                                        '".$arrayTorcedores[$i][6]."','".$arrayTorcedores[$i][7]."','".$arrayTorcedores[$i][8]."','".$arrayTorcedores[$i][9]."') ON CONFLICT (documento) DO NOTHING");

                array_push($idArray, $arrayTorcedores[$i][1]);
                array_push($nome, $arrayTorcedores[$i][0]);
                array_push($documento, $arrayTorcedores[$i][1]);
                array_push($cep, $arrayTorcedores[$i][2]);
                array_push($endereco, $arrayTorcedores[$i][3]);
                array_push($bairro, $arrayTorcedores[$i][4]);
                array_push($cidade, $arrayTorcedores[$i][5]);
                array_push($uf, $arrayTorcedores[$i][6]);

                if(isset($arrayTorcedores[$i][7])){
                    array_push($telefone, $arrayTorcedores[$i][7]);
                }else{
                    array_push($telefone, "");
                }

                if(isset($arrayTorcedores[$i][8])){
                    array_push($email, $arrayTorcedores[$i][8]);
                }else{
                    array_push($email, "");
                }

                array_push($ativo, $arrayTorcedores[$i][9]);
            }

            print_r(json_encode([true,'Planilha carregada com sucesso.',[$idArray,$nome,$documento,$cep,$endereco,$bairro,$cidade,$uf,$telefone,$email,$ativo]]));
        }catch(\PhpOffice\PhpSpreadsheet\Reader\Exception $e){

            print_r(json_encode([false,'Erro ao carregar arquivo: '.$e->getMessage()]));
        }



    }

$bd->fechaBd($pdo);