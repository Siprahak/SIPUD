laporan.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/fontawesome-free-6.5.2-web/css/all.min.css">

    <!-- jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }

    form div {
        margin-bottom: 10px;
    }

    .img-thumbnail {
        max-width: 200px;
    }

    .detail-item-list {
        list-style-type: none;
        padding-left: 0;
    }

    .detail-item-list li {
        margin-bottom: 5px;
    }
</style>

<body>
<?php require "navbar.php"; ?>

<div class="container mt-5">

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
            <a href="../adminpanel" class="no-decoration text-muted">
            <i class="fas fa-home me-1"></i>Home
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Laporan
        </li>
    </ol>
</nav>

<?php
require "../koneksi.php"; // Memastikan file koneksi.php di-include

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['status'], $_POST['order_id'])) {
    $status = $_POST['status'];
    $order_id = $_POST['order_id'];

    $sql = "UPDATE `order` SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
    $stmt->close();

    // Redirect untuk menghindari resubmission form
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Mengambil data pesanan
$sql = "SELECT order_id, nama, alamat, no_telp, total, waktu, status, bukti FROM `order`";
$result = $conn->query($sql);

$data_pemesanan = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data_pemesanan[] = $row;
    }
} else {
    echo "0 hasil";
}

// Mengambil total barang yang terjual dari setiap barang
$sql_total_barang = "SELECT produk, SUM(jumlah) as total_terjual FROM detail GROUP BY produk";
$result_total_barang = $conn->query($sql_total_barang);

$total_barang_terjual = [];
if ($result_total_barang->num_rows > 0) {
    while ($row = $result_total_barang->fetch_assoc()) {
        $total_barang_terjual[] = $row;
    }
}
?>

<h2>Laporan Penjualan</h2>
<a href="http://localhost/fp-sipud-coba2/adminpanel/cetak.php" class="btn btn-primary mb-4">Cetak</a>

<!-- Tabel Total Barang Terjual -->
<h4>Total Barang Terjual</h4>
<table class="table table-striped mb-5">
    <thead>
        <tr>
            <th>Produk</th>
            <th>Total Terjual</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($total_barang_terjual as $barang) { ?>
            <tr>
                <td><?php echo htmlentities($barang['produk']); ?></td>
                <td><?php echo htmlentities($barang['total_terjual']); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Tabel Laporan Penjualan -->
<table class="table table-striped" id="tabel-laporan">
    <thead>
        <tr>
            <th>ID Order</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>No Telepon</th>
            <th>Total</th>
            <th>Waktu</th>
            <th>Status</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data_pemesanan as $pemesanan) { ?>
            <tr>
                <td><?php echo $pemesanan['order_id']; ?></td>
                <td><?php echo $pemesanan['nama']; ?></td>
                <td><?php echo $pemesanan['alamat']; ?></td>
                <td><?php echo $pemesanan['no_telp']; ?></td>
                <td><?php echo number_format($pemesanan['total'], 0, ",", "."); ?></td>
                <td><?php echo $pemesanan['waktu']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $pemesanan['order_id']; ?>">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="pending" <?php echo $pemesanan['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="terverifikasi" <?php echo $pemesanan['status'] == 'terverifikasi' ? 'selected' : ''; ?>>Terverifikasi</option>
                        </select>
                    </form>
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $pemesanan['order_id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                            Lihat Detail
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $pemesanan['order_id']; ?>">
                            <li class="dropdown-item">
                                <img src="../bukti/<?php echo $pemesanan['bukti']; ?>" alt="Bukti Transfer" class="img-thumbnail">
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <?php
                            // Mengambil detail pesanan
                            $sql_detail = "SELECT produk, jumlah FROM detail WHERE order_id = ?";
                            $stmt_detail = $conn->prepare($sql_detail);
                            $stmt_detail->bind_param("i", $pemesanan['order_id']);
                            $stmt_detail->execute();
                            $result_detail = $stmt_detail->get_result();
                            while ($detail = $result_detail->fetch_assoc()) {
                                echo "<li class='dropdown-item'>" . htmlentities($detail['produk']) . " (Jumlah: " . htmlentities($detail['jumlah']) . ")</li>";
                            }
                            $stmt_detail->close();
                            ?>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script src="../bootstrap/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>
</html>
