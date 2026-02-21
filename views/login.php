<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Gestion Projets ENSAK</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="site-header">
    <div class="container">
        <nav class="site-nav">
            <ul>
                <li><a href="index.php" class="nav-link">Accueil</a></li>
                <li><a href="login.php" class="nav-link">Connexion</a></li>
                <a href="backend/register.php" class="nav-link">Inscription</a>


            </ul>
        </nav>
    </div>
</header>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Gestion Projets ENSAK</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['role'])) : ?>
            <?php if ($_SESSION['role'] == 'etudiant') : ?>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard Étudiant</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ajouter_projet.php">Soumettre Projet</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="recherche_projets.php">Recherche</a>
                </li>
            <?php elseif ($_SESSION['role'] == 'encadrant') : ?>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard Encadrant</a>
                </li>
            <?php elseif ($_SESSION['role'] == 'admin') : ?>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard Admin</a>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link" href="../controllers/logout.php">Déconnexion</a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
    <h2>Connexion</h2>

    <!-- Afficher les messages d'erreur ou succès -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="../views/auth.php">
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>

        <div class="mb-3">
            <input type="password" name="mot_de_passe" class="form-control" placeholder="Mot de passe" required>
        </div>

        <div class="mb-3">
            <select name="role" class="form-select" required>
                <option value="">-- Sélectionner votre rôle --</option>
                <option value="etudiant">Étudiant</option>
                <option value="encadrant">Encadrant</option>
                <option value="admin">Administrateur</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>

<!-- Script Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
