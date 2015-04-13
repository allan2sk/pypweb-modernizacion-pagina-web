<?php
	include 'MailChimp.php';
if (isset($_POST['email'])) {
	$email = $_POST['email'];
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		echo "Error. Email invalido: " . $email . ".";
		exit;
	}
    subscribe($_POST['email']);
} else {
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	echo "Error. Se requiere email";
	exit;
}


function subscribe($email) {
	$MailChimp = new \Drewm\MailChimp('734bbf0e231bc8b7db0c6e85c3c30440-us7');
	$result = $MailChimp->call('lists/subscribe', array(
                'id'                => '0714612f99',
                'email'             => array('email'=>$email),
                'double_optin'      => false,
                'update_existing'   => true,
                'replace_interests' => false,
                'send_welcome'      => false,
            ));

	if ( isset($result['status']) && !(stripos($result['status'],'error')=== false)) {
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		echo "Error al procesar la solicitud. Detalle: " . $result['name'] . ". " . $result['error'];
	} else {
		echo "Email " . $email . " suscrito correctamente.";
	}
    exit;
}

?>