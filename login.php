<?php
session_start();

// Koneksi ke database
$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "furqon-shop";

$conn = mysqli_connect($db_servername, $db_username, $db_password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function loginUser($email, $password)
{
    global $conn;

    // Query untuk memeriksa pengguna berdasarkan email
    $query = "SELECT * FROM t_user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Memeriksa kecocokan password
        if (password_verify($password, $row['password'])) {
            // Atur session pengguna dengan role dari database
            $_SESSION["user_role"] = $row['role'];
            return $row['role'];
        }
    }

    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $role = loginUser($email, $password);

    if ($role === "Admin") {
        // Redirect ke halaman dashboard Admin
        header("Location: admin/index.php");
        exit();
    } elseif ($role === "Customer") {
        // Redirect ke halaman dashboard Customer
        header("Location: customer/index.php");
        exit();
    } else {
        $error_message = "Email atau password salah.";
    }
}


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="login-style.css">
</head>
  <body>
    
  <div class="container-fluid ps-md-0">
    <div class="row g-0">
        <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
        <div class="col-md-8 col-lg-6">
        <div class="login d-flex align-items-center py-5">
            <div class="container">
            <div class="row">
                <div class="col-md-9 col-lg-8 mx-auto">
                <h3 class="login-heading mb-4">Form Login</h3>

                <!-- Tampilkan pesan Pendaftaran berhasil jika ada -->
                <?php if (isset($_SESSION["success_message"])) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $_SESSION["success_message"]; ?>
                    </div>
                    <?php unset($_SESSION["success_message"]); ?>
                <?php endif; ?>

                <!-- Tampilkan pesan error jika ada -->
                <?php if (isset($error_message)) : ?>
                    <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <!-- Sign In Form -->
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="form-floating mb-3">
                    <input type="email" class="form-control" placeholder="name@example.com" name="email">
                    <label>Email address</label>
                    </div>

                    <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                    <label for="floatingPassword">Password</label>
                    </div>

                    
                    <div class="d-grid">
                    <button class="btn btn-lg btn-dark btn-login text-uppercase fw-bold mb-2" type="submit">Sign in</button>
                    <div class="text-center">
                    Don't have an account ? <a class="small text-decoration-none" href="register.php"><b>Register Here</b></a>
                    </div>
                    </div>

                </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>