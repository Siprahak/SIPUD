

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parengan Store | Home</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.5.2-web/css/fontawesome.min.css">


     <!-- CSS -->
      <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <?php require "navbar.php"; ?>
    
    <!-- Banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>E-Commerce Produk Unggulan Desa Parengan</h1>
            <h3>Temukan Produk Kelas Dunia Desa Kami</h3>
            <div class="col-md-8 offset-md-2">
                <form method="get" action="produk.php">
                    <div class="input-group input-group-lg my-4">
                        <input type="text" class="form-control" placeholder="Cari Produk" aria-label="Cari Produk" aria-describedby="basic-addon2" name="keyword">
                        <button class="btn warna2 text-white" type="submit" >Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Highlight Kategori -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Kategori Produk Unggulan</h3>

            <div class="row mt-3 justify-content-center">
                <div class="col-12 col-md-6 mx-auto">
                    <div class="highlighted-kategori kategori-tenun-ikat d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a href="produk.php?kategori=Tenun">Tenun</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tentang Kami Section -->
    <div class="container-fluid warna3 py-5">
        <div class="container text-center">
            <h3>Tentang Kami</h3>
            <p class="fs-5 mt-3">Desa Parengan yang terletak di Kecamatan Maduran Kabupaten Lamongan Jawa Timur memiliki berbagai macam produk unggulan yang telah dikenal hingga manca negara. Salah satu produknya yang paling terkenal yakni kain tenun ikat. Selain tenun ikat, masih banyak produk lain yang juga tidak kalah kualitasnya, diantaranya berbagai jajanan tradisional dan olahan tanah liat yang biasa disebut gerabah. Yuk belanja di Website kami dan jangan lupa berkunjung pula di desa kami untuk melihat produk-produk unggulan yang lainnya.</p>
        </div>
    </div>

    <!-- Produk Terbaru -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Produk Kami</h3>

            <div class="row mt-5">
                <div class="col-sm-6 col-md-4">
                <div class="card">
                    <img src="image/sarung-tenun1.JPG" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h4 class="card-title">Sarung Tenun Ikat</h4>
                            <p class="card-text text-truncate">Sarung tenun ikat khas Parengan dikenal dingin dan nyaman saat dikenakan. Sensasi dingin ini dikarenakan bahan dasar benang yang digunakan ialah benang jenis maseris (mercerized).Sarung yang memiliki motif dan pewarnaan khas itu diproduksi oleh tangan terampil para perajin sarung tenun ikat di Desa Parengan.</p>
                            <p class="card-text text-harga">Rp. 500.000</p>
                            <a href="#" class="btn btn-primary">Lihat detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                <div class="card">
                    <img src="image/aFNCDBKAeka4QmrP1UxH.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h4 class="card-title">Rambut Nenek</h4>
                            <p class="card-text text-truncate">Rambut nenek adalah jajanan tradisional yang berasal dari Lamongan. Rambut nenek sebenarnya adalah gulali yang diberi tepung. Berbeda dengan gulali yang memiliki rasa manis yang lumer di mulut, rambut nenek ada sedikit rasa tepung mengecap di lidah</p>
                            <p class="card-text text-harga">Rp. 20.000</p>
                            <a href="#" class="btn btn-primary">Lihat detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                <div class="card">
                    <img src="image/celengan-tanahliat1.jpeg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h4 class="card-title">Celengan Tanah Liat</h4>
                            <p class="card-text text-truncate">Celengan tanah liat adalah simbol kebijaksanaan finansial yang indah dan tradisional. Dibuat dengan teliti oleh tangan terampil pengrajin lokal, setiap celengan memancarkan pesona dan kehangatan alami. Ideal sebagai hadiah yang berarti atau hiasan rumah yang klasik.</p>
                            <p class="card-text text-harga">Rp. 45.000</p>
                            <a href="#" class="btn btn-primary">Lihat detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
        <?php require "footer.php"; ?>

     <!-- Javascript -->
    <script src="bootstrap/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/fontawesome-free-6.5.2-web/js/all.min.js"></script>

</body>
</html>
