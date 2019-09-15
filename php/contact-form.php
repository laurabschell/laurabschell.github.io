<?php
session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));

header('Content-type: application/json');

require 'php-mailer/PHPMailerAutoload.php';

// Your email address
$to = 'laurabelenschell@gmail.com';
$name = 'Laura';

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
// change this from 2 to 0 if the site is going live
    $mail->SMTPDebug = 0;//2;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.hostinger.com.ar';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';

 //use SMTP authentication
    $mail->SMTPAuth = true;
//Username to use for SMTP authentication
    $mail->Username = "contact@lauraschell.tech";
    $mail->Password = "adminturrado";
	
    $mail->setFrom('contact@lauraschell.tech', 'Contact');
    $mail->addReplyTo($_POST['email'], $_POST['name']);
    
//Recipients
    $mail->addAddress($to,$name);
	//$mail->addAddress('schell.daniel@gmail.com', 'Daniel');
	$mail->addBCC('schell.daniel@gmail.com', 'Daniel');
	
    $mail->Subject = 'New contact from lauraschell.tech';
// $message is gotten from the form
    $mail->msgHTML($message);
	$mail->AltBody = $filteredmessage;

	$arrResult = array ('response'=>'success');

	if(!$mail->Send()) {
	   $arrResult = array ('response'=>'error');
	}	

	echo json_encode($arrResult);

	
} else {

	$arrResult = array ('response'=>'error');
	echo json_encode($arrResult);

}
?>