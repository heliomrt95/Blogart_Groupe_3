<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$numMemb = (int)$_POST['numMemb'];

// Vérification : empêcher la suppression de l'administrateur
$member = sql_select("MEMBRE", "numStat", "numMemb = $numMemb")[0];
$statut = sql_select("STATUT", "libStat", "numStat = " . $member['numStat'])[0];

if($statut['libStat'] == 'Administrateur') {
    echo "<script>alert('ERREUR : La suppression du compte Administrateur est INTERDITE !'); window.location.href='../../views/backend/members/list.php';</script>";
    exit;
}

// Suppression de tous les commentaires du membre (CIR)
sql_delete('COMMENT', "numMemb = $numMemb");

// Suppression de tous les likes du membre (CIR)
sql_delete('LIKEART', "numMemb = $numMemb");

// Suppression du membre
sql_delete('MEMBRE', "numMemb = $numMemb");

// Redirection
header('Location: ../../views/backend/members/list.php');
?>