<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$numCom = (int)$_POST['numCom'];

// Suppression physique
sql_delete('COMMENT', "numCom = $numCom");

header('Location: ../../views/backend/comments/list.php');
?>