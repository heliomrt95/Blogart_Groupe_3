<?php
function sql_connect(){
    global $DB;
    try {
        $DB = new PDO(
            'mysql:host=' . SQL_HOST . ';charset=utf8;dbname=' . SQL_DB,
            SQL_USER,
            SQL_PWD,
            [
                PDO::ATTR_TIMEOUT => 5,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    } catch (PDOException $e) {
        die('Erreur DB: ' . $e->getMessage() . '<br>Host: ' . SQL_HOST . ' | DB: ' . SQL_DB . ' | User: ' . SQL_USER);
    }
}
?>
