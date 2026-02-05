<?php
// Include the main header file containing database and utility functions
include '../../header.php';

// Vérifier si une demande POST a été envoyée (formulaire d'édition soumis)
if($_POST){
    // Récupérer l'ID de l'article depuis le champ caché du formulaire
    $numArt = $_POST['numArt'];
    
    // Récupérer et échapper tous les champs texte du formulaire
    $libTitrArt = addslashes($_POST['libTitrArt']);
    $libChapoArt = addslashes($_POST['libChapoArt']);
    $libAccrochArt = addslashes($_POST['libAccrochArt']);
    $parag1Art = addslashes($_POST['parag1Art']);
    $libSsTitr1Art = addslashes($_POST['libSsTitr1Art']);
    $parag2Art = addslashes($_POST['parag2Art']);
    $libSsTitr2Art = addslashes($_POST['libSsTitr2Art']);
    $parag3Art = addslashes($_POST['parag3Art']);
    $libConclArt = addslashes($_POST['libConclArt']);
    $numThem = $_POST['numThem'];

    // Ce tableau est utilisé par la fonction sql_update() pour construire la requête UPDATE
    $data = [
        'libTitrArt' => $libTitrArt,
        'libChapoArt' => $libChapoArt,
        'libAccrochArt' => $libAccrochArt,
        'parag1Art' => $parag1Art,
        'libSsTitr1Art' => $libSsTitr1Art,
        'parag2Art' => $parag2Art,
        'libSsTitr2Art' => $libSsTitr2Art,
        'parag3Art' => $parag3Art,
        'libConclArt' => $libConclArt,
        'numThem' => $numThem
    ];

    // 'urlPhotArt' correspond au champ file du formulaire <input type="file" name="urlPhotArt" />
    if(!empty($_FILES['urlPhotArt']['name'])){
        
        // Définir le répertoire de destination pour les uploads
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/BLOGART26/src/uploads/';
        
        // Vérifier que le répertoire d'upload existe, sinon le créer
        if (!is_dir($upload_dir)) {

            // le paramètre true permet la création récursive des répertoires parents
            mkdir($upload_dir, 0755, true);
        }

        $file_name = basename($_FILES['urlPhotArt']['name']);
        // Chemin complet où le fichier sera sauvegardé
        $file_path = $upload_dir . $file_name;
        
        // Déplacer le fichier du dossier temporaire vers le dossier cible
        // move_uploaded_file() valide que c'est un vrai upload avant de le déplacer
        if(move_uploaded_file($_FILES['urlPhotArt']['tmp_name'], $file_path)){
            // L'upload a réussi, ajouter le chemin au tableau de données
            // Utiliser un chemin relatif au webroot pour l'accès via navigateur
            $data['urlPhotArt'] = '/BLOGART26/src/uploads/' . $file_name;
        }
        // Si l'upload échoue, on ne modifie pas le champ 'urlPhotArt' et l'ancienne photo reste
    }
    
    // Appeler sql_update() pour mettre à jour l'enregistrement ARTICLE
    // sql_update("TABLE", [colonnes], "WHERE condition")
    // Ceci exécute : UPDATE ARTICLE SET colonne1=valeur1, colonne2=valeur2, ... WHERE numArt=$numArt
    sql_update("ARTICLE", $data, "numArt = $numArt");
    
    // Supprimer TOUTES les associations de mots-clés pour CET article
    // Cela prépare pour l'ajout des nouvelles associations sélectionnées par l'utilisateur
    sql_delete('MOTCLEARTICLE', "numArt = $numArt");
    
    // Ajouter les NOUVELLES associations de mots-clés
    // Vérifier d'abord que l'utilisateur a sélectionné au moins un mot-clé
    if(isset($_POST['motscles_choisis']) && !empty($_POST['motscles_choisis'])){
        // Boucler sur chaque mot-clé sélectionné dans la liste de droite du formulaire
        foreach($_POST['motscles_choisis'] as $numMotCle){

            // Ceci exécute : INSERT INTO MOTCLEARTICLE (numArt, numMotCle) VALUES ($numArt, $numMotCle)
            sql_insert("MOTCLEARTICLE", [
                'numArt' => $numArt,
                'numMotCle' => $numMotCle
            ]);
        }
    }
    // Si l'utilisateur n'a pas sélectionné de mots-clés, l'article n'aura aucune association

    // Après la modification réussie, rediriger l'utilisateur vers la liste des articles
    // pour qu'il puisse voir les modifications effectuées
    header('Location: ' . ROOT_URL . '/views/backend/articles/list.php');
    // exit() arrête l'exécution du script et force la redirection HTTP
    exit();
}
?>
