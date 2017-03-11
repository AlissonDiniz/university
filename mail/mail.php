<?php


/* apenas dispara o envio da mensagem caso houver/existir $_POST['enviar'] */
if (isset($_GET['send'])) {

    /*     * ********************************* A PARTIR DAQUI NAO ALTERAR *********************************** */

    require("PHPMailerAutoload.php");

    $To = 'alisson.trial@gmail.com';
    $Subject = 'Teste de Email';
    $Message = 'Teste de Email - Mensagem';
    $Host = 'smtp.destaqueformaturas.com';
    $Username = 'contas@destaqueformaturas.com';
    $Password = 'cont@sdest@que';
    $Port = "587";

    $mail = new PHPMailer();
    $body = $Message;
    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->Host = $Host; // SMTP server
    $mail->SMTPDebug = 0; // enables SMTP debug information (for testing)
    $mail->SMTPAuth = true; // enable SMTP authentication
    $mail->Port = $Port; // set the SMTP port for the service server
    $mail->Username = $Username; // account username
    $mail->Password = $Password; // account password

    $mail->SetFrom($usuario, $nomeDestinatario);
    $mail->Subject = $Subject;
    $mail->MsgHTML($body);
    $mail->AddAddress($To, "");

    if (!$mail->Send()) {
        $mensagemRetorno = 'Erro ao enviar e-mail: ' . print($mail->ErrorInfo);
    } else {
        $mensagemRetorno = 'E-mail enviado com sucesso!';
    }
}else{
    echo "FALTA O ENVIAR";
}
?>