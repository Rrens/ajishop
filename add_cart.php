<?php
include "config.php";
// var_dump($id);
$query_user = mysqli_query($db, "SELECT * FROM db_user"); //nanti diganti session
$row_user = mysqli_fetch_assoc($query_user);
$user = $row_user['ID_USER'];
$cek_query = mysqli_query($db, "SELECT * FROM CART");
// $row_cek = mysqli_fetch_assoc($cek_query);
// if (isset($_POST['tmbh_cart'])) {

while ($row_cek = mysqli_fetch_assoc($cek_query)) {
    $row_cek['status'];
    echo "<br> INI STATUS ADA BRP";
    if ($row_cek['status'] == "berjalan") {
        echo "<br> INI STATUSNYA" . $row_cek['status'] . $row_cek['ID_CART'];
        break;
    }
}

if (isset($_POST['tmbh_cart'])) {
    $id = $_GET['id'];
    echo "ID_PRODUK = " . $id;
    if ($row_cek['status'] == null) {
        mysqli_query($db, "INSERT INTO cart VALUES('', '$user', '', '', '', '', 'berjalan')");
    } elseif ($row_cek['status'] == "selesai") {
        echo "<br> INI STATUSNYA" . $row_cek['status'] . $row_cek['ID_CART'];
        echo "<br> Sukses Update";
    } elseif ($row_cek['status'] == "berjalan") {
        $query_berjalan_awal = mysqli_query($db, "SELECT d.ID_CART_ITEM ,b.NAME, b.PRICE, b.DISCOUNT, d.QUANTITY 
                FROM cart_item d 
                JOIN product b ON d.ID_PRODUCT = b.ID_PRODUCT 
                JOIN cart c ON d.ID_CART = c.ID_CART 
                JOIN db_user a ON c.ID_USER = a.ID_USER WHERE c.status = 'berjalan'");
        $row_berjalan_awal = mysqli_fetch_assoc($query_berjalan_awal);
        $query_id_cart = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM cart WHERE status = 'berjalan'"));
        if ($row_berjalan_awal['ID_CART_ITEM'] != "") {
            $price = $row_berjalan_awal['PRICE'];
            echo "<br> harga = " . $price;
            // <br>
            $banyak = $row_berjalan_awal['QUANTITY'];
            echo "<br> banyak = " . $banyak;
            // <br>

            $query_berjalan_akhir = mysqli_query($db, "SELECT c.ID_CART, c.PRICE, c.DELIVERY_CHARGE, c.GRAND_TOTAL 
                    FROM cart_item d 
                    JOIN product b ON d.ID_PRODUCT = b.ID_PRODUCT 
                    JOIN cart c ON d.ID_CART = c.ID_CART 
                    JOIN db_user a ON c.ID_USER = a.ID_USER WHERE c.status = 'berjalan'");
            $row_berjalan_akhir = mysqli_fetch_assoc($query_berjalan_akhir);
            $id_cart = $row_berjalan_akhir['ID_CART'];

            $total_harga = $price * $banyak;
            echo "<br> TOTAL BAYAR = " . $total_harga;
            // <br>
            $ongkir = $total_harga / 0.01;
            echo "<br> BIAYA ONGKIR = " . $ongkir;
            mysqli_query($db, "UPDATE cart SET PROMO = 'COBAAJA', PRICE = '$price', `DELIVERY_CHARGE` = 5000, `GRAND_TOTAL` = '$total_harga' WHERE `cart`.`ID_CART` = '$id_cart'");
            header("Location: cart/index.php");
            $query_cek_cart_item = mysqli_query($db, "SELECT a.ID_PRODUCT FROM cart_item a JOIN cart b ON a.ID_CART = b.ID_CART WHERE status = 'berjalan'");

            while ($row_cek_cart_item = mysqli_fetch_assoc($query_cek_cart_item)) {
                $cek_id_produk = $row_cek_cart_item['ID_PRODUCT'];
                if ($id == $cek_id_produk) {
                    break;
                }
            }
            echo " <br> ID_PRODUK = " . $cek_id_produk;


            $query_product = mysqli_query($db, "SELECT * FROM product WHERE ID_PRODUCT = '$id'");
            $row_produk = mysqli_fetch_assoc($query_product);
            $price_product = $row_produk['PRICE'];
            $diskon = $row_produk['DISCOUNT'];
            echo "<br> HARGA_PRODUK = " . $price_product;


            $quantity = 1;
            if ($cek_id_produk != $id) {
                mysqli_query($db, "INSERT INTO cart_item VALUES ('', '$id_cart', '$id', '$price_product', '$diskon', '$quantity', '')");
                echo " <br> ID_BARANG JADI = " . $row_cek_cart_item['ID_PRODUCT'];
                echo "<header> SUKSES UPDATE";
                header("Location: cart.php");
            } elseif ($cek_id_produk == null) {
                mysqli_query($db, "INSERT INTO cart_item VALUES (5001, '$id_cart', '$id', '$price_product', '$diskon', '$quantity', '')");
                echo " <br> ID_BARANG JADI = " . $row_cek_cart_item['ID_PRODUCT'];
                echo "<header> SUKSES UPDATE";
                header("Location: cart.php");
            } else {
                echo "<H5> GAGAL UPDATE";
                header("Location: cart.php");
            }
        } else {
            $query_product = mysqli_query($db, "SELECT * FROM product WHERE ID_PRODUCT = '$id'");
            $row_produk = mysqli_fetch_assoc($query_product);
            $price_product = $row_produk['PRICE'];
            $diskon = $row_produk['DISCOUNT'];
            echo "<br> HARGA_PRODUK = " . $price_product;
            $cek_id_cart_berjalan = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM cart WHERE status = 'berjalan'"));
            $id_cart_null = $cek_id_cart_berjalan['ID_CART'];
            $quantity = 1;
            $query = mysqli_query($db, "INSERT INTO cart_item VALUES ('', '$id_cart_null', '$id', '$price_product', '$diskon', '$quantity', '')");
            if ($query) {
                echo "
                        <script>
                            alert('INSERT DARI NULL BERHASIL!!!!');
                        </script>
                        ";
            }
            header("Location: cart.php");
        }
    }
} elseif (isset($_POST['hapus_cart'])) {
    $id = $_GET['id'];
    $query = mysqli_query($db, "DELETE FROM category_product WHERE ID_PRODUCT = '$id'");
    $query2 = mysqli_query($db, "DELETE FROM product WHERE ID_PRODUCT = '$id'");
    if ($query2) {
        echo "
                    <script>
                        alert('Hapus PRODUK Sukses');
                    </script>
                ";
    }
    if ($query) {
        echo "
                    <script>
                        alert('Hapus CATEGORY Sukses');
                    </script>
                ";
        // header("Location: homepage.php");
    } else {
        echo "
                    <script>
                        alert('Hapus Gagal');
                    </script>
                ";
    }
} else {
    echo "
            <script>
                alert('Tidak membuka apa-apa');
            </script>
        ";
}
        // header("Location: Homepage/index.php");
