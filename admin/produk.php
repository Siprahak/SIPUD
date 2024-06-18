<?php
    require "session.php";
    require "../koneksi.php";

    $query = mysqli_query($conn, 
    "SELECT a.*, b.NAMA_KATEGORI 
    FROM produk a 
    JOIN kategori b ON a.KATEGORI_ID = b.KATEGORI_ID;
    ");
    $jumlahproduk = mysqli_num_rows($query);

    $querykategori = mysqli_query($conn, "SELECT * FROM kategori");

    function generateRandomString($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength  =strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++){
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/fontawesome-free-6.5.2-web/css/fontawesome.min.css">

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
                    Produk
                </li>
            </ol>
        </nav>
        
        <!-- Tambah Produk Start -->
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Produk</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama Produk</label>
                    <input type="text" name="nama" id="nama" class="form-control" autocomplete="off">
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value="">Pilih Kategori</option>
                        <?php
                            while($data = mysqli_fetch_array($querykategori)){
                        ?>
                            <option value="<?php echo $data['KATEGORI_ID']; ?>"><?php echo $data['NAMA_KATEGORI']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" class="form-control">
                </div>
                <div>
                    <label for="foto">Foto Produk</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div>
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" class="form-control">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
            </form>

            <?php
                if(isset($_POST['simpan'])){
                    $nama = htmlspecialchars($_POST['nama']);
                    $kategori = htmlspecialchars($_POST['kategori']);
                    $harga = htmlspecialchars($_POST['harga']);
                    $stok = htmlspecialchars($_POST['stok']);
                    $deskripsi = htmlspecialchars($_POST['deskripsi']);

                    $target_dir = "../image/";
                    $nama_file = basename($_FILES['foto']['name']);
                    $target_file = $target_dir . $nama_file;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $image_size = $_FILES['foto']['size'];
                    $random_name_file = generateRandomString(20);
                    $new_file_name = $random_name_file . "." . $imageFileType;

                    if($nama=='' || $kategori=='' || $harga=='' || $stok==''){
                ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Nama Produk, Kategori, Harga dan Stok Wajib diisi!!
                        </div>
                <?php
                    }
                    else{
                        if($nama_file!=''){
                            if($image_size > 1000000){
                ?>
                                <div class="alert alert-warning mt-3" role="alert">
                                Ukuran Max. foto 1Mb
                                </div>
                <?php
                            }
                            else{
                                if($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'gif') {
                ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Gunakan foto dengan tipe file JPG/PNG/GIF
                                    </div>
                <?php
                                }
                                else{
                                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_file_name);
                                }
                            }
                        }

                        // Query Insert to Database
                        $queryTambah = mysqli_query($conn, "INSERT INTO produk (KATEGORI_ID, NAMA_PRODUK, foto, DESKRIPSI, HARGA, STOK) VALUES ('$kategori', '$nama', '$new_file_name', '$deskripsi', '$harga', '$stok')");

                        if($queryTambah){
                ?>
                            <div class="alert alert-success mt-3" role="alert">
                                Produk Baru Berhasil Disimpan
                            </div>
                            
                            <meta http-equiv="refresh" content="2; url=produk.php"/>
                <?php
                        }
                        else{
                            echo mysqli_error($conn);
                        }
                    }
                }
            ?>
        </div>
        <!-- tambah Produk End -->

        <!-- Listview Product Start -->
        <div class="mt-3 mb-5">
            <h2>List Produk</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                                if($jumlahproduk == 0){
                            ?>
                                <tr>
                                    <td colspan=6 class="text-center mt-2">Data Produk Tidak Tersedia</td>
                                </tr>
                            <?php
                                }
                                else{
                                    $jumlah = 1;
                                    while($data = mysqli_fetch_array($query)){
                            ?>
                                    <tr>
                                        <td><?php echo $jumlah; ?></td>
                                        <td><?php echo $data['NAMA_PRODUK']; ?></td ?>>
                                        <td><?php echo $data['NAMA_KATEGORI'] ?></td>
                                        <td><?php echo $data['HARGA'] ?></td>
                                        <td><?php echo $data['STOK'] ?></td>
                                        <td>
                                            <a href="produk-detail.php?p=<?php echo $data['PRODUK_ID'] ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
                                        </td>
                                    </tr>
                            <?php
                                    $jumlah++;
                                    }
                                }

                            ?>

                            
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <script src="../bootstrap/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/fontawesome-free-6.5.2-web/js/all.min.js"></script>

</body>
</html>
