<?php

function enviarMail($nome, $para, $assunto_mail, $corpo_mail, $file)
{

    if (!isset($nome)) {
        $nome = "Utilizador";
    }


    require '../sendgrid-php/sendgrid-php.php';
    $APIkey = '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';


    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("lplabmm@gmail.com", "LP Vinyl Store");
    $email->setSubject($assunto_mail);
    $email->addTo($para, $nome);
    $email->addContent("text/html", $corpo_mail);
    if (isset($file)) {
        $file_encoded = base64_encode(file_get_contents('../faturas/invoice/' . $file));
        $email->addAttachment(
            $file_encoded,
            "application/pdf",
            $file,
            "attachment"
        );
    }
    $sendgrid = new \SendGrid($APIkey);
    try {
        $response = $sendgrid->send($email);
        print $response->statusCode() . "\n";
        print_r($response->headers());
        print $response->body() . "\n";
    } catch (Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
    }

}
