<?php
session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));

header('Content-type: application/json');

require 'php-mailer/PHPMailerAutoload.php';

// Your email address
$to = 'lauryschell97@gmail.com';

$subject = $_POST['subject'];

if($to) {

	$name = $_POST['name'];
	$email = $_POST['email'];
	
	$fields = array(
		0 => array(
			'text' => 'Name',
			'val' => $_POST['name']
		),
		1 => array(
			'text' => 'Email address',
			'val' => $_POST['email']
		),
		2 => array(
			'text' => 'Message',
			'val' => $_POST['message']
		)
	);
	
	$message = "";
	
	foreach($fields as $field) {
		$message .= $field['text'].": " . htmlspecialchars($field['val'], ENT_QUOTES) . "<br>\n";
	}
	
//Create a new PHPMailer instance
    $mail = new PHPMailer;   
    $mail->isSMTP();
// change this to 0 if the site is going live
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = 'html';

    //$mail->Host = 'smtp.gmail.com';
    //$mail->Port = 587;

    $mail->Host = 'smtp.hostinger.com.ar';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';

 //use SMTP authentication
    $mail->SMTPAuth = true;
//Username to use for SMTP authentication
    $mail->Username = "pruebas@lauraschell.tech";
    $mail->Password = "pruebas";
	
    $mail->setFrom('pruebas@lauraschell.tech', 'Pruebas');
    $mail->addReplyTo('pruebas@lauraschell.tech', 'Pruebas');
    $mail->addAddress('schell.daniel@gmail.com', 'Daniel');
    $mail->Subject = 'New contact from somebody';
    // $message is gotten from the form
    $mail->msgHTML($message);
	$mail->AltBody = $filteredmessage;

	$arrResult = array ('response'=>'success');

	if(!$mail->Send()) {
	   $arrResult = array ('response'=>'error');
	}	

	echo json_encode($arrResult);
	
	/*
	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	//Set who the message is to be sent from
	$mail->setFrom('from@example.com', 'First Last');
	//Set an alternative reply-to address
	$mail->addReplyTo('replyto@example.com', 'First Last');
	//Set who the message is to be sent to
	$mail->addAddress($to, 'Laura');
	//Set the subject line
	$mail->Subject = 'PHPMailer mail() test';
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
    $mail->msgHTML($message);
	//Replace the plain text body with one created manually
	$mail->AltBody = 'This is a plain-text message body';
	//Attach an image file
	//$mail->addAttachment('images/phpmailer_mini.png');

	//send the message, check for errors
	if (!$mail->send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}
	*/
	
} else {

	$arrResult = array ('response'=>'error');
	echo json_encode($arrResult);

}
?>