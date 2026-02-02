<?php
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_lifetime', 3600);


session_start();

function isLoggedIn() {
    return isset($_SESSION['pengguna']) && !empty($_SESSION['pengguna']);
}

function checkSessionTimeout() {
    if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > 3600) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
    $_SESSION['last_activity'] = time();
}

?>