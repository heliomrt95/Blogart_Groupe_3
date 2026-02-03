<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// === VÉRIFICATION reCAPTCHA v3 ===
if(!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
    $_SESSION['signup_error'] = "Veuillez valider le reCAPTCHA.";
    header('Location: ../../views/backend/security/signup.php');
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
    $_SESSION['signup_error'] = "Échec de validation reCAPTCHA. Veuillez réessayer.";
    header('Location: ../../views/backend/security/signup.php');
    exit;
}

// Récupération des données
$pseudo = isset($_POST['pseudo']) ? addslashes(trim($_POST['pseudo'])) : '';
$prenom = isset($_POST['prenom']) ? addslashes(trim($_POST['prenom'])) : '';
$nom = isset($_POST['nom']) ? addslashes(trim($_POST['nom'])) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$password_confirm = isset($_POST['password_confirm']) ? trim($_POST['password_confirm']) : '';
$email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
$email_confirm = isset($_POST['email_confirm']) ? addslashes(trim($_POST['email_confirm'])) : '';
$rgpd = isset($_POST['rgpd']) ? (int)$_POST['rgpd'] : 0;

// Validation pseudo
if(strlen($pseudo) < 6 || strlen($pseudo) > 70) {
    $_SESSION['signup_error'] = "Le pseudo doit contenir entre 6 et 70 caractères.";
    header('Location: ../../views/backend/security/signup.php');
    exit;
}

// Vérifier unicité pseudo
$existing = sql_select("MEMBRE", "COUNT(*) as nb", "pseudoMemb = '$pseudo'");
if($existing[0]['nb'] > 0) {
    $_SESSION['signup_error'] = "Ce pseudo est déjà utilisé.";
    header('Location: ../../views/backend/security/signup.php');
    exit;
}

// Vérifier emails
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['signup_error'] = "Email invalide.";
    header('Location: ../../views/backend/security/signup.php');
    exit;
}

if($email !== $email_confirm) {
    $_SESSION['signup_error'] = "Les emails ne correspondent pas.";
    header('Location: ../../views/backend/security/signup.php');
    exit;
}

// Vérifier passwords
if($password !== $password_confirm) {
    $_SESSION['signup_error'] = "Les mots de passe ne correspondent pas.";
    header('Location: ../../views/backend/security/signup.php');
    exit;
}

if(strlen($password) < 8 || strlen($password) > 15) {
    $_SESSION['signup_error'] = "Le mot de passe doit contenir entre 8 et 15 caractères.";
    header('Location: ../../views/backend/security/signup.php');
    exit;
}

// Vérifier RGPD
if($rgpd != 1) {
    $_SESSION['signup_error'] = "Vous devez accepter que vos données soient conservées.";
    header('Location: ../../views/backend/security/signup.php');
    exit;
}

// Hasher le password
$passMemb = password_hash($password, PASSWORD_DEFAULT);

// Récupérer le statut "Membre"
$statut = sql_select("STATUT", "numStat", "libStat = 'Membre'");
if(count($statut) == 0) {
    sql_insert('STATUT', 'libStat', "'Membre'");
    $statut = sql_select("STATUT", "numStat", "libStat = 'Membre'");
}
$numStat = $statut[0]['numStat'];

// Insertion
$columns = 'pseudoMemb, prenomMemb, nomMemb, passMemb, eMailMemb, accordMemb, numStat';
$values = "'$pseudo', '$prenom', '$nom', '$passMemb', '$email', $rgpd, $numStat";

sql_insert('MEMBRE', $columns, $values);

// MESSAGE DE SUCCÈS
$_SESSION['signup_success'] = "✅ Votre compte a été créé avec succès ! Vous pouvez maintenant vous connecter avec votre pseudo : <strong>$pseudo</strong>";
header('Location: ../../views/backend/security/login.php');
exit;
?>