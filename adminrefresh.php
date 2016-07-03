<?php //adminrefresh.php is table just for admin!

	include 'helper.php';
	require_once 'login.php';
	$connection = new mysqli($db_hostname, $db_username, $db_password, 
		$db_database);
	if ($connection->connect_error)
		die($connection->connect_error);

	session_start();

	echo '
	<div class="jumbotron">
      	<div class="row">
      		<div class="col-md-6">
      			<table class="table">
      				<thead>
      				</thead>
      				<thead>
      					<tr>
      						<th>Status</th>
      						<th>File Name</th>
      						<th>Date Uploaded</th>
      						<th>Email Address</th>
      					</tr>
      				</thead>';

	$orders = format_admin_table($connection);
	if (count($orders) > 0) { //if user has orders
		echo '<tbody>';
		for ($i = 0; $i < count($orders); $i++) {
			$row = $orders[$i];
			echo '<tr><td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>'
				 . date('m-d-Y', $row[2]) . '</td><td>' . $row[4] . '</td>';
			echo "<td><form action='vieworder.php' method='POST'><input type='hidden' name='file_id' value='".$row[3]."'/>
                      <input type='submit' name='submit' value='View' /></form></td></tr>";
		}	
      	echo '</tbody>';
	}

	echo'
      			</table>
      		</div>
      	 </div>
      </div>';
?>
