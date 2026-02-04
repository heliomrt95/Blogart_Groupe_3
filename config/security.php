<?php
/**
 * VÉRIFICATION DE SÉCURITÉ
 * Vérifie si l'utilisateur est connecté
 */

// Constante pour vérifier si l'utilisateur est connecté
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    define('USER_IS_LOGGED_IN', true);
    define('USER_ID', $_SESSION['user_id']);
    define('USER_PSEUDO', $_SESSION['user_pseudo']);
    define('USER_ROLE', $_SESSION['user_statut_nom']);
} else {
    define('USER_IS_LOGGED_IN', false);
    define('USER_ID', 0);
    define('USER_PSEUDO', '');
    define('USER_ROLE', '');
}

/**
 * Fonction pour protéger une page (réserver aux utilisateurs connectés)
 */
function require_login() {
    if (!USER_IS_LOGGED_IN) {
        $_SESSION['login_error'] = "Vous devez être connecté pour accéder à cette page.";
        header('Location: /views/backend/security/login.php');
        exit;
    }
}

/**
 * Fonction pour protéger une page (réserver aux modérateurs)
 */
function require_moderator() {
    if (!USER_IS_LOGGED_IN || USER_ROLE !== 'Modérateur') {
        $_SESSION['login_error'] = "Accès réservé aux modérateurs.";
        header('Location: /index.php');
        exit;
    }
}

/**
 * Fonction pour échapper les sorties HTML (protection XSS)
 */
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>