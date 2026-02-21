<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Gestion Projets ENSAK</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <!-- Pour les étudiants -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'etudiant') : ?>
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ajouter_projet.php">Soumettre Projet</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="recherche_projets.php">Recherche</a>
          </li>
        <?php endif; ?>

        <!-- Pour les encadrants -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'encadrant') : ?>
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Dashboard Encadrant</a>
          </li>
        <?php endif; ?>

        <!-- Pour les admins -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Dashboard Admin</a>
          </li>
        <?php endif; ?>

        <li class="nav-item">
          <a class="nav-link" href="../../controllers/logout.php">Déconnexion</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header('Location: ../../login.php');
    exit();
}

// Statistiques générales
$nbProjets = $pdo->query("SELECT COUNT(*) FROM projets")->fetchColumn();
$nbEtudiants = $pdo->query("SELECT COUNT(*) FROM etudiant")->fetchColumn();
$nbEncadrants = $pdo->query("SELECT COUNT(*) FROM encadrant")->fetchColumn();

// Projets par état
$projetsValides = $pdo->query("SELECT COUNT(*) FROM projets WHERE etat = 'valide'")->fetchColumn();
$projetsRefuses = $pdo->query("SELECT COUNT(*) FROM projets WHERE etat = 'refuse'")->fetchColumn();
$projetsAttente = $pdo->query("SELECT COUNT(*) FROM projets WHERE etat = 'en_attente'")->fetchColumn();

// Top projets les plus likés
$topProjets = $pdo->query("
    SELECT p.titre, COUNT(l.id) as total_likes 
    FROM projets p 
    LEFT JOIN likes l ON p.id = l.projet_id 
    GROUP BY p.id 
    ORDER BY total_likes DESC 
    LIMIT 5
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/app.js"></script>

<body>
    <h1>Dashboard Administrateur</h1>
    
    <h2>Statistiques Générales</h2>
    <ul>
        <li>Nombre de projets : <?= $nbProjets ?></li>
        <li>Nombre d'étudiants : <?= $nbEtudiants ?></li>
        <li>Nombre d'encadrants : <?= $nbEncadrants ?></li>
    </ul>

    <h2>Statistiques Projets</h2>
    <ul>
        <li>Projets validés : <?= $projetsValides ?></li>
        <li>Projets refusés : <?= $projetsRefuses ?></li>
        <li>Projets en attente : <?= $projetsAttente ?></li>
    </ul>

    <h2>Top 5 Projets les Plus Likés</h2>
    <ol>
        <?php foreach ($topProjets as $projet): ?>
            <li><?= htmlspecialchars($projet['titre']) ?> - ❤️ <?= $projet['total_likes'] ?> like(s)</li>
        <?php endforeach; ?>
    </ol>

</body>
</html>
