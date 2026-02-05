<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Récupérer et valider l'identifiant envoyé en POST
$numCom = 0;
if (isset($_POST['numCom'])) {
	$numCom = (int) $_POST['numCom'];
}

if ($numCom <= 0) {
	// id invalide -> retourner à la liste sans rien faire
	header('Location: ../../views/backend/comments/list.php');
	exit;
}

// Connexion PDO (utilise la variable globale $DB définie par config.php)
global $DB;
if (!$DB) {
	sql_connect();
}

try {
	$stmt = $DB->prepare("UPDATE `COMMENT` SET delLogiq = 1, dtDelLogCom = NOW() WHERE numCom = :numCom");
	$stmt->execute(['numCom' => $numCom]);
} catch (PDOException $e) {
	// on redirige simplement vers la liste (on pourrait logger l'erreur)
	header('Location: ../../views/backend/comments/list.php');
	exit;
}

// Redirection (succès)
header('Location: ../../views/backend/comments/list.php');
?>