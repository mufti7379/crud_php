<?php
include 'config_session.php';

header('Content-Type: application/json');

echo json_encode([
    'logged_in' => isLoggedIn()
]);
?>