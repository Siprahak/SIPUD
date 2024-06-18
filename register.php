<?php
require "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Pelanggan</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.5.2-web/css/fontawesome.min.css">


     <!-- CSS -->
      <link rel="stylesheet" href="css/style.css">
</head>

<style>
    .main{
        height: 100vh;
    }

    .login-box{
        width: 500px;
        height: fit-content;
        box-sizing: border-box;
        border-radius: 10px;
    }

    .form-control{
        margin-bottom: 15px;
    }

    .for-control{
        width: 100%;
    }

    .alternate-link{
        color: blue;
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php";?>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="login-box p-5 shadow w-25">
            <h3 class="text-center mb-4">Register Pelanggan</h3>
            <form action="" method="post">
            <div>
                <label for="name">Nama</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>
            <div>
                <label for="email">E-mail</label>
                <input type="text" class="form-control" name="email" id="email">
            </div>
            <div>
                <label for="alamat">Alamat</label>
                <textarea class="form-control" name="alamat" id="alamat"></textarea>
            </div>
            <div>
                <label for="phone">Nomor Telepon</label>
                <input type="text" class="form-control" name="phone" id="phone">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div>
                <label for="re-password">Ulangi Password</label>
                <input type="password" class="form-control" name="re-password" id="re-password">
            </div>
            <div>
                <button class="btn btn-primary for-control mt-3" type="submit" name="registerbtn">Register</button>
            </div>
            <div class="mt-3 text-center">
                Sudah punya akun? <a class="alternate-link" href="login.php">Login</a>
            </div>
            </form>
        </div>

        <div class="mt-3" style="width: 500px;">
            <?php
            if(isset($_POST['registerbtn'])){
                $name = $_POST['name'];
                $email = $_POST['email'];
                $alamat = $_POST['alamat'];
                $phone = $_POST['phone'];
                $password = $_POST['password'];
                $re_password = $_POST['re-password'];
            
                // Validasi form
                if(empty($name) || empty($email) || empty($alamat) || empty($phone) || empty($password)){
                    ?>
                    <div class="alert alert-warning" role="alert">
                        Semua field harus diisi!
                    </div>
                    <?php
                    exit;
                } elseif ($password != $re_password) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        Password tidak cocok!
                    </div>
                    <?php
                    exit;
                }
            
                // Cek apakah email sudah terdaftar
                $query = $conn->prepare("SELECT * FROM pelanggan WHERE EMAIL = ?");
                if (!$query) {
                    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
                    exit;
                }
                $query->bind_param("s", $email);
                $query->execute();
                $result = $query->get_result();

                if ($result->num_rows > 0) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        Email sudah terdaftar!
                    </div>
                    <?php
                    exit;
                } else {
                    // Hash password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
                    // Insert data ke dalam database
                    $insertQuery = $conn->prepare("INSERT INTO pelanggan (NAMA_PELANGGAN, EMAIL, ALAMAT, NOMER_TELEPON, PASSWORD) VALUES (?, ?, ?, ?, ?)");
                    if (!$insertQuery) {
                        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
                        exit;
                    }
                    $insertQuery->bind_param("sssss", $name, $email, $alamat, $phone, $hashed_password);
                    $insertResult = $insertQuery->execute();
            
                    if ($insertResult) {
                        header("Location: login.php");
                        exit;
                    } else {
                        exit;
                        ?>
                        <div class="alert alert-danger" role="alert">
                            Error inserting data
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="container-fluid py-3 bg-dark text-light">
        <div class="container d-flex justify-content-between">
            <label>&copy; 2024 Parengan Store</label>
            <label>Created By Kelompok 10  |  Parallel D</label>
        </div>
    </div>      

    <!-- Javascript -->
    <script src="bootstrap/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/fontawesome-free-6.5.2-web/js/all.min.js"></script>

</body>
</html>
