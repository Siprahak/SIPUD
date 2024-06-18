<?php
session_start();
require "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.5.2-web/css/fontawesome.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <!-- Terima Kasih -->
    <div class="container mt-4 d-flex justify-content-center align-items-center" style="height: 70vh;">
        <div class="text-center">
            <h1 class="mb-4">Terima Kasih Telah Berbelanja</h1>
            <a href="index.php" class="btn btn-primary">Kembali ke Homepage</a>
        </div>
    </div>

    <!-- Javascript -->
    <script src="bootstrap/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>
</html>
