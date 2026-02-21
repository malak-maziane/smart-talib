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
          <a class="nav-link" href="/projets_ensak/controllers/logout.php">Déconnexion</a>
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
    <title>Soumettre un Projet</title>
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/projets_ensak/assets/js/app.js"></script>

<body>
    <h2>Soumettre un Projet</h2>
    <form action="/projets_ensak/controllers/ajouter_projet.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="titre" placeholder="Titre du projet" required><br><br>
        
        <textarea name="description" placeholder="Description du projet" required></textarea><br><br>
        
        <input type="text" name="categorie" placeholder="Catégorie du projet" required><br><br>
        
        <select name="type" required>
            <option value="stage">Stage</option>
            <option value="module">Module</option>
        </select><br><br>
        
        <label for="livrable">Uploader un livrable (PDF/ZIP uniquement) :</label>
        <input type="file" name="livrable" accept=".pdf,.zip" required><br><br>
        
        <button type="submit">Envoyer le projet</button>
    </form>
</body>
</html>
