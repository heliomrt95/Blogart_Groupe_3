<?php
require_once '../../config.php';

// Connexion à la BDD
sql_connect();
global $DB;

// Récupérer l'ID de l'article
$numArt = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($numArt <= 0) {
    header('Location: ../../views/backend/articles/list.php?error=ID invalide');
    exit;
}

try {
    // Vérifier que l'article existe
    $checkArticle = $DB->prepare("SELECT numArt FROM ARTICLE WHERE numArt = :id");
    $checkArticle->execute(['id' => $numArt]);
    
    if ($checkArticle->rowCount() == 0) {
        header('Location: ../../views/backend/articles/list.php?error=Article introuvable');
        exit;
    }
    
    // ÉTAPE 1 : Supprimer les liaisons dans MOTCLEARTICLE
    $deleteKeywords = $DB->prepare("DELETE FROM MOTCLEARTICLE WHERE numArt = :id");
    $deleteKeywords->execute(['id' => $numArt]);
    
    // ÉTAPE 2 : Supprimer les commentaires liés
    $deleteComments = $DB->prepare("DELETE FROM COMMENT WHERE numArt = :id");
    $deleteComments->execute(['id' => $numArt]);
    
    // ÉTAPE 3 : Supprimer les likes liés
    $deleteLikes = $DB->prepare("DELETE FROM LIKEART WHERE numArt = :id");
    $deleteLikes->execute(['id' => $numArt]);
    
    // ÉTAPE 4 : Récupérer le nom de l'image pour la supprimer du serveur
    $getImage = $DB->prepare("SELECT urlPhotArt FROM ARTICLE WHERE numArt = :id");
    $getImage->execute(['id' => $numArt]);
    $article = $getImage->fetch(PDO::FETCH_ASSOC);
    
    // ÉTAPE 5 : Supprimer l'article
    $deleteArticle = $DB->prepare("DELETE FROM ARTICLE WHERE numArt = :id");
    $deleteArticle->execute(['id' => $numArt]);
    
    // ÉTAPE 6 : Supprimer l'image du serveur
    if ($article && !empty($article['urlPhotArt'])) {
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $article['urlPhotArt'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    
    // Redirection avec message de succès
    header('Location: ../../views/backend/articles/list.php?success=deleted');
    exit;
    
} catch (PDOException $e) {
    // En cas d'erreur
    header('Location: ../../views/backend/articles/list.php?error=' . urlencode($e->getMessage()));
    exit;
}
?>