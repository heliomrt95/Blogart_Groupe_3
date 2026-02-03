<?php
// Inclusion du fichier de configuration
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Inclusion de la fonction de contrôle des saisies
require_once '../../functions/ctrlSaisies.php';

// Récupération de l'ID de l'article à supprimer
$numArt = $_POST['numArt'];
// Récupération du nom de l'image associée à l'article
$urlPhotArt = $_POST['urlPhotArt'];

// Vérification d'intégrité référentielle : on vérifie si des commentaires existent pour cet article
$comments = sql_select("COMMENT", "COUNT(*) as nb", "numArt = $numArt");
$nbComments = $comments[0]['nb'];

// Vérification d'intégrité référentielle : on vérifie si des likes existent pour cet article
$likes = sql_select("LIKEART", "COUNT(*) as nb", "numArt = $numArt");
$nbLikes = $likes[0]['nb'];

// Vérification d'intégrité référentielle : on vérifie si des mots-clés sont associés à cet article
$motcles = sql_select("MOTCLEARTICLE", "COUNT(*) as nb", "numArt = $numArt");
$nbMotcles = $motcles[0]['nb'];

// Vérification si l'article possède des données associées
if($nbComments > 0 || $nbLikes > 0 || $nbMotcles > 0){
    // L'article possède des relations, suppression impossible
    // Construction d'un message d'erreur détaillé
    $message = "Suppression impossible :\\n";
    if($nbComments > 0) $message .= "- $nbComments commentaire(s) associé(s)\\n";
    if($nbLikes > 0) $message .= "- $nbLikes like(s) associé(s)\\n";
    if($nbMotcles > 0) $message .= "- $nbMotcles mot(s)-clé(s) associé(s)\\n";
    
    // Affichage d'une alerte et redirection vers la liste
    echo "<script>alert('$message'); window.location.href='../../views/backend/articles/list.php';</script>";
    exit;
} else {
    // Aucune relation détectée, suppression possible
    
    // Suppression de l'image associée du serveur si elle existe
    if(!empty($urlPhotArt)) {
        // Construction du chemin complet de l'image
        $image_path = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $urlPhotArt;
        // Vérification de l'existence du fichier et suppression
        if(file_exists($image_path)) {
            unlink($image_path);
        }
    }
    
    // Suppression de l'article de la base de données
    sql_delete('ARTICLE', "numArt = $numArt");
    
    // Redirection vers la liste des articles
    header('Location: ../../views/backend/articles/list.php');
}
?>