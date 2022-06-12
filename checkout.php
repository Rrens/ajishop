<?php

include "config.php";
$id = $_GET['id_cart'];
$query = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM CART WHERE ID_CART = '$id'"));
// echo "HARGA". $query['PRICE'];
// if (isset($_POST['submit'])) {
$tambah_uang = mysqli_fetch_assoc(mysqli_query($db, "SELECT sum(tmp_price) 'BANYAK' FROM cart_item WHERE ID_CART = '$id'"));
$uang = $tambah_uang['BANYAK'];
$tambah_proses = mysqli_query($db, "UPDATE cart SET GRAND_TOTAL = '$uang' WHERE ID_CART = '$id'");
$query_cart = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM cart WHERE ID_CART = '$id'"));
$query_checkout = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM checkout WHERE ID_CART = '$id'"));

// }else{
// header("Location: Keranjang/index.php");
// }

if (isset($_POST['continue'])) {
	$nama = $_POST['nama'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$country = $_POST['country'];
	$zip = $_POST['zip'];
	$payment = $_POST['payment'];
	$name_card = $_POST['name_card'];
	$card_number = $_POST['card_number'];
	$expire = $_POST['expire'];
	$cvv = $_POST['cvv'];

	echo "NAMA = " . $nama;
	echo "<br> email = " . $email;
	echo "<br> address = " . $address;
	echo "<br> country = " . $country;
	echo "<br> zip = " . $zip;
	echo "<br> payment = " . $payment;
	echo "<br> name_card = " . $name_card;
	echo "<br> card number = " . $card_number;
	echo "<br> expire = " . $expire;
	echo "<br> cvv = " . $cvv;

	if ($query_checkout['ID_CART'] != "") {

		// $query_cek_1 = mysqli_query($db, "INSERT INTO checkout VALUES(10001, '$nama', '$address', '$country', '$payment', '$name_card', '$card_number', '$expire', '$cvv', '$id')");
		$query_cek_1 = mysqli_query($db, "INSERT INTO checkout VALUES (10001, '$name', '$address', '$country', '$payment', '$name_card', '$card_number', '$expire', '$cvv', '$id')");
		echo "
<script>
	alert('Pembelian Selesai, Kembali ke HOME');
</script>
";

		mysqli_query($db, "UPDATE cart SET status = 'selesai' WHERE ID_CART = '$id'");
		// header("Location: confirmation.php");
	} elseif ($query_checkout['ID_CART'] == "") {
		$query_cek_1 = mysqli_query($db, "INSERT INTO checkout VALUES ('', '$name', '$address', '$country', '$payment', '$name_card', '$card_number', '$expire', '$cvv', '$id')");
		echo "
<script>
	alert('Data Berhasil di inputkan, Kembali ke HOME');
</script>
";
		mysqli_query($db, "UPDATE cart SET status = 'selesai' WHERE ID_CART = '$id'");
		// header("Location: kon");
	}
	// echo "ININININININ = ". $query_checkout['ID_CHECKOUT'];
}

$query_order = mysqli_query($db, "SELECT product.gambar,product.NAME, product.PRICE, cart_item.QUANTITY FROM cart_item JOIN product ON cart_item.ID_PRODUCT = product.ID_PRODUCT WHERE ID_CART = '$id'");
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
	<link rel="stylesheet" href="css/datepicker.css" />

	<script src="js/bootstrap-datepicker.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

	<!-- Main Stylesheet -->
	<link rel="stylesheet" href="css/style.css">

</head>

<body id="body">
	<?php include "components/navbar.php" ?>
	<section class="page-header">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="content">
						<h1 class="page-name">Checkout</h1>
						<ol class="breadcrumb">
							<li><a href="index.html">Home</a></li>
							<li class="active">checkout</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="page-wrapper">
		<div class="checkout shopping">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<form class="" method="POST">
							<div class="block billing-details">
								<h4 class="widget-title">Billing Details</h4>
								<div class="form-group">
									<label for="full_name">Full Name</label>
									<input type="text" class="form-control" id="full_name" name="nama">
								</div>
								<div class="form-group">
									<label for="user_address">Address</label>
									<input type="text" class="form-control" id="user_address" name="address">
								</div>
								<div class="checkout-country-code clearfix">
									<div class="form-group">
										<label for="user_post_code">Zip Code</label>
										<input type="text" class="form-control" id="user_post_code" name="zip" value="">
									</div>
									<div class="form-group">
										<label for="user_city">Country</label>
										<input type="text" class="form-control" id="country" name="country" value="">
									</div>
								</div>

							</div>
							<div class="block">
								<h4 class="widget-title">Payment Method</h4>
								<p>Credit Cart Details (Secure payment)</p>
								<div class="checkout-product-details">
									<div class="payment">
										<div class="card-details">
											<div class="form-group">
												<label for="payment"><span class="required"></span></label>
												<select class="form-control" name="payment">
													<option selected>Choose payment method</option>
													<option value="credit">Credit Card</option>
													<option value="debit">Debit Card</option>
													<option value="paypal">Paypal</option>
												</select>
											</div>
											<div class="form-group half-width padding-left">
												<label for="name=card">Name on Card <span class="required"></span></label>
												<input id="name=card" class="form-control" type="tel" placeholder="Achmad Azzy" name="name_card">
											</div>
											<div class="form-group">
												<label for="card-number">Card Number <span class="required">*</span></label>
												<input id="card-number" class="form-control" type="tel" placeholder="•••• •••• •••• ••••" name="card_number">
											</div>
											<div class="form-group half-width padding-right">
												<label for="date" class="col-1 col-form-label">Date</label>
												<input id="card-number" class="form-control" type="date" placeholder="12/10/2004" name="expire">
											</div>
											<div class="form-group half-width padding-left">
												<label for="card-cvc">CVV <span class="required">*</span></label>
												<input id="card-cvc" name="cvv" class="form-control" type="tel" maxlength="4" placeholder="CVC">
											</div>
											<button name="continue" type="submit" class="btn btn-main mt-20">Place Order</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="col-md-4">
						<div class="product-checkout-details">
							<div class="block">
								<h4 class="widget-title">Order Summary</h4>
								<?php while ($row_order = mysqli_fetch_assoc($query_order)) : ?>
									<div class="media product-card">
										<a class="pull-left" href="product-single.html">
											<img class="media-object" src="images/product/<?= $row_order['gambar'] ?>" alt="Image" />
										</a>
										<div class="media-body">
											<h4 class="media-heading"><a href="product-single.html"><?= $row_order['NAME'] ?></a></h4>
											<p class="price">Rp. <?= $row_order['PRICE'] ?> x<?= $row_order['QUANTITY'] ?></p>
											<!-- <span class="remove">Remove</span> -->
										</div>
									</div>
								<?php endwhile ?>
								<!-- <div class="discount-code">
									<p>Have a discount ? <a data-toggle="modal" data-target="#coupon-modal" href="#!">enter it here</a></p>
								</div> -->
								<ul class="summary-prices">
									<li>
										<span>Subtotal:</span>
										<span class="price">Rp. <?= $query['GRAND_TOTAL'] ?></span>
									</li>
									<li>
										<span>Shipping:</span>
										<!-- <span>Free</span> -->
										<?php $cek = ($query['DELIVERY_CHARGE'] == '') ? 'Free' : $query['DELIVERY_CHARGE'];
										echo '<span>Rp. ' . $cek . '</span>';
										?>
									</li>
								</ul>
								<div class="summary-total">
									<span>Total</span>
									<span>Rp. <?php
												$total = $query['GRAND_TOTAL'] + $query['DELIVERY_CHARGE'];
												echo $total; ?></span>
								</div>
								<div class="verified-icon">
									<img src="images/shop/verified.png">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include 'components/footer.php' ?>
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