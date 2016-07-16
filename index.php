<?php

  include 'assets/helper.php';
  $email_address = get_user_email_cookie();
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/favicon.ico">

    <title>Home</title>

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

    <div class="container">

      <!-- Carousel
      ================================================== -->
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
          <div class="item active">
            <img class="first-slide" src="img/code.jpg" alt="First slide">
            <div class="container">
              <div class="carousel-caption">
                <a class="btn btn-lg btn-primary" href="#" role="button">Custom Website Creation</a>
              </div>
            </div>
          </div>
          <div class="item">
            <img class="second-slide" src="img/fullstack.jpg" alt="Second slide">
            <div class="container">
              <div class="carousel-caption">
                <a class="btn btn-lg btn-primary" href="#" role="button">Full Stack Development</a>
              </div>
            </div>
          </div>
          <div class="item">
            <img class="third-slide" src="img/printing.jpg" alt="Third slide">
            <div class="container">
              <div class="carousel-caption">
                <a class="btn btn-lg btn-primary" href="#" role="button">Print and Imaging</a>
              </div>
            </div>
          </div>
        </div>
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div><!-- /.carousel -->

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Torcuda Software</h1>
        <p>Subdivision of instygraphics that designs custom software tools for small businesses. Fast, robust, and maintainable code that provides consumer grade programs at a fair price.</p>
        <p>Currently in beta.</p>
        <p>
          <a class="btn btn-lg btn-primary" href="www.instygraphics.com/torcuda" role="button">Go to Torcuda &raquo;</a>
        </p>
      </div>

      <div class="page-header">
        <h1>6 Steps to Success</h1>
      </div>
      <div class="well">
        <p>Revolutions don't come easy. Thats why instygraphics devised a 6 step method to properly align your business with the new age of technology. From coming up with an advertising strategy to building your web server, we got you every step of the way.</p>
      </div>

      <div class="row">
        <div class="col-xs-6 col-lg-4">
          <h3>Step 1: Outline your goals</h3>
          <p>Write it on paper. Plan it on a whiteboard. Walk us through your thoughts. It is often said that the hardest part is figuring out what to do. Once this plan is airtight, the rest is a cakewalk.</p>
          <p><a class="btn btn-default" href="#" role="button">Learn more &raquo;</a></p>
        </div><!--/.col-xs-6.col-lg-4-->
        <div class="col-xs-6 col-lg-4">
          <h3>Step 2: Generate a strategy</h3>
          <p>At instygraphics, we know that one size doesn't fit all. That's why we have a plethora of different ways you can achieve your goals - and if you have a vision for something unique, we'll help you make it a reality.</p>
          <p><a class="btn btn-default" href="#" role="button">Learn more &raquo;</a></p>
        </div><!--/.col-xs-6.col-lg-4-->
        <div class="col-xs-6 col-lg-4">
          <h3>Step 3: Gather the resources</h3>
          <p>Need a website capable of handling over 100 simultaneous users? What kind of hardware would you need? instygraphics knows what, where, and for how much supplies are actually worth.</p>
          <p><a class="btn btn-default" href="#" role="button">Learn more &raquo;</a></p>
        </div><!--/.col-xs-6.col-lg-4-->
        <div class="col-xs-6 col-lg-4">
          <h3>Step 4: Put it together</h3>
          <p>We'll take the pain out of binding 100 spiral-bound textbooks, as well as build your website from the ground up. Need custom instructions? instygraphics thrives on its ability to give full attention to any project. </p>
          <p><a class="btn btn-default" href="#" role="button">Learn more &raquo;</a></p>
        </div><!--/.col-xs-6.col-lg-4-->
        <div class="col-xs-6 col-lg-4">
          <h3>Step 5: Regression testing</h3>
          <p>instygraphics will test each of our products and services until it exceeds your standards. If what you see isn't to your liking, 100% money back guarentee, as well as a generous return policy.</p>
          <p><a class="btn btn-default" href="#" role="button">Learn more &raquo;</a></p>
        </div><!--/.col-xs-6.col-lg-4-->
        <div class="col-xs-6 col-lg-4">
          <h3>Step 6: Following up</h3>
          <p>Our job isn't done yet. We'll periodically check up on you, do routine maintenance free of charge, and reassess your business needs after 6 months. instygraphics is more than just a one-time purchase.</p>
          <p><a class="btn btn-default" href="#" role="button">Learn more &raquo;</a></p>
        </div><!--/.col-xs-6.col-lg-4-->
      </div><!--/row-->

      <div class="alert alert-info" role="alert">
        <strong>Heads up!</strong> instygraphics.com is still in development, so please report any bugs you find.
      </div>

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
