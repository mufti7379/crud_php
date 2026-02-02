<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$_SESSION = [];

if(ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 86400,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

if(ob_get_level()){
    ob_end_clean();
}

header("Cache-Control: no-cache, no-store, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");

header("Location: login.php");
echo '<script>window.location.href = "login.php";</script>';
exit();
?>