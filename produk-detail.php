<?php
        session_start();
    require "koneksi.php";

    if(!isset($_GET['nama']) || empty($_GET['nama'])){
        header("Location: index.php");
        exit;
    }

    $nama = htmlspecialchars($_GET['nama']);
    $queryproduk = mysqli_query($conn, "SELECT * FROM produk WHERE NAMA_PRODUK='$nama'");
    $produk = mysqli_fetch_array($queryproduk);

    $queryprodukterkait = mysqli_query($conn, "SELECT * FROM produk WHERE KATEGORI_ID='$produk[KATEGORI_ID]' AND PRODUK_ID!='$produk[PRODUK_ID]' LIMIT 4");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Detail Produk</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap/bootstrap-5.2.3-dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.5.2-web/css/fontawesome.min.css">


     <!-- CSS -->
      <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-3">
                    <img src="/fp-sipud-coba2/image/<?php echo $produk['foto'] ?>" class="w-100" alt="...">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h1><?php echo $produk['NAMA_PRODUK']?></h1>
                    <p class="fs-5">
                        <?php echo $produk['DESKRIPSI']?>
                    </p>
                    <p class="text-harga">
                        Rp. <?php echo $produk['HARGA']?>
                    </p>
                    <p class="fs-5">
                        Jumlah Stok : <strong><?php echo $produk['STOK']?></strong>
                    </p>
                    <form method="POST" action="tambah-keranjang.php?id=<?php echo $produk['PRODUK_ID'];?>" method="post">
                    <div class="row g-2">
                        <div class="col-3">
                            <input type="number" class="form-control" name="jumlah" value="1">
                        </div>
                        <div class="col-9">
                            <button type="submit" class="btn btn-primary w-100">Tambah Ke Keranjang</button>
                        </div>
                    </div>    
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Produk Terkait -->
    <div class="container-fluid py-5 warna2">
        <div class="container">
            <h2 class="text-center text-white mb-5">Produk Terkait</h2>

            <div class="row">
                <?php while($data=mysqli_fetch_array($queryprodukterkait)){?>
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="produk-detail.php?nama=<?php echo $data['nama']?>">
                    <img src="/fp-sipud-coba2/image/<?php echo $data['foto']?>" class="img-fluid img-thumbnail produk-terkait-image" alt="">
                </div>
                <?php }?>
            </div>
        </div>
    </div>
    
    <?php require "footer.php";?>
    
    <!-- Javascript -->
    <script src="bootstrap/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/fontawesome-free-6.5.2-web/js/all.min.js"></script>

</body>
</html>
