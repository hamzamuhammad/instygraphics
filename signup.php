<?php //signup.php registers a new user into the database

  	//DEBUG ONLY
  	ini_set('display_errors', 'On');
  	error_reporting(E_ALL | E_STRICT);
  	//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	include 'helper.php';
	require_once 'login.php';
	$connection = new mysqli($db_hostname, $db_username, $db_password, 
		$db_database);
	if ($connection->connect_error)
		die($connection->connect_error);

	if (isset($_POST['submit'])) {		
		$first_name = sanitizeMySQL($connection, $_POST['first_name']);
	    $last_name = sanitizeMySQL($connection, $_POST['last_name']);
	    $company_name = sanitizeMySQL($connection, $_POST['company_name']);
	    $phone_number = sanitizeMySQL($connection, $_POST['phone_number']);
	    $email_address = sanitizeMySQL($connection, $_POST['email_address']);
	    $password = sanitizeMySQL($connection, $_POST['password']);

	    lock_table($connection);

	 	$result = add_account($connection, $first_name, $last_name, $company_name, 
	 		$phone_number, $email_address, $password);
	 	//have to show popup box telling user to confirm account via email!
	 	//NOTE: BOTTOM IS TEMP!!!
	 	if ($result) {
		 	echo '<div class="alert alert-success">Successfully signed up!</div>';
		 	echo '<script>setTimeout(function(){window.location.href=
		 		"../../index.html"},2000);</script>';
		}
		unlock_table($connection);
	}
	end:
	$connection->close();	

	function add_account($connection, $first_name, $last_name, $company_name, 
		$phone_number, $email_address, $password) {
		$salt1 = "zn7!";
	 	$salt2 = "#db12";
	 	$token = hash('ripemd128', "$salt2$password$salt1");	 	
	 	$query = "INSERT INTO users VALUES('$first_name', '$last_name', 
	 		'$company_name', '$phone_number', '$email_address', '$token')";
		$result = $connection->query($query);
		if (!$result) {
	 		echo '<div class="alert alert-danger">Email address already 
	 			registered.</div>';
	 		return FALSE;
		}
		return TRUE;
	}
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Sign up</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

<form action = "signup.php" method="POST" form class="form-horizontal" role="form">
    <div class="centercontents">
      <h2 class="form-signin-heading">Sign up</h2>
    </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="text">First name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="firstName" name="first_name" placeholder="Enter first name" required
      value="<?php if (isset($_POST['submit'])) echo $first_name;?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="text">Last name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Enter last name" required
      value="<?php if (isset($_POST['submit'])) echo $last_name;?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="text">Company</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="companyName" name="company_name" placeholder="Enter company name" required
      value="<?php if (isset($_POST['submit'])) echo $company_name;?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="text">Cell number</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="emailAddress" name="phone_number" placeholder="Enter cell number" required
      value="<?php if (isset($_POST['submit'])) echo $phone_number;?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="emailAddress" name="email_address" placeholder="Enter email address" required
      value="<?php if (isset($_POST['submit'])) echo $email_address;?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Password</label>
    <div class="col-sm-10"> 
      <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
    </div>
  </div>
  <div class="form-group"> 
    <div class="centercontents">
      <button type="submit" class="btn btn-default" name="submit">Submit</button>
    </div>
  </div>
</form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>