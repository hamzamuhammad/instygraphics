<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Console (admin)</title>

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
        <h3 class="text-muted">instygraphics Console - admin</h3>
        <nav>
          <ul class="nav nav-justified">
            <li class="active"><a href="#">Orders</a></li>
            <li><a href="../home/logout.php">Logout</a></li>
          </ul>
        </nav>
      </div>

      <div id="orderPlaced">
        <div class="alert alert-info" role="alert">
          <strong>Success! </strong>Order updated!
        </div>
        <div class="centercontents">
          <a href="adminconsole.php" class="btn btn-info btn-md" role="button">Return &raquo;</a>
        </div>
      </div>      

<?php //vieworder.php lets admin download file and view comments

    include '../assets/helper.php';
    require_once '../assets/login.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, 
      $db_database);
    if ($connection->connect_error)
      die($connection->connect_error);

    $old_file_id = "";
    $comments = "";
    if (isset($_POST['file_id'])) {
      $old_file_id = sanitizeMySQL($connection, $_POST['file_id']);
      $comments = get_user_comments($connection, $old_file_id);
    }

    $query = "SELECT * FROM files WHERE file_id = '$old_file_id'";
    $result = $connection->query($query);
    $row = $result->fetch_array(MYSQLI_NUM);
    $result->close();
    $comments = $row[4];
    $status = $row[3];
    $old_file_name = $row[5];
    $email_address = $row[0];

    if (isset($_POST['update'])) { //admin changed status
        $array = array("pending", "on hold", "in progress", "completed");
        $new_status = $array[intval(sanitizeMySQL($connection, $_POST['status']))];
        if ($new_status !== $status) { //if status was changed
          $query = "UPDATE files SET status = '$new_status' WHERE file_id = '$old_file_id'";
          $result = $connection->query($query);
          if (!$result) //order doesn't exist (user may have deleted?) look into this
            die($connection->error);
          echo '<script type="text/javascript">document.getElementById("orderPlaced").style.display = "block";</script>';
          $status = $new_status;
          $message = "Your order where you submitted the file " . $old_file_name . " has had it's status updated!";
          send_email($email_address, "Order Status Updated!", $message);
        }
    }

    $connection->close();
?>

        <div class="centercontents">
          <h2 class="page-header">View Order</h2>
        </div>
        <h4 class="sub-header" align="center">Download a file and change order status</h4>
        <div class="centercontents">
          <div id="bar_blank">
              <div id="bar_color">
              </div>
          </div>
        </div>
        <div id="status"></div>
        <form action="vieworder.php" method="POST" role="form" enctype="multipart/form-data" id="myForm" target="hidden_iframe">
          <div class="form-group">
            <input type="hidden" value="myForm" name="<?php echo ini_get("session.upload_progress.name"); ?>">
          </div>
          <div class="form-group">
            <input type="hidden" value="<?php if ($old_file_id !== "") echo $old_file_id; ?>" name="file_id">
          </div>
          <div class="form-group">
            <div class="centercontents">
              <button type="button" class="btn btn-info">
                <?php echo '<a href="../uploads/' . $old_file_id . '" download="' . $old_file_name . '"> Download File </a>'; ?>       
              </button>
            </div>
          </div>
          <div class="form-group">
            <label for="comment">Comments</label>
            <textarea class="form-control" rows="5" id="comment" name="comments" readonly><?php echo $comments; ?></textarea>
          </div>
          <div class="centercontents">
          </div class = "form-group">
            <?php 
              $array = array("pending", "on hold", "in progress", "completed");
              for ($i = 0; $i < count($array); $i++) {
                if ($array[$i] === $status) 
                  echo '<label class="radio-inline"><input type="radio" value=' . $i . ' name="status" checked="checked">'. $status . '</label>';
                else 
                  echo '<label class="radio-inline"><input type="radio" value=' . $i . ' name="status">'. $array[$i] . '</label>';
              }
            ?>
          </div>
          </div>
          <div class="centercontents">
            <div class="row">
              <a href="adminconsole.php" class="btn btn-warning btn-md" role="button">Cancel</a>
              <button type="submit" class="btn btn-success" id="update-btn" name="update">Update</button>
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