<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$isAjax = isset($_POST['ajax']) && $_POST['ajax'] == '1';

// Vérifier connexion
if(!isset($_SESSION['user_id'])) {
    if ($isAjax) {
        echo json_encode(['success' => false, 'message' => 'Vous devez être connecté.']);
        exit;
    }
    $_SESSION['comment_error'] = "Vous devez être connecté.";
    header('Location: /views/backend/security/login.php');
    exit;
}

// Récupération données
$numArt = (int)$_POST['numArt'];
$numMemb = (int)$_POST['numMemb'];
$libCom = trim($_POST['libCom']);
$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '/views/frontend/articles.php';

// Vérifications
if($numMemb != $_SESSION['user_id']) {
    if ($isAjax) {
        echo json_encode(['success' => false, 'message' => 'Erreur utilisateur.']);
        exit;
    }
    $_SESSION['comment_error'] = "Erreur utilisateur.";
    header('Location: ' . $redirect);
    exit;
}

if(empty($libCom) || strlen($libCom) > 600) {
    if ($isAjax) {
        echo json_encode(['success' => false, 'message' => 'Le commentaire doit contenir entre 1 et 600 caractères.']);
        exit;
    }
    $_SESSION['comment_error'] = "Commentaire entre 1 et 600 caractères.";
    header('Location: ' . $redirect);
    exit;
}

// Protection SQL
$libCom = addslashes(htmlspecialchars($libCom, ENT_QUOTES, 'UTF-8'));

// Insertion (attModOK = 0 = en attente de modération)
$columns = 'libCom, numArt, numMemb, attModOK, delLogiq';
$values = "'$libCom', $numArt, $numMemb, 0, 0";
sql_insert('COMMENT', $columns, $values);

if ($isAjax) {
    echo json_encode([
        'success' => true, 
        'message' => 'Votre commentaire a été soumis et est en attente de modération.'
    ]);
    exit;
}

$_SESSION['comment_success'] = "Votre commentaire a été soumis et est en attente de modération.";
header('Location: ' . $redirect);
?>