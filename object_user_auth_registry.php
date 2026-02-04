<?php
include 'koneksi.php';
require 'userStatus.php';


$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$inputStatus = $_POST['status'] ?? null;
$password = $_POST['password'] ?? null;

$password_encrypt = password_hash($password, PASSWORD_BCRYPT);
$status = userStatus::tryFrom($inputStatus);
$validasi_email = "SELECT id_user FROM pengguna WHERE email=?";
$stmt = $conn->prepare($validasi_email);
$stmt->bind_param('s',$email);
$stmt->execute();
$result = $stmt->get_result();

if(isset($_POST['register'])){
    if(!$status) {
    echo "<script>alert('Status pengguna tidak valid');window.location='object_user_auth_registry.php';</script>";
    exit();
    }
    
    if($result->num_rows == 0){
        $query = "INSERT INTO pengguna (nama, email, password, role) VALUES ('$name', '$email', '$password_encrypt','$status->value')";
        if($conn->query($query)){
            echo "<script>alert('Registrasi berhasil');window.location='login.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal');window.location='object_user_auth_registry.php';</script>";
        }
    } else {
        echo "<script>alert('Email sudah terdaftar');window.location='object_user_auth_registry.php';</script>";
    }
}
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Berita BSIP</title>
    <!-- Bootstrap CSS -->
    <link href="../admin/assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
        }
        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }
        .form-signin {
            max-width: 330px;
            padding: 15px;
        }
        .form-signin .form-floating:focus-within {
            z-index: 2;
        }
        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
    </head>
    <body class="text-center">     
    <main class="form-signin w-100 m-auto">
    <form method="post" action="object_user_auth_registry.php">
        <img class="mb-4" src="../images/BSIP LOGO2.png" alt="" width="180" height="60">
        <h1 class="h3 mb-3 fw-normal">Please <br>Register New Account</h1>
        <div class="form-floating">
            <input type="text" class="form-control" name="name" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Nama Pengguna</label>
        </div>
        <div class="form-floating">
            <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <div class="form-floating">
            <select name="status">
                <option value="admin">Admin</option>
                <option value="penulis">Penulis</option>
            </select>
        </div>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit" name="register">Create Account</button>
        <p class="mt-5 mb-3 text-body-secondary">&copy;2026 BSIP</p>
    </form>
    </main>
    <!-- Bootstrap JavaScript -->
    <script src="../admin/assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
