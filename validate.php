<?php //validate.php confirms user registration

	include 'helper.php';
	require_once 'login.php';
	$connection = new mysqli($db_hostname, $db_username, $db_password, 
		$db_database);
	if ($connection->connect_error)
		die($connection->connect_error);

	if (isset($_POST['submit'])) {
		$verify_string = sanitizeMySQL($connection, $_POST['verify_string']);
		
		lock_table($connection);

		$result = check_verify_string($connection, $verify_string);
		if ($result) {
			echo '<div class="alert alert-success">Successfully validated your 
				account! You can now sign in.</div>';
		} 
		unlock_table($connection);
	}
	$connection->close();

	function check_verify_string($connection, $verify_string) {
		$query = "SELECT * FROM users WHERE verify_string = 
			'$verify_string'";
		$result = $connection->query($query);
		if (!$result->num_rows) { //incorrect phrase
			$result->close();
			unlock_table($connection);
			echo '<div class="alert alert-danger">Invalid code.</div>';
			return false;
		}
		$row = $result->fetch_array(MYSQLI_NUM);
		$result->close();
		$email_address = $row[4];
		update_verify_string($connection, $email_address);
		$subject = 'Account Validated!';
    	$message = 'Congratulations! Your account has been validated. Now you
    		can sign in.';
    	send_email($email_address, $subject, $message);
		return true;
	}

	function update_verify_string($connection, $email_address) {
		$query = "UPDATE users SET verify_string = '0' WHERE email_address =
			'$email_address'";
		$result = $connection->query($query);
		if (!$result) //SHOULDN'T GET HERE
			die($connection->error);
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

    <title>Validate</title>

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
          <a class="navbar-brand" href="index.html">instygraphics</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#signup">FAQ</a></li>  
            <li class="active"><a href="#signup">Sign up</a><li>                  
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Login <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li>     
                 <form class="form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav">
                  <div class="form-group">
                   <label class="sr-only" for="exampleInputEmail2">Email address</label>
                   <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email address" required>
                 </div>
                 <div class="form-group">
                   <label class="sr-only" for="exampleInputPassword2">Password</label>
                   <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" required>
                   <div id="left">
                   <div class="help-block text-left"><a href="">Forgot password?</a></div>
                   </div>
                   <div class="help-block text-right"><a href="signup.php">Sign up</a></div>
                 </div>
                 <div class="form-group">
                   <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                 </div>
                 <div class="checkbox">
                   <label>
                    <input type="checkbox"> Remember me
                   </label>
                 </div>
               </form>
                </li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

	<form action = "validate.php" method="POST" form class="form-signin" role="form">
        <h2 class="form-signin-heading">Please enter in code</h2>
        <label for="inputText" class="sr-only">Enter Validation Code</label>
        <div class="form-group">
        	<input type="text" id="inputText" class="form-control" placeholder="Validation Code" name="verify_string" required autofocus>        
        </div>
        <div class="form-group">
        	<button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Validate</button>
    	</div>
    </form>

    </div> <!-- /container -->

    <footer class="footer">
      <div class="container">
        <p class="text-muted">© 2016 instygraphics. All rights reserved. | Designed by Hamza Muhammad | Version 0.9.0 | Bugs? <a href="bugs.php">Click here</a></p>
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