<?php
function registerUser($name, $email, $password, $role)
{
    // Koneksi ke database
    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "furqon-shop";

    $conn = mysqli_connect($db_servername, $db_username, $db_password, $dbname);

    // Periksa koneksi database
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Query untuk memeriksa apakah email sudah terdaftar
    $email_check = "SELECT * FROM t_user WHERE email='$email'";
    $result_check = mysqli_query($conn, $email_check);

    if (mysqli_num_rows($result_check) > 0) {
        return "Email sudah terdaftar.";
    } else {
        // Query untuk menyimpan data pendaftaran ke database
        $sql = "INSERT INTO t_user (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";

        if (mysqli_query($conn, $sql)) {
            return "success";
        } else {
            return "Terjadi kesalahan saat mendaftar. Silakan coba lagi.";
        }
    }
}

// Jika form register disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = 'Customer';

    $registerResult = registerUser($name, $email, password_hash($password, PASSWORD_DEFAULT), $role);

    if ($registerResult === "success") {
        // Set session untuk menampilkan pesan sukses
        session_start();
        $_SESSION["success_message"] = "Pendaftaran berhasil! Silakan masuk dengan akun Anda.";
        
        // Redirect ke halaman login setelah pendaftaran berhasil
        header("Location: login.php");
        exit();
    } else {
        // Tampilkan pesan error
        $error_message = $registerResult;
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
                <h3 class="login-heading mb-4">Form Register</h3>

                <!-- Tampilkan pesan error jika ada -->
                <?php if (isset($error_message)) : ?>
                    <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <!-- Sign In Form -->
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

                    <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Jhonny" name="name">
                    <label>Name</label>
                    </div>

                    <div class="form-floating mb-3">
                    <input type="email" class="form-control" placeholder="name@example.com" name="email">
                    <label>Email address</label>
                    </div>

                    <div class="form-floating mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <label>Password</label>
                    </div>

                    
                    <div class="d-grid">
                    <button class="btn btn-lg btn-dark btn-login text-uppercase fw-bold mb-2" type="submit">Sign up</button>
                    <div class="text-center">
                    Do you have an account ? <a class="small text-decoration-none" href="login.php"><b>Login Here</b></a>
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