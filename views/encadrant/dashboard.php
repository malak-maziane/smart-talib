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
require_once '../../config/db.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'encadrant') {
    header('Location: ../../login.php');
    exit();
}

$encadrant_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("SELECT p.*, e.nom AS etudiant_nom, e.prenom AS etudiant_prenom 
                       FROM projets p
                       JOIN etudiant e ON p.etudiant_id = e.id
                       WHERE p.encadrant_id = ? OR p.encadrant_id IS NULL");
$stmt->execute([$encadrant_id]);
$projets = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Encadrant</title>
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/app.js"></script>

<body>
    <h2>Bienvenue <?php echo $_SESSION['user']['prenom']; ?></h2>

    <h3>Liste des Projets</h3>

    <table border="1">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Étudiant</th>
                <th>Type</th>
                <th>État</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($projets as $projet) : ?>
            <tr>
                <td><?= htmlspecialchars($projet['titre']) ?></td>
                <td><?= htmlspecialchars($projet['etudiant_prenom'] . ' ' . $projet['etudiant_nom']) ?></td>
                <td><?= htmlspecialchars($projet['type']) ?></td>
                <td><?= htmlspecialchars($projet['etat']) ?></td>
                <td>
                    <a href="voir_projet.php?id=<?= $projet['id'] ?>">Voir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
