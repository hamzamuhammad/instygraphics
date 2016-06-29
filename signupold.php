<?php //signup.php 

  include 'helper.php';
  require_once 'login.php';
  $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
  if ($connection->connect_error) die($connection->connect_error);

  $form_filled = false;
  if (isset($_POST['submit'])) {
    $first_name = sanitizeMySQL($connection, $_POST['first_name']);
    $last_name = sanitizeMySQL($connection, $_POST['last_name']);
    $company_name = sanitizeMySQL($connection, $_POST['company_name']);
    $phone_number = sanitizeMySQL($connection, $_POST['phone_number']);
    $email_address = sanitizeMySQL($connection, $_POST['email_address']);
    $password = sanitizeMySQL($connection, $_POST['password']);
    // if (!empty($first_name) && $last_name != "" && $company_name != "" && $email_address != "" 
    //   && $phone_number != "" && $password != "") {
    if (!empty($first_name) && !empty($last_name) && !empty($company_name) && !empty($phone_number)
      && !empty($email_address) && !empty($password)) {
      $form_filled = TRUE;
    }
    else {
      echo '<div class="alert alert-danger">Please fill out all fields.</div>';
    }
  }

  if ($form_filled) {
    $is_email_valid = FALSE;
    $query = "SELECT user_password, email_address FROM users WHERE email_address = '$email_address'";
    $result = $connection->query($query);
    $result->data_seek(0);

    if (!($result->fetch_assoc()['user_password'])) {
      //if email addres is NOT IN USE
      $is_email_valid = TRUE;
    }
    $result->close(); //close mysql query

    if (!$is_email_valid) {
      echo '<div class="alert alert-danger">Email address already registered.</div>';
    }
    else {
      //actually put in info now
      $salt1 = "b3z!";
      $salt2 = "5n(E";
      $token = hash('ripemd128', "$salt1$password$salt2");
      $query = "INSERT INTO users VALUES('$first_name', '$last_name', '$company_name', '$phone_number', 
        '$email_address', '$token')";
      $result = $connection->query($query);
      if (!$result) die($connection->error);
      //$result->close(); HAVE TO FIX THIS SHIT SOON
      echo '<div class="alert alert-success">Successfully signed up!</div>';
      //should automatically go back to the home page after this
      echo '<script>setTimeout(function(){window.location.href="../../index.html"},2000);</script>';
    }
  }
  $connection->close();

echo <<<_END
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
      <input type="text" class="form-control" id="firstName" name="first_name" placeholder="Enter first name">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="text">Last name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Enter last name">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="text">Company</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="companyName" name="company_name" placeholder="Enter company name">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="text">Cell number</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="emailAddress" name="phone_number" placeholder="Enter cell number">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="emailAddress" name="email_address" placeholder="Enter email address">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Password</label>
    <div class="col-sm-10"> 
      <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
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
_END;

  function get_post($connection, $var) {
    return $connection->real_escape_string($_POST[$var]);
  }

  function sanitizeString($var) {
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    return $var;
  }

  function sanitizeMySQL($connection, $var) {
    $var = $connection->real_escape_string($var);
    $var = sanitizeString($var);
    return $var;
  }
?>