<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=projets_ensak", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
