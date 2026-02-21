<?php
session_start();
require_once('C:/xampp/htdocs/projets_ensak/config/db.php');
// Vérifier si l'utilisateur est un étudiant
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'etudiant') {
    header('Location: ../../login.php');
    exit();
}

$etudiant_id = $_SESSION['user']['id'];
$projet_id = $_POST['projet_id'];

// Vérifier si l'étudiant a déjà liké ce projet
$stmtCheck = $pdo->prepare("SELECT * FROM likes WHERE projet_id = ? AND etudiant_id = ?");
$stmtCheck->execute([$projet_id, $etudiant_id]);

if ($stmtCheck->rowCount() == 0) {
    // Ajouter un like
    $stmt = $pdo->prepare("INSERT INTO likes (projet_id, etudiant_id) VALUES (?, ?)");
    $stmt->execute([$projet_id, $etudiant_id]);
}

header('Location: /projets_ensak/views/etudiant/recherche_projets.php');
exit();
?>
