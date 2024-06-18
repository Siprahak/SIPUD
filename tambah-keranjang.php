    <?php
    session_start();

    if(!isset($_GET['id']) || empty($_GET['id'])){
        header("Location: keranjang.php");
        exit;
    }
    $jumlah = 1;
    if(isset($_POST['jumlah'])){
        $jumlah = max($_POST['jumlah'],1);
    }
    echo $jumlah;

    if(!isset($_SESSION['keranjang'])){
        $_SESSION['keranjang'] = [];
    }
    print_r ($_SESSION['keranjang']);
    $id = $_GET['id'];
    if(isset($_SESSION['keranjang'][$id])){
        $_SESSION['keranjang'][$id] = $jumlah;
    }else{
        $_SESSION['keranjang'][$id] += $jumlah; 
    }
    
    header("Location: keranjang.php");
    exit;
?>
