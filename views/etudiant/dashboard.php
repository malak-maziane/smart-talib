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
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'etudiant') {
    header('Location: ../../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Étudiant</title>
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/app.js"></script>

<body>
    <h1>Bienvenue <?php echo $_SESSION['user']['prenom']; ?></h1>
    <ul>
        <li><a href="ajouter_projet.php">Soumettre un projet</a></li>
        <li><a href="mes_projets.php">Mes projets</a></li>
    </ul>
</body>
</html>
