<?php //timeout.php (lazy fix to the div button issue)

	$_SESSION = array();
	setcookie(session_name(), '', time() - 2592000, '/');
	session_destroy();
    echo '<div class="alert alert-danger">You\'ve been logged out due to inactivity.</div>';
	include 'index.php';
?>