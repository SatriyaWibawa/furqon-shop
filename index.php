<?php
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

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
  <body>
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item active">
            <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
            </li>
        </ul>
        </div>
    </div>
    </nav>

    <header>

    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
        <div class="carousel-item active" style="background-image: url('https://images.unsplash.com/photo-1496181133206-80ce9b88a853?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80')">
            <div class="carousel-caption">
            <h5>First slide label</h5>
            <p>Some representative placeholder content for the first slide.</p>
            </div>
        </div>
        <div class="carousel-item" style="background-image: url('https://images.unsplash.com/photo-1496181133206-80ce9b88a853?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80')">
            <div class="carousel-caption">
            <h5>Second slide label</h5>
            <p>Some representative placeholder content for the second slide.</p>
            </div>
        </div>
        <div class="carousel-item" style="background-image: url('https://images.unsplash.com/photo-1496181133206-80ce9b88a853?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80')">
            <div class="carousel-caption">
            <h5>Third slide label</h5>
            <p>Some representative placeholder content for the third slide.</p>
            </div>
        </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
        </button>
    </div>
    </header>

    <!-- Page Content -->
    <div class="container">

    <!-- Page Heading -->
    <h1 class="my-5 text-center">Selamat Datang Di Furqon Shop</h1>

    <div class="row mb-5">
   
    <?php foreach($barangs as $barang) : ?>
<div class="col-lg-4 col-sm-6 mb-4">
    <div class="card h-100">
        <a href="#">
            <img class="card-img-top p-2" src="/furqon-shop/image/<?php echo $barang['gambar']?>" alt="" style="object-fit: cover; width: 100%; height: 200px;">
        </a>
        <div class="card-body">
            <h4 class="card-title">
                <a href="" class="text-dark text-decoration-none"><?php echo $barang['barang_nama']?></a>
            </h4>
            <p class="card-text">Harga : <b>Rp. <?php echo $barang['harga']?></b></p>
            <p class="card-text">Merk : <?php echo $barang['barang_merk']?></p>
            <p class="card-text">Tanggal Input : <?php echo date('d/m/Y', strtotime($barang['tanggal_input'])); ?></p>
            <a href="details.php" class="btn btn-sm btn-outline-success">Detail</a>
            <a href="" class="btn btn-sm btn-outline-success">Pesan Sekarang</a>
        </div>
    </div>
</div>
<?php endforeach; ?>




    </div>
    <!-- /.row -->
    </div>
    <!-- /.container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>