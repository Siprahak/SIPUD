<?php
require "session.php";
require "../koneksi.php";

// Mendapatkan ID produk dari query string atau menggunakan default jika tidak ada
$id = isset($_GET['p']) ? $_GET['p'] : "PRODUK_ID";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['simpan'])) {
        // Logika untuk menyimpan data
        $nama = $_POST['nama'];
        $kategori = $_POST['kategori'];
        $harga = $_POST['harga'];
        $deskripsi = $_POST['deskripsi'];
        $stok = $_POST['stok'];

        

        // Update query
        $updateQuery = "UPDATE produk SET NAMA_PRODUK='$nama', KATEGORI_ID='$kategori', HARGA='$harga', DESKRIPSI='$deskripsi', STOK='$stok' WHERE PRODUK_ID='$id'";
        if (mysqli_query($conn, $updateQuery)) {
            echo "Data berhasil disimpan.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete'])) {
        // Logika untuk menghapus data
        $deleteQuery = "DELETE FROM produk WHERE PRODUK_ID='$id'";
        if (mysqli_query($conn, $deleteQuery)) {
            echo "Data berhasil dihapus.";
            header("Location: produk-list.php"); // Redirect ke halaman daftar produk setelah menghapus
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

if ($id) {
    // Query untuk mengambil data produk berdasarkan PRODUK_ID
    $query = mysqli_query($conn, "SELECT * FROM produk WHERE PRODUK_ID = '$id'");
    if (!$query) {
        die('Query failed: ' . mysqli_error($conn));
    }

    // Memeriksa jumlah baris yang dikembalikan
    if (mysqli_num_rows($query) == 0) {
        $data = null;
    } else {
        $data = mysqli_fetch_array($query);
    }
} else {
    $data = null;
}

// Query untuk mengambil semua kategori
$querykategori = mysqli_query($conn, "SELECT * FROM kategori");
if (!$querykategori) {
    die('Query failed: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <style>
        form div {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <h2>Detail Produk</h2>

        <div class="col-12 col-md-6">
            <form action="" method="post" enctype="multipart/form-data">
                
                <div>
                    <label for="nama">Nama Produk</label>
                    <input type="text" name="nama" id="nama" value="<?php echo $data ? htmlspecialchars($data['NAMA_PRODUK']) : ''; ?>" class="form-control" autocomplete="off">
                </div>

                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <?php
                            if ($data) {
                                echo '<option value="' . $data['KATEGORI_ID'] . '">' . $data['KATEGORI_ID'] . '</option>';
                            }
                            while ($kategori = mysqli_fetch_array($querykategori)) {
                                echo '<option value="' . $kategori['KATEGORI_ID'] . '">' . $kategori['NAMA_KATEGORI'] . '</option>';
                            }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" id="harga" value="<?php echo $data ? htmlspecialchars($data['HARGA']) : ''; ?>" class="form-control" autocomplete="off">
                </div>

                <div>
                    <label for="foto">Foto Produk Sekarang</label>
                    <?php if ($data && $data['foto']): ?>
                        <img src="../uploads/<?php echo htmlspecialchars($data['foto']); ?>" alt="Foto Produk" class="img-fluid">
                    <?php else: ?>
                        <p>Tidak ada foto produk.</p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>

                <div>
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control"><?php echo $data ? htmlspecialchars($data['DESKRIPSI']) : ''; ?></textarea>
                </div>

                <div>
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" id="stok" value="<?php echo $data ? htmlspecialchars($data['STOK']) : ''; ?>" class="form-control" autocomplete="off">
                </div>

                <div>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                </div>
        
            </form>
        </div>
    </div>

    <!-- Javascript -->
    <script src="../bootstrap/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
