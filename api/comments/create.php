<?php
// Démarrage de la session pour accéder aux données utilisateur
session_start();

// Inclusion du fichier de configuration (connexion BDD, constantes, etc.)
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// DÉTECTION DU TYPE DE REQUÊTE (AJAX ou classique)
// Permet d'adapter le format de réponse selon le type de requête
$isAjax = isset($_POST['ajax']) && $_POST['ajax'] == '1';

// VÉRIFICATION DE L'AUTHENTIFICATION
// L'utilisateur doit être connecté pour pouvoir commenter
if(!isset($_SESSION['user_id'])) {
    if ($isAjax) {
        // Réponse JSON pour les requêtes AJAX
        echo json_encode(['success' => false, 'message' => 'Vous devez être connecté.']);
        exit;
    }
    // Stockage du message d'erreur en session et redirection vers la page de connexion
    $_SESSION['comment_error'] = "Vous devez être connecté.";
    header('Location: /views/backend/security/login.php');
    exit;
}


// RÉCUPÉRATION ET NETTOYAGE DES DONNÉES DU FORMULAIRE
// Cast en entier pour sécuriser les identifiants numériques
$numArt = (int)$_POST['numArt'];      // ID de l'article
$numMemb = (int)$_POST['numMemb'];    // ID du membre
$libCom = trim($_POST['libCom']);      // Contenu du commentaire (espaces supprimés)

// URL de redirection après traitement (par défaut : liste des articles)
$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '/views/frontend/articles.php';


// VALIDATION : VÉRIFICATION DE L'IDENTITÉ DE L'UTILISATEUR
// Sécurité : l'ID membre envoyé doit correspondre à l'utilisateur connecté
// Empêche un utilisateur de poster un commentaire au nom d'un autre
if($numMemb != $_SESSION['user_id']) {
    if ($isAjax) {
        echo json_encode(['success' => false, 'message' => 'Erreur utilisateur.']);
        exit;
    }
    $_SESSION['comment_error'] = "Erreur utilisateur.";
    header('Location: ' . $redirect);
    exit;
}


// VALIDATION : VÉRIFICATION DU CONTENU DU COMMENTAIRE
// Le commentaire ne doit pas être vide et ne doit pas dépasser 600 caractères
if(empty($libCom) || strlen($libCom) > 600) {
    if ($isAjax) {
        echo json_encode(['success' => false, 'message' => 'Le commentaire doit contenir entre 1 et 600 caractères.']);
        exit;
    }
    $_SESSION['comment_error'] = "Commentaire entre 1 et 600 caractères.";
    header('Location: ' . $redirect);
    exit;
}

// SÉCURISATION DES DONNÉES AVANT INSERTION
// Protection contre les injections SQL et les attaques XSS :
// - htmlspecialchars() : convertit les caractères spéciaux HTML en entités
// - addslashes() : échappe les caractères spéciaux pour SQL
$libCom = addslashes(htmlspecialchars($libCom, ENT_QUOTES, 'UTF-8'));

// INSERTION DU COMMENTAIRE EN BASE DE DONNÉES
// Colonnes de la table COMMENT à remplir
$columns = 'libCom, numArt, numMemb, attModOK, delLogiq';

// Valeurs à insérer :
// - attModOK = 0 : commentaire en attente de modération (non validé)
// - delLogiq = 0 : commentaire non supprimé (suppression logique inactive)
$values = "'$libCom', $numArt, $numMemb, 0, 0";

// Appel de la fonction d'insertion SQL
sql_insert('COMMENT', $columns, $values);

// RÉPONSE SELON LE TYPE DE REQUÊTE
if ($isAjax) {
    // Réponse JSON pour les requêtes AJAX (succès)
    echo json_encode([
        'success' => true, 
        'message' => 'Votre commentaire a été soumis et est en attente de modération.'
    ]);
    exit;
}

// Stockage du message de succès en session et redirection
$_SESSION['comment_success'] = "Votre commentaire a été soumis et est en attente de modération.";
header('Location: ' . $redirect);
?>