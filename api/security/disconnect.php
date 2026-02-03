<?php
session_start();

// Détruire toutes les sessions
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

// Message de déconnexion
session_start();
$_SESSION['logout_success'] = "Vous avez été déconnecté avec succès.";

header('Location: ../../index.php');
exit;
?>