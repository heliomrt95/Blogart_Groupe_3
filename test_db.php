<?php
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$db   = getenv('DB_DATABASE');

echo "Host: $host<br>";
echo "User: $user<br>";
echo "DB: $db<br>";

try {
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$db", $user, $pass, [
        PDO::ATTR_TIMEOUT => 10
    ]);
    echo "<b style='color:green'>✅ Connexion OK !</b>";
} catch (Exception $e) {
    echo "<b style='color:red'>❌ Erreur: " . $e->getMessage() . "</b>";
}
