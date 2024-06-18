<?php
require "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pelanggan</title>

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
        margin-bottom: 12px;
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
            <h3 class="text-center mb-4">Login Pelanggan</h1>
            <form action="" method="post">
                <div>
            <label for="email">E-mail</label>
            <input type="text" class="form-control" name="email" id="email">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <div>
            <button class="btn btn-primary for-control mt-3 w-100" type="submit" name="loginbtn">Login</button>
        </div>
        <div class="mt-3 text-center">
            Belum punya akun? <a class="alternate-link" href="register.php">Register</a>
        </div>
        </form>
        </div>

        <div class="mt-3" style="width: 500px">
            <?php
                if(isset($_POST['loginbtn'])){
                    $email = htmlspecialchars($_POST['email']);
                    $password = htmlspecialchars($_POST['password']);
                    echo $email;
                    echo $password;
                    // Menggunakan prepared statement untuk mencegah SQL Injection
                    $query = $conn->prepare("SELECT * FROM pelanggan WHERE EMAIL = ?");
                    $query->bind_param("s", $email);
                    $query->execute();
                    $result = $query->get_result();
                    $data = $result->fetch_assoc();
                    print_r($data);
                    echo password_hash($data['PASSWORD'], PASSWORD_DEFAULT);
                    if($data){
                        if(password_verify($password, $data['PASSWORD'])){
                            $_SESSION['user_id'] = $data['ID_PELANGGAN'];
                            $_SESSION['username'] = $data['NAMA_PELANGGAN'];
                            $_SESSION['login'] = true;

                            header('location: index.php');
                        } else {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                Password salah!
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            Data pelanggan tidak valid!
                        </div>
                        <?php
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
