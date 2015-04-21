<?php

session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));
include "http-utils/Snoopy.class.php";

$subject = $_POST['subject'];

if (isset($_POST['email'])) {
	
	$name = $_POST['name'];
	$email = $_POST['email'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	
	$post_data['entry.1673855134'] = $name;
	$post_data['entry.1856281856'] = $email;
	$post_data['entry.1367163162'] = $subject;
	$post_data['entry.1455322259'] = $message;

	$snoopy = new Snoopy();
	$snoopy->httpmethod = "POST"; // is GET by default
	$snoopy->submit("https://docs.google.com/forms/d/1NNmc_GJHnP8V4-FCvTL-dbf6dlS2uI5061mt0JOH1fA/formResponse", $post_data);
	
	$pos = strpos($snoopy->response_code, "200");
	if ($pos === false) {
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		$data = array( 'resultado' => 'ERROR', 'mensaje' => $snoopy->response, 'response' => 'failed');
		header('Content-Type: application/json');
		echo json_encode($data);
		return;
	} else {
		$data = array( 'resultado' => 'OK', 'mensaje' => 'Solicitud procesada correctamente.', 'response' => 'success');
		header('Content-Type: application/json');
		echo json_encode($data);
		return;
	}

} else {
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		$data = array( 'resultado' => 'ERROR', 'mensaje' => 'Solicitud recibida sin email.', 'response' => 'failed');
		header('Content-Type: application/json');
		echo json_encode($data);
		return;
}

?>