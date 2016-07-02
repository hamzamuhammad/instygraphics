<?php
  
  session_start();
  if (!isset($_SESSION['email_address'])) { //session timed out {}
    include 'timeout.php';
    exit;
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
            <li class="active"><a href="#">Home</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="inbox.php">Inbox (Beta)</a></li>
            <li><a href="help.php">Help</a></li>
            <li><a href="setting.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </nav>
      </div>

      <!-- Jumbotron -->
      <div class="centercontents">
        <h1>Welcome!</h1>
        <p>Manage all of your business with our user-friendly console. <p>Get started by placing a new order!</p></p>
        <p><a class="btn btn-lg btn-success" href="#" role="button">Send a quote</a></p>
      </div>

      <!-- Example row of columns -->
      <div class="row">
        <div class="col-lg-4">
          <h2>Not sure where to start?</h2>
          <p>Go to our help page and read the tutorials on how to use the instygraphics console.</p>
          <p><a class="btn btn-primary" href="#" role="button">Help page &raquo;</a></p>
        </div>
        <div class="col-lg-4">
          <h2>Want to advertise with us?</h2>
          <p>For a limited time, instygraphics is offering some ad space on the main website.</p>
          <p><a class="btn btn-primary" href="#" role="button">More info &raquo;</a></p>
       </div>
        <div class="col-lg-4">
          <h2>Like our website so far?</h2>
          <p>The entire instygraphics site is part of the Small Business Starter Pack (SBSP).</p>
          <p><a class="btn btn-primary" href="#" role="button">Check it out &raquo;</a></p>
        </div>
      </div>

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
