<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$numCom = (int)$_POST['numCom'];
$attModOK = (int)$_POST['attModOK'];
$notifComKOAff = isset($_POST['notifComKOAff']) ? addslashes(trim($_POST['notifComKOAff'])) : null;

// Mise à jour
if($notifComKOAff) {
    $update_data = "attModOK = $attModOK, notifComKOAff = '$notifComKOAff', dtModCom = NOW()";
} else {
    $update_data = "attModOK = $attModOK, dtModCom = NOW()";
}

sql_update('COMMENT', $update_data, "numCom = $numCom");
header('Location: ../../views/backend/comments/list.php');
?>