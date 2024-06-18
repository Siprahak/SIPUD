<?php
     require "session.php";
     require "../koneksi.php";

     $id = $_GET['q'];

     $query = mysqli_query($conn, "SELECT * FROM kategori WHERE KATEGORI_ID = '$id'");
     $data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>

     <!-- Bootstrap -->
     <link rel="stylesheet" href="../bootstrap/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/fontawesome-free-6.5.2-web/css/fontawesome.min.css">

</head>
</head>

<style>
    form div{
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <h2>Detail kategori</h2>   

        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $data['NAMA_KATEGORI'] ?>">
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="editbtn">Edit</button>
                    <button type="submit" class="btn btn-danger" name="deletebtn">Delete</button>
                </div>
            </form>

            <?php
                if(isset($_POST['editbtn'])){
                    $kategoribaru = htmlspecialchars($_POST['kategori']);

                    if($data['NAMA_KATEGORI'] == $kategoribaru){
                        ?>
                            <meta http-equiv="refresh" content="0; url=kategori.php?q"/>
                        <?php
                    }
                    else{
                        $query = mysqli_query($conn, "SELECT * FROM kategori WHERE NAMA_KATEGORI = '$kategoribaru'");
                        $jumlahdata = mysqli_num_rows($query);

                        if($jumlahdata > 0){
                            ?>
                            <div class="alert alert-warning mt-2" role="alert">
                            Kategori Sudah Ada!
                            </div>
                            <?php
                        }
                        else{
                            $querySimpan = mysqli_query($conn, "UPDATE kategori SET NAMA_KATEGORI = '$kategoribaru' WHERE KATEGORI_ID = '$id'");
                        
                        if($querySimpan){
                            ?>
                            <div class="alert alert-success mt-3" role="alert">
                            Kategori Berhasil Diupdate!
                            </div>

                            <meta http-equiv="refresh" content="2; url=kategori.php?q"/>
                            <?php
                        }
                        else{
                            echo mysqli_error($conn);
                        }
                    }
                    }
                }

                if(isset($_POST['deletebtn'])){
                    $queryCheck = mysqli_query($conn, "SELECT * FROM produk WHERE KATEGORI_ID='$id'");
                    $dataCount = mysqli_num_rows($queryCheck);

                    if($dataCount > 0){
                        ?>
                            <div class="alert alert-warning mt-3" role="alert">
                            Kategori Tidak Bisa Dihapus Karena sudah digunakan pada Produk!
                            </div>
                        <?php
                        die();
                    }

                    $querydelete = mysqli_query($conn, "DELETE FROM kategori WHERE KATEGORI_ID = '$id'");

                    if($querydelete){
                        ?>
                        <div class="alert alert-info mt-3" role="alert">
                        Kategori Berhasil Dihapus!
                        </div>

                        <meta http-equiv="refresh" content="2; url=kategori.php?q"/>

                        <?php
                    }
                    else{
                        echo mysqli_error($conn);
                    }
                }
            ?>
        </div>
    </div>
    

    <!-- Javascript -->
    <script src="../bootstrap/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>
</body>
</html>
