<?php
include "config.php";
session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

$login = $_SESSION['login'];

$query_user = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM db_user WHERE EMAIL = '$login'"));

$id = $_GET['id'];
$query = mysqli_fetch_assoc(mysqli_query($db, "SELECT category.NAME as 'category_name', product.BRAND, product.NAME, product.gambar, product.ID_PRODUCT, product.PRICE, product.PRICE,product.product_detail  FROM category_product JOIN product ON category_product.ID_PRODUCT = product.ID_PRODUCT JOIN category ON category_product.ID_CATEGORY = category.ID_CATEGORY WHERE product.ID_PRODUCT = '$id'"));
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
	<!-- Start Top Header Bar -->
	<?php include 'components/navbar.php' ?>
	<section class="single-product">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<ol class="breadcrumb">
						<li><a href="index.php">Home</a></li>
						<li><a href="shop-sidebar.php">Shop</a></li>
						<li class="active">Single Product</li>
					</ol>
				</div>
			</div>
			<div class="row mt-20">
				<div class="col-md-5">
					<div class="single-product-slider">
						<div id='carousel-custom' class='carousel slide' data-ride='carousel'>
							<div class='carousel-outer'>
								<!-- me art lab slider -->
								<div class='carousel-inner '>
									<div class='item active'>
										<img src='images/product/<?= $query['gambar'] ?>' alt='' data-zoom-image="images/shop/single-products/product-1.jpg" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="single-product-details">
						<h2><?= $query['NAME'] ?></h2>
						<p class="product-price">Rp. <?= $query['PRICE'] ?></p>
						<div class="product-quantity">
							<span>Quantity:</span>
							<div class="product-quantity-slider">
								<input id="product-quantity" type="text" value="0" name="product-quantity">
							</div>
						</div>
						<div class="product-category">
							<span>Categories:</span>
							<ul>
								<li>
									<a href="shop-sidebar.php?category=<?= $query['ID_CATEGORY'] ?>"><?= $query['category_name'] ?></a>
									<a href="shop-sidebar.php?category=<?= $query['ID_CATEGORY'] ?>"><?= $query['BRAND'] ?></a>
								</li>
							</ul>
						</div>
						<form action="add_cart.php?id=<?= $query['ID_PRODUCT'] ?>" method="post">
							<a href="add_cart.php?id=<?= $query['ID_PRODUCT'] ?>">
								<button type="submit" name="tmbh_cart" type="submit" class="btn btn-main mt-20">Add To Cart</button>
							</a>
						</form>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="tabCommon mt-20">

						<div class="tab-content patternbg">
							<div id="details" class="tab-pane fade active in">
								<h4>Product Description</h4>
								<p><?= $query['product_detail'] ?></p>
							</div>
							<div id="reviews" class="tab-pane fade">

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	// $id_category = $query['ID_CATEGORY'];
	$query_modal = mysqli_query($db, "SELECT category.NAME as 'category_name', product.BRAND, product.NAME, product.gambar, product.ID_PRODUCT, product.PRICE, product.PRICE, product.product_detail, category.ID_CATEGORY FROM category_product JOIN product ON category_product.ID_PRODUCT = product.ID_PRODUCT JOIN category ON category_product.ID_CATEGORY = category.ID_CATEGORY WHERE PRODUCT.ID_PRODUCT = '$id'");
	while ($row_data = mysqli_fetch_assoc($query_modal)) :

	?>

		<section class="products related-products section">
			<div class="container">
				<div class="row">
					<div class="title text-center">
						<h2>Related Products</h2>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<div class="product-item">
							<div class="product-thumb">
								<img class="img-responsive" src="images/product/<?= $row_data['gambar'] ?>" alt="product-img" />
								<div class="preview-meta">
									<ul>
										<li>
											<span data-toggle="modal" data-target="#product-modal<?= $row_data['ID_PRODUCT'] ?>">
												<i class="tf-ion-ios-search"></i>
											</span>
										</li>
										<li>
											<a href="#"><i class="tf-ion-ios-heart"></i></a>
										</li>
										<li>
											<a href="#!"><i class="tf-ion-android-cart"></i></a>
										</li>
									</ul>
								</div>
							</div>
							<div class="product-content">
								<h4><a href="product-single.php"><?= $row_data['NAME'] ?></a></h4>
								<p class="price">Rp. <?= $row_data['PRICE'] ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>



		<!-- Modal -->
		<div class="modal product-modal fade" id="product-modal<?= $row_data['ID_PRODUCT'] ?>">
			<button type=" button" class="close" data-dismiss="modal" aria-label="Close">
				<i class="tf-ion-close"></i>
			</button>
			<div class="modal-dialog " role="document">
				<div class="modal-content">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-8">
								<div class="modal-image">
									<img class="img-responsive" src="images/product/<?= $row_data['gambar'] ?>" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="product-short-details">
									<h2 class="product-title"><?= $row_data['NAME'] ?></h2>
									<p class="product-price">Rp. <?= $row_data['PRICE'] ?></p>
									<p class="product-short-description">
										<?= $row_data['product_detail'] ?>
									</p>
									<a href="add_cart.php?id=<?= $query['ID_PRODUCT'] ?>">
										<button type="submit" name="tmbh_cart" type="submit" class="btn btn-main mt-20">Add To Cart</button>
									</a>
									<a href="product-single.php?id=<?= $row_data['ID_PRODUCT'] ?>" class="btn btn-transparent">View Product Details</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	endwhile;

	include 'components/footer.php' ?>
</body>

</html>