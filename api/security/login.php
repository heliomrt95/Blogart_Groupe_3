<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// === VÉRIFICATION reCAPTCHA v3 ===
if(!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
    $_SESSION['login_error'] = "Veuillez valider le reCAPTCHA.";
    header('Location: /views/backend/security/login.php');
    exit;
}

$token = $_POST['g-recaptcha-response'];
$url = 'https://www.google.com/recaptcha/api/siteverify';

$data = array(
    'secret' => '6LcW8l0sAAAAALUKpIDotR7ZxfWqIjw58OFvJ4OE',
    'response' => $token
);

$options = array(
    'http' => array (
        'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
    )
);

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$response = json_decode($result);

if (!$response->success || $response->score < 0.5) {
    $_SESSION['login_error'] = "Échec de validation reCAPTCHA. Veuillez réessayer.";
    header('Location: /views/backend/security/login.php');
    exit;
}

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