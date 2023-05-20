<?php

namespace App\Service;
// require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

class SendMsg {
  public function getEmail($userName, $userEmail, $userSubject, $userMessage) {
    $email = "abhikrjha45@gmail.com";

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = "abhi31kr45@gmail.com";
    $mail->Password = "ylagckqsadjtgigz";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom("abhi31kr45@gmail.com");
    $mail->addAddress($email);
    $mail->Subject = "Contact by user!!!";
    $mail->isHTML(TRUE);
    $mail->Body = "<h3>Name : $userName <br> Email : $userEmail
    <br> Subject : $userSubject <br> $userMessage";
    $mail->send();
  }
}

?>
