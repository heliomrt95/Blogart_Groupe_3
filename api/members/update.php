<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Récupération des données du formulaire
$numMemb = (int)$_POST['numMemb'];
$prenomMemb = trim($_POST['prenomMemb']);
$nomMemb = trim($_POST['nomMemb']);
$eMailMemb = trim($_POST['eMailMemb']);
$eMailMemb2 = trim($_POST['eMailMemb2']);
$passMemb = isset($_POST['passMemb']) ? $_POST['passMemb'] : '';
$passMemb2 = isset($_POST['passMemb2']) ? $_POST['passMemb2'] : '';
$numStat = (int)$_POST['numStat'];

// === VALIDATIONS ===

// 1. Validation PRÉNOM et NOM (obligatoires)
if(empty($prenomMemb) || empty($nomMemb)) {
    echo "<script>alert('Le prénom et le nom sont obligatoires.'); window.history.back();</script>";
    exit;
}

// 2. Validation EMAIL (format + identiques)
if(!filter_var($eMailMemb, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('L\'adresse email n\'est pas valide.'); window.history.back();</script>";
    exit;
}

if($eMailMemb !== $eMailMemb2) {
    echo "<script>alert('Les deux adresses email doivent être identiques.'); window.history.back();</script>";
    exit;
}

// 3. Validation PASSWORD (si changement demandé)
$updatePassword = false;
if(!empty($passMemb) || !empty($passMemb2)) {
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
    
    $hashedPassword = password_hash($passMemb, PASSWORD_DEFAULT);
    $updatePassword = true;
}

// === MISE À JOUR EN BASE DE DONNÉES ===
if($updatePassword) {
    // Mise à jour avec nouveau password
    $update_data = "prenomMemb = '$prenomMemb', 
                    nomMemb = '$nomMemb', 
                    eMailMemb = '$eMailMemb', 
                    passMemb = '$hashedPassword', 
                    numStat = $numStat";
} else {
    // Mise à jour sans changer le password
    $update_data = "prenomMemb = '$prenomMemb', 
                    nomMemb = '$nomMemb', 
                    eMailMemb = '$eMailMemb', 
                    numStat = $numStat";
}

sql_update('MEMBRE', $update_data, "numMemb = $numMemb");

// Redirection
header('Location: ../../views/backend/members/list.php');
?>