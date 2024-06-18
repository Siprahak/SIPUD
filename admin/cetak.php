<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>laporan</title>

     <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/fontawesome-free-6.5.2-web/css/fontawesome.min.css">

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

$sql = "SELECT PELANGGAN_ID, TANGGAL_PEMESANAN, TOTAL_HARGA, STATUS_BAYAR FROM pemesanan";
$result = $conn->query($sql);

$data_pemesanan = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data_pemesanan[] = $row;
    }
} else {
    echo "0 hasil";
}
$conn->close();
?>

<h2>Laporan Penjualan</h2>
<table class="table" id="tabel-laporan">
    <thead>
        <tr>
            <th>ID Pelanggan</th>
            <th>Tanggal Pemesanan</th>
            <th>Total Harga</th>
            <th>Status Bayar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data_pemesanan as $pemesanan) { ?>
            <tr>
                <td><?php echo $pemesanan['PELANGGAN_ID']; ?></td>
                <td><?php echo $pemesanan['TANGGAL_PEMESANAN']; ?></td>
                <td><?php echo $pemesanan['TOTAL_HARGA']; ?></td>
                <td><?php echo $pemesanan['STATUS_BAYAR']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    window.print();
</script>

    <script src="../bootstrap/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>
</html>
