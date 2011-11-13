<?php
//$to = "coffbr01@gmail.com, create@philipjordandesign.com";
$to = "coffbr01@gmail.com";
$subject = "subject";                                                    
$random_hash = md5(time());
$name = $_FILES["fileInput"]["name"];
$attachment = base64_encode(file_get_contents($_FILES["fileInput"]["tmp_name"]));

ob_start();
?>
From: coffbr01@gmail.com 
MIME-Version: 1.0 
Content-Type: multipart/mixed; boundary=<?php echo $random_hash ?> 

This is a multi part email message. 
--<?php echo $random_hash; ?> 
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit 

<p>PDF should be attached.</p> 

--<?php echo $random_hash; ?> 
Content-Type: application/octet-stream; name="<?php echo $name; ?>" 
Content-Transfer-Encoding: base64 
Content-Disposition: attachment 

<?php echo $attachment; ?> 
--<?php echo $random_hash; ?>-- 

<?php
$headers = ob_get_clean();

mail($to, $subject, "", $headers); 
?>
thanks
