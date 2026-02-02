<?php
session_start();
include 'koneksi.php';
if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $query = "SELECT * FROM pengguna WHERE email='$email'";
    $result = $conn->query($query);

    if($result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row['password'])){
            $_SESSION['pengguna'] = [
                'id' => $row['id_user'],
                'nama' => $row['nama'],
                'email' => $row['email'],
                'role' => $row['role']
            ];
            header("Location: home.php");
            exit();
        } else {
            echo "<script>alert('Password salah');window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Email tidak ditemukan');window.location='login.php';</script>";
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
    <form method="post" action="login.php">
        <img class="mb-4" src="../images/BSIP LOGO2.png" alt="" width="180" height="60">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        <div class="form-floating">
            <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit" name="login">Sign in</button>
        <p class="mt-5 mb-3 text-body-secondary">&copy;2026 BSIP</p>
    </form>
    </main>
    <!-- Bootstrap JavaScript -->
    <script src="../admin/assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
