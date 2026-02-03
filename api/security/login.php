<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Récupération des données
$pseudo = isset($_POST['pseudo']) ? trim($_POST['pseudo']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// Validation
if(empty($pseudo) || empty($password)) {
    $_SESSION['login_error'] = "Veuillez remplir tous les champs.";
    header('Location: ../../views/backend/security/login.php');
    exit;
}

// Rechercher l'utilisateur
$pseudo_escaped = addslashes($pseudo);
$user = sql_select("MEMBRE", "*", "pseudoMemb = '$pseudo_escaped'");

if(count($user) == 0) {
    $_SESSION['login_error'] = "Identifiants incorrects.";
    header('Location: ../../views/backend/security/login.php');
    exit;
}

$user = $user[0];

// Vérifier le mot de passe
if(!password_verify($password, $user['passMemb'])) {
    $_SESSION['login_error'] = "Identifiants incorrects.";
    header('Location: ../../views/backend/security/login.php');
    exit;
}

// Connexion réussie
$_SESSION['user_id'] = $user['numMemb'];
$_SESSION['user_pseudo'] = $user['pseudoMemb'];
$_SESSION['user_prenom'] = $user['prenomMemb'];
$_SESSION['user_nom'] = $user['nomMemb'];
$_SESSION['user_statut'] = $user['numStat'];
$_SESSION['logged_in'] = true;

// Récupérer le nom du statut (Membre ou Modérateur)
$statut = sql_select("STATUT", "libStat", "numStat = " . $user['numStat']);
if(count($statut) > 0) {
    $_SESSION['user_statut_nom'] = $statut[0]['libStat'];
} else {
    $_SESSION['user_statut_nom'] = 'Membre'; // Par défaut
}

// Redirection vers l'accueil
header('Location: ../../index.php');
exit;
?>