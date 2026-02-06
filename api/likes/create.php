<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$isAjax = isset($_POST['ajax']) && $_POST['ajax'] == '1';

// Vérifier connexion
if(!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Non connecté']);
    exit;
    header('Location: /views/backend/security/login.php');
    exit;
}

$numMemb = (int)$_POST['numMemb'];
$numArt = (int)$_POST['numArt'];
$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '/views/frontend/articles.php';

// Vérifier que c'est bien l'utilisateur connecté
if($numMemb != $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'error' => 'Erreur utilisateur']);
    exit;
    header('Location: ' . $redirect);
    exit;
}

// Vérifier que le like n'existe pas déjà
$existing = sql_select("LIKEART", "*", "numMemb = $numMemb AND numArt = $numArt");

if(count($existing) > 0) {
    if ($isAjax) {
        // Compter les likes
        $likes = sql_select("LIKEART", "*", "numArt = $numArt");
        echo json_encode([
            'success' => true,
            'liked' => true,
            'totalLikes' => count($likes)
        ]);
        exit;
    }
    header('Location: ' . $redirect);
    exit;
}

// Créer le like
sql_insert('LIKEART', 'numMemb, numArt, likeA', "$numMemb, $numArt, 1");

if ($isAjax) {
    // Compter les likes
    $likes = sql_select("LIKEART", "*", "numArt = $numArt");
    echo json_encode([
        'success' => true,
        'liked' => true,
        'totalLikes' => count($likes)
    ]);
    exit;
}

header('Location: ' . $redirect);
?>