<?php
session_start();

if(isset($_SESSION['pengguna'])) {
    // User is logged in, proceed to logout
    unset($_SESSION['pengguna']);
};

foreach ($_SESSION as $key => $value) {
    unset($_SESSION[$key]);
}

$_SESSION = array();

if(isset($_COOKIE[session_name()])){
    setcookie(session_name(), '', time() - 3600, '/');
};

$_SESSION = array();

if(ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

header("Cache-Control: no-cache, no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");

header("Location: login.php");
exit();
?>