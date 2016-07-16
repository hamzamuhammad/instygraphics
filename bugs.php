<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/favicon.ico">

    <title>Bugs</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/home.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

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
          <div class="navbar-left"><img src="img/logo.png" width="50" height="50"></div>
          <a class="navbar-brand" href="index.php">instygraphics</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#faq">FAQ</a></li>
            <li><a href="home/signup.php">Sign up</a><li>          
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Login <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li>     
                   <form class="form" role="form" method="POST" action="console/authenticate.php" accept-charset="UTF-8" id="login-nav">
                    <div class="form-group">
                     <label class="sr-only" for="exampleInputEmail2">Email address</label>
                     <input type="email" class="form-control" id="emailAddress" placeholder="Email address" name="email_address" value="<?php if ($email_address !== "") echo $email_address; ?>" required>
                   </div>
                   <div class="form-group">
                     <label class="sr-only" for="exampleInputPassword2">Password</label>
                     <input type="password" class="form-control" id="userPassword" placeholder="Password" name="user_password" required>
                     <div id="left">
                       <div class="help-block text-left"><a href="home/recover.php">Forgot password?</a></div>
                     </div>
                     <div class="help-block text-right"><a href="home/signup.php">Sign up</a></div>
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

<?php //bugs.php lets user submit an error form that is sent to admin

  include 'assets/helper.php';
  $email_address = get_user_email_cookie();

  if (isset($_POST['submit'])) {
    $comments = "";
    if (isset($_POST['comments']))
      $comments = sanitizeString($_POST['comments']);
    if ($comments === "") 
      echo '<div class="alert alert-danger">No text in comments box!</div>';
    else {
      send_email("sales@instygraphics.com", "Bug Report", $comments);
      echo '<div class="alert alert-success">Successfully submitted bug report!</div>';
    }
  }
?>

    <div class="container">

        <h4 class="sub-header" align="center">Please describe the bug in detail!</h4>
        <form action="bugs.php" method="POST" role="form">
          <div class="form-group">
            <label for="comment">Comments</label>
            <textarea class="form-control" rows="5" id="comment" name="comments"></textarea>
          </div>
          <div class="centercontents">
            <div class="row">
              <button type="submit" class="btn btn-success" id="submit-btn" name="submit">Submit</button>
            </div>
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
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
