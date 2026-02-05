<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Récupération des données du formulaire
$pseudoMemb = trim($_POST['pseudoMemb']);
$prenomMemb = trim($_POST['prenomMemb']);
$nomMemb = trim($_POST['nomMemb']);
$eMailMemb = trim($_POST['eMailMemb']);
$eMailMemb2 = trim($_POST['eMailMemb2']);
$passMemb = $_POST['passMemb'];
$passMemb2 = $_POST['passMemb2'];
$accordMemb = isset($_POST['accordMemb']) ? (int)$_POST['accordMemb'] : 0;
$numStat = (int)$_POST['numStat'];

// VALIDATIONS

// Validation PSEUDO (6-70 caractères, unique)
if(strlen($pseudoMemb) < 6 || strlen($pseudoMemb) > 70) {
    echo "<script>alert('Le pseudo doit contenir entre 6 et 70 caractères.'); window.history.back();</script>";
    exit;
}

// Vérification unicité du pseudo
$existingPseudo = sql_select("MEMBRE", "COUNT(*) as nb", "pseudoMemb = '$pseudoMemb'");
if($existingPseudo[0]['nb'] > 0) {
    echo "<script>alert('Ce pseudo existe déjà. Veuillez en choisir un autre.'); window.history.back();</script>";
    exit;
}

// Validation PRÉNOM et NOM (obligatoires)
if(empty($prenomMemb) || empty($nomMemb)) {
    echo "<script>alert('Le prénom et le nom sont obligatoires.'); window.history.back();</script>";
    exit;
}

// Validation EMAIL (format + identiques)
if(!filter_var($eMailMemb, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('L\'adresse email n\'est pas valide.'); window.history.back();</script>";
    exit;
}

if($eMailMemb !== $eMailMemb2) {
    echo "<script>alert('Les deux adresses email doivent être identiques.'); window.history.back();</script>";
    exit;
}

// Validation PASSWORD (8-15 car., maj+min+chiffre+spécial + identiques)
if($passMemb !== $passMemb2) {
    echo "<script>alert('Les deux mots de passe doivent être identiques.'); window.history.back();</script>";
    exit;
}

// Regex : au moins 1 maj, 1 min, 1 chiffre, 1 spécial, 8-15 caractères
$passRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/';
if(!preg_match($passRegex, $passMemb)) {
    echo "<script>alert('Le mot de passe doit contenir entre 8 et 15 caractères avec au moins : 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial (@$!%*?&).'); window.history.back();</script>";
    exit;
}

// Cryptage du password
$hashedPassword = password_hash($passMemb, PASSWORD_DEFAULT);

// Validation RGPD (doit être accepté)
if($accordMemb != 1) {
    echo "<script>alert('Vous devez accepter la conservation de vos données personnelles pour créer un compte.'); window.history.back();</script>";
    exit;
}

// Validation reCAPTCHA v3 (optionnel - à implémenter avec vos clés)
// TODO: Ajouter la vérification reCAPTCHA ici

// INSERTION EN BASE DE DONNÉES
$columns = 'pseudoMemb, prenomMemb, nomMemb, eMailMemb, passMemb, accordMemb, numStat';
$values = "'$pseudoMemb', '$prenomMemb', '$nomMemb', '$eMailMemb', '$hashedPassword', $accordMemb, $numStat";

sql_insert('MEMBRE', $columns, $values);

// Redirection
header('Location: ../../views/backend/members/list.php');
?>