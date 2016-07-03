<?php //upload.php pushes file to server

    session_start();
    if (!isset($_SESSION['email_address'])) { //session timed out
      include 'timeout.php'; 
      exit;
    }
	$email_address = $_SESSION['email_address'];

	include 'helper.php';
	require_once 'login.php';
	$connection = new mysqli($db_hostname, $db_username, $db_password, 
		$db_database);
	if ($connection->connect_error)
		die($connection->connect_error);

	if (isset($_POST)) {
		if (!isset($_FILES['file']))
			die('File is missing!');
		$comments = sanitizeMySQL($connection, $_POST['comments']); 
        $old_file_name = $_FILES['file']['name'];
		$file_count = inc_file_count();
		$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		$new_file_name = $file_count . '.' . $extension;
		move_uploaded_file($_FILES['file']['tmp_name'], "uploads/$new_file_name");
		update_files_db($connection, $email_address, $new_file_name, $comments, 
			$old_file_name);
	}
	$connection->close();

	function update_files_db($connection, $email_address, $new_file_name, 
		$comments, $old_file_name) {
		send_email("sales@instygraphics.com", "New order submitted!", "Please 
			check the admin console to view the order details.");
		$timestamp = time();
		$query = "INSERT INTO 
			files(email_address, file_name, date_uploaded, status, comments, 
				old_file_name) 
        	VALUES('$email_address', '$new_file_name', '$timestamp', 'pending', 
        		'$comments', '$old_file_name')";
		$result = $connection->query($query);
		if (!$result)
			die($connection->error);
	}

	function inc_file_count() {
		$fh = fopen("count.txt", 'r+') or die("File does not exist or you lack 
			permission to open it");
		$line = fgets($fh);
		$count = intval($line);
		$file_count = $count + 1;
		fseek($fh, 0);
		fwrite($fh, $file_count) or die("Could not write to file");
		fclose($fh);
		return $file_count;
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

    <title>Console</title>

    <!-- jquery plugin -->
    <script type = "text/javascript" src = "http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="console.css" rel="stylesheet">

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

      <!-- The justified navigation menu is meant for single line per list item.
           Multiple lines will require custom code not provided by Bootstrap. -->
      <div class="masthead">
        <h3 class="text-muted">instygraphics Console</h3>
        <nav>
          <ul class="nav nav-justified">
            <li><a href="console.php">Home</a></li>
            <li class="active"><a href="#">Orders</a></li>
            <li><a href="inbox.php">Inbox (Beta)</a></li>
            <li><a href="help.php">Help</a></li>
            <li><a href="setting.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </nav>
      </div>

        <div class="centercontents">
          <h1 class="page-header">New Order</h1>
        </div>
        <h4 class="sub-header" align="center">Upload a file and add additional comments</h4>
        <form action="upload.php" method="POST" role="form" enctype="multipart/form-data" >
          <div class="form-group">
            <div class="centercontents">
              <label class="btn btn-primary" for="my-file-selector">
                <input id="my-file-selector" type="file" size='10' name="file">
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="comment">Comments</label>
            <textarea class="form-control" rows="5" id="comment" name="comments"></textarea>
          </div>
          <div class="centercontents">
            <div class="row">
              <a href="orders.php" class="btn btn-warning btn-md" role="button">Cancel</a>
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      

      <!-- Site footer -->
      <footer class="footer">
        <p>&copy; 2016 instygraphics. All rights reserved. | Designed by Hamza Muhammad | Version 0.9.0 | Bugs? <a href="bugs.php">Click here</a></p>
      </footer>

    </div> <!-- /container -->

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