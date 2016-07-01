<?php //logout.php logs user out and sends them back to home page
	
	session_start();
	$_SESSION = array();
	setcookie(session_name(), '', time() - 2592000, '/');
	session_destroy();
	echo '<div class="alert alert-success">Successfully logged out!</div>';	
	include 'index.php';
?>