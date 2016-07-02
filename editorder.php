<?php //editorder.php reuses refresh code due to displaying a select option (along with cancel)
    
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

    $file_name = "";
    $comments = "";
    if (isset($_POST['file_name'])) {
      $file_name = sanitizeMySQL($connection, $_POST['file_name']);
      $comments = get_user_comments($connection, $file_name);
    }

    if (isset($_POST['update'])) { //user wants to update
      $new_file_name = $_FILES['file']['name'];
      if (isset($_FILES['file'])) {
        move_uploaded_file($_FILES['file']['tmp_name'], "uploads/$file_name");
        update_order(true, $connection, $file_name, $new_file_name, $comments);      
      }
      else
        update_order(false, $connection, $file_name, $new_file_name, $comments);
    }
    else if (isset($_POST['delete'])) { //completely wipe the order
      delete_order($connection, $file_name);
      echo '<script type="text/javascript">
            document.getElementById("update-btn").style.display = "none";
            document.getElementById("delete-btn").style.display = "none";
            </script>'
    }

    $connection->close();
  
	  function get_user_comments($connection, $file_name) {
      lock_table($connection);
      $query = "SELECT * FROM files WHERE file_name = '$file_name'";
      $connection->query($query);
      if (!$result) {
        unlock_table($connection);
        echo '<div class="alert alert-danger">Order doesn\'t exist!</div>';
        exit;
      }
      $row = $result->fetch_array(MYSQLI_NUM);
      $result->close();
      $comments = $row[4];
      unlock_table($connection);
      return $comments;
    }

    function update_order($changed_file, $connection, $file_name, 
      $new_file_name, $comments) {
      if ($changed_file)
        update_file($connection, $file_name, $new_file_name);
      update_comments($connection, $file_name, $comments)
    }

    function update_file($connection, $file_name, $new_file_name) {
      lock_table($connection);
      $query = "UPDATE files SET old_file_name = '$new_file_name' WHERE 
        file_name = '$file_name'";
      $result = $connection->query($query);
      if (!$result) {
        unlock_table($connection);
        die($connection->error);
      }
      unlock_table($connection);
    }

    function update_comments($connection, $file_name, $comments) {
      lock_table($connection);
      $query = "UPDATE files SET comments = '$comments' WHERE 
        file_name = '$file_name'";
      $result = $connection->query($query);
      if (!$result) {
        unlock_table($connection);
        die($connection->error);
      }
      unlock_table($connection);
    }

    function delete_order($connection, $file_name) {
      lock_table($connection);
      $query = "DELETE FROM files WHERE file_name = '$file_name'";
      $result = $connection->query($query);
      if (!$result) {
        unlock_table($connection);
        die($connection->error);
      }
      unlock_table($connection);
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


      <div id="orderPlaced">
        <div class="alert alert-info" role="alert">
          <strong>Success! </strong>Your order has been changed!
        </div>
        <div class="centercontents">
          <a href="orders.php" class="btn btn-info btn-md" role="button">Return &raquo;</a>
        </div>
      </div>
        <div class="centercontents">
          <h2 class="page-header">Edit Order</h2>
        </div>
        <h4 class="sub-header" align="center">Upload a file and add additional comments</h4>
        <div class="centercontents">
          <div id="bar_blank">
              <div id="bar_color">
              </div>
          </div>
        </div>
        <div id="status"></div>
        <form action="neworder.php" method="POST" role="form" enctype="multipart/form-data" id="myForm" target="hidden_iframe">
          <div class="form-group">
            <input type="hidden" value="myForm" name="<?php echo ini_get("session.upload_progress.name"); ?>">
          </div>
          <div class="form-group">
            <div class="centercontents">
              <label class="btn btn-primary" for="fileInput">
                <input id="fileInput" type="file" size='10' name="file">
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="comment">Comments</label>
            <textarea class="form-control" rows="5" id="comment" name="comments"><?php echo $comments; ?></textarea>
          </div>
          <div class="centercontents">
            <div class="row">
              <a href="orders.php" class="btn btn-warning btn-md" role="button">Cancel</a>
              <button type="submit" class="btn btn-danger" id="delete-btn" name="delete">Delete</button>
              <button type="submit" class="btn btn-success" id="update-btn" name="update">Update</button>
            </div>
          </div>
        </form>
        <iframe id="hidden_iframe" name="hidden_iframe" src="about:blank"></iframe>
        <script type="text/javascript" src="loading.js"></script>
      
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