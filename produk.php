<?php
require "koneksi.php";

$querykategori = mysqli_query($conn, "SELECT * FROM kategori");

if (isset($_GET['keyword'])) {
    $queryproduk = mysqli_query($conn, "SELECT * FROM produk WHERE NAMA_PRODUK LIKE '%$_GET[keyword]%'");
} elseif (isset($_GET['kategori'])) {
    $querygetkategoriid = mysqli_query($conn, "SELECT KATEGORI_ID FROM kategori WHERE NAMA_KATEGORI='$_GET[kategori]'");
    $kategoriid = mysqli_fetch_array($querygetkategoriid);
    $queryproduk = mysqli_query($conn, "SELECT * FROM produk WHERE KATEGORI_ID='$kategoriid[KATEGORI_ID]'");
} else {
    $queryproduk = mysqli_query($conn, "SELECT * FROM produk");
}

$countdata = mysqli_num_rows($queryproduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Produk</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.5.2-web/css/fontawesome.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .image-box img {
            max-height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .card-title {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }
        .card-truncate {
            flex: 1;
        }
        .card-harga {
            font-weight: bold;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .btn {
            margin-top: auto;
        }
        .category-card {
            text-align: center;
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.2s;
        }
        .category-card:hover {
            transform: scale(1.05);
        }
        .category-icon {
            font-size: 3rem;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>
    <!-- Banner 2 -->
    <div class="container-fluid banner2 d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Produk</h1>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3>Kategori</h3>
                <div class="row">
                    <?php while ($kategori = mysqli_fetch_array($querykategori)) { ?>
                    <div class="col-md-12">
                        <a class="no-decoration" href="produk.php?kategori=<?php echo $kategori['NAMA_KATEGORI'] ?>">
                            <div class="card category-card">
                                <div class="category-icon">
                                    <i class="fas fa-tag"></i> <!-- You can replace this icon with any other fontawesome icon or your own image -->
                                </div>
                                <div class="category-name">
                                    <?php echo $kategori['NAMA_KATEGORI']; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Produk</h3>
                <div class="row">
                    <?php
                    if ($countdata < 1) {
                    ?>
                    <h4 class="text-center py-5">Produk yang anda cari tidak tersedia</h4>
                    <?php
                    }
                    ?>
                    <?php while ($produk = mysqli_fetch_array($queryproduk)) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="image-box">
                                <img src="image/<?php echo $produk['foto']; ?>" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $produk['NAMA_PRODUK']; ?></h4>
                                <p class="card-truncate"><?php echo $produk['DESKRIPSI']; ?></p>
                                <p class="card-harga">Rp. <?php echo $produk['HARGA']; ?></p>
                                <a href="produk-detail.php?nama=<?php echo $produk['NAMA_PRODUK']; ?>" class="btn warna2 text-white">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>

    <!-- Javascript -->
    <script src="bootstrap/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>
</html>
