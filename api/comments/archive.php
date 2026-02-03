<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$numCom = (int)$_POST['numCom'];

// Mise à jour : suppression logique (delLogiq = 1)
$update_data = "delLogiq = 1, dtDelLogCom = NOW()";

sql_update('COMMENT', $update_data, "numCom = $numCom");

// Redirection
header('Location: ../../views/backend/comments/list.php');
?>