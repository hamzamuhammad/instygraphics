<?php //refresh.php is the standard script called from orders.php
	
	include 'helper.php';
	require_once 'login.php';
	$connection = new mysqli($db_hostname, $db_username, $db_password, 
		$db_database);
	if ($connection->connect_error)
		die($connection->connect_error);

	session_start();
	$email_address = $_SESSION['email_address'];

	echo '<div class="jumbotron">
      	<div class="row">
      		<div class="col-md-6">
      			<table class="table">
      				<thead>
      					<tr>
      						<th colspan="3" style="text-align:center">
								<div class="btn-group btn-group-justified" role="group" aria-label="Justified button group"> 
	      							<div class="btn-group" role"group">
	      								<form action = "neworder.php" form class="form-signin" role="form">
	      									<div class="form-group">
	      										<button type="submit" class="input-block-level">New</button>
	      									</div>
	      								</form>
	      							</div>
	      							<div class="btn-group" role"group">
	      								<form action = "editorder.php" form class="form-signin" role="form">
	      									<div class="form-group">
	      										<button type="submit" class="input-block-level">Edit</button>
	      									</div>
	      								</form>	      							
	      							</div>	      							
	      							<div class="btn-group" role"group">
	      								<form action = "deleteorder.php" form class="form-signin" role="form">
	      									<div class="form-group">
	      										<button type="submit" class="input-block-level">Delete</button>
	      									</div>
	      								</form>
	      							</div>
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
				 . $row[2] . '</td></tr>';
		}
      	echo '</tbody>';
	}

	echo'
      			</table>
      		</div>
      	 </div>
      </div>';




?>