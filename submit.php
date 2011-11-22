<?php
include "email.php";

$mail = new EMail();
//$mail->setTo("create@philipjordandesign.com");
$mail->setTo("coffbr01@gmail.com");
$mail->setFrom("coffbr01@gmail.com");
$mail->setSubject("This is the subject of the email");
$mail->setMessage("This is the body of the email");
$mail->setAttachName($_FILES["fileInput"]["name"]);
$mail->setAttachFileName($_FILES["fileInput"]["tmp_name"]);
$result = $mail->SendMail();
echo $result[1];
?>
