<?php
    require "session.php";
    require "../koneksi.php";

    $querykategori = mysqli_query($conn, "SELECT * FROM kategori");
    $jumlahkategori = mysqli_num_rows($querykategori);

    $queryproduk = mysqli_query($conn, "SELECT * FROM produk");
    $jumlahproduk = mysqli_num_rows($queryproduk);
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="../fontawesome/fontawesome-free-6.5.2-web/css/fontawesome.min.css">
</head>

<style>
    .kotak {
        border: solid;
    }

    .summary-kategori {
        background-color: #0a6b4a;
        border-radius: 10px;
    }

    .summary-product {
        background-color: #0a516b;
        border-radius: 15px;
    }

    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php" ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-home me-1"></i>Home</li>
            </ol>
        </nav>
    <h2>Welcome <?php echo $_SESSION['username']?></h2>

        <div class="caontainer mt-5">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-kategori p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-align-justify fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Kategori</h3>
                                <p class="fs-4"><?php echo $jumlahkategori; ?> Kategori</p>
                                <p><a href="kategori.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>      
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-product p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-box fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Produk</h3>
                                <p class="fs-4"><?php echo $jumlahproduk; ?> Produk</p>
                                <p><a href="Produk.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script src="../bootstrap/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>
</html>
