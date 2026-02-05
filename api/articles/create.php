<?php
// Inclusion du fichier de configuration
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Inclusion de la fonction de contrôle des saisies
require_once '../../functions/ctrlSaisies.php';

// CONNEXION À LA BASE DE DONNÉES
sql_connect();
global $DB;

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
$numThem = (int)$_POST['numThem'];

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

// ✅ INSERTION DE L'ARTICLE AVEC PDO
try {
    sql_insert('ARTICLE', 
        'libTitrArt, libChapoArt, libAccrochArt, parag1Art, libSsTitr1Art, parag2Art, libSsTitr2Art, parag3Art, libConclArt, urlPhotArt, numThem',
        "???"
    );

    $stmt = $DB->prepare($query);
    
    // Exécuter l'insertion
    $stmt->execute([
        'libTitrArt' => $libTitrArt,
        'libChapoArt' => $libChapoArt,
        'libAccrochArt' => $libAccrochArt,
        'parag1Art' => $parag1Art,
        'libSsTitr1Art' => $libSsTitr1Art,
        'parag2Art' => $parag2Art,
        'libSsTitr2Art' => $libSsTitr2Art,
        'parag3Art' => $parag3Art,
        'libConclArt' => $libConclArt,
        'urlPhotArt' => $urlPhotArt,
        'numThem' => $numThem
    ]);
    
    // ✅ RÉCUPÉRER L'ID DE L'ARTICLE
    $lastArticleId = $DB->lastInsertId();
    
    // ✅ TRAITEMENT DES MOTS-CLÉS
    if (isset($_POST['motscles']) && is_array($_POST['motscles']) && count($_POST['motscles']) > 0) {
        
        foreach ($_POST['motscles'] as $keywordId) {
            $keywordId = (int)$keywordId;
            
            if ($keywordId > 0) {
                // Vérifier que le mot-clé existe
                $checkKeyword = $DB->prepare("SELECT numMotCle FROM MOTCLE WHERE numMotCle = :id");
                $checkKeyword->execute(['id' => $keywordId]);
                
                if ($checkKeyword->rowCount() > 0) {
                    // Insérer la liaison
                    $insertLink = $DB->prepare("INSERT INTO MOTCLEARTICLE (numArt, numMotCle) VALUES (:numArt, :numMotCle)");
                    $insertLink->execute([
                        'numArt' => $lastArticleId,
                        'numMotCle' => $keywordId
                    ]);
                }
            }
        }
    }
    
    // Redirection vers la liste des articles
    header('Location: ../../views/backend/articles/list.php');
    exit;
    
} catch (PDOException $e) {
    // Afficher l'erreur pour déboguer
    die("Erreur SQL : " . $e->getMessage());
}
?>