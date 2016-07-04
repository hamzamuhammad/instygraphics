<?php //newpass.php takes in a code and new password for the user!

	include '../assets/helper.php';
	require_once '../assets/login.php';
	$connection = new mysqli($db_hostname, $db_username, $db_password, 
		$db_database);
	if ($connection->connect_error)
		die($connection->connect_error);

	if (isset($_POST['submit'])) { 
		$code = sanitizeMySQL($connection, $_POST['user_code']);
		$user_password = sanitizeMySQL($connection, $_POST['user_password']);
		$confirm_password = sanitizeMySQL($connection, 
			$_POST['confirm_password']);

		lock_table($connection);

		$is_code_correct = check_code($connection, $code);
		$email_address = get_user_email_address($connection, $code);
		if ($user_password === $confirm_password && $is_code_correct && 
			$email_address) {
			//if we got here, then it all checks out!
			update_password($connection, $user_password, $email_address);
			update_verify_string($connection, $email_address);
			echo '<div class="alert alert-success">Successfully changed 
				password!</div>';
		}
		else if ($user_password !== $confirm_password) 
			echo '<div class="alert alert-danger">Passwords do not match!</div>';
		else if (!$is_code_correct)
			echo '<div class="alert alert-danger">Incorrect code!</div>';
		else
			echo '<div class="alert alert-danger">Account doesn\'t exist!</div>';

	}	
	$connection->close();

	//get our cookie
	$email_address = get_user_email_cookie();

	function check_code($connection, $code) { //this is implying that 
		//the code sent to the user WAS NOT intercepted
		$query = "SELECT * FROM users WHERE verify_string ='$code'";			
		$result = $connection->query($query);
		if (!$result) 
			die($connection->error);
		$row = $result->fetch_array(MYSQLI_NUM);
		$result->close();
		$stored_code = $row[6];
		if ($stored_code === $code)
			return true;
		unlock_table($connection);
		return false;
	}

	function update_password($connection, $user_password, $email_address) {
		$token = generate_password($user_password);
		$query = "UPDATE users SET user_password = '$token' WHERE 
		email_address = '$email_address'";
		$result = $connection->query($query);
		if (!$result) {
			unlock_table($connection);
			die($connection->error);			
		}
	}

	function get_user_email_address($connection, $code) {
		$query = "SELECT * FROM users WHERE verify_string = '$code'";
		$result = $connection->query($query);
		if (!$result) {
			unlock_table($connection);
			return false;
		}
		$row = $result->fetch_array(MYSQLI_NUM);
		$result->close();
		$email_address = $row[4];
		return $email_address;
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
    <link rel="icon" href="../img/favicon.ico">

    <title>New Password</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/signup.css" rel="stylesheet">

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
          <div class="navbar-left"><img src="../img/logo.png" width="50" height="50"></div>
          <a class="navbar-brand" href="../index.php">instygraphics</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="../index.php">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#FAQ">FAQ</a></li>  
            <li class="active"><a href="#reciver">Recover</a><li>                  
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Login <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li>     
                   <form class="form" role="form" method="POST" action="../console/authenticate.php" accept-charset="UTF-8" id="login-nav">
                    <div class="form-group">
                     <label class="sr-only" for="exampleInputEmail2">Email address</label>
                     <input type="email" class="form-control" id="emailAddress" placeholder="Email address" name="email_address" value="<?php if ($email_address !== "") echo $email_address; ?>" required>
                   </div>
                   <div class="form-group">
                     <label class="sr-only" for="exampleInputPassword2">Password</label>
                     <input type="password" class="form-control" id="userPassword" placeholder="Password" name="user_password" required>
                     <div id="left">
                       <div class="help-block text-left"><a href="../home/recover.php">Forgot password?</a></div>
                     </div>
                     <div class="help-block text-right"><a href="../home/signup.php">Sign up</a></div>
                   </div>
                   <div class="form-group">
                     <button type="submit" class="btn btn-primary btn-block" name="submit">Sign in</button>
                   </div>
                   <div class="checkbox">
                     <label>
                      <input type="checkbox" name="remember_me" <?php if ($email_address !== "") echo 'checked'; ?> > Remember me
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

	<form action = "newpass.php" method="POST" form class="form-signin" role="form">
        <h2 class="form-signin-heading">Enter your code and new password</h2>
        <div class="form-group">
        	<input type="text" id="inputText" class="form-control" placeholder="Code" name="user_code" required autofocus>        
        </div>
        <div class="form-group">
        	<input type="password" id="inputText" class="form-control" placeholder="New Password" name="user_password" required autofocus>        
        </div>
        <div class="form-group">
        	<input type="password" id="inputText" class="form-control" placeholder="Confirm Password" name="confirm_password" required autofocus>        
        </div>
        <div class="form-group">
        	<button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Update</button>
    	</div>
    </form>

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
    <script>window.jQuery || document.write('<script src="../js/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>