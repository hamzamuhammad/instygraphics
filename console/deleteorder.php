<?php //deleteorder.php does at it says!
	
	  include '../assets/helper.php';
  	require_once '../assets/login.php';
  	$connection = new mysqli($db_hostname, $db_username, $db_password, 
  		$db_database);
  	if ($connection->connect_error)
      die($connection->connect_error);


    $old_file_id = "";
    if (isset($_POST['file_id'])) 
      $old_file_id = sanitizeMySQL($connection, $_POST['file_id']);

    if (isset($_POST['submit'])) {
      $query = "DELETE FROM files WHERE file_id = '$old_file_id'";
      $result = $connection->query($query);
      if (!$result) 
        die($connection->error);
    }

    $connection->close();

    include 'orders.php';
?>