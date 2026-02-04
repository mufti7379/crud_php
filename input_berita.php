<?php
include 'config_session.php';
include 'koneksi.php';

$nama = $_SESSION['pengguna']['nama'];

if(!isLoggedIn()) {
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
    header("Location: login.php");
    exit();
}

checkSessionTimeout();

header("Cache-Control: no-cache, no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");

$user = $_SESSION['pengguna'];

$judul = $_POST['judul'] ?? null;
$isi = $_POST['isi'] ?? null;

$all = "SELECT * FROM berita WHERE judul=?";
$stmt = $conn->prepare($all);
$stmt->bind_param("s",$judul);
$stmt->execute();
$result = $stmt->get_result();

if(isset($_POST['Submit'])) {
    if($result->num_rows == 0){
        $query = "INSERT INTO berita (judul, isi, foto) values ('$judul', '$isi','$foto')";
        if($conn->query($query)){
            echo '<script>alert("Berita berhasil ditambahkan");window.location="kategori.php";</script>';
        }else{
            echo '<script>alert("Gagal menambahkan berita");window.location="input_kategori.php";</script>';
        }
    }else{
        echo '<script>alert("Berita sudah ada");window.location="input_kategori.php";</script>';
    }
}

$user = $_SESSION['pengguna'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Kategori Berita BSIP</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link href="../admin/assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }
         .dashboard-content {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: #212529;
            color: #fff;
            position: sticky;
            top: 0;
        }

        .content {
            flex-grow: 1;
            background: #f8f9fa;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link.active:hover {
            background-color: #0d6efd;
            color: #fff;
        }


        @media (min-width: 992px) {
            .sidebar {
                display: none;
            }

            .content {
                width: 75%;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark d-lg-none">
        <div class="container-fluid">
            <button class="btn btn-outline-light" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile" aria-controls="offcanvasSidebar">
            ☰
            </button>
            <span class="navbar-brand">Berita BSIP</span>
        </div>
    </nav>

    <!-- sidebar dekstop -->
    <div class="dashboard-content">
    <aside class="sidebar d-none d-lg-flex flex-column p-3 text-bg-dark">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none"> 
        <svg class="bi pe-none me-2" width="40" height="32" aria-hidden="true"><use xlink:href="#bootstrap"></use></svg> <span class="fs-4">Berita BSIP</span> 
        </a> 
        <hr> 
        <ul class="nav nav-pills flex-column mb-auto"> 
            <li class="nav-item"> 
                <a href="dashboard.php" class="nav-link text-white" > 
                <svg class="bi pe-none me-2" width="16" height="16" aria-hidden="true"><use xlink:href="#dashboard"></use></svg>Dashboard</a> 
            </li> 
            <li> 
                <a href="isi_berita.php"  class="nav-link active" aria-current="page"> 
                <svg class="bi pe-none me-2" width="16" height="16" aria-hidden="true"><use xlink:href="#isi_berita"></use></svg>Isi Berita
                </a> 
            </li> 
                <a href="kategori.php" class="nav-link text-white"> 
                <svg class="bi pe-none me-2" width="16" height="16" aria-hidden="true"><use xlink:href="#kategori"></use></svg>Kategori
                </a> 
            </li> 
                <a href="#" class="nav-link text-white"> 
                <svg class="bi pe-none me-2" width="16" height="16" aria-hidden="true"><use xlink:href="#dashboard"></use></svg>User
                </a> 
            </li> 
        </ul> 
        <hr> 

        <!-- admin profile dekstop -->
        <div class="dropdown"> 
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> 
            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2"> 
            <strong><?php echo htmlspecialchars($nama)?></strong> 
            </a> 
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">  
                <li><a class="dropdown-item" href="#">Profile</a></li> 
                <li><a class="dropdown-item" href="logout.php">Sign out</a></li> 
            </ul> 
        </div> 
    </aside>
    <main class="content p-3">
        <h2 class="text-center mt-5">Input Berita BSIP</h2>
        <form class="w-50 mx-auto mt-4" method="post" action="input_berita.php">
            <div class="mb-3">
                <label for="namaKategori" class="form-label">Nama Berita</label>
                <input type="text" class="form-control" id="namaKategori" name="nama_berita" placeholder="Masukkan nama berita">
            </div>
            <div class="mb-3">
                <label for="deskripsiKategori" class="form-label">Isi Berita</label>
                <textarea class="form-control" id="deskripsiKategori" name="isi_berita" rows="15" placeholder="Masukkan isi berita"></textarea>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Pilih Kategori Berita</label>
                <select class="form-control" id="kategoriBerita" name="kategori_berita">
                    <option value="">Pilih Kategori</option>
                    <?php
                    $query = "SELECT * FROM kategori";
                    $result = $conn->query($query);
                    while($row = $result->fetch_assoc()){
                        echo "<option value='".$row['id_kategori']."'>".$row['nama_kategori']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Upload Foto (JPG/PNG)</label>
                <input type="file" class="form-control" id="gambarBerita" name="gambar_berita">
            </div>
            
            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        </form>
    </main>
    </div>
    

    <!-- Sidebar mobile -->
    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="sidebarMobile">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Berita BSIP</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav nav-pills flex-column mb-3">
                <li class="nav-item">
                    <a class="nav-link text-white" href="dashboard.php">Dashboard</a>
                </li>
                <li>
                    <a class="nav-link active" href="isi_berita.php">Isi Berita</a>
                </li>
                <li>
                    <a class="nav-link text-white" href="kategori.php">Kategori</a>
                </li>
                <li>
                    <a class="nav-link text-white" href="#">User</a>
                </li>
            </ul>
        
        <!-- admin profile mobile -->
        <div class="d-flex align-items-center gap-2">
            <img src="https://github.com/mdo.png" alt="" width="36" height="36" class="rounded-circle me-2"> 
            <div class="dropdown p-10"> 
            <a href="#" class="align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> 
            <strong><?php echo htmlspecialchars($nama)?></strong> 
            </a> 
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">  
                <li><a href="#">Profile</a></li> 
                <li><a href="logout.php" class="btn btn-danger">Logout</a></li> 
            </ul> 
            </div> 
        </div>
        </div>
    </div>
    <script src="../admin/assets/js/bootstrap.bundle.min.js"></script>
    <script>
        window.onload = function() {
            history.pushState(null, null, location.href);
            window.onpopstate = function() {
                history.go(1);
            };
        }

        setInterval(function() {
            fetch('check_session.php')
            .then(response => response.json())
            .then(data => {
                if(!data.logged_in)  {
                    alert('Session Anda telah habis. Silakan login kembali.');
                    window.location.href = 'login.php';
                }
            });
        }, 5000);
    </script>
</body>
</html>