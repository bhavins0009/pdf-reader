<?php
exit('test.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'PHPMailer/src/PHPMailer.php';
$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = 'send.one.com';
$mail->SMTPAuth = true;
$mail->Username = 'test@softinform.in';
$mail->Password = '$fq:!e]FHg6^~rR&';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->addReplyTo('info@softinform.dk', 'Softinform');

// Add a recipient
$mail->addAddress('bhavin.smart@gmail.com');

// Add cc or bcc
$mail->addCC('bs@softinform.dk');
$mail->addBCC('ds@softinform.dk');

// Email subject
$mail->Subject = 'Send Email via SMTP using PHPMailer';

// Set email format to HTML
$mail->isHTML(true);

// Email body content
$mailContent = 'Bhavin Solanki Pote';

$mail->Body = $mailContent;

// Send email
if(!$mail->send()){

echo 'Message could not be sent.';
echo 'Mailer Error: ' . $mail->ErrorInfo;
}else{
echo 'Message has been sent';
}