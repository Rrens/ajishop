<!-- 
THEME: Aviato | E-commerce template
VERSION: 1.0.0
AUTHOR: Themefisher

HOMEPAGE: https://themefisher.com/products/aviato-e-commerce-template/
DEMO: https://demo.themefisher.com/aviato/
GITHUB: https://github.com/themefisher/Aviato-E-Commerce-Template/

WEBSITE: https://themefisher.com
TWITTER: https://twitter.com/themefisher
FACEBOOK: https://www.facebook.com/themefisher
-->

<?php
include "config.php";

if (isset($_POST['simpan'])) {
  $nama_depan = $_POST['nama_depan'];
  $nama_belakang = $_POST['nama_belakang'];
  $email = strtolower($_POST['email']);
  $nomor = $_POST['nomor'];
  $kecamatan = $_POST['kecamatan'];
  $provinsi = $_POST['provinsi'];
  $kota = $_POST['kota'];
  $password = $_POST['password'];
  $repassword = $_POST['repassword'];
  $gambar = $_POST['file'];

  $query = mysqli_query($db, "SELECT * FROM db_user");
  while ($row = mysqli_fetch_assoc($query)) {
    $row_email = $row['EMAIL'];
    if ($row_email == null) {
      break;
    } else if ($row_email == $email) {
      echo "
                    <script>
                        alert('Email Sudah Pernah digunakan');
                    </script>
                ";
    }
  }


  $ekstensi_diperboleh = array('png', 'jpg');
  $nama_foto = basename($_FILES['file']['name']);
  $x = explode('.', $nama_foto);
  $ekstensi = strtolower(end($x));
  $ukuran = $_FILES['file']['size'];
  $file_temp = $_FILES['file']['tmp_name'];

  if (in_array($ekstensi, $ekstensi_diperboleh) === true) {
    if ($ukuran > 10440700) {
      echo "
                    <script>
                        alert('Ukuran File Terlalu Besar');
                    </script>
                ";
    }
  } else {
    echo "
                <script>
                    alert('Eksetensi Yang diperbolehkan Hanya jpg dan png');
                </script>
            ";
  }
  move_uploaded_file($file_temp, 'images/profile' . $nama_foto);



  echo "<br> nama depan = " . $nama_depan;
  echo "<br> nama belakang = " . $nama_belakang;
  echo "<br> email = " . $email;
  echo "<br> number = " . $nomor;
  echo "<br> kecamatan = " . $kecamatan;
  echo "<br> provinsi = " . $provinsi;
  echo "<br> kota = " . $kota;
  echo "<br> password = " . $password;
  echo "<br> repassword = " . $repassword;
  var_dump($gambar);

  $query = mysqli_query($db, "SELECT * FROM db_user");
  while ($row = mysqli_fetch_assoc($query)) {
    $row_email = $row['EMAIL'];
    echo "EMAILROW" . $row_email;
  }

  if ($password != $repassword) {

    echo "
            <script>
                alert('Password tidak cocok');
            </script>
            ";
  } else {
    if ($row_email == null) {
      echo "
            <script>
                alert('Sukses Mendaftar dengan null');
            </script>
            ";
      $query_1 = mysqli_query($db, "INSERT INTO db_user VALUES('','$nama_depan','$nama_belakang','$email','$password','$provinsi','$kota','$kecamatan',''$nama_foto,'$nomor','')");
      if ($query_1) {
        echo "
                <script>
                    alert('SUKSES');
                </script>
                ";
      }
      if ($query) {
        echo "                                    
                    <script>
                    alert('JELEK');
                    </script>
                ";
      }
    } else if ($row_email == $email) {
      echo "
            <script>
                alert('Email Sudah Pernah digunakan');
            </script>
            ";
    } elseif ($row_email != $email) {
      echo "
            <script>
                alert('Sukses Mendaftar');
            </script>`
            ";
      $query_2 = mysqli_query($db, "INSERT INTO db_user VALUES('','$nama_depan','$nama_belakang','$email','$password','$provinsi','$kota','$kecamatan','$nama_foto','$nomor','')");
      // INSERT INTO `db_user` (`ID_USER`, `FIRST_NAME`, `LAST_NAME`, `EMAIL`, `PASSWORD`, `PROVINSI`, `CITY`, `DISTRICTS`, `PHOTO`, `PHONE`, `FAVORITE`) VALUES (NULL, 'Rendy', 'Yusuf', 'rendi@yusuf.com', 'aaaa', 'Surabaya Timur', 'Surabaya', 'tambak', '', '091241525', NULL)
      if ($query_2) {
        echo "
                <script>
                    alert('SUKSES');
                </script>
                ";
      }
    }
    // mysqli_query($db, "INSERT INTO db_user VALUES('','$nama_depan','$nama_belakang','$email','$password','$provinsi','$kota','$kecamatan','$nama_foto','$nomor','')");
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic Page Needs
  ================================================== -->
  <meta charset="utf-8" />
  <title>Aviato | E-commerce template</title>

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="Construction Html5 Template" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  <meta name="author" content="Themefisher" />
  <meta name="generator" content="Themefisher Constra HTML Template v1.0" />

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />

  <!-- Themefisher Icon font -->
  <link rel="stylesheet" href="plugins/themefisher-font/style.css" />
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css" />

  <!-- Animate css -->
  <link rel="stylesheet" href="plugins/animate/animate.css" />
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="plugins/slick/slick.css" />
  <link rel="stylesheet" href="plugins/slick/slick-theme.css" />

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="css/style.css" />
</head>

<body id="body">
  <section class="signin-page account">
    <form action="" method="post" enctype="multipart/form-data">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="block text-center">
              <a class="logo" href="index.html">
                <img src="images/logo.png" alt="" />
              </a>
              <h2 class="text-center">Create Your Account</h2>
              <form class="text-left clearfix" action="index.html">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="First Name" name="nama_depan" />
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Last Name" name="nama_belakang" />
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" placeholder="Email" name="email" />
                </div>
                <div class="form-group">
                  <input type="number" class="form-control" placeholder="Nomor Telepon" name="nomor" />
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" placeholder="Password" name="password" />
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Masukan Password Lagi" name="repassword" />
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="kecamatan" placeholder="Kecamatan" name="kecamatan" />
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="provinsi" placeholder="Provinsi" name="provinsi" />
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="kota" placeholder="Kota" name="kota" />
                </div>
                <div class="form-group">
                  <input class="form-control" type="file" name="file">
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-main text-center" name="simpan">
                    Sign In
                  </button>
                </div>
              </form>
              <p class="mt-20">
                Already hava an account ?<a href="login.php"> Login</a>
              </p>
              <!-- <p><a href="forget-password.html"> Forgot your password?</a></p> -->
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
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
  <script type="text/javascript" src="plugins/google-map/gmap.js"></script>

  <!-- Main Js File -->
  <script src="js/script.js"></script>
</body>

</html>