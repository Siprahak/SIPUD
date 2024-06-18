<?php
    require "session.php";
    require "../koneksi.php";

    $querykategori = mysqli_query($conn, "SELECT * FROM kategori");
    $jumlahkategori = mysqli_num_rows($querykategori);
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kategori</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/fontawesome-free-6.5.2-web/css/fontawesome.min.css">
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <!-- Navbar -->
    <?php require "navbar.php"; ?>

    <div class="container mt-5">

        <!-- Breadcrump -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                    <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Kategori
                </li>
            </ol>
        </nav>

        <!-- Tambah Kategori Start -->
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Kategori</h3>

            <!-- input kategori layout -->
            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text"  name="kategori" id="kategori" placeholder="Input nama kategori" class="form-control mt-1">
                </div>
                <div>
                    <button class="btn btn-primary mt-2" type="submit" name="simpan_kategori">Simpan</button>
                </div>
            </form>

            <!-- Input kategori logic -->
            <?php 
                if(isset($_POST['simpan_kategori'])){
                    $kategoribaru = htmlspecialchars($_POST['kategori']);

                    $queryExist = mysqli_query($conn, "SELECT NAMA_KATEGORI FROM kategori WHERE NAMA_KATEGORI = '$kategoribaru'");
                    $jumlahDataKategoriBaru = mysqli_num_rows($queryExist);

                    if($jumlahDataKategoriBaru > 0){
                        ?>
                            <div class="alert alert-warning mt-3" role="alert">
                            Kategori Sudah Ada!
                            </div>
                        <?php
                    }
                    else{
                        $querySimpan = mysqli_query($conn, "INSERT INTO kategori (NAMA_KATEGORI) VALUES ('$kategoribaru')");
                        
                        if($querySimpan){
                            ?>
                            <div class="alert alert-success mt-3" role="alert">
                            Kategori Berhasil Disimpan
                            </div>

                            <meta http-equiv="refresh" content="1; url=kategori.php?q"/>
                            <?php
                        }
                        else{
                            echo mysqli_error($conn);
                        }
                    }
                }
            ?>
        </div>
        <!-- Tambah Kategori End -->

        <!-- list Kategori Start -->
        <div class="mt-3">
            <h2>List Kategori</h2>

            <!-- Listview kategori -->
            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if($jumlahkategori == 0){
                        ?>
                            <tr>
                                <td colspan=3 class="text-center">Data Kategori Tidak Tersedia</td>
                            </tr>
                        <?php
                            } else 
                                $number = 1;
                                while($data = mysqli_fetch_array($querykategori)){
                        ?>
                                    <tr>
                                        <td><?php echo $number; ?></td>
                                        <td><?php echo $data['NAMA_KATEGORI']; ?></td>
                                        <td>
                                            <a href="kategori-detail.php?q=<?php echo $data['KATEGORI_ID']; ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
                                        </td>
                                    </tr>
                        <?php
                                    $number++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- list Kategori end -->
        </div>
    </div>
    

    <script src="../bootstrap/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>
</html>
