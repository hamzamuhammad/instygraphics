<?php //signup.php registers a new user into the database

	include '../assets/helper.php';
	require_once '../assets/login.php';
	$connection = new mysqli($db_hostname, $db_username, $db_password, 
		$db_database);
	if ($connection->connect_error)
		die($connection->connect_error);

  $email_address = "";
	if (isset($_POST['submit'])) {		
		$first_name = sanitizeMySQL($connection, $_POST['first_name']);
	  $last_name = sanitizeMySQL($connection, $_POST['last_name']);
	  $company_name = sanitizeMySQL($connection, $_POST['company_name']);
	  $phone_number = sanitizeMySQL($connection, $_POST['phone_number']);
	  $email_address = sanitizeMySQL($connection, $_POST['email_address']);
	  $user_password = sanitizeMySQL($connection, $_POST['user_password']);

    lock_table($connection);

	 	$result = add_account($connection, $first_name, $last_name, $company_name, 
	 		$phone_number, $email_address, $user_password);
	 	//have to show popup box telling user to confirm account via email!
	 	//NOTE: BOTTOM IS TEMP!!!
	 	if ($result) {
		 	echo '<div class="alert alert-success">Successfully signed up! 
      Please check your email to validate your registration.</div>';
		}
		unlock_table($connection);
	}
	$connection->close();	

  //get our cookie
  $old_email_address = $email_address;
  $email_address = get_user_email_cookie();

	function add_account($connection, $first_name, $last_name, $company_name, 
		$phone_number, $email_address, $user_password) {
		$token = generate_password($user_password);
    $verify_string = random_str(8);	 	
	 	$query = "INSERT INTO users VALUES('$first_name', '$last_name', 
	 		'$company_name', '$phone_number', '$email_address', '$token', 
      '$verify_string')";
		$result = $connection->query($query);
		if (!$result) {
      unlock_table($connection);
	 		echo '<div class="alert alert-danger">Email address already 
	 			registered.</div>';
	 		return false;
		}
    //send the mail here
    $subject = 'Account Validation';
    $message = 'Go to www.instygraphics.com/home/validate.php and enter in '
      . $verify_string . ' to verify your email address.';
    send_email($email_address, $subject, $message);
		return true;
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

    <title>Sign up</title>

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
            <li><a href="#signup">FAQ</a></li>  
            <li class="active"><a href="#signup">Sign up</a><li>                  
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
                       <div class="help-block text-left"><a href="recover.php">Forgot password?</a></div>
                     </div>
                     <div class="help-block text-right"><a href="signup.php">Sign up</a></div>
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
      value="<?php if (isset($_POST['submit'])) echo $old_email_address;?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Password</label>
    <div class="col-sm-10"> 
      <input type="password" class="form-control" id="password" name="user_password" placeholder="Enter password" required>
    </div>
  </div>
  <div class="form-group"> 
    <div class="centercontents">
      <button type="submit" class="btn btn-success" name="submit">Submit</button>
    </div>
  </div>
</form>

    </div> <!-- /container -->

    <footer class="footer">
      <div class="container">
        <p class="text-muted">&copy; 2016 instygraphics. All rights reserved. | Designed by Hamza Muhammad | Version 0.9.0 | Bugs? <a href="../bugs.php">Click here</a></p>
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