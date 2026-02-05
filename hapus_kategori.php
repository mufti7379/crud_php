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


?>