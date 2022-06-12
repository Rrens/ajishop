<?php
include "config.php";
session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

$login = $_SESSION['login'];

$query_user = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM db_user WHERE EMAIL = '$login'"));

$user = mysqli_fetch_assoc(mysqli_query($db, "SELECT FIRST_NAME FROM db_user WHERE EMAIL = '$login'"));
$cek_cart_id = mysqli_query($db, "SELECT * FROM cart WHERE status = 'berjalan'");
$row_cart = mysqli_fetch_assoc($cek_cart_id);
$id_cart = $row_cart['ID_CART'];
// $cek_cart_item = mysqli_query($db, "SELECT b.NAME, b.QUANTITY, b.PRICE, a.QUANTITY as 'BANYAK', a.ID_CART_ITEM FROM cart_item a JOIN product b ON a.ID_PRODUCT = b.ID_PRODUCT WHERE a.ID_CART = '$id_cart'");
$cek_cart_item = mysqli_query($db, "SELECT *, a.QUANTITY as 'BANYAK' FROM cart_item a JOIN product b ON a.ID_PRODUCT = b.ID_PRODUCT WHERE a.ID_CART = '$id_cart'");
$row_cart_item = mysqli_fetch_assoc($cek_cart_item);
$cek_quantity = mysqli_fetch_assoc(mysqli_query($db, "SELECT SUM(QUANTITY) 'BANYAK' FROM cart_item WHERE ID_CART = '$id_cart'"));
$banyak_uang = mysqli_fetch_assoc(mysqli_query($db, "SELECT SUM(a.tmp_price) 'BANYAK' FROM cart_item a JOIN product b ON a.ID_PRODUCT = b.ID_PRODUCT WHERE a.ID_CART = '$id_cart'"));
$quantity = 1;
$ambil_quantity = mysqli_query($db, "SELECT * FROM cart_item WHERE a.ID_CART = '$id_cart'");

if (isset($_POST['tambah'])) {
	$id_tambah = $_GET['id_cart_item'];
	$query_tambah = mysqli_query($db, "SELECT * FROM cart_item WHERE ID_CART_ITEM = '$id_tambah'");
	$row_tambah = mysqli_fetch_assoc($query_tambah);
	$hitung_tambah = $row_tambah['QUANTITY'];
	$hitung_tambah++;
	mysqli_query($db, "UPDATE cart_item SET QUANTITY = '$hitung_tambah' WHERE ID_CART_ITEM = '$id_tambah'");

	$row_tambah_stok = mysqli_fetch_assoc(mysqli_query($db, "SELECT b.QUANTITY, b.ID_PRODUCT FROM cart_item a JOIN product b ON a.ID_PRODUCT = b.ID_PRODUCT WHERE ID_CART_ITEM = '$id_tambah'"));
	$id_barang_tambah = $row_tambah_stok['ID_PRODUCT'];
	$stok = $row_tambah_stok['QUANTITY'];

	$total_tambah = $stok - 1;
	mysqli_query($db, "UPDATE product SET QUANTITY = '$total_tambah' WHERE ID_PRODUCT = '$id_barang_tambah'");

	$hitung_uang_satu = mysqli_fetch_assoc(mysqli_query($db, "SELECT PRICE, QUANTITY FROM cart_item WHERE ID_CART_ITEM = '$id_tambah'"));
	$hitung_uang_dua = $hitung_uang_satu['PRICE'] * $row_tambah['QUANTITY'];
	// echo "TOTAL UANG = " . $hitung_uang_dua;
	mysqli_query($db, "UPDATE cart_item SET  tmp_price = '$hitung_uang_dua' WHERE ID_CART_ITEM = '$id_tambah'");
	// echo "<br> TOTAL BANYAK = " . $cek_quantity['BANYAK'];
	$total_banyak = $banyak_uang['BANYAK'] - ($banyak_uang['BANYAK'] - ($cek_quantity['BANYAK'] * 1000));
	// echo "<br> BANYAK SEMUA = " .$total_banyak;
	mysqli_query($db, "UPDATE cart SET DELIVERY_CHARGE = '$total_banyak' WHERE ID_CART = '$id_cart'");
} else if (isset($_POST['kurang'])) {
	$id_kurang = $_GET['id_cart_item'];
	$query_kurang = mysqli_query($db, "SELECT * FROM cart_item WHERE ID_CART_ITEM = '$id_kurang'");
	$row_kurang = mysqli_fetch_assoc($query_kurang);
	$hitung_kurang = $row_kurang['QUANTITY'];
	$hitung_kurang--;
	mysqli_query($db, "UPDATE cart_item SET QUANTITY = '$hitung_kurang' WHERE ID_CART_ITEM = '$id_kurang'");

	$row_kurang_stok = mysqli_fetch_assoc(mysqli_query($db, "SELECT b.QUANTITY, b.ID_PRODUCT, a.QUANTITY 'BANYAK' FROM cart_item a JOIN product b ON a.ID_PRODUCT = b.ID_PRODUCT WHERE ID_CART_ITEM = '$id_kurang'"));
	$id_barang_kurang = $row_kurang_stok['ID_PRODUCT'];
	$stok = $row_kurang_stok['QUANTITY'];
	$row_banyak = $row_kurang_stok['BANYAK'];
	// echo "QUANTITY = " .$row_kurang_stok['BANYAK'];
	$total_kurang = $stok + 1;
	mysqli_query($db, "UPDATE product SET QUANTITY = '$total_kurang' WHERE ID_PRODUCT = '$id_barang_kurang'");

	$hitung_uang_satu = mysqli_fetch_assoc(mysqli_query($db, "SELECT PRICE, QUANTITY FROM cart_item WHERE ID_CART_ITEM = '$id_kurang'"));
	$hitung_uang_dua = $hitung_uang_satu['PRICE'] / $row_kurang['QUANTITY'];
	// echo "TOTAL UANG = " . $hitung_uang_dua;
	mysqli_query($db, "UPDATE cart_item SET tmp_price = '$hitung_uang_dua' WHERE ID_CART_ITEM = '$id_kurang'");
	// echo "<br> TOTAL BANYAK = " . $cek_quantity['BANYAK'];
	$total_banyak = $banyak_uang['BANYAK'] - ($banyak_uang['BANYAK'] - ($cek_quantity['BANYAK'] * 1000));
	// echo "<br> BANYAK SEMUA = " .$total_banyak;
	mysqli_query($db, "UPDATE cart SET DELIVERY_CHARGE = '$total_banyak' WHERE ID_CART = '$id_cart'");
	if ($row_kurang_stok['BANYAK'] < 1) {
		mysqli_query($db, "DELETE FROM cart_item WHERE ID_CART_ITEM = '$id_kurang'");
	}
} else {
	global $row_banyak, $id_kurang;
	// echo "<br> TOTAL BANYAK = " . $cek_quantity['BANYAK'];
	$total_banyak = $banyak_uang['BANYAK'] - ($banyak_uang['BANYAK'] - ($cek_quantity['BANYAK'] * 1000));
	// echo "<br> BANYAK SEMUA = " .$total_banyak;
	mysqli_query($db, "UPDATE cart SET DELIVERY_CHARGE = '$total_banyak' WHERE ID_CART = '$id_cart'");
	if ($row_banyak < 1) {
		mysqli_query($db, "DELETE FROM cart_item WHERE ID_CART_ITEM = '$id_kurang'");
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

	<?php include 'components/navbar.php' ?>

	<section class="page-header">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="content">
						<h1 class="page-name">Cart</h1>
						<ol class="breadcrumb">
							<li><a href="index.html">Home</a></li>
							<li class="active">cart</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>



	<div class="page-wrapper">
		<div class="cart shopping">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="block">
							<div class="product-list">
								<table class="table">
									<form method="post">
										<thead>
											<tr>
												<th class="">Item Name</th>
												<th class="">Item Price</th>
												<th class="">Available</th>
												<th class="">Quantity</th>
												<!-- <th class="">Actions</th> -->
											</tr>
										</thead>
										<tbody>
											<?php
											$query = mysqli_query($db, "SELECT a.ID_CART_ITEM, b.NAME, b.QUANTITY, a.QUANTITY 'BANYAK', b.PRICE, b.gambar FROM cart_item a JOIN product b ON a.ID_PRODUCT = b.ID_PRODUCT WHERE ID_CART = '$id_cart'");
											while ($row = mysqli_fetch_assoc($query)) :
											?>
												<tr class="">
													<td class="">
														<div class="product-info">
															<img width="80" src="images/product/<?= $row['gambar'] ?>" alt="" />
															<a href="#!"><?= $row['NAME'] ?></a>
														</div>
													</td>
													<td class="">Rp. <?= $row['PRICE'] ?></td>
													<td class=""><?= $row['BANYAK'] ?></td>
													<form action="cart.php?id_cart_item=<?= $row['ID_CART_ITEM'] ?>" method="post">
														<td>
															<a href="cart.php?id_cart_item=<?= $row['ID_CART_ITEM'] ?>">
																<button type="submit" name="tambah">+</button>
															</a>
															<a href="cart.php?id_cart_item=<?= $row['ID_CART_ITEM'] ?>">
																<button type="submit" name="kurang">-</button>
															</a>
														</td>
													</form>
													<!-- <td class="">
														<a class="product-remove" href="#!">Remove</a>
													</td> -->
												</tr>
											<?php endwhile ?>
										</tbody>
									</form>
								</table>
								<form action="checkout.php?id_cart=<?= $id_cart ?>" method="post">
									<button class="btn btn-main pull-right" name="submit" type="submit">Lanjutkan</button>
								</form>
								<!-- <a href=" checkout.html" class="btn btn-main pull-right">Checkout</a> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<footer class="footer section text-center">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul class="social-media">
						<li>
							<a href="https://www.facebook.com/themefisher">
								<i class="tf-ion-social-facebook"></i>
							</a>
						</li>
						<li>
							<a href="https://www.instagram.com/themefisher">
								<i class="tf-ion-social-instagram"></i>
							</a>
						</li>
						<li>
							<a href="https://www.twitter.com/themefisher">
								<i class="tf-ion-social-twitter"></i>
							</a>
						</li>
						<li>
							<a href="https://www.pinterest.com/themefisher/">
								<i class="tf-ion-social-pinterest"></i>
							</a>
						</li>
					</ul>
					<ul class="footer-menu text-uppercase">
						<li>
							<a href="contact.html">CONTACT</a>
						</li>
						<li>
							<a href="shop.html">SHOP</a>
						</li>
						<li>
							<a href="pricing.html">Pricing</a>
						</li>
						<li>
							<a href="contact.html">PRIVACY POLICY</a>
						</li>
					</ul>
					<p class="copyright-text">Copyright &copy;2021, Designed &amp; Developed by <a href="https://themefisher.com/">Themefisher</a></p>
				</div>
			</div>
		</div>
	</footer>

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