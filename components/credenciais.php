<?php

    $str = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/components/psql.ini");

    $dados = json_decode($str, true);

    $bancoClassTeste = new Banco($dados["usuario"], $dados["senha"],
            $dados["host"], $dados["porta"], $dados["banco"], "pgsql");

    $conn = $bancoClassTeste->connectPdo();