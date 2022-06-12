<?php
include "config.php";

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

$login = $_SESSION['login'];

if (isset($_GET['category'])) {
	$id = $_GET['category'];
	$query_name = mysqli_query($db, "SELECT * FROM CATEGORY WHERE ID_CATEGORY = '$id'");
} else {
	$query_name = mysqli_query($db, "SELECT * FROM CATEGORY");
}
$row_nama = mysqli_fetch_assoc($query_name);
$user = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM db_user WHERE EMAIL = '$login'"));
$id_user = $user['ID_USER'];
$query_keranjang = mysqli_fetch_assoc(mysqli_query($db, "select b.ID_CART, a.FIRST_NAME, b.status 
FROM cart b JOIN db_user a ON a.ID_USER = b.ID_USER WHERE a.ID_USER = '$id_user'"));

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

	<?php include "components/navbar.php" ?>

	<section class="page-header">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="content">
						<h1 class="page-name">Shop</h1>
						<ol class="breadcrumb">
							<li><a href="index.html">Home</a></li>
							<li class="active">shop</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="products section">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="widget product-category">
						<h4 class="widget-title">Categories</h4>
						<div class="panel-group commonAccordion" id="accordion" role="tablist" aria-multiselectable="true">
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingOne">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
											Jenis
										</a>
									</h4>
								</div>
								<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
									<div class="panel-body">
										<?php
										$query_jenis = mysqli_query($db, "SELECT * FROM category");


										while ($row = mysqli_fetch_assoc($query_jenis)) :

										?>
											<ul name="jenis">
												<li><a href="shop-sidebar.php?category=<?= $row['ID_CATEGORY'] ?>"><?= $row['NAME'] ?></a></li>
											</ul>
										<?php endwhile; ?>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingTwo">
									<h4 class="panel-title">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
											Brand
										</a>
									</h4>
								</div>
								<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
									<div class="panel-body">
										<?php
										$query_jenis = mysqli_query($db, "SELECT DISTINCT(brand) FROM product");


										while ($row_jenis = mysqli_fetch_assoc($query_jenis)) :

										?>
											<ul name="jenis">
												<li><a href="shop-sidebar.php?brand=<?= $row_jenis['brand'] ?>"><?= $row_jenis['brand'] ?></a></li>
											</ul>
										<?php endwhile; ?>
									</div>
								</div>
							</div>

						</div>

					</div>
				</div>

				<div class="col-md-9">
					<a href="add_product.php" class="btn btn-main btn-medium btn-round btn-icon" style="margin-bottom: 20px">Tambah Barang</a>
					<div class="row ">
						<?php
						if (isset($_GET['category'])) {
							$id_category = ($_GET['category']);
							$fetch_data_product = mysqli_query($db, "SELECT category.NAME as 'category_name', product.NAME, product.gambar, product.ID_PRODUCT, product.PRICE, product.PRICE,product.product_detail FROM category_product JOIN product ON category_product.ID_PRODUCT = product.ID_PRODUCT JOIN category ON category_product.ID_CATEGORY = category.ID_CATEGORY WHERE category.ID_CATEGORY = '$id_category'");
						} elseif (isset($_GET['brand'])) {
							$brand = $_GET['brand'];
							$fetch_data_product = mysqli_query($db, "SELECT * from product WHERE brand = '$brand'");
						} else {
							$fetch_data_product = mysqli_query($db, "SELECT category.NAME as 'category_name', product.NAME, product.gambar, product.ID_PRODUCT, product.PRICE, product.PRICE,product.product_detail FROM category_product JOIN product ON category_product.ID_PRODUCT = product.ID_PRODUCT JOIN category ON category_product.ID_CATEGORY = category.ID_CATEGORY");
						}
						while ($row_data = mysqli_fetch_assoc($fetch_data_product)) :
						?>
							<div class="col-md-4">
								<div class="product-item">
									<div class="product-thumb">
										<span class="bage">Sale</span>
										<img class="img-responsive" src="images/product/<?= $row_data['gambar'] ?>" alt="product-img" />
										<div class="preview-meta">
											<ul>
												<li>
													<span data-toggle="modal" data-target="#product-modal<?= $row_data['ID_PRODUCT'] ?>">
														<i class="tf-ion-ios-search-strong"></i>
													</span>
												</li>
												<!-- <li>
													<a href="#!"><i class="tf-ion-ios-heart"></i></a>
												</li> -->
												<li>
													<form action="add_cart.php?id=<?= $row_data['ID_PRODUCT'] ?>" method="post">
														<button type="submit" name="tmbh_cart" style="background: #fff; padding: 10px 0px; cursor: pointer; display: inline-block; font-size: 20px; transition: 0.2s all; width: 50px; ">
															<i class="tf-ion-android-cart"></i>
														</button>
														<!-- <button </button> -->

													</form>
												</li>
											</ul>
										</div>
									</div>
									<div class="product-content">
										<h4><a href="product-single.html"><?= $row_data['NAME'] ?></a></h4>
										<p class="price">Rp. <?= $row_data['PRICE'] ?></p>
									</div>
								</div>
							</div>
							<!-- Modal -->
							<div class="modal product-modal fade" id="product-modal<?= $row_data['ID_PRODUCT'] ?>">
								<butto n type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i class="tf-ion-close"></i>
								</butto>
								<div class="modal-dialog " role="document">
									<div class="modal-content">
										<div class="modal-body">
											<div class="row">
												<div class="col-md-8 col-sm-6 col-xs-12">
													<div class="modal-image">
														<img class="img-responsive" src="images/product/<?= $row_data['gambar'] ?>" alt="product-img" />
													</div>
												</div>
												<div class="col-md-4 col-sm-6 col-xs-12">
													<div class="product-short-details">
														<h2 class="product-title"><?= $row_data['NAME'] ?></h2>
														<p class="product-price"><?= $row_data['PRICE'] ?></p>
														<p class="product-short-description">
															<?= $row_data['product_detail'] ?>
														</p>
														<form action="add_cart.php?id=<?= $row_data['ID_PRODUCT'] ?>" method="post">
															<a href="add_cart.php?id=<?= $row_data['ID_PRODUCT'] ?>">
																<button type="submit" name="tmbh_cart" type="submit" class="btn btn-main mt-20">Add To Cart</button>
															</a>
														</form>
														<a href="product-single.php?id=<?= $row_data['ID_PRODUCT'] ?>" class="btn btn-transparent">View Product Details</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div><!-- /.modal -->
						<?php endwhile ?>
					</div>
				</div>


			</div>
		</div>
	</section>




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