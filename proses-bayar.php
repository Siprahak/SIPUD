<?php
session_start();
require "koneksi.php";

function getDatabaseConnection() {
    $host = "localhost";
    $dbname = "db_sipud";
    $username = "root";
    $password = "";
    try {
        $con = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        return $con;
    } catch (PDOException $e) {
        die("Koneksi atau query bermasalah: " . $e->getMessage());
    }
}

$con = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $total = 0; 

   
    if (!empty($_SESSION['keranjang'])) {
        $sql = "SELECT * FROM produk WHERE PRODUK_ID in(";
        $idproduk = array_keys($_SESSION['keranjang']);
        $sql .= trim(str_repeat("?,", count($idproduk)), ",");
        $sql .= ")";
        $query = $con->prepare($sql);
        $query->execute($idproduk);
        while ($produk = $query->fetch()) {
            $total += $produk['HARGA'] * $_SESSION['keranjang'][$produk['PRODUK_ID']];
        }
    }

   
    $bukti = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'bukti/';
        $bukti = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $bukti);
    }

   
    $stmt = $con->prepare("INSERT INTO `order` (nama, alamat, no_telp, bukti, total, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([$nama, $alamat, $no_telp, $bukti, $total]);
    $order_id = $con->lastInsertId();


    if (!empty($_SESSION['keranjang'])) {
        $stmt = $con->prepare("INSERT INTO detail (order_id, produk, jumlah) VALUES (?, ?, ?)");
        foreach ($_SESSION['keranjang'] as $produk_id => $jumlah) {
            $query = $con->prepare("SELECT NAMA_PRODUK FROM produk WHERE PRODUK_ID = ?");
            $query->execute([$produk_id]);
            $produk = $query->fetch();
            $stmt->execute([$order_id, $produk['NAMA_PRODUK'], $jumlah]);
        }
    }


    $_SESSION['keranjang'] = [];

    header("Location: sukses.php");
    exit;
}
?>
