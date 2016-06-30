<?php //authenticate.php logs the user in (and sets a cookie if possible)

	include 'helper.php';
	require_once 'login.php';
	$connection = new mysqli($db_hostname, $db_username, $db_password, 
		$db_database);
	if ($connection->connect_error)
		die($connection->connect_error);

	if (isset($_POST['submit'])) {
		$email_address = sanitizeMySQL($connection, $_POST['email_address']);
		$user_password = sanitizeMySQL($connection, $_POST['user_password']);

		lock_table($connection);

		$result = check_password($connection, $email_address, $user_password);
		if ($result) { //successful login!
			//have to check if checkbox was selected
			if (isset($_POST['remember_me'])) {
				setcookie('email_address', $email_address, 
    				time() + 60 * 60 * 24 * 7, '/');
			}
			else if(isset($_COOKIE['email_address'])) {
				setcookie('email_address', 'hamzamuhammad@utexas.edu', 
					time() - 2592000);
			}
			//now, we start a session for this user: 
			session_start();
			$_SESSION['email_address'] = $email_address; 
			welcome_msg();
		}

	}
	$connection->close();

	function check_password($connection, $email_address, $user_password) {
		$query = "SELECT * FROM users WHERE email_address='$email_address'";
		$result = $connection->query($query);
		if (!$result->num_rows) { //account doesn't exist
			$result->close();
			unlock_table($connection);
			error_msg();
			return false;
		}
		$row = $result->fetch_array(MYSQLI_NUM);
		$result->close();
		$stored_password = $row[5];
		$token = generate_password($user_password);
		if ($token !== $stored_password) { //password is wrong
			unlock_table($connection);
			error_msg();
			return false;
		}
		return true;
	}

	function error_msg() {
		echo '<div class="alert alert-danger">Invalid account. 
			<a href="recover.php">Forgot password?</a> Not registered? 
			<a href="signup.php">Sign up!</a></div>';
	}

	function welcome_msg() {
		echo '<div class="alert alert-success">Successfully signed in!</div>';
		echo '<div class="alert alert-info" role="alert">
        	<strong>Heads up! </strong>The admin is working on getting an SSL 
        	certificate.</div>';
        echo '<form action = "console.php" form class="form-signin" role="form">
        	<div class="form-group">
        	<button class="btn btn-lg btn-primary btn-block" type="submit" 
        	name="submit">Console</button></div></form>';
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
    <link href="signup.css" rel="stylesheet">

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

       <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="navbar-left"><img src="logo.png" width="50" height="50"></div>
          <a class="navbar-brand" href="index.php">instygraphics</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#signup">FAQ</a></li>  
            <li class="active"><a href="#">Console</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">


    </div> <!-- /container -->

    <footer class="footer">
      <div class="container">
        <p class="text-muted">&copy; 2016 instygraphics. All rights reserved. | Designed by Hamza Muhammad | Version 0.9.0 | Bugs? <a href="bugs.php">Click here</a></p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>