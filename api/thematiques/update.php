<?php
// Inclut la configuration globale (connexion DB, constantes, fonctions utilitaires)
require_once '../../config.php';

// Validation des données POST : on s'assure que tous les champs attendus sont présents
if (
    isset($_POST['oldNumStat']) && is_numeric($_POST['oldNumStat']) &&
    isset($_POST['numStat']) && is_numeric($_POST['numStat']) &&
    isset($_POST['dtCreaStat']) && !empty($_POST['dtCreaStat']) &&
    isset($_POST['libStat']) && !empty($_POST['libStat'])
) {
    // Casts et normalisations
    $oldNumStat = (int) $_POST['oldNumStat']; // id d'origine
    $numStat = (int) $_POST['numStat'];       // nouvel id souhaité

    // Convertit la date HTML5 (datetime-local) en format MySQL 'Y-m-d H:i:s'
    $dtCreaStat = date('Y-m-d H:i:s', strtotime($_POST['dtCreaStat']));

    // Nettoie le libellé (trim enleve espaces de début/fin)
    $libStat = trim($_POST['libStat']);

    // Construit la clause SET pour la fonction sql_update (tableau non utilisé ici)
    // NOTE: on utilise des valeurs interpolées ; pour plus de sécurité on pourrait
    // préparer la requête avec des bindParameters dans sql_update.
    $attributs = "numStat = $numStat, libStat = '$libStat', dtCreaStat = '$dtCreaStat'";
    // Condition WHERE pour identifier la ligne à mettre à jour
    $where = "numStat = $oldNumStat";

    // Appelle la fonction centrale qui exécute la mise à jour en base
    $result = sql_update("THEMATIQUE", $attributs, $where);

    if ($result) {
        // Si succès, redirige vers la liste des thématiques
        header('Location: ' . ROOT_URL . '/views/backend/thematiques/list.php');
        exit;
    } else {
        // Affiche un message simple en cas d'erreur (améliorable)
        echo "Erreur lors de la mise à jour.";
    }
} else {
    // Si paramètres manquants/invalide : retourne à la liste
    header('Location: ' . ROOT_URL . '/views/backend/thematiques/list.php');
    exit;
}
?>