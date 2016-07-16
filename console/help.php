<?php
  
  session_start();
  if (!isset($_SESSION['email_address'])) { //session timed out {}
    include '../assets/timeout.php';
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
        <h3 class="text-muted">instygraphics Console</h3>
        <nav>
          <ul class="nav nav-justified">
            <li><a href="console.php">Home</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="inbox.php">Inbox (Beta)</a></li>
            <li class="active"><a href="#">Help</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="../home/logout.php">Logout</a></li>
          </ul>
        </nav>
      </div>

      <div class="blog-header">
        <h1 class="blog-title">Help Page</h1>
        <p class="lead blog-description">Updated as new features are rolled out.</p>
      </div>

      <div class="row">

        <div class="col-sm-8 blog-main">

          <div class="blog-post">
            <h2 class="blog-post-title">Using the instygraphics console</h2>
            <p class="blog-post-meta">July 3, 2016 by <a href="#">Hamza</a></p>

            <p>Once you login, you're greeted with a home page that is occasionally updated with new content from instygraphics.</p>
            <hr>
            <p>Click on <a href="orders.php">Orders</a> to make new orders as well as edit existing ones. Initially, it'll be empty until you submit an order; when you do, you'll see a table with various information in it.</p>
            <blockquote>
              <p><strong>Status</strong> tells you what the current state of your order is. There are 4: pending, on hold, in progress, and completed.</p>
              <hr>
              <p><strong>File Name</strong> tells you the name of the file you uploaded with the corresponding order (so make sure to have descriptive file names!).</p>
              <hr>
              <p><strong>Date Uploaded</strong> tells you the date order was submitted in month-day-year format.</p>
            </blockquote>
            <p>The orders table is refreshed <em>every few seconds</em> so you'll see real-time updates as your order gets processed.</p>
            <h2>Making a new order</h2>
            <p>Click on the new button to view a form containing a button to upload your files, and a textbox for comments you want the admin to view. Please note that the progress bar will show you how much
            	of the file has been uploaded, so please <em>DO NOT</em> exit the page until its complete. Then, press submit to send an order!</p>
            <h3>Editing and deleting orders</h3>
            <p>Click on the edit button to view a page similar to new order page, with your original comments still there. Upload a new file to override the old one submitted, and update your comments as well. Press update to finish the process.</p>
            <p>Click on the delete button to permanently remove an order.</p>
          </div><!-- /.blog-post -->

        </div><!-- /.blog-main -->

        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
          <div class="sidebar-module">
            <h4>Topics</h4>
            <ol class="list-unstyled">
              <li><a href="#">console</a></li>
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>For developers</h4>
            <ol class="list-unstyled">
              <li><a href="#">GitHub</a></li>
            </ol>
          </div>
        </div><!-- /.blog-sidebar -->

      </div><!-- /.row -->

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
