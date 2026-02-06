<?php
// ===============================
// 1) DÉMARRAGE DE LA SESSION
// ===============================

// La session permet d’accéder aux informations de l’utilisateur connecté
// (exemple : $_SESSION['user_id'])
session_start();


// ===============================
// 2) INCLUSION DE LA CONFIGURATION
// ===============================

// Inclusion du fichier config.php qui contient :
// - les constantes de connexion à la base de données
// - la connexion PDO ($DB)
// - les fonctions SQL (sql_insert, sql_connect, etc.)
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';


// ===============================
// 3) DÉTECTION DU MODE AJAX
// ===============================

// Si ajax=1 est présent dans le POST, cela signifie que la requête
// a été envoyée en AJAX (fetch / JavaScript)
$isAjax = isset($_POST['ajax']) && $_POST['ajax'] == '1';


// ===============================
// 4) VÉRIFICATION : UTILISATEUR CONNECTÉ
// ===============================

// Un utilisateur doit être connecté pour poster un commentaire
if (!isset($_SESSION['user_id'])) {

    // Si la requête est en AJAX, on renvoie une réponse JSON
    if ($isAjax) {
        echo json_encode([
            'success' => false,
            'message' => 'Vous devez être connecté.'
        ]);
    }

    // Sinon, on stocke un message d’erreur en session
    // puis on redirige vers la page de connexion
    $_SESSION['comment_error'] = "Vous devez être connecté.";
    header('Location: /views/backend/security/login.php');
}


// ===============================
// 5) RÉCUPÉRATION DES DONNÉES DU FORMULAIRE
// ===============================

// Récupération et sécurisation des identifiants numériques
// Le cast (int) empêche l’envoi de valeurs non numériques
$numArt  = (int) $_POST['numArt'];     // Identifiant de l’article
$numMemb = (int) $_POST['numMemb'];    // Identifiant du membre

// trim() enlève les espaces inutiles au début et à la fin du texte
$libCom = trim($_POST['libCom']);      // Texte du commentaire

// URL de redirection après traitement
// Si aucune URL n’est fournie, on revient à la liste des articles
$redirect = isset($_POST['redirect'])
    ? $_POST['redirect']
    : '/views/frontend/articles.php';


// ===============================
// 6) SÉCURITÉ : VÉRIFICATION DE L’IDENTITÉ
// ===============================

// Vérification essentielle :
// l’ID du membre envoyé doit correspondre à l’utilisateur connecté
// Cela empêche l’usurpation d’identité
if ($numMemb != $_SESSION['user_id']) {

    if ($isAjax) {
        echo json_encode([
            'success' => false,
            'message' => 'Erreur utilisateur.'
        ]);
    }

    $_SESSION['comment_error'] = "Erreur utilisateur.";
    header('Location: ' . $redirect);
}


// ===============================
// 7) VALIDATION DU CONTENU DU COMMENTAIRE
// ===============================

// Le commentaire doit :
// - contenir au moins 1 caractère
// - ne pas dépasser 600 caractères
if (empty($libCom) || strlen($libCom) > 600) {

    if ($isAjax) {
        echo json_encode([
            'success' => false,
            'message' => 'Le commentaire doit contenir entre 1 et 600 caractères.'
        ]);
    }

    $_SESSION['comment_error'] = "Commentaire entre 1 et 600 caractères.";
    header('Location: ' . $redirect);
}


// ===============================
// 8) SÉCURISATION DU TEXTE AVANT INSERTION
// ===============================

// htmlspecialchars() : empêche l’injection de HTML/JavaScript (XSS)
// addslashes() : échappe certains caractères spéciaux pour la requête SQL
// (idéalement, on utiliserait une requête préparée)
$libCom = addslashes(htmlspecialchars($libCom, ENT_QUOTES, 'UTF-8'));


// ===============================
// 9) INSERTION DU COMMENTAIRE EN BASE
// ===============================

// Colonnes de la table COMMENT à remplir
$columns = 'libCom, numArt, numMemb, attModOK, delLogiq';

// Valeurs insérées :
// - attModOK = 0 → commentaire en attente de modération
// - delLogiq = 0 → commentaire non supprimé (suppression logique inactive)
$values = "'$libCom', $numArt, $numMemb, 0, 0";

// Insertion du commentaire en base de données
sql_insert('COMMENT', $columns, $values);


// ===============================
// 10) RÉPONSE SELON LE TYPE DE REQUÊTE
// ===============================

// Si la requête est en AJAX, on renvoie une réponse JSON
if ($isAjax) {
    echo json_encode([
        'success' => true,
        'message' => 'Votre commentaire a été soumis et est en attente de modération.'
    ]);
}

// Sinon, on stocke un message de succès en session
// puis on redirige vers la page précédente
$_SESSION['comment_success'] = "Votre commentaire a été soumis et est en attente de modération.";
header('Location: ' . $redirect);
?>
