<?php //refresh.php is the standard script called from orders.php
	
	include 'helper.php';
	require_once 'login.php';
	$connection = new mysqli($db_hostname, $db_username, $db_password, 
		$db_database);
	if ($connection->connect_error)
		die($connection->connect_error);

	session_start();
	if (!isset($_SESSION['email_address'])) { //session timed out
  	  include 'timeout.php'; 
      exit;
  	}
	$email_address = $_SESSION['email_address'];

	echo '


	<div class="jumbotron">
      	<div class="row">
      		<div class="col-md-6">
      			<form action = "editorder.php" method="POST" role="form" id="edit_form"></form>
      			<table class="table">
      				<thead>
      					<tr>
      						<th>
								<div class="centercontents">
									<a href="neworder.php" class="btn btn-primary btn-md" role="button">New</a>
								</div>
      						</th>
      					</tr>
      				</thead>
      				<thead>
      					<tr>
      						<th>Status</th>
      						<th>File Name</th>
      						<th>Date Uploaded</th>
      					</tr>
      				</thead>';

	$orders = format_user_table($connection, $email_address);
	if (count($orders) > 0) { //if user has orders
		echo '<tbody>';
		for ($i = 0; $i < count($orders); $i++) {
			$row = $orders[$i];
			echo '<tr><td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>'
				 . date('m-d-Y', $row[2]) . '</td>';
			echo "<td><form action='editorder.php' method='POST'><input type='hidden' name='file_id' value='".$row[3]."'/>
                      <input type='submit' name='submit' value='Edit' /></form></td>
                      <td><form action='deleteorder.php' method='POST'><input type='hidden' name='file_id' value='".$row[3]."'/>
                      <input type='submit' name='submit' value='Delete' /></form></td>
                      </tr>";
		}	
      	echo '</tbody>';
	}

	echo'
      			</table>
      		</div>
      	 </div>
      </div>';
?>