<?php
include "config.php";

$query_user = mysqli_query($db, "SELECT FIRST_NAME FROM db_user");
$row = mysqli_fetch_assoc($query_user);

if (isset($_POST['simpan'])) {

    // $id = ($_GET['id_category']) != null ? $_GET['id'] : 3001;
    if ($_POST['jenis'] == 'BAJU') {
        $id = 3001;
    } elseif ($_POST['jenis'] == 'CELANA') {
        $id = 3002;
    } elseif ($_POST['jenis'] == 'JAKET') {
        $id = 3003;
    }
    // $id = $_GET['id_category'];
    $nama = $_POST['nama'];
    $brand = $_POST['brand'];
    $harga = $_POST['price'];
    $diskon = $_POST['discount'];
    $quantity = $_POST['quantity'];
    $deksripsi = $_POST['deskripsi'];
    // $foto = $_POST['file'];
    // echo $id;

    // $targer_dir = "gambar/";
    // $name_photo = $_FILES['file']['name'];
    // $target_file = $targer_dir . basename($name_photo);
    // $uploadOK = 1;
    // $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // CEK GAMBARNYA BENERAN APA GA


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
    move_uploaded_file($file_temp, 'images/product/' . $nama_foto);
    $cek_nama_barang = mysqli_query($db, "SELECT * FROM product");

    while ($row_nama_barang = mysqli_fetch_assoc($cek_nama_barang)) {
        $nama_barang = $row_nama_barang['NAME'];
        if ($nama_barang == null) {
            mysqli_query($db, "INSERT INTO product VALUES(4001, '$nama ', '$harga', '$diskon', '$quantity', '$nama_foto', '', '$deksripsi', '$brand')");
            mysqli_query($db, "INSERT INTO category_product VALUES('$id',4001)");
            echo "
                    <script>
                        alert('Data sukses ditambahkan');
                    </script>
                ";
            break;
        } else if ($nama_barang != $nama) {
            mysqli_query($db, "INSERT INTO product VALUES('', '$nama ', '$harga', '$diskon', '$quantity', '$nama_foto', '', '$deksripsi', '$brand')");
            echo "
                    <script>
                        alert('Data sukses ditambahkan');
                    </script>
                ";
            break;
        } else if ($nama_barang == $nama) {
            echo "
                    <script>
                        alert('Data Gagal ditambahkan');
                    </script>
                ";
            // break;
        }
    }
    $query_update_barang_baru = mysqli_query($db, "SELECT * FROM product ORDER BY ID_PRODUCT DESC LIMIT 1");
    $row_query_update_barang_baru = mysqli_fetch_assoc($query_update_barang_baru);
    $id_barang = $row_query_update_barang_baru['ID_PRODUCT'];
    $query =  mysqli_query($db, "INSERT INTO category_product VALUES('', '$id','$id_barang')");
    // header("Location: add_product.php");
    // $row_id_barang = mysqli_fetch_assoc($cek_id_barang);

    // mysqli_query($db, "INSERT INTO BARANG VALUES('', '$nama', '$harga', '$stok', '$deksripsi')");
    // echo "
    //     <script>
    //         alert('Data sukses ditambahkan');
    //     </script>
    // ";
    if ($query) {
        echo "
                    <script>
                        alert('Category Sukses Ditambahkan');
                    </script>
                ";
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

<body>
    <?php
    include 'components/navbar.php'
    ?>
    <div class="container">
        <div class="row">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-5 mt-3">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" required>
                </div>
                <div class="mb-3">
                    <!-- <input type="text" class="form-control" name="brand" required> -->
                    <label for="brand">Brand</label>
                    <select class="form-control form-select-lg mb-3" name="brand">
                        <option selected>Pilih Merk</option>
                        <option value="Erigo">Erigo</option>
                        <option value="Roughneck">Roughneck</option>
                        <option value="Nike">Nike</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jenis">Jenis</label>
                    <select class="form-control form-select-lg mb-3" name="jenis">
                        <option selected>Pilih Jenis</option>
                        <option value="BAJU">Baju</option>
                        <option value="CELANA">Celana</option>
                        <option value="JAKET">Jaket</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" name="price" required>
                </div>
                <div class="mb-3">
                    <label for="discount">Discount</label>
                    <input type="text" class="form-control" name="discount" required>
                </div>
                <div class="mb-3">
                    <label for="quantity">Quantity</label>
                    <input type="text" class="form-control" name="quantity" required>
                </div>
                <div class="mb-3">
                    <!-- <label class="input-group-text" for="inputGroupFile01">Upload Gambar</label> -->
                    <label for="foto">Input Foto</label>
                    <input type="file" class="form-control" name="file" id="foto">
                </div>
                <div class="mb-3">
                    <label for="quantity">Deskripsi Produk</label>
                    <input type="text" class="form-control" name="deskripsi" style="padding-bottom: 80px;" required>
                </div>
                <div class="mb-3">
                    <button type="submit" name="simpan" class="btn btn-primary">simpan</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>