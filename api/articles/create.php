<?php
// Inclusion du fichier de configuration
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Inclusion de la fonction de contrôle des saisies
require_once '../../functions/ctrlSaisies.php';

// Récupération des données avec protection
$libTitrArt = addslashes($_POST['libTitrArt']);
$libChapoArt = addslashes($_POST['libChapoArt']);
$libAccrochArt = addslashes($_POST['libAccrochArt']);
$parag1Art = addslashes($_POST['parag1Art']);
$libSsTitr1Art = addslashes($_POST['libSsTitr1Art']);
$parag2Art = addslashes($_POST['parag2Art']);
$libSsTitr2Art = addslashes($_POST['libSsTitr2Art']);
$parag3Art = addslashes($_POST['parag3Art']);
$libConclArt = addslashes($_POST['libConclArt']);
// Récupération de la thématique associée
$numThem = $_POST['numThem'];

// Gestion de l'upload d'image
$urlPhotArt = '';
// Vérification que le fichier a été uploadé sans erreur
if(isset($_FILES['urlPhotArt']) && $_FILES['urlPhotArt']['error'] == 0) {
    // Liste des extensions autorisées
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    // Récupération du nom, du chemin temporaire et de l'extension du fichier
    $file_name = $_FILES['urlPhotArt']['name'];
    $file_tmp = $_FILES['urlPhotArt']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Vérification que l'extension du fichier est autorisée
    if(in_array($file_ext, $allowed_extensions)) {
        // Génération d'un nom unique pour éviter les doublons (timestamp + nombre aléatoire)
        $new_file_name = 'article_' . time() . '_' . rand(1000, 9999) . '.' . $file_ext;
        // Chemin de destination du fichier
        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $new_file_name;
        
        // Déplacement du fichier temporaire vers le dossier uploads
        if(move_uploaded_file($file_tmp, $upload_path)) {
            // Stockage du nom du fichier pour insertion en base de données
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

// Insertion en base de données
// Définition des colonnes de la table ARTICLE
$columns = 'libTitrArt, libChapoArt, libAccrochArt, parag1Art, libSsTitr1Art, parag2Art, libSsTitr2Art, parag3Art, libConclArt, urlPhotArt, numThem';
// Définition des valeurs à insérer
$values = "'$libTitrArt', '$libChapoArt', '$libAccrochArt', '$parag1Art', '$libSsTitr1Art', '$parag2Art', '$libSsTitr2Art', '$parag3Art', '$libConclArt', '$urlPhotArt', $numThem";

// Exécution de l'insertion
sql_insert('ARTICLE', $columns, $values);

// Redirection vers la liste des articles
header('Location: ../../views/backend/articles/list.php');
?>