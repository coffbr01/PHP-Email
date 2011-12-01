<?php
include "email.php";

$mail = new EMail();
//$mail->setTo("create@philipjordandesign.com");
$mail->setTo("coffbr01@gmail.com");
$mail->setFrom("noreply@mybusiness.com");
$mail->setSubject("This is the subject of the email");
$mail->setMessage("This is the body of the email");

$attachmentNameArray = array($_FILES["fileInput"]["name"], $_FILES["fileInput2"]["name"]);
$attachmentFileNameArray = array($_FILES["fileInput"]["tmp_name"], $_FILES["fileInput2"]["tmp_name"]);
$mail->setAttachName($attachmentNameArray);
$mail->setAttachFileName($attachmentFileNameArray);

$result = $mail->SendMail();
echo $result[1];
?>
