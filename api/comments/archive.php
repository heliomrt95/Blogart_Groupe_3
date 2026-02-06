<?php
// On inclut le fichier de configuration général du projet
// Il contient :
// - les constantes de connexion à la base de données
// - les fonctions (sql_connect, etc.)
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';


// ===============================
// RÉCUPÉRATION DE L'ID COMMENTAIRE
// ===============================

// On initialise l'identifiant du commentaire à 0 par défaut
// 0 = valeur invalide
$numCom = 0;

// On vérifie si l'identifiant du commentaire a bien été envoyé en POST
if (isset($_POST['numCom'])) {
	// On force le type en entier pour éviter les injections
	// et garantir que c’est bien un nombre
	$numCom = (int) $_POST['numCom'];
}


// ===============================
// VÉRIFICATION DE VALIDITÉ
// ===============================

// Si l'identifiant est invalide ou inexistant
if ($numCom <= 0) {
	// On ne fait aucune action en base
	// On redirige simplement vers la liste des commentaires
	header('Location: ../../views/backend/comments/list.php');
	exit; // On arrête complètement le script
}


// ===============================
// CONNEXION À LA BASE DE DONNÉES
// ===============================

// On utilise la variable globale $DB qui contient la connexion PDO
global $DB;

// Si la connexion n'existe pas encore
if (!$DB) {
	// On appelle la fonction qui crée la connexion PDO
	sql_connect();
}


// ===============================
// SUPPRESSION LOGIQUE DU COMMENTAIRE
// ===============================

try {
	// Préparation de la requête SQL
	// Ici on ne supprime PAS le commentaire physiquement
	// On met simplement :
	// - delLogiq = 1 → commentaire archivé / masqué
	// - dtDelLogCom = NOW() → date de suppression logique
	$stmt = $DB->prepare("
		UPDATE `COMMENT`
		SET delLogiq = 1,
		    dtDelLogCom = NOW()
		WHERE numCom = :numCom
	");

	// Exécution de la requête avec un paramètre sécurisé
	// :numCom est remplacé par la vraie valeur de $numCom
	$stmt->execute([
		'numCom' => $numCom
	]);

} catch (PDOException $e) {
	// En cas d’erreur SQL :
	// - on ne bloque pas l’utilisateur
	// - on pourrait logger l’erreur (mais ici ce n’est pas fait)
	// - on redirige simplement vers la liste des commentaires
	header('Location: ../../views/backend/comments/list.php');
	exit;
}


// ===============================
// REDIRECTION FINALE
// ===============================

// Si tout s’est bien passé :
// on redirige vers la page de liste des commentaires
header('Location: ../../views/backend/comments/list.php');
exit;
?>
