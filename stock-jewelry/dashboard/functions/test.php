<?php

	/***
	Server SMTP/POP : mail.thaicreate.com
	Email Account : webmaster@thaicreate.com
	Password : 123456
	*/
	require_once('../../../plugins/phpmailer/PHPMailer.php');

  $phpmailer = new PHPMailer();
  $phpmailer->isSMTP();
  $phpmailer->Host = 'smtp.mailtrap.io';
  $phpmailer->SMTPAuth = true;
  $phpmailer->Port = 2525;
  $phpmailer->Username = '30426371117c96';
  $phpmailer->Password = 'cfe23131f7a165';
	$phpmailer->From = "webmaster@thaicreate.com"; // "name@yourdomain.com";
	//$mail->AddReplyTo = "support@thaicreate.com"; // Reply
	$phpmailer->FromName = "Mr.Weerachai Nukitram";  // set from Name
	$phpmailer->Subject = "Test sending mail."; 
	$phpmailer->Body = '<iframe width="560" height="315" src="https://www.youtube.com/embed/UPNkOwabRDY?autoplay=1&mute=1" title="YouTube video player" frameborder="0"></iframe>';

	$phpmailer->AddAddress("thanalop@ensurecomm.com"); // to Address

	$phpmailer->Send(); 
?>