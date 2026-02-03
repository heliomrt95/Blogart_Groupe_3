<?php
// Inclusion du fichier de configuration
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Inclusion de la fonction de contrôle des saisies
require_once '../../functions/ctrlSaisies.php';

// Récupération des données du formulaire
// ID de l'article à mettre à jour
$numArt = $_POST['numArt'];
// Contenu de l'article (titre, chapô, accroche, paragraphes, sous-titres, conclusion)
// Contenu de l'article avec protection contre les apostrophes
$libTitrArt = addslashes($_POST['libTitrArt']);
$libChapoArt = addslashes($_POST['libChapoArt']);
$libAccrochArt = addslashes($_POST['libAccrochArt']);
$parag1Art = addslashes($_POST['parag1Art']);
$libSsTitr1Art = addslashes($_POST['libSsTitr1Art']);
$parag2Art = addslashes($_POST['parag2Art']);
$libSsTitr2Art = addslashes($_POST['libSsTitr2Art']);
$parag3Art = addslashes($_POST['parag3Art']);
$libConclArt = addslashes($_POST['libConclArt']);
// Thématique associée
$numThem = $_POST['numThem'];
// Ancienne image (par défaut vide si non fournie)
$oldImage = $_POST['oldImage'] ?? '';

// Gestion de l'upload d'image (si une nouvelle image est fournie)
// Par défaut, on conserve l'ancienne image
$urlPhotArt = $oldImage;

// Vérification qu'une nouvelle image a été uploadée sans erreur
if(isset($_FILES['urlPhotArt']) && $_FILES['urlPhotArt']['error'] == 0) {
    // Liste des extensions autorisées
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    // Récupération du nom, du chemin temporaire et de l'extension du fichier
    $file_name = $_FILES['urlPhotArt']['name'];
    $file_tmp = $_FILES['urlPhotArt']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Vérification que l'extension du fichier est autorisée
    if(in_array($file_ext, $allowed_extensions)) {
        // Suppression de l'ancienne image du serveur si elle existe
        if(!empty($oldImage)) {
            // Construction du chemin complet de l'ancienne image
            $old_image_path = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $oldImage;
            // Vérification de l'existence et suppression
            if(file_exists($old_image_path)) {
                unlink($old_image_path);
            }
        }
        
        // Génération d'un nom unique pour la nouvelle image (timestamp + nombre aléatoire)
        $new_file_name = 'article_' . time() . '_' . rand(1000, 9999) . '.' . $file_ext;
        // Chemin de destination du fichier
        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $new_file_name;
        
        // Déplacement du fichier temporaire vers le dossier uploads
        if(move_uploaded_file($file_tmp, $upload_path)) {
            // Stockage du nom du fichier pour mise à jour en base de données
            $urlPhotArt = $new_file_name;
        } else {
            // Affichage d'un message d'erreur et retour au formulaire
            echo "<script>alert('Erreur lors de l\'upload de l\'image.'); window.history.back();</script>";
            exit;
        }
    } else {
        // Affichage d'un message d'erreur si l'extension n'est pas autorisée
        echo "<script>alert('Extension de fichier non autorisée. Utilisez JPG, JPEG, PNG ou GIF.'); window.history.back();</script>";
        exit;
    }
}

// ÉCHAPPEMENT DES APOSTROPHES pour éviter les erreurs SQL
$libTitrArt = addslashes($libTitrArt);
$libChapoArt = addslashes($libChapoArt);
$libAccrochArt = addslashes($libAccrochArt);
$parag1Art = addslashes($parag1Art);
$libSsTitr1Art = addslashes($libSsTitr1Art);
$parag2Art = addslashes($parag2Art);
$libSsTitr2Art = addslashes($libSsTitr2Art);
$parag3Art = addslashes($parag3Art);
$libConclArt = addslashes($libConclArt);

// Mise à jour en base de données
// Définition de tous les champs à mettre à jour avec leurs nouvelles valeurs
$update_data = "libTitrArt = '$libTitrArt', 
                libChapoArt = '$libChapoArt', 
                libAccrochArt = '$libAccrochArt', 
                parag1Art = '$parag1Art', 
                libSsTitr1Art = '$libSsTitr1Art', 
                parag2Art = '$parag2Art', 
                libSsTitr2Art = '$libSsTitr2Art', 
                parag3Art = '$parag3Art', 
                libConclArt = '$libConclArt', 
                urlPhotArt = '$urlPhotArt', 
                numThem = $numThem";

// Exécution de la mise à jour
sql_update('ARTICLE', $update_data, "numArt = $numArt");

// Redirection vers la liste des articles
header('Location: ../../views/backend/articles/list.php');
?>