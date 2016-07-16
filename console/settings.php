<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Console</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/console.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <!-- The justified navigation menu is meant for single line per list item.
           Multiple lines will require custom code not provided by Bootstrap. -->
      <div class="masthead">
        <h3 class="text-muted">instygraphics Console</h3>
        <nav>
          <ul class="nav nav-justified">
            <li><a href="console.php">Home</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="inbox.php">Inbox (Beta)</a></li>
            <li><a href="help.php">Help</a></li>
            <li class="active"><a href="settings.php">Settings</a></li>
            <li><a href="../home/logout.php">Logout</a></li>
          </ul>
        </nav>
      </div>

      <div id="orderPlaced">
      	<div class="alert alert-info" role="alert">
          <strong>Success! </strong>Account details updated!
        </div>
      </div>

<?php //settings.php just shows user info and lets them edit it
  
session_start();
  if (!isset($_SESSION['email_address'])) { //session timed out {}
  include '../assets/timeout.php';
  exit;
}

include '../assets/helper.php';
require_once '../assets/login.php';
$connection = new mysqli($db_hostname, $db_username, $db_password, 
	$db_database);
if ($connection->connect_error)
	die($connection->connect_error);

$email_address = $_SESSION['email_address'];

$first_name = "";
$last_name = "";
$company_name = "";
$phone_number = "";

$query = "SELECT * FROM users WHERE email_address = '$email_address'";
$result = $connection->query($query);
if (!$result)
	die($connection->error);
$row = $result->fetch_array(MYSQLI_NUM);
$result->close();
$first_name = $row[0];
$last_name = $row[1];
$company_name = $row[2];
$phone_number = $row[3];
$password = $row[5];

if (isset($_POST['update'])) {
	$first_name = sanitizeMySQL($connection, $_POST['first_name']);
	$last_name = sanitizeMySQL($connection, $_POST['last_name']);
	$company_name = sanitizeMySQL($connection, $_POST['company_name']);
	$phone_number = sanitizeMySQL($connection, $_POST['phone_number']);
	$old_password = sanitizeMySQL($connection, $_POST['old_password']);
	$new_password = sanitizeMySQL($connection, $_POST['new_password']);
	$token = "";
	$pass_chunk = "a";
	$is_pass = isset($_POST['old_password']) && isset($_POST['new_password']);

	if ($is_pass) {
		$token = generate_password($new_password);
		$pass_chunk = ", user_password='" . $token . "'";
	}

	if ($is_pass && generate_password($old_password) !== $password) 
		echo '<div class="alert alert-danger">Wrong password! <a href="../home/recover.php">Forgot?</a></div>';	
	else {
		$query = "UPDATE users SET first_name='$first_name', last_name='$last_name', company_name='$company_name', 
		phone_number='$phone_number'". $pass_chunk . " WHERE email_address='$email_address'";
		$result = $connection->query($query);
		if (!$result)
			die($connection->error);
		echo '<script type="text/javascript">document.getElementById("orderPlaced").style.display = "block";</script>';
	}	
 }

$connection->close();

?>

<form action = "settings.php" method="POST" form class="form-horizontal" role="form">
    <div class="centercontents">
      <h2 class="form-signin-heading">Change account details</h2>
    </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="text">First name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="firstName" name="first_name" placeholder="Enter first name" required
      value="<?php echo $first_name;?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="text">Last name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Enter last name" required
      value="<?php echo $last_name;?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="text">Company</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="companyName" name="company_name" placeholder="Enter company name" required
      value="<?php echo $company_name;?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="text">Cell number</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="emailAddress" name="phone_number" placeholder="Enter cell number" required
      value="<?php echo $phone_number;?>">
    </div>
  </div>
   <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Old password</label>
    <div class="col-sm-10"> 
      <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Enter current password">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">New password</label>
    <div class="col-sm-10"> 
      <input type="password" class="form-control" id="old_password" name="new_password" placeholder="Enter new password">
    </div>
  </div>
  <div class="form-group"> 
    <div class="centercontents">
		<a href="settings.php" class="btn btn-warning" role="button">Cancel</a>
		<button type="submit" class="btn btn-success" name="update">Update</button>
    </div>
  </div>
</form>

      <!-- Site footer -->
      <footer class="footer">
        <p>&copy; 2016 instygraphics. All rights reserved. | Designed by Hamza Muhammad | Version 0.9.0 | Bugs? <a href="../bugs.php">Click here</a></p>
      </footer>

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../js/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
