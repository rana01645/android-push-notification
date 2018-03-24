<?php 

if (isset($_REQUEST["Token"])) {

	$_uv_Token=$_REQUEST["Token"];

	$dsn = 'mysql:dbname=droidrace_fcm;host=localhost';
	$user = 'droidrace_r0n00';
	$password = '7262Notification';

	try {
	    $db = new PDO($dsn, $user, $password);
	} catch (PDOException $e) {
	    echo 'Connection failed: ' . $e->getMessage();
	    exit();
	}

	$q="INSERT INTO users (Token) VALUES ( :token ) " ." ON DUPLICATE KEY UPDATE Token = :token";
	$insert = $db->prepare($q);
	$insert = $insert->execute(array('token' => $_uv_Token));

	if(!$insert) echo "Failed";
}
?>