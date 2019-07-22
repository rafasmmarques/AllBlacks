<?php
    if(session_id()=="")
    {
        session_start();
    }

    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 'On');

    require_once $_SERVER['DOCUMENT_ROOT'] . '/login/checklog.php';
    include $_SERVER["DOCUMENT_ROOT"]."/classes/Banco.php";
    include $_SERVER["DOCUMENT_ROOT"]."/components/credenciais.php";

    $bd = new Banco($dados["usuario"], $dados["senha"], $dados["host"], $dados["porta"], $dados["banco"], "pgsql");

    $pdo = $bd->connectPdo();

    $verifica = $bd->verificaECriaTabela($pdo,'torcedores','CREATE TABLE torcedores (id TEXT PRIMARY KEY NOT NULL, nome TEXT NOT NULL, documento TEXT NOT NULL UNIQUE, cep TEXT NOT NULL, endereco TEXT NOT NULL, bairro TEXT NOT NULL, cidade TEXT NOT NULL, uf TEXT NOT NULL, telefone TEXT, email TEXT, ativo TEXT NOT NULL )');

    $torcedores = $bd->executaQuery($pdo,'SELECT * FROM torcedores ORDER BY nome');

    $bd->fechaBd($pdo);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel='shortcut icon' href='public/images/all-blacks-icon.jpg' type='image/x-icon'/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>AllBlacks - Torcedores</title>
        <?php include('components/header.php'); ?>
    </head>
    <body style="background-color: #e7efee;">
    <header>
        <?php include('components/navbar.php'); ?>
        <div class="progress lime">
            <div id="progressBar" style="display: none" class="indeterminate black"></div>
        </div>
    </header>
    <main>
        <!--Accordion wrapper-->
        <div class="card m-3">
            <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">


                <!-- Accordion card -->
                <div class="card">

                    <!-- Card header -->
                    <div class="card-header" role="tab" id="headingOne1">
                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="true"
                           aria-controls="collapseOne1" style="color: #2e2e2e;!important;">
                            <h5 class="mb-0">
                                <i class="fa fa-question-circle pl-1" aria-hidden="true" data-toggle="tooltip"
                                   title="Apenas extensões '.xlsx' e '.xml'"
                                   style="font-size: 75%"></i>
                                Upload de Arquivo <i class="fas fa-angle-down rotate-icon"></i>
                            </h5>
                        </a>
                    </div>

                    <!-- Card body -->
                    <div id="collapseOne1" class="collapse show" role="tabpanel" aria-labelledby="headingOne1"
                         data-parent="#accordionEx">
                        <div class="card-body">
                            <div class="p-3">
                                <form id="formEnviaXML">

                                    <div class="row my-3">
                                        <div class="col">
                                            <div class="file-field">
                                                <div class="btn btn-elegant waves-effect btn-sm float-left" style="line-height: 0.5rem;">
                                                    <span><i class="fas fa-upload"></i></span>
                                                    <input type="file" id="arquivoAnexado">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input id="nomeArquivo" class="file-path validate disabled"  type="text" placeholder="Carregar aquivo" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="button" onclick="btnSubmitForm()" class="btn btn-elegant waves-effect btn-md float-right">Enivar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Accordion card -->

                <!-- Accordion card -->
                <div class="card">

                    <!-- Card header -->
                    <div class="card-header" role="tab" id="headingTwo2">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2"
                           aria-expanded="false" aria-controls="collapseTwo2" style="color: #2e2e2e;">
                            <h5 class="mb-0">
                                Torcedores Cadastrados <i class="fas fa-angle-down rotate-icon"></i>
                            </h5>
                        </a>
                    </div>

                    <!-- Card body -->
                    <div id="collapseTwo2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2"
                         data-parent="#accordionEx">
                        <div class="card-body">
                            <div class="p-3">
                                <table id="tabelaTorcedores" class="stripe row-border hover">
                                    <thead>
                                    <tr class="text-center">
                                        <th>Nome</th>
                                        <th>Documento</th>
                                        <th>CEP</th>
                                        <th>Endereço</th>
                                        <th>Bairro</th>
                                        <th>Cidade</th>
                                        <th>UF</th>
                                        <th>Telefone</th>
                                        <th>E-mail</th>
                                        <th>Ativo</th>
                                        <th>Editar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if(is_array($torcedores) || is_object($torcedores)){
                                        foreach ($torcedores as $dado){?>
                                            <tr id="<?=$dado['id']?>">
                                                <td><?=$dado['nome']?></td>
                                                <td><?=preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/',"\$1.\$2.\$3/\$4-\$5",$dado['documento'])?></td>
                                                <td><?=preg_replace('/([0-9]{5})([0-9]{3})/',"\$1-\$2",$dado['cep'])?></td>
                                                <td><?=$dado['endereco']?></td>
                                                <td><?=$dado['bairro']?></td>
                                                <td><?=$dado['cidade']?></td>
                                                <td><?=$dado['uf']?></td>
                                                <td><?=preg_replace('/([0-9]{2})([0-9]{3,5})([0-9]{4})/',"(\$1)\$2-\$3",$dado['telefone'])?></td>
                                                <td><?=$dado['email']?></td>
                                                <td><?=$dado['ativo']?></td>
                                                <td><a onclick="modalEditaTorcedor(this)"><i class="fas fa-edit"></i></a></td>
                                            </tr>
                                    <?php }
                                    }else{ ?>
                                        <h5>Não há torcedores indexados no momento.</h5>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Accordion card -->

            </div>
        </div>
        <!-- Accordion wrapper -->
        <?php include('views/modalEditaTorcedor.php'); ?>
        <?php include('views/modalConfirmaExclusao.php'); ?>
        <?php include('views/modalAlertaTorcedor.php'); ?>
    </main>
    <?php include('components/footer.php'); ?>
    <script type="text/javascript" src="public/js/index.js"></script>
    </body>
</html>