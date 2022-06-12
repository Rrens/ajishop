<?php
include "config.php";
session_start();

if (isset($_SESSION["login"])) {
  header("Location: index.php");
  exit;
}

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // echo "username = " . $username;
  echo "email = " . $email;
  echo "password = " . $password;

  $query = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM db_user WHERE EMAIL = '$email'"));

  if ($query) {
    $password_db = $query['PASSWORD'];
    $email_db = $query['EMAIL'];

    if ($password != $password_db) {
      $error_password = true;
    } elseif ($email != $email_db) {
      $error_email = true;
    } else {
      $_SESSION["login"] = $email;
      header("Location: index.php");
      // echo "<script alert('sukses login')/>";
      // echo "sukses";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Basic Page Needs
  ================================================== -->
  <meta charset="utf-8">
  <title>Aviato | E-commerce template</title>

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Construction Html5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Constra HTML Template v1.0">

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />

  <!-- Themefisher Icon font -->
  <link rel="stylesheet" href="plugins/themefisher-font/style.css">
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">

  <!-- Animate css -->
  <link rel="stylesheet" href="plugins/animate/animate.css">
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <link rel="stylesheet" href="plugins/slick/slick-theme.css">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="css/style.css">

</head>

<body id="body">
  <section class="signin-page account">
    <form action="" method="post">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="block text-center">
              <a class="logo" href="index.html">
                <img src="images/logo.png" alt="">
              </a>
              <h2 class="text-center">Welcome Back</h2>
              <form class="text-left clearfix" action="index.html">
                <div class="form-group">
                  <input type="email" class="form-control" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" placeholder="Password" name="password">
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-main text-center" name="submit">Login</button>
                </div>
              </form>
              <p class="mt-20">New in this site ?<a href="signin.html"> Create New Account</a></p>
              <?php if (isset($error_email)) : ?>
                <p style="color: red; font-style: italic; font-size: 14px;">Email Salah</p>
              <?php elseif (isset($error_password)) : ?>
                <p style="color: red; font-style: italic; font-size: 14px;">Password Salah</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
    </form>
    </div>
  </section>

  <!-- 
    Essential Scripts
    =====================================-->

  <!-- Main jQuery -->
  <script src="plugins/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.1 -->
  <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap Touchpin -->
  <script src="plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
  <!-- Instagram Feed Js -->
  <script src="plugins/instafeed/instafeed.min.js"></script>
  <!-- Video Lightbox Plugin -->
  <script src="plugins/ekko-lightbox/dist/ekko-lightbox.min.js"></script>
  <!-- Count Down Js -->
  <script src="plugins/syo-timer/build/jquery.syotimer.min.js"></script>

  <!-- slick Carousel -->
  <script src="plugins/slick/slick.min.js"></script>
  <script src="plugins/slick/slick-animation.min.js"></script>

  <!-- Google Mapl -->
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script> -->
  <!-- <script type="text/javascript" src="plugins/google-map/gmap.js"></script> -->

  <!-- Main Js File -->
  <script src="js/script.js"></script>



</body>

</html>