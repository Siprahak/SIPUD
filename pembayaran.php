<?php
session_start();
require "koneksi.php";

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

if(!empty($_POST)){
    foreach($_POST['jumlah'] as $id => $jumlah){
        $_SESSION['keranjang'][$id] = max($jumlah, 1);
    }

    header("Location: keranjang.php");
    exit;
}

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.5.2-web/css/fontawesome.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>
    
    <!-- Transfer Information -->
    <div class="container mt-4">
        <div class="alert alert-info text-center">
            <h1>Transfer ke BCA 6077677026 atas nama Maheswara</h1>
        </div>
    </div>

    <!-- Tabel Keranjang -->
    <div class="container">
        <form action="" method="post">
        <table class="table table-striped">
            <!-- Table Head -->
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th class="text-end">Harga</th>
                    <th class="text-end">Total</th>
                    <th></th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody>
                <?php
                if (!empty($_SESSION['keranjang'])) {
                    $sql = "SELECT * FROM produk WHERE PRODUK_ID in(";
                    $idproduk = array_keys($_SESSION['keranjang']);
                    $sql .= trim(str_repeat("?,", count($idproduk)), ",");
                    $sql .= ")";
                    $query = $con->prepare($sql);
                    $query->execute($idproduk);
                    $total = 0;
                    while ($produk = $query->fetch()) {
                        $total += $produk['HARGA'] * $_SESSION['keranjang'][$produk['PRODUK_ID']];
                ?>
                <tr>
                    <td><?php echo htmlentities($produk['NAMA_PRODUK']); ?></td>
                    <td>
                    <input type="number" class="form-control w-auto" name="jumlah[<?php echo $produk['PRODUK_ID']; ?>]" value="<?php echo $_SESSION['keranjang'][$produk['PRODUK_ID']]; ?>" readonly>
                    </td>
                    <td class="text-end"><?php echo number_format($produk['HARGA'], 0, ",", "."); ?></td>
                    <td class="text-end"><?php echo number_format($produk['HARGA'] * $_SESSION['keranjang'][$produk['PRODUK_ID']], 0, ",", "."); ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="3" class="text-end">Total</td>
                    <td class="text-end h4 text-success"><?php echo number_format($total, 0, ",", "."); ?></td>
                </tr>
                <?php 
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Keranjang Belanja Kosong</td></tr>";
                } ?>

            </tbody>
        </table>
        </form>

        <!-- Form Input -->
        <div class="mt-4">
            <h3>Input Data Pembeli</h3>
            <form action="proses-bayar.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                </div>
                <div class="mb-3">
                    <label for="no_telp" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Bukti Transfer</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                </div>
                <button type="submit" class="btn btn-primary">Bayar</button>
            </form>
        </div>
    </div>

    <!-- Javascript -->
    <script src="bootstrap/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>
</html>
