<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
sql_connect();

// Vérifier les statuts disponibles
global $DB;
echo "<h3>Statuts dans la DB :</h3>";
$statuts = $DB->query("SELECT * FROM STATUT")->fetchAll(PDO::FETCH_ASSOC);
foreach ($statuts as $s) {
    echo "numStat: {$s['numStat']} | libStat: {$s['libStat']}<br>";
}

// Vérifier l'utilisateur admin99
echo "<h3>Utilisateur admin99 :</h3>";
$user = $DB->query("SELECT numMemb, pseudoMemb, numStat FROM MEMBRE WHERE pseudoMemb = 'admin99'")->fetchAll(PDO::FETCH_ASSOC);
if (count($user) === 0) {
    echo "<b style='color:red'>❌ Utilisateur admin99 introuvable dans la DB !</b>";
} else {
    echo "numMemb: {$user[0]['numMemb']} | pseudo: {$user[0]['pseudoMemb']} | numStat: {$user[0]['numStat']}<br>";
}
?>
