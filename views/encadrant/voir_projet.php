<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'encadrant') {
    header('Location: ../../login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$projet_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM projets WHERE id = ?");
$stmt->execute([$projet_id]);
$projet = $stmt->fetch();

if (!$projet) {
    echo "Projet introuvable.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail Projet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

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

<div class="container">
    <a href="dashboard.php" class="btn btn-secondary mb-3">Retour</a>

    <h2><?= htmlspecialchars($projet['titre']) ?></h2>

    <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($projet['description'])) ?></p>
    <p><strong>Catégorie :</strong> <?= htmlspecialchars($projet['categorie']) ?></p>
    <p><strong>Type :</strong> <?= htmlspecialchars($projet['type']) ?></p>
    <p><strong>État :</strong> <?= htmlspecialchars($projet['etat']) ?></p>

    <!-- Lien pour télécharger le fichier -->
    <?php if (!empty($projet['fichier'])) : ?>
        <p><strong>Télécharger le projet :</strong> <a href="../../uploads/projets/<?= $projet['fichier'] ?>" class="btn btn-primary" download>Télécharger</a></p>
    <?php else : ?>
        <p>Aucun fichier soumis pour ce projet.</p>
    <?php endif; ?>

    <form action="/projets_ensak/controllers/valider_refuser_projet.php" method="POST" class="mb-4">
        <input type="hidden" name="projet_id" value="<?= $projet['id'] ?>">
        <button type="submit" name="action" value="valider" class="btn btn-success me-2">Valider</button>
        <button type="submit" name="action" value="refuser" class="btn btn-danger">Refuser</button>
    </form>

    <h3>Ajouter une remarque et une note</h3>
    <form action="/projets_ensak/controllers/ajouter_remarque.php" method="POST">
        <input type="hidden" name="projet_id" value="<?= $projet['id'] ?>">
        <div class="mb-3">
            <textarea name="contenu" class="form-control" placeholder="Votre remarque..." required></textarea>
        </div>
        <div class="mb-3">
            <input type="number" step="0.1" min="0" max="20" name="note" class="form-control" placeholder="Note sur 20" required>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/app.js"></script>
</body>
</html>
