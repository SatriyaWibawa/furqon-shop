<?php
session_start();

// Periksa apakah pengguna telah login dan memiliki peran sebagai admin
if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "Admin") {
    // Redirect ke halaman login atau halaman lain yang diinginkan
    header("Location: /furqon-shop/login.php");
    exit();
}

// Fungsi untuk logout
function logoutUser() {
    // Hapus semua data session
    session_unset();
    
    // Hapus cookie session jika ada
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Hancurkan session
    session_destroy();
    
    // Redirect ke halaman login atau halaman lain yang diinginkan
    header("Location: /furqon-shop/login.php");
    exit();
}

// Panggil fungsi logout jika tombol logout ditekan
if (isset($_POST["logout"])) {
    logoutUser();
}

// Konfigurasi database
$host = 'localhost';  // Ganti dengan host database Anda
$user = 'root';  // Ganti dengan username database Anda
$password = '';  // Ganti dengan password database Anda
$database = 'furqon-shop';  // Ganti dengan nama database Anda

// Membuat koneksi ke database
$mysqli = new mysqli($host, $user, $password, $database);

// Memeriksa koneksi
if ($mysqli->connect_errno) {
    echo "Gagal terhubung ke MySQL: " . $mysqli->connect_error;
    exit();
}

// Mengambil data barang dari database
$query = "SELECT * FROM `t_barang`";
$result = $mysqli->query($query);

// Memeriksa apakah query berhasil dijalankan
if (!$result) {
    echo "Error: " . $mysqli->error;
    exit();
}

$barangs = $result->fetch_all(MYSQLI_ASSOC);

$mysqli->close();

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Start Bootstrap</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">   
                        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                            <button type="submit" name="logout" class="btn btn-link text-decoration-none text-dark">Logout</button>
                        </form>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="/furqon-shop/admin/index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Master Data</div>
                            <a class="nav-link" href="/furqon-shop/admin/read_admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Data Admin
                            </a>
                            <a class="nav-link" href="/furqon-shop/admin/read_customer.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Data Customer
                            </a>
                            <a class="nav-link" href="/furqon-shop/admin/read_barang.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-laptop"></i></div>
                                Data Barang
                            </a>
                            <a class="nav-link" href="/furqon-shop/admin/read_transaksi.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                                Data Transaksi
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4 mb-3">Data Barang</h1>

                        <a href="/furqon-shop/admin/create_barang.php" class="btn btn-success mb-3">Tambah Data Barang</a>
                       
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th>Nama Barang</th>
                                    <th>Merk Barang</th>
                                    <th>Harga Barang</th>
                                    <th>Tanggal Input</th>
                                    <th>Status</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1;?>
                                <?php foreach($barangs as $barang) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $barang['barang_nama']?></td>
                                        <td><?php echo $barang['barang_merk']?></td>
                                        <td><?php echo $barang['harga']?></td>
                                        <td><?php echo $barang['tanggal_input']?></td>
                                        <td><?php echo $barang['status']?></td>
                                        <td><img src="/furqon-shop/image/<?php echo $barang['gambar']?>" alt="" width="50px" height="50px"></td>
                                        <td>
                                           <a href="" class="btn btn-sm btn-success">Lihat</a>
                                           <a href="" class="btn btn-sm btn-primary">Ubah</a>
                                           <a href="" class="btn btn-sm btn-danger">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>

                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>

