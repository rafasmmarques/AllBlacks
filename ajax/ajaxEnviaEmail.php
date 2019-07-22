<?php
date_default_timezone_set('Etc/UTC');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/Exception.php';
include $_SERVER["DOCUMENT_ROOT"]."/classes/Banco.php";
include $_SERVER["DOCUMENT_ROOT"]."/components/credenciais.php";

$bd = new Banco($dados["usuario"], $dados["senha"], $dados["host"], $dados["porta"], $dados["banco"], "pgsql");

$pdo = $bd->connectPdo();

$torcedores = $bd->executaQuery($pdo,'SELECT * FROM torcedores ORDER BY id');

$bd->fechaBd($pdo);

if(isset($_POST)){
    $nome       = $_POST['nome'];
    $email      = $_POST['email'];
    $assunto    = $_POST['assunto'];
    $corpo      = $_POST['corpo'];
    $broadcast  = $_POST['broadcast'];

    $html = file_get_contents('../views/conteudoEmail.html');

    $corpo = str_replace('Olá Blacks,','<h2>Olá Blacks,</h2><p>',$corpo);

    $html = str_replace('MENSAGEM',$corpo,$html);

    $mail = new PHPMailer;

    $mail->CharSet = 'UTF-8';

    $mail->Encoding = 'base64';

    $mail->isSMTP();

    $mail->SMTPDebug = 2;

    $mail->Debugoutput = 'html';

    $mail->Host = 'smtp.gmail.com';

    $mail->Port = 587;

    $mail->SMTPSecure = 'tls';

    $mail->SMTPAuth = true;

    $mail->Username = "exemplo@gmail.com"; //email real (Gmail) para usar o host STMP da Google

    $mail->Password = "senha"; //senha real do email acima

    $mail->setFrom('exemplo@gmail.com', 'All Blacks'); //email real para enviar a mensagem (não necessariamente o mesmo usado para o host)

    if($broadcast === true){
        foreach ($torcedores as $dado){
            $mail->addAddress($dado['email'], $dado['nome']);

            $mail->Subject = $assunto;

            $mail->msgHTML($html);

            if (!$mail->send()) {
                $sendError = $mail->ErrorInfo;
            }

            $mail->ClearAllRecipients();
        }

        if(isset($sendError)){
            print_r(json_encode([false,'Erro ao enviar e-mail. Erro: '. $sendError]));
        }else{
            print_r(json_encode([true,'E-mail(s) enviado(s) com sucesso.']));
        }
    }else{
        $mail->addAddress($email, $nome); //email real para receber a mensagem

        $mail->Subject = $assunto;

        $mail->msgHTML($html);

        if (!$mail->send()) {
            print_r(json_encode([false,'Erro ao enviar e-mail. Erro: '. $mail->ErrorInfo]));
        } else {
            print_r(json_encode([true,'E-mail(s) enviado(s) com sucesso.','EMAILOK']));
        }
    }

}else{
    print_r(json_encode([false,'Erro ao receber dados do formulário.']));
}