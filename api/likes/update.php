<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$numMemb = (int)$_POST['numMemb'];
$numArt = (int)$_POST['numArt'];
$likeA = (int)$_POST['likeA'];

// Mettre à jour
sql_update('LIKEART', "likeA = $likeA", "numMemb = $numMemb AND numArt = $numArt");

header('Location: ../../views/backend/likes/list.php');
?>