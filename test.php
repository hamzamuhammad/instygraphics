<?php
	include 'helper.php';
	$mail = new PHPMailer(true);

	$email_address = "hamzamuhammad@utexas.edu";
	//Typical mail data
	$mail->IsSMTP();
	$mail->AddAddress($email_address);
	$mail->SetFrom("webmaster@instygraphics.com");
	$mail->Subject = "My Subject";
	$mail->Body = 'Hello ' . $email_address . '!';

	try{
	    $mail->Send();
	    echo "Success!";
	} catch(Exception $e){
	    //Something went bad
	    echo "Fail - " . $mail->ErrorInfo;
	}
?>